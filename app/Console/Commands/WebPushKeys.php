<?php

namespace App\Console\Commands;

use App\Services\WebPush;
use Illuminate\Console\Command;

/**
 * Generates the VAPID key pair that identifies this server to the browser
 * push services. Run once; keep the output. Regenerating invalidates every
 * existing subscription, so operators would have to re-enable notifications.
 */
class WebPushKeys extends Command
{
    protected $signature = 'webpush:keys';

    protected $description = 'Generate a VAPID key pair for background push notifications';

    public function handle(): int
    {
        $key = openssl_pkey_new([
            'curve_name'        => 'prime256v1',
            'private_key_type'  => OPENSSL_KEYTYPE_EC,
        ]);

        if (!$key) {
            $this->error('openssl could not generate a P-256 key: ' . openssl_error_string());
            return self::FAILURE;
        }

        $pem = '';
        openssl_pkey_export($key, $pem);

        $details = openssl_pkey_get_details($key);
        $point   = "\x04"
            . str_pad($details['ec']['x'], 32, "\x00", STR_PAD_LEFT)
            . str_pad($details['ec']['y'], 32, "\x00", STR_PAD_LEFT);

        $public  = WebPush::b64url($point);
        // openssl strips leading zero bytes from the scalar; Web Push wants a
        // fixed 32 byte value, so pad it back before encoding.
        $private = WebPush::b64url(str_pad($details['ec']['d'], 32, "\x00", STR_PAD_LEFT));

        $this->newLine();
        $this->line('Add these to your .env file (and to the live server\'s .env):');
        $this->newLine();
        $this->line('WEBPUSH_VAPID_PUBLIC_KEY=' . $public);
        $this->line('WEBPUSH_VAPID_PRIVATE_KEY=' . $private);
        $this->line('WEBPUSH_VAPID_SUBJECT=mailto:info@xpertva.com');
        $this->newLine();
        $this->comment('The public key is sent to browsers. Keep the private key secret —');
        $this->comment('anyone holding it can push notifications to your operators.');
        $this->newLine();
        $this->comment('Single line PEM alternative, if the raw key above is ever rejected:');
        $this->line('WEBPUSH_VAPID_PRIVATE_PEM=' . base64_encode($pem));
        $this->newLine();

        return self::SUCCESS;
    }
}
