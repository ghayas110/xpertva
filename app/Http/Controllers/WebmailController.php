<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EmailAccount;
use Webklex\PHPIMAP\ClientManager;

class WebmailController extends Controller
{
    public function index()
    {
        $emailAccount = auth()->user()->emailAccount;
        return view('webmail.index', compact('emailAccount'));
    }

    public function saveConfig(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        \Log::info("Webmail Setup Attempt:", $request->except(['password']));
        
        // Unlock session so background dashboard ajax doesn't deadlock the single-threaded artisan server
        if($request->hasSession()) {
            $request->session()->save();
        }

        try {
            $cm = new ClientManager([]);
            $client = $cm->make([
                'host'          => 'gcam1211.siteground.biz',
                'port'          => 993,
                'encryption'    => 'ssl', 
                'validate_cert' => false, // For easier setup initially
                'username'      => $request->email,
                'password'      => $request->password,
                'protocol'      => 'imap'
            ]);

            // Test connection
            $client->connect();
            \Log::info("Webmail Setup IMAP Connected Successfully.");

            // Save credentials
            EmailAccount::updateOrCreate(
                ['user_id' => auth()->id()],
                [
                    'email' => $request->email,
                    'password' => $request->password, // Casts will encrypt this
                    'imap_host' => 'gcam1211.siteground.biz',
                    'imap_port' => 993,
                    'smtp_host' => 'gcam1211.siteground.biz',
                    'smtp_port' => 465,
                ]
            );

            return response()->json(['success' => true]);

        } catch (\Exception $e) {
            \Log::error("Webmail Setup Failed: " . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return response()->json(['success' => false, 'message' => $e->getMessage()], 422);
        }
    }

    public function disconnect(Request $request)
    {
        $account = auth()->user()->emailAccount;
        if ($account) {
            $account->delete();
        }
        return response()->json(['success' => true]);
    }

    public function fetchMessages(Request $request)
    {
        // Unlock session so background dashboard ajax doesn't deadlock the single-threaded artisan server
        if($request->hasSession()) {
            $request->session()->save();
        }

        try {
            $account = auth()->user()->emailAccount;
            if (!$account) return response()->json(['error' => 'No account configured'], 400);

            $cm = new ClientManager([]);
            $client = $cm->make([
                'host'          => $account->imap_host,
                'port'          => $account->imap_port,
                'encryption'    => 'ssl', 
                'validate_cert' => false,
                'username'      => $account->email,
                'password'      => $account->password,
                'protocol'      => 'imap'
            ]);

            $client->connect();
            
            $requestedFolder = $request->input('folder', 'INBOX');
            
            // Map common folder names to likely cPanel/IMAP paths
            $folderMap = [
                'INBOX' => 'INBOX',
                'Sent' => 'INBOX.Sent',
                'Drafts' => 'INBOX.Drafts',
                'Trash' => 'INBOX.Trash',
            ];
            
            $folderPath = $folderMap[$requestedFolder] ?? $requestedFolder;
            
            try {
                $folder = $client->getFolderByPath($folderPath);
            } catch (\Exception $e) {
                // Fallback: try default name if mapped path fails
                try {
                    $folder = $client->getFolderByPath($requestedFolder);
                } catch (\Exception $e2) {
                    return response()->json(['success' => false, 'message' => "Folder {$requestedFolder} not found on server."]);
                }
            }
            
            // Fetch newest messages first. setFetchOrderDesc() avoids the
            // Sent-tab bug where IMAP's ascending-UID default would return
            // oldest messages and hide a freshly sent one behind them.
            $limit = (int) $request->input('limit', 100);
            $limit = max(1, min($limit, 500));

            $messages = $folder->messages()
                ->all()
                ->setFetchFlags(true)
                ->setFetchBody(true)
                ->setFetchOrderDesc()
                ->leaveUnread()  // BODY.PEEK — do not mark messages \Seen on fetch
                ->limit($limit)
                ->get();
            
            $formatted = [];
            foreach ($messages as $message) {
                $textBody = $message->getTextBody() ?? '';
                if(empty($textBody)) {
                    $textBody = strip_tags($message->getHTMLBody() ?? '');
                }

                $snippet = mb_substr(trim(preg_replace('/\s+/', ' ', $textBody)), 0, 100) . '...';

                // Get HTML body and resolve cid: inline images to base64 data URIs
                $htmlBody = $message->getHTMLBody(true) ?? nl2br($textBody);
                try {
                    $attachments  = $message->getAttachments();
                    $inlineBlocks = [];
                    $fileChips    = [];
                    foreach ($attachments as $attachment) {
                        $mimeType = (string)($attachment->getMimeType() ?? 'application/octet-stream');
                        $isImage  = str_starts_with($mimeType, 'image/');
                        $content  = (string)$attachment->getContent();
                        if ($content === '') continue;
                        $b64      = base64_encode($content);
                        $dataUri  = 'data:' . $mimeType . ';base64,' . $b64;
                        $name     = (string)($attachment->getName() ?? ($isImage ? 'image' : 'file'));
                        $nameEsc  = htmlspecialchars($name, ENT_QUOTES);
                        $sizeKb   = number_format(strlen($content) / 1024, 1) . ' KB';

                        // 1) Try to replace any cid: reference in the HTML
                        $cid      = $attachment->getId();
                        $replaced = false;
                        if ($cid) {
                            $cid    = trim((string)$cid, '<>');
                            $before = $htmlBody;
                            $htmlBody = str_replace(
                                ['cid:' . $cid, 'cid:<' . $cid . '>'],
                                $dataUri,
                                $htmlBody
                            );
                            if ($htmlBody !== $before) $replaced = true;
                        }
                        if ($replaced) continue;

                        // 2) Image attachment with no cid reference → render inline at the end
                        if ($isImage) {
                            $inlineBlocks[] = '<div style="margin-top:12px"><img src="' . $dataUri . '" alt="' . $nameEsc . '" style="max-width:100%;height:auto;display:block;"></div>';
                            continue;
                        }

                        // 3) Non-image attachment (PDF, doc, zip…) → render a download chip.
                        // Use unicode glyphs because the email-body iframe doesn't load Font Awesome.
                        $glyph = '📎';
                        $label = strtoupper(pathinfo($name, PATHINFO_EXTENSION) ?: 'FILE');
                        if (str_contains($mimeType, 'pdf'))                                             { $glyph = '📕'; $label = 'PDF'; }
                        elseif (str_contains($mimeType, 'zip'))                                         { $glyph = '🗜'; $label = 'ZIP'; }
                        elseif (str_contains($mimeType, 'word'))                                        { $glyph = '📘'; $label = 'DOC'; }
                        elseif (str_contains($mimeType, 'excel') || str_contains($mimeType, 'sheet'))   { $glyph = '📗'; $label = 'XLS'; }
                        elseif (str_contains($mimeType, 'text'))                                        { $glyph = '📄'; $label = 'TXT'; }

                        $fileChips[] =
                            '<a href="' . $dataUri . '" download="' . $nameEsc . '" target="_blank" rel="noopener" ' .
                            'style="display:inline-flex;align-items:center;gap:10px;padding:10px 14px;margin:6px 6px 0 0;' .
                            'background:#f1f3f4;border:1px solid #dadce0;border-radius:8px;text-decoration:none;color:#202124;font-size:13px;">' .
                            '<span style="font-size:22px;line-height:1">' . $glyph . '</span>' .
                            '<span><strong>' . $nameEsc . '</strong><br><span style="color:#5f6368;font-size:11px">' . $label . ' &middot; ' . $sizeKb . ' &middot; Click to download</span></span>' .
                            '</a>';
                    }

                    if (!empty($inlineBlocks)) {
                        $htmlBody .= implode('', $inlineBlocks);
                    }
                    if (!empty($fileChips)) {
                        $htmlBody .= '<div style="margin-top:16px;padding-top:12px;border-top:1px solid #e0e0e0">'
                                  .  '<div style="font-size:12px;color:#5f6368;margin-bottom:6px">Attachments</div>'
                                  .  implode('', $fileChips)
                                  .  '</div>';
                    }
                } catch (\Exception $e) {
                    \Log::info("Webmail: Could not process inline attachments: " . $e->getMessage());
                }

                $dateObj = $message->getDate()[0] ?? now();
                $formatted[] = [
                    'id'        => $message->getUid(),
                    'subject'   => (string)$message->getSubject() ?: '(No Subject)',
                    'from'      => $message->getFrom()[0]->mail ?? 'Unknown',
                    'from_name' => $message->getFrom()[0]->personal ?? ($message->getFrom()[0]->mail ?? 'Unknown'),
                    'reply_to'  => $message->getReplyTo()[0]->mail ?? ($message->getFrom()[0]->mail ?? ''),
                    'date'      => $dateObj->format('M d, g:i A'),
                    'date_ts'   => (int) $dateObj->getTimestamp(),
                    'snippet'   => $snippet,
                    'body'      => $htmlBody,
                    'flags'     => [
                        'seen' => $message->hasFlag('SEEN')
                    ],
                ];
            }

            // Hard-sort by date descending so the newest message is always
            // at the top — independent of how the IMAP server happened to
            // return them or how setFetchOrderDesc() was interpreted.
            usort($formatted, fn($a, $b) => $b['date_ts'] <=> $a['date_ts']);
            foreach ($formatted as &$m) { unset($m['date_ts']); }

            return response()->json(['success' => true, 'messages' => $formatted]);

        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    public function markSeen(Request $request)
    {
        $request->validate([
            'uid'    => 'required|integer',
            'folder' => 'nullable|string',
        ]);

        if ($request->hasSession()) $request->session()->save();

        try {
            $account = auth()->user()->emailAccount;
            if (!$account) return response()->json(['success' => false], 400);

            $cm = new ClientManager([]);
            $client = $cm->make([
                'host'          => $account->imap_host,
                'port'          => $account->imap_port,
                'encryption'    => 'ssl',
                'validate_cert' => false,
                'username'      => $account->email,
                'password'      => $account->password,
                'protocol'      => 'imap',
            ]);
            $client->connect();

            $folderMap = [
                'INBOX'  => 'INBOX',
                'Sent'   => 'INBOX.Sent',
                'Drafts' => 'INBOX.Drafts',
                'Trash'  => 'INBOX.Trash',
            ];
            $folderPath = $folderMap[$request->folder ?? 'INBOX'] ?? ($request->folder ?? 'INBOX');

            $folder  = $client->getFolderByPath($folderPath);
            $message = $folder->query()->getMessageByUid((int) $request->uid);
            if ($message) {
                $message->setFlag('Seen');
            }
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            \Log::info("Webmail mark-seen failed: " . $e->getMessage());
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    public function sendEmail(Request $request)
    {
        $request->validate([
            'to'             => 'required|email',
            'subject'        => 'required|string',
            'body'           => 'required|string',
            'attachments'    => 'nullable|array',
            'attachments.*'  => 'file|max:25600', // 25 MB per file
        ]);

        // Unlock session so background dashboard ajax doesn't deadlock the single-threaded artisan server
        if($request->hasSession()) {
            $request->session()->save();
        }

        $account = auth()->user()->emailAccount;
        if (!$account) return response()->json(['error' => 'No account configured'], 400);

        try {
            // Configure dynamic SMTP mailer
            config([
                'mail.mailers.custom_smtp' => [
                    'transport' => 'smtp',
                    'host' => $account->smtp_host,
                    'port' => $account->smtp_port,
                    'encryption' => 'ssl',
                    'username' => $account->email,
                    'password' => $account->password,
                ],
                'mail.from.address' => $account->email,
                'mail.from.name' => auth()->user()->name,
            ]);

            $htmlBody    = $request->body;
            $uploadFiles = $request->file('attachments') ?? [];

            $sentMessage = \Illuminate\Support\Facades\Mail::mailer('custom_smtp')->html($htmlBody, function ($message) use ($request, $account, $uploadFiles) {
                $message->from($account->email, auth()->user()->name);
                $message->to($request->to)->subject($request->subject);

                if ($request->filled('cc')) {
                    $ccs = array_map('trim', explode(',', $request->cc));
                    $message->cc(array_filter($ccs));
                }
                if ($request->filled('bcc')) {
                    $bccs = array_map('trim', explode(',', $request->bcc));
                    $message->bcc(array_filter($bccs));
                }

                foreach ($uploadFiles as $file) {
                    if (!$file) continue;
                    $message->attachData(
                        file_get_contents($file->getRealPath()),
                        $file->getClientOriginalName(),
                        ['mime' => $file->getMimeType() ?: 'application/octet-stream']
                    );
                }
            });

            // Append to Sent Folder via IMAP
            $appendStatus = $this->appendToSentFolder($account, $request, $htmlBody, $sentMessage);

            return response()->json(['success' => true, 'sent_folder' => $appendStatus]);

        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    /**
     * Append a sent message to the IMAP Sent folder.
     * Returns a short status string for logging / response.
     */
    private function appendToSentFolder($account, Request $request, string $htmlBody, $sentMessage): string
    {
        try {
            $cm = new ClientManager([]);
            $client = $cm->make([
                'host'          => $account->imap_host,
                'port'          => $account->imap_port,
                'encryption'    => 'ssl',
                'validate_cert' => false,
                'username'      => $account->email,
                'password'      => $account->password,
                'protocol'      => 'imap',
            ]);
            $client->connect();

            // 1) Discover the Sent folder
            $sentFolder = $this->discoverSentFolder($client);
            if (!$sentFolder) {
                \Log::warning("Webmail Append: Could not find Sent folder on server.");
                return 'no_folder';
            }

            // 2) Build a valid RFC822 MIME message
            $rawMime = $this->buildSentMimeMessage($sentMessage, $account, $request, $htmlBody);

            // 3) Force CRLF line endings (IMAP APPEND requirement)
            $rawMime = preg_replace("/(?<!\r)\n/", "\r\n", $rawMime);

            // 4) Append (mark as Seen)
            $sentFolder->appendMessage($rawMime, ['\\Seen'], now()->format('d-M-Y H:i:s O'));
            \Log::info("Webmail: Message appended to Sent folder [" . $sentFolder->path . "].");
            return 'appended';
        } catch (\Exception $e) {
            \Log::error("Webmail Append Sent Failed: " . $e->getMessage());
            return 'error: ' . $e->getMessage();
        }
    }

    /**
     * Locate the Sent folder by common paths, with a folder-listing fallback.
     */
    private function discoverSentFolder($client)
    {
        $candidates = ['INBOX.Sent', 'Sent', 'Sent Messages', 'Sent Mail', 'INBOX.Sent Messages', '[Gmail]/Sent Mail'];
        foreach ($candidates as $name) {
            try {
                $folder = $client->getFolderByPath($name);
                if ($folder) return $folder;
            } catch (\Exception $e) {
                // try next
            }
        }

        // Fallback: enumerate folders and match by name
        try {
            $folders = $client->getFolders(false);
            foreach ($folders as $folder) {
                $n = strtolower($folder->name ?? '');
                $p = strtolower($folder->path ?? '');
                if (str_contains($n, 'sent') || str_contains($p, 'sent')) {
                    return $folder;
                }
            }
        } catch (\Exception $e) {
            \Log::info("Webmail: Folder enumeration failed: " . $e->getMessage());
        }

        return null;
    }

    /**
     * Build the MIME source to append. Prefers the Symfony-rendered MIME
     * from the actual sent message; falls back to a hand-built one with
     * Message-ID and proper UTF-8 subject + quoted-printable body encoding.
     */
    private function buildSentMimeMessage($sentMessage, $account, Request $request, string $htmlBody): string
    {
        // Prefer the real MIME the SMTP server received
        if ($sentMessage) {
            try {
                if (method_exists($sentMessage, 'getSymfonySentMessage')) {
                    $symfony = $sentMessage->getSymfonySentMessage();
                    if ($symfony && method_exists($symfony, 'getOriginalMessage')) {
                        $mime = $symfony->getOriginalMessage()->toString();
                        if (is_string($mime) && $mime !== '') return $mime;
                    }
                }
            } catch (\Exception $e) {
                \Log::info("Webmail: Could not extract Symfony MIME, falling back to manual. " . $e->getMessage());
            }
        }

        // Manual fallback — must be a fully-valid RFC822 message
        $domain    = parse_url(config('app.url'), PHP_URL_HOST) ?: 'localhost';
        $messageId = '<' . bin2hex(random_bytes(8)) . '.' . time() . '@' . $domain . '>';
        $fromName  = $this->encodeHeaderUtf8(auth()->user()->name);
        $subject   = $this->encodeHeaderUtf8($request->subject);

        $headers   = [];
        $headers[] = "From: $fromName <{$account->email}>";
        $headers[] = "To: {$request->to}";
        $headers[] = "Subject: $subject";
        $headers[] = "Date: " . now()->format('r');
        $headers[] = "Message-ID: $messageId";
        $headers[] = "MIME-Version: 1.0";
        $headers[] = "Content-Type: text/html; charset=UTF-8";
        $headers[] = "Content-Transfer-Encoding: quoted-printable";

        return implode("\r\n", $headers) . "\r\n\r\n" . quoted_printable_encode($htmlBody);
    }

    private function encodeHeaderUtf8(string $value): string
    {
        return preg_match('/[^\x20-\x7e]/', $value)
            ? '=?UTF-8?B?' . base64_encode($value) . '?='
            : $value;
    }
}
