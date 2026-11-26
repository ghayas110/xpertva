<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PublicLeadController;


/*
 | Public marketing and blog pages.
 |
 | These run WITHOUT the session middleware. With SESSION_DRIVER=database the
 | web group was doing a database read and a write on every anonymous page
 | view to build a session no marketing page reads, and the resulting
 | laravel-session cookie made the response uncacheable by any CDN.
 |
 | Dropping it removes that round trip and lets Cloudflare hold the HTML.
 | Anything that genuinely needs a session — the portal, login, the chat
 | endpoints, the lead POSTs — keeps the full web group.
*/
$publicPage = ['cache.public'];
$noSession  = [
    \Illuminate\Session\Middleware\StartSession::class,
    \Illuminate\View\Middleware\ShareErrorsFromSession::class,
    \Illuminate\Foundation\Http\Middleware\ValidateCsrfToken::class,
];

Route::middleware($publicPage)->withoutMiddleware($noSession)->group(function () {

Route::get('/', function () {
    return view('home');
})->name('home');

Route::prefix('services')->name('services.')->group(function () {
    Route::get('/', function () {
        return view('services.index');
    })->name('index');

    Route::get('/amazon', function () {
        return view('services.amazon');
    })->name('amazon');

    Route::prefix('amazon')->name('amazon.')->group(function () {
        Route::get('/listing-optimization', fn () => view('services.amazon.listing-optimization'))->name('listing-optimization');
        Route::get('/ppc-management', fn () => view('services.amazon.ppc-management'))->name('ppc-management');
        Route::get('/seo-keyword-research', fn () => view('services.amazon.seo-keyword-research'))->name('seo-keyword-research');
        Route::get('/a-plus-storefront', fn () => view('services.amazon.a-plus-storefront'))->name('a-plus-storefront');
        Route::get('/account-management', fn () => view('services.amazon.account-management'))->name('account-management');
        Route::get('/brand-protection', fn () => view('services.amazon.brand-protection'))->name('brand-protection');
    });

    Route::get('/shopify', function () {
        return view('services.shopify');
    })->name('shopify');

    Route::get('/walmart', function () {
        return view('services.walmart');
    })->name('walmart');

    Route::get('/ebay', function () {
        return view('services.ebay');
    })->name('ebay');

    Route::get('/design-development', function () {
        return view('services.design-development');
    })->name('design');

    Route::get('/amazon-virtual-assistant', fn () => view('services.amazon-virtual-assistant'))->name('amazon-va');

    Route::get('/virtual-assistant', function () {
        return view('services.va');
    })->name('va');

    Route::get('/marketing-solutions', function () {
        return view('services.marketing-solutions');
    })->name('marketing');

    Route::get('/web-development', function () {
        return view('services.web-development');
    })->name('web-dev');

    Route::get('/amazon-operations', function () {
        return view('services.amazon-operation');
    })->name('amazon-ops');

    Route::get('/content-branding', function () {
        return view('services.content-branding');
    })->name('content-branding');

    Route::get('/mobile-app-development', function () {
        return view('services.mobile-app-development');
    })->name('mobile-app');
});

Route::get('/work', function () {
    return view('work');
})->name('work');

// Amazon case files: one page per Seller Central case we resolved, from
// resources/data/amazon-cases.json. Registered before /work/{case} so
// "amazon-cases" is never read as a case-study slug.
Route::get('/work/amazon-cases', function () {
    return view('work-amazon-cases', ['cases' => \App\Support\AmazonCases::all()]);
})->name('work.amazon-cases');

Route::get('/work/amazon-cases/{slug}', function (string $slug) {
    $case = \App\Support\AmazonCases::find($slug) ?? abort(404);

    return view('work-amazon-case', compact('slug', 'case'));
})->where('slug', '[a-z0-9-]+')->name('work.amazon-case');

// Case studies and author bio pages are both driven by config/content.php,
// so an unknown slug is a plain 404 rather than a database miss.
Route::get('/work/{case}', function (string $case) {
    $study = config('content.case_studies', [])[$case] ?? abort(404);

    return view('work-case', ['slug' => $case, 'study' => $study]);
})->where('case', '[a-z0-9-]+')->name('work.case');

Route::get('/team', function () {
    return view('team');
})->name('team');

Route::get('/team/{member}', function (string $member) {
    $author = \App\Support\Authors::find($member) ?? abort(404);
    $posts = \App\Models\Blog::listed()
        ->whereIn('slug', \App\Support\Authors::slugsFor($member))
        ->latest()
        ->get();

    return view('team-member', compact('author', 'posts'));
})->where('member', '[a-z0-9-]+')->name('team.member');

});

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\NoteController;

// Dashboard Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/attendance/toggle', [AttendanceController::class, 'toggle'])->name('attendance.toggle');
    
    // Tasks
    Route::get('/tasks', [TaskController::class, 'index'])->name('tasks.index');
    Route::post('/tasks', [TaskController::class, 'store'])->name('tasks.store');
    Route::get('/tasks/{task}', [TaskController::class, 'show'])->name('tasks.show');
    Route::get('/tasks/{task}/card', [TaskController::class, 'getCard'])->name('tasks.card');
    Route::patch('/tasks/{task}/status', [TaskController::class, 'updateStatus'])->name('tasks.status');
    Route::patch('/tasks/{task}', [TaskController::class, 'update'])->name('tasks.update');
    Route::patch('/tasks/{task}/assignee', [TaskController::class, 'updateAssignee'])->name('tasks.updateAssignee');
    Route::post('/tasks/{task}/comments', [TaskController::class, 'addComment'])->name('tasks.comments.store');
    Route::delete('/tasks/{task}', [TaskController::class, 'destroy'])->name('tasks.destroy');

    // Clients
    Route::get('/clients', [\App\Http\Controllers\ClientController::class, 'index'])->name('clients.index');
    Route::post('/clients', [\App\Http\Controllers\ClientController::class, 'store'])->name('clients.store');
    Route::put('/clients/{client}', [\App\Http\Controllers\ClientController::class, 'update'])->name('clients.update');
    Route::patch('/clients/{client}/convert', [\App\Http\Controllers\ClientController::class, 'convertToClient'])->name('clients.convert');
    Route::delete('/clients/{client}', [\App\Http\Controllers\ClientController::class, 'destroy'])->name('clients.destroy');

    // Financials
    Route::get('/financials', [\App\Http\Controllers\FinancialController::class, 'index'])->name('financials.index');
    Route::post('/financials', [\App\Http\Controllers\FinancialController::class, 'store'])->name('financials.store');
    Route::put('/financials/{financial}', [\App\Http\Controllers\FinancialController::class, 'update'])->name('financials.update');
    Route::delete('/financials/{financial}', [\App\Http\Controllers\FinancialController::class, 'destroy'])->name('financials.destroy');

    // HR
    Route::get('/hr/progress', [\App\Http\Controllers\HrController::class, 'index'])->name('hr.progress');

    // Messages
    Route::get('/messages', [\App\Http\Controllers\MessageController::class, 'index'])->name('messages.index');
    Route::post('/messages', [\App\Http\Controllers\MessageController::class, 'store'])->name('messages.store');
    Route::patch('/messages/{message}/read', [\App\Http\Controllers\MessageController::class, 'markAsRead'])->name('messages.read');

    // Internal User Management
    Route::get('/users', [\App\Http\Controllers\UserController::class, 'index'])->name('users.index');
    Route::post('/users', [\App\Http\Controllers\UserController::class, 'store'])->name('users.store');
    Route::get('/users/{user}', [\App\Http\Controllers\UserController::class, 'show'])->name('users.show');
    Route::put('/users/{user}', [\App\Http\Controllers\UserController::class, 'update'])->name('users.update');
    Route::post('/users/{user}/fire', [\App\Http\Controllers\UserController::class, 'fire'])->name('users.fire');
    Route::get('/activities', [\App\Http\Controllers\Admin\ActivityLogController::class, 'index'])->name('admin.activities');

    // Website chat inbox (operator side)
    Route::get('/chat', [\App\Http\Controllers\Admin\ChatInboxController::class, 'index'])->name('chat.index');
    Route::get('/chat/threads', [\App\Http\Controllers\Admin\ChatInboxController::class, 'threads'])->name('chat.threads');
    Route::get('/chat/{conversation}/messages', [\App\Http\Controllers\Admin\ChatInboxController::class, 'messages'])->name('chat.messages');
    Route::post('/chat/{conversation}/reply', [\App\Http\Controllers\Admin\ChatInboxController::class, 'reply'])->name('chat.reply');
    Route::post('/chat/{conversation}/close', [\App\Http\Controllers\Admin\ChatInboxController::class, 'close'])->name('chat.close');

    // Desktop monitoring agent provisioning (super admin only)
    Route::get('/admin/agents', [\App\Http\Controllers\Admin\AgentProvisionController::class, 'index'])->name('admin.agents');
    Route::post('/admin/agents/{user}/regenerate', [\App\Http\Controllers\Admin\AgentProvisionController::class, 'regenerate'])->name('admin.agents.regenerate');

    // Background push notification subscriptions (one row per browser)
    Route::post('/push/subscribe', [\App\Http\Controllers\PushSubscriptionController::class, 'store'])->name('push.subscribe');
    Route::post('/push/unsubscribe', [\App\Http\Controllers\PushSubscriptionController::class, 'destroy'])->name('push.unsubscribe');
    Route::post('/push/test', [\App\Http\Controllers\PushSubscriptionController::class, 'test'])
        ->middleware('throttle:6,1')
        ->name('push.test');

    // Notifications
    Route::post('/notifications/mark-all-read', function () {
        auth()->user()->unreadNotifications->markAsRead();
        return back();
    })->name('notifications.markAllRead');

    Route::get('/notifications/poll', function (\Illuminate\Http\Request $request) {
        $user  = auth()->user();
        $since = $request->query('since');

        $query = $user->notifications();
        if ($since) {
            try {
                $query->where('created_at', '>', \Carbon\Carbon::parse($since));
            } catch (\Throwable $e) { /* ignore bad timestamp */ }
        }

        $new = $query->orderBy('created_at')->get();

        $items = $new->map(function ($n) {
            // One resolver for all three places a notification can be clicked:
            // this poll response, the bell dropdown, and the background push.
            $url = \App\Support\NotificationLink::for((array) $n->data);

            return [
                'id'         => $n->id,
                'title'      => $n->data['title']   ?? 'New Notification',
                'message'    => $n->data['message'] ?? '',
                'icon'       => $n->data['icon']    ?? 'fa-solid fa-bell',
                'url'        => $url,
                'created_at' => $n->created_at->toIso8601String(),
                'is_unread'  => is_null($n->read_at),
            ];
        })->values();

        return response()->json([
            'unread_count' => $user->unreadNotifications()->count(),
            'server_time'  => now()->toIso8601String(),
            'new'          => $items,
        ]);
    })->name('notifications.poll');

    // Employee Activity
    Route::post('/employee-activity', [\App\Http\Controllers\EmployeeActivityController::class, 'store'])->name('activity.store');

    // Attendance Views
    Route::get('/my-attendance', [\App\Http\Controllers\AttendanceController::class, 'myAttendance'])->name('attendance.my');
    Route::middleware('role:hr,super_admin')->group(function () {
        Route::get('/attendance-management', [\App\Http\Controllers\AttendanceController::class, 'manage'])->name('attendance.manage');
    });

    // Webmail 
    Route::get('/email', [\App\Http\Controllers\WebmailController::class, 'index'])->name('webmail.index');
    Route::post('/email/save-config', [\App\Http\Controllers\WebmailController::class, 'saveConfig'])->name('webmail.save-config');
    Route::post('/email/disconnect', [\App\Http\Controllers\WebmailController::class, 'disconnect'])->name('webmail.disconnect');
    Route::get('/email/fetch', [\App\Http\Controllers\WebmailController::class, 'fetchMessages'])->name('webmail.fetch');
    Route::post('/email/send', [\App\Http\Controllers\WebmailController::class, 'sendEmail'])->name('webmail.send');
    Route::post('/email/mark-seen', [\App\Http\Controllers\WebmailController::class, 'markSeen'])->name('webmail.mark-seen');

    // Notes (Google Keep-like)
    Route::get('/notes', [NoteController::class, 'index'])->name('notes.index');
    Route::post('/notes', [NoteController::class, 'store'])->name('notes.store');
    Route::patch('/notes/{note}', [NoteController::class, 'update'])->name('notes.update');
    Route::delete('/notes/{note}', [NoteController::class, 'destroy'])->name('notes.destroy');

    // Attendance heartbeat (keep-alive for online status)
    Route::post('/attendance/heartbeat', [AttendanceController::class, 'heartbeat'])->name('attendance.heartbeat');

    // Leaves
    Route::get('/leaves', [\App\Http\Controllers\LeaveController::class, 'index'])->name('leaves.index');
    Route::get('/leaves/create', [\App\Http\Controllers\LeaveController::class, 'create'])->name('leaves.create');
    Route::post('/leaves', [\App\Http\Controllers\LeaveController::class, 'store'])->name('leaves.store');
    Route::get('/leaves/{leave}/edit', [\App\Http\Controllers\LeaveController::class, 'edit'])->name('leaves.edit');
    Route::put('/leaves/{leave}', [\App\Http\Controllers\LeaveController::class, 'update'])->name('leaves.update');

    // Profile
    Route::get('/profile', [\App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [\App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
    Route::patch('/profile/password', [\App\Http\Controllers\ProfileController::class, 'updatePassword'])->name('profile.password');
    Route::patch('/profile/contact', [\App\Http\Controllers\ProfileController::class, 'updateContact'])->name('profile.contact');

    // Settings (Super Admin & HR only; admin can also edit company shift schedule)
    Route::middleware('role:super_admin,hr')->group(function () {
        Route::get('/settings', [\App\Http\Controllers\SettingsController::class, 'index'])->name('settings.index');
    });
    Route::middleware('role:super_admin')->group(function () {
        Route::patch('/settings/shift', [\App\Http\Controllers\SettingsController::class, 'update'])->name('settings.shift');
    });

    // Admin Blog Management
    Route::middleware('role:super_admin')->group(function () {
        Route::resource('admin/blogs', \App\Http\Controllers\Admin\BlogController::class)->names([
            'index' => 'admin.blogs.index',
            'create' => 'admin.blogs.create',
            'store' => 'admin.blogs.store',
            'edit' => 'admin.blogs.edit',
            'update' => 'admin.blogs.update',
            'destroy' => 'admin.blogs.destroy',
        ])->except(['show']);
    });
});

Route::middleware($publicPage)->withoutMiddleware($noSession)->group(function () {

Route::get('/contact', function () {
    return view('contact');
})->name('contact');

Route::get('/about', function () {
    return redirect()->route('team', [], 301);
})->name('about');

Route::get('/sitemap.xml', function () {
    /*
     | lastmod for a page is the modified time of the view that renders it,
     | so it moves when the page's content actually changes and not on every
     | deploy. changefreq and priority are gone: Google ignores both.
     |
     | Deploys must preserve file mtimes for this to mean anything. A plain
     | git pull does (it only touches changed files); an upload tool that
     | resets every timestamp would make every page look freshly edited.
    */
    $viewTime = function (string $view): ?string {
        $file = resource_path('views/' . str_replace('.', '/', $view) . '.blade.php');

        return is_file($file) ? date(DATE_ATOM, filemtime($file)) : null;
    };

    $pages = [
        '/'                                      => 'home',
        '/team'                                  => 'team',
        '/work'                                  => 'work',
        '/contact'                               => 'contact',
        '/services'                              => 'services.index',
        '/services/amazon'                       => 'services.amazon',
        '/services/amazon/listing-optimization'  => 'services.amazon.listing-optimization',
        '/services/amazon/ppc-management'        => 'services.amazon.ppc-management',
        '/services/amazon/seo-keyword-research'  => 'services.amazon.seo-keyword-research',
        '/services/amazon/a-plus-storefront'     => 'services.amazon.a-plus-storefront',
        '/services/amazon/account-management'    => 'services.amazon.account-management',
        '/services/amazon/brand-protection'      => 'services.amazon.brand-protection',
        '/services/shopify'                      => 'services.shopify',
        '/services/walmart'                      => 'services.walmart',
        '/services/ebay'                         => 'services.ebay',
        '/services/amazon-virtual-assistant'     => 'services.amazon-virtual-assistant',
        '/services/virtual-assistant'            => 'services.va',
        '/services/amazon-operations'            => 'services.amazon-operation',
        '/services/marketing-solutions'          => 'services.marketing-solutions',
        '/services/web-development'              => 'services.web-development',
        '/services/content-branding'             => 'services.content-branding',
        '/services/mobile-app-development'       => 'services.mobile-app-development',
        '/services/design-development'           => 'services.design-development',
        '/privacy-policy'                        => 'privacy-policy',
    ];

    $urls = [];
    foreach ($pages as $path => $view) {
        $urls[] = ['loc' => url($path), 'lastmod' => $viewTime($view)];
    }

    // Config-driven pages: the later of the view and config/content.php.
    $contentTime = filemtime(config_path('content.php'));
    $later = fn (?string $a) => date(DATE_ATOM, max($a ? strtotime($a) : 0, $contentTime));
    foreach (array_keys(config('content.case_studies', [])) as $slug) {
        $urls[] = ['loc' => route('work.case', $slug), 'lastmod' => $later($viewTime('work-case'))];
    }
    $casesTime = fn (string $view) => date(DATE_ATOM, max(strtotime($viewTime($view) ?? '@0'), \App\Support\AmazonCases::lastModified()));
    $urls[] = ['loc' => route('work.amazon-cases'), 'lastmod' => $casesTime('work-amazon-cases')];
    foreach (array_keys(\App\Support\AmazonCases::all()) as $slug) {
        $urls[] = ['loc' => route('work.amazon-case', $slug), 'lastmod' => $casesTime('work-amazon-case')];
    }
    foreach (array_keys(config('content.authors', [])) as $key) {
        $urls[] = ['loc' => route('team.member', $key), 'lastmod' => $later($viewTime('team-member'))];
    }

    $blogs = \App\Models\Blog::listed()->select('slug', 'updated_at')->orderBy('created_at', 'desc')->get();
    $urls[] = ['loc' => url('/blog'), 'lastmod' => optional($blogs->max('updated_at'))->toAtomString()];
    foreach ($blogs as $blog) {
        $urls[] = ['loc' => url('/blog/' . $blog->slug), 'lastmod' => $blog->updated_at->toAtomString()];
    }

    $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
    $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";
    foreach ($urls as $url) {
        $xml .= "  <url>\n";
        $xml .= "    <loc>" . e($url['loc']) . "</loc>\n";
        if (!empty($url['lastmod'])) {
            $xml .= "    <lastmod>" . $url['lastmod'] . "</lastmod>\n";
        }
        $xml .= "  </url>\n";
    }
    $xml .= '</urlset>';

    return response($xml, 200)->header('Content-Type', 'application/xml');
})->name('sitemap');

Route::get('/thank-you', function () {
    return view('thank-you');
})->name('thank-you');

Route::get('/privacy-policy', function () {
    return view('privacy-policy');
})->name('privacy-policy');

// Blog Frontend
Route::prefix('blog')->name('blog.')->group(function () {
    Route::get('/', [\App\Http\Controllers\BlogController::class, 'index'])->name('index');
    Route::get('/{slug}', [\App\Http\Controllers\BlogController::class, 'show'])->name('show');
});

});

// Public Website Chat (anonymous visitors, throttled)
Route::middleware('throttle:30,1')->prefix('chat')->name('chat.')->group(function () {
    Route::get('/token', [\App\Http\Controllers\ChatController::class, 'token'])->name('token');
    Route::post('/start', [\App\Http\Controllers\ChatController::class, 'start'])->name('start');
    Route::post('/{token}/send', [\App\Http\Controllers\ChatController::class, 'send'])->name('send');
});
Route::middleware('throttle:120,1')
    ->get('/chat/{token}/poll', [\App\Http\Controllers\ChatController::class, 'poll'])
    ->name('chat.poll');

// Public Lead Submissions
Route::post('/contact/submit', [PublicLeadController::class, 'contactSubmit'])->name('contact.submit');
Route::post('/audit/submit', [PublicLeadController::class, 'auditSubmit'])->name('audit.submit');

