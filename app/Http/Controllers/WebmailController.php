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
            
            // Fetch messages with bodystructure eagerly to avoid N+1 IMAP query lag.
            // Limit to 10 latest to ensure snappy UX.
            $messages = $folder->messages()->all()->setFetchFlags(true)->setFetchBody(true)->limit(10, 0)->get();
            
            $formatted = [];
            foreach ($messages as $message) {
                $textBody = $message->getTextBody() ?? '';
                if(empty($textBody)) {
                    $textBody = strip_tags($message->getHTMLBody() ?? '');
                }
                
                $snippet = mb_substr(trim(preg_replace('/\s+/', ' ', $textBody)), 0, 100) . '...';
                
                $dateObj = $message->getDate()[0] ?? now();
                $formatted[] = [
                    'id'      => $message->getUid(),
                    'subject' => (string)$message->getSubject() ?: '(No Subject)',
                    'from'    => $message->getFrom()[0]->mail ?? 'Unknown',
                    'from_name' => $message->getFrom()[0]->personal ?? ($message->getFrom()[0]->mail ?? 'Unknown'),
                    'date'    => $dateObj->format('M d, g:i A'),
                    'snippet' => $snippet,
                    'body'    => $message->getHTMLBody(true) ?? nl2br($textBody),
                    'flags'   => [
                        'seen' => $message->hasFlag('SEEN')
                    ],
                ];
            }

            return response()->json(['success' => true, 'messages' => array_reverse($formatted)]);

        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    public function sendEmail(Request $request)
    {
        $request->validate([
            'to' => 'required|email',
            'subject' => 'required',
            'body' => 'required'
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

            $sentMessage = \Illuminate\Support\Facades\Mail::mailer('custom_smtp')->raw($request->body, function ($message) use ($request, $account) {
                $message->from($account->email, auth()->user()->name);
                $message->to($request->to)->subject($request->subject);
                
                if ($request->filled('cc')) {
                    // split by comma if necessary
                    $ccs = array_map('trim', explode(',', $request->cc));
                    $message->cc(array_filter($ccs));
                }
                if ($request->filled('bcc')) {
                    $bccs = array_map('trim', explode(',', $request->bcc));
                    $message->bcc(array_filter($bccs));
                }
            });

            // Append to Sent Folder via IMAP
            try {
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

                // Try standard sent folder paths
                $folderNames = ['INBOX.Sent', 'Sent', 'Sent Messages', 'Sent Mail', 'INBOX.Sent Messages'];
                $sentFolder = null;
                foreach ($folderNames as $name) {
                    try {
                        $sentFolder = $client->getFolderByPath($name);
                        if ($sentFolder) break;
                    } catch (\Exception $e) { }
                }

                if ($sentFolder) {
                    // Build the MIME message manually for append
                    $rawMime = "From: " . auth()->user()->name . " <{$account->email}>\r\n";
                    $rawMime .= "To: {$request->to}\r\n";
                    $rawMime .= "Subject: {$request->subject}\r\n";
                    $rawMime .= "Date: " . now()->format('r') . "\r\n";
                    $rawMime .= "Content-Type: text/plain; charset=UTF-8\r\n";
                    $rawMime .= "\r\n";
                    $rawMime .= $request->body;

                    // Try to get the actual MIME from Symfony if available
                    if ($sentMessage && method_exists($sentMessage, 'getSymfonySentMessage')) {
                        try {
                            $rawMime = $sentMessage->getSymfonySentMessage()->getOriginalMessage()->toString();
                        } catch (\Exception $e) {
                            \Log::info("Using manually built MIME for Sent folder append.");
                        }
                    }

                    $sentFolder->appendMessage($rawMime, ['\Seen']);
                    \Log::info("Webmail: Message appended to Sent folder successfully.");
                } else {
                    \Log::warning("Webmail Append: Could not find Sent folder on server.");
                }
            } catch (\Exception $e) {
                \Log::error("Webmail Append Sent Failed: " . $e->getMessage());
            }

            return response()->json(['success' => true]);

        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }
}
