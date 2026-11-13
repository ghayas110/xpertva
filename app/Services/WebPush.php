<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;

/**
 * Web Push sender — RFC 8291 (aes128gcm payload encryption) + RFC 8292 (VAPID).
 *
 * Deliberately dependency free. The portal is deployed over FTP to a PHP 8.2
 * host while this repo's vendor/ tree is built for a much newer PHP, so pulling
 * in minishlink/web-push would mean shipping a vendor folder that cannot run
 * there. Everything below is done with the openssl extension, which that host
 * already has: P-256 ECDH, HKDF via hash_hmac, and AES-128-GCM.
 *
 * Nothing here is XpertVA specific. Give it subscriptions and a payload array.
 */
class WebPush
{
    /** Browsers reject records larger than this. 4096 is the universal floor. */
    private const RECORD_SIZE = 4096;

    /** How long a push service should hold an undelivered message. 28 days. */
    private const TTL = 2419200;

    /** Fixed DER prefix of a P-256 SubjectPublicKeyInfo. */
    private const SPKI_P256_PREFIX = "\x30\x59\x30\x13\x06\x07\x2a\x86\x48\xce\x3d\x02\x01"
        . "\x06\x08\x2a\x86\x48\xce\x3d\x03\x01\x07\x03\x42\x00";

    /** DER object identifier for prime256v1, as it appears inside an EC private key. */
    private const OID_P256 = "\x06\x08\x2a\x86\x48\xce\x3d\x03\x01\x07";

    /** @var array{public:string,private:string,pem:string,subject:string}|null */
    private $vapid = null;

    /** Parsed private key, kept per instance — never a function static, which
     *  would leak one request's key into the next in a long lived process. */
    private $signingKey = null;

    public function __construct()
    {
        $public  = (string) config('webpush.public_key');
        $private = (string) config('webpush.private_key');
        $pem     = (string) config('webpush.private_pem');
        $subject = (string) config('webpush.subject');

        if (($private !== '' || $pem !== '') && $subject !== '') {
            $this->vapid = [
                'public'  => $public,
                'private' => $private,
                'pem'     => $pem,
                'subject' => $subject,
            ];
        }
    }

    /**
     * True when VAPID keys are present. The client is told this so that a
     * browser never silently stops showing notifications because the server
     * accepted a subscription it can't actually push to.
     */
    public function isConfigured(): bool
    {
        return $this->vapid !== null && $this->publicKey() !== null;
    }

    /**
     * The application server key the browser needs, as base64url of the raw
     * uncompressed point. Derived from the private key when not configured
     * explicitly, so the two can never drift apart.
     */
    public function publicKey(): ?string
    {
        if ($this->vapid === null) {
            return null;
        }

        if ($this->vapid['public'] !== '') {
            return $this->vapid['public'];
        }

        try {
            $key     = $this->vapidPrivateKey();
            $details = openssl_pkey_get_details($key);
            if (!$details || !isset($details['ec']['x'], $details['ec']['y'])) {
                return null;
            }
            return self::b64url($this->point($details['ec']['x'], $details['ec']['y']));
        } catch (\Throwable $e) {
            return null;
        }
    }

    /**
     * Encrypt and deliver one payload to many subscriptions at once.
     *
     * Sent with curl_multi rather than one call after another: this runs inside
     * the web request that created the notification (shared hosting, no queue
     * worker), so ten operators must cost one round trip, not ten.
     *
     * @param  iterable  $subscriptions  objects/arrays with endpoint, p256dh, auth
     * @param  array     $payload        JSON-serialisable notification body
     * @return array<string,int>         endpoint => HTTP status (0 = transport failure)
     */
    public function send(iterable $subscriptions, array $payload): array
    {
        if (!$this->isConfigured()) {
            return [];
        }

        $json    = json_encode($payload, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        $multi   = curl_multi_init();
        $handles = [];

        foreach ($subscriptions as $sub) {
            $endpoint = $this->field($sub, 'endpoint');
            $p256dh   = $this->field($sub, 'p256dh');
            $auth     = $this->field($sub, 'auth');

            if (!$endpoint || !$p256dh || !$auth) {
                continue;
            }

            try {
                $ch = $this->request($endpoint, $p256dh, $auth, $json);
            } catch (\Throwable $e) {
                Log::warning('Web push encryption failed', [
                    'endpoint' => substr($endpoint, 0, 60),
                    'error'    => $e->getMessage(),
                ]);
                continue;
            }

            $handles[(int) $ch] = ['handle' => $ch, 'endpoint' => $endpoint];
            curl_multi_add_handle($multi, $ch);
        }

        if (!$handles) {
            curl_multi_close($multi);
            return [];
        }

        $running = null;
        do {
            curl_multi_exec($multi, $running);
            if ($running) {
                curl_multi_select($multi, 1.0);
            }
        } while ($running > 0);

        $results = [];
        foreach ($handles as $entry) {
            $status = (int) curl_getinfo($entry['handle'], CURLINFO_HTTP_CODE);
            $results[$entry['endpoint']] = $status;

            if ($status === 0 || $status >= 400) {
                Log::info('Web push not delivered', [
                    'endpoint' => substr($entry['endpoint'], 0, 60),
                    'status'   => $status,
                    'error'    => curl_error($entry['handle']) ?: null,
                ]);
            }

            curl_multi_remove_handle($multi, $entry['handle']);
            curl_close($entry['handle']);
        }
        curl_multi_close($multi);

        return $results;
    }

    /* ------------------------------------------------------------------ */
    /* Request assembly                                                    */
    /* ------------------------------------------------------------------ */

    /**
     * @return resource|\CurlHandle
     */
    private function request(string $endpoint, string $p256dh, string $auth, string $json)
    {
        $body = $this->encrypt($json, $p256dh, $auth);

        $headers = [
            'Content-Type: application/octet-stream',
            'Content-Encoding: aes128gcm',
            'Content-Length: ' . strlen($body),
            'TTL: ' . self::TTL,
            'Urgency: high',
            'Authorization: ' . $this->vapidHeader($endpoint),
        ];

        $ch = curl_init($endpoint);
        curl_setopt_array($ch, [
            CURLOPT_POST           => true,
            CURLOPT_POSTFIELDS     => $body,
            CURLOPT_HTTPHEADER     => $headers,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT        => 8,
            CURLOPT_CONNECTTIMEOUT => 4,
            CURLOPT_FOLLOWLOCATION => false,
        ]);

        return $ch;
    }

    /**
     * RFC 8292 §3: a signed JWT plus the application server's public key.
     * The audience is the push service origin, so it is per endpoint.
     */
    private function vapidHeader(string $endpoint): string
    {
        $parts = parse_url($endpoint);
        $aud   = ($parts['scheme'] ?? 'https') . '://' . ($parts['host'] ?? '');

        $header  = self::b64url('{"typ":"JWT","alg":"ES256"}');
        $claims  = self::b64url(json_encode([
            'aud' => $aud,
            'exp' => time() + 43200, // 12h; services reject anything beyond 24h
            'sub' => $this->vapid['subject'],
        ], JSON_UNESCAPED_SLASHES));

        $signing = $header . '.' . $claims;

        $der = '';
        if (!openssl_sign($signing, $der, $this->vapidPrivateKey(), OPENSSL_ALGO_SHA256)) {
            throw new \RuntimeException('Could not sign the VAPID token.');
        }

        $jwt = $signing . '.' . self::b64url($this->derToRaw($der));

        return 'vapid t=' . $jwt . ', k=' . $this->publicKey();
    }

    /* ------------------------------------------------------------------ */
    /* Payload encryption — RFC 8291                                        */
    /* ------------------------------------------------------------------ */

    /**
     * Returns the aes128gcm body: salt | record size | key id length | server
     * public key | ciphertext. Exposed for the self-test against the RFC's
     * published vector; callers should use send().
     */
    public function encrypt(
        string $plaintext,
        string $uaPublicB64,
        string $authSecretB64,
        ?string $saltOverride = null,
        ?string $serverPemOverride = null
    ): string {
        $uaPublic = self::b64urlDecode($uaPublicB64);
        $auth     = self::b64urlDecode($authSecretB64);

        if (strlen($uaPublic) !== 65 || $uaPublic[0] !== "\x04") {
            throw new \RuntimeException('Subscription key is not an uncompressed P-256 point.');
        }
        if (strlen($auth) !== 16) {
            throw new \RuntimeException('Subscription auth secret must be 16 bytes.');
        }

        // Ephemeral server keypair, one per message.
        if ($serverPemOverride !== null) {
            $server = openssl_pkey_get_private($serverPemOverride);
        } else {
            $server = openssl_pkey_new(['curve_name' => 'prime256v1', 'private_key_type' => OPENSSL_KEYTYPE_EC]);
        }
        if (!$server) {
            throw new \RuntimeException('Could not create an ephemeral EC key: ' . openssl_error_string());
        }

        $details = openssl_pkey_get_details($server);
        if (!$details || !isset($details['ec']['x'], $details['ec']['y'])) {
            throw new \RuntimeException('Could not read the ephemeral public key.');
        }
        $serverPublic = $this->point($details['ec']['x'], $details['ec']['y']);

        $shared = openssl_pkey_derive($this->spki($uaPublic), $server, 32);
        if ($shared === false) {
            throw new \RuntimeException('ECDH failed: ' . openssl_error_string());
        }

        $salt = $saltOverride !== null ? $saltOverride : random_bytes(16);

        // Combine the shared secret with the subscription's auth secret.
        $keyInfo = "WebPush: info\x00" . $uaPublic . $serverPublic;
        $ikm     = self::hkdf($auth, $shared, $keyInfo, 32);

        // Then the generic aes128gcm content encoding of RFC 8188.
        $cek   = self::hkdf($salt, $ikm, "Content-Encoding: aes128gcm\x00", 16);
        $nonce = self::hkdf($salt, $ikm, "Content-Encoding: nonce\x00", 12);

        // 0x02 marks the final (and here only) record.
        $padded = $plaintext . "\x02";

        $tag = '';
        $cipher = openssl_encrypt($padded, 'aes-128-gcm', $cek, OPENSSL_RAW_DATA, $nonce, $tag);
        if ($cipher === false) {
            throw new \RuntimeException('AES-128-GCM failed: ' . openssl_error_string());
        }

        return $salt
            . pack('N', self::RECORD_SIZE)
            . chr(strlen($serverPublic))
            . $serverPublic
            . $cipher . $tag;
    }

    /** HKDF with SHA-256, as used by both specs above. */
    private static function hkdf(string $salt, string $ikm, string $info, int $length): string
    {
        $prk = hash_hmac('sha256', $ikm, $salt, true);
        return substr(hash_hmac('sha256', $info . "\x01", $prk, true), 0, $length);
    }

    /* ------------------------------------------------------------------ */
    /* Key plumbing                                                         */
    /* ------------------------------------------------------------------ */

    /**
     * The configured VAPID private key as an openssl key.
     *
     * Two accepted shapes: a base64 encoded PEM (what our generator emits, and
     * what survives a single line .env cleanly), or the base64url 32 byte
     * scalar that every other Web Push tool produces.
     *
     * @return resource|\OpenSSLAsymmetricKey
     */
    private function vapidPrivateKey()
    {
        if ($this->signingKey !== null) {
            return $this->signingKey;
        }

        if (!empty($this->vapid['pem'])) {
            $pem = $this->vapid['pem'];
            if (strpos($pem, '-----BEGIN') === false) {
                $pem = (string) base64_decode(strtr($pem, '-_', '+/'), false);
            }
            $key = openssl_pkey_get_private($pem);
            if (!$key) {
                throw new \RuntimeException('WEBPUSH_VAPID_PRIVATE_PEM is not a readable private key.');
            }
            return $this->signingKey = $key;
        }

        $d = self::b64urlDecode($this->vapid['private']);
        if (strlen($d) !== 32) {
            throw new \RuntimeException('WEBPUSH_VAPID_PRIVATE_KEY must be a base64url encoded 32 byte key.');
        }

        $public = self::b64urlDecode($this->vapid['public']);
        if (strlen($public) !== 65) {
            throw new \RuntimeException('WEBPUSH_VAPID_PUBLIC_KEY must accompany a raw private key.');
        }

        $key = openssl_pkey_get_private($this->sec1Pem($d, $public));
        if (!$key) {
            throw new \RuntimeException('Could not assemble a key from the configured VAPID pair.');
        }

        return $this->signingKey = $key;
    }

    /** Wrap raw x/y coordinates as an uncompressed point, left padding each to 32 bytes. */
    private function point(string $x, string $y): string
    {
        return "\x04" . str_pad($x, 32, "\x00", STR_PAD_LEFT) . str_pad($y, 32, "\x00", STR_PAD_LEFT);
    }

    /** openssl cannot load a bare point, so wrap it in a SubjectPublicKeyInfo. */
    private function spki(string $point): string
    {
        return "-----BEGIN PUBLIC KEY-----\n"
            . chunk_split(base64_encode(self::SPKI_P256_PREFIX . $point), 64, "\n")
            . "-----END PUBLIC KEY-----\n";
    }

    /** Build an RFC 5915 EC private key around a raw scalar and its public point. */
    private function sec1Pem(string $d, string $point): string
    {
        $der = self::der("\x30",                                   // SEQUENCE
            "\x02\x01\x01"                                         // version 1
            . self::der("\x04", $d)                                // privateKey
            . self::der("\xa0", self::OID_P256)                    // [0] namedCurve
            . self::der("\xa1", self::der("\x03", "\x00" . $point))// [1] publicKey BIT STRING
        );

        return "-----BEGIN EC PRIVATE KEY-----\n"
            . chunk_split(base64_encode($der), 64, "\n")
            . "-----END EC PRIVATE KEY-----\n";
    }

    /** Minimal DER tag-length-value writer (lengths here never exceed 2 bytes). */
    private static function der(string $tag, string $value): string
    {
        $len = strlen($value);
        if ($len < 0x80) {
            $length = chr($len);
        } elseif ($len < 0x100) {
            $length = "\x81" . chr($len);
        } else {
            $length = "\x82" . pack('n', $len);
        }
        return $tag . $length . $value;
    }

    /**
     * openssl_sign emits a DER SEQUENCE of two INTEGERs; JWS ES256 wants the
     * raw 64 byte r||s concatenation.
     */
    private function derToRaw(string $der): string
    {
        $offset = 0;

        // Reads one DER tag-length-value at $offset and returns its contents.
        $read = function (string $expect) use (&$der, &$offset): string {
            if (($der[$offset] ?? '') !== $expect) {
                throw new \RuntimeException('Unexpected DER signature structure.');
            }
            $offset++;

            $len = ord($der[$offset++]);
            if ($len & 0x80) {
                $bytes = $len & 0x7f;
                $len   = 0;
                for ($i = 0; $i < $bytes; $i++) {
                    $len = ($len << 8) | ord($der[$offset++]);
                }
            }

            $value   = substr($der, $offset, $len);
            $offset += $len;

            return $value;
        };

        // Descend into the SEQUENCE, then read the two INTEGERs inside it.
        // $der and $offset are held by reference so this reassignment is seen
        // by the reader above.
        $der    = $read("\x30");
        $offset = 0;

        $r = $read("\x02");
        $s = $read("\x02");

        // DER INTEGERs are signed, so a high bit gained a leading zero byte.
        // ES256 wants two fixed width 32 byte values instead.
        $fixed = function (string $n): string {
            return str_pad(ltrim($n, "\x00"), 32, "\x00", STR_PAD_LEFT);
        };

        return $fixed($r) . $fixed($s);
    }

    /* ------------------------------------------------------------------ */
    /* Small helpers                                                        */
    /* ------------------------------------------------------------------ */

    /** Read a property off either a model/object or a plain array. */
    private function field($sub, string $key): ?string
    {
        if (is_array($sub)) {
            return isset($sub[$key]) ? (string) $sub[$key] : null;
        }
        return isset($sub->{$key}) ? (string) $sub->{$key} : null;
    }

    public static function b64url(string $raw): string
    {
        return rtrim(strtr(base64_encode($raw), '+/', '-_'), '=');
    }

    public static function b64urlDecode(string $value): string
    {
        $value = strtr(trim($value), '-_', '+/');
        $pad   = strlen($value) % 4;
        if ($pad) {
            $value .= str_repeat('=', 4 - $pad);
        }
        return (string) base64_decode($value, false);
    }
}
