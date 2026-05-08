<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PublicLeadController;

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

    Route::prefix('amazon')->name('amazon.')->group(function () {
        Route::get('/listing-optimization', fn() => view('services.amazon.listing-optimization'))->name('listing-optimization');
        Route::get('/ppc-management', fn() => view('services.amazon.ppc-management'))->name('ppc-management');
        Route::get('/seo-keyword-research', fn() => view('services.amazon.seo-keyword-research'))->name('seo-keyword-research');
        Route::get('/a-plus-storefront', fn() => view('services.amazon.a-plus-storefront'))->name('a-plus-storefront');
        Route::get('/account-management', fn() => view('services.amazon.account-management'))->name('account-management');
        Route::get('/brand-protection', fn() => view('services.amazon.brand-protection'))->name('brand-protection');
    });
});

Route::get('/work', function () {
    return view('work');
})->name('work');

Route::get('/team', function () {
    return view('team');
})->name('team');

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\TaskController;

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

    // Notifications
    Route::post('/notifications/mark-all-read', function () {
        auth()->user()->unreadNotifications->markAsRead();
        return back();
    })->name('notifications.markAllRead');

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

    // Leaves
    Route::get('/leaves', [\App\Http\Controllers\LeaveController::class, 'index'])->name('leaves.index');
    Route::get('/leaves/create', [\App\Http\Controllers\LeaveController::class, 'create'])->name('leaves.create');
    Route::post('/leaves', [\App\Http\Controllers\LeaveController::class, 'store'])->name('leaves.store');
    Route::get('/leaves/{leave}/edit', [\App\Http\Controllers\LeaveController::class, 'edit'])->name('leaves.edit');
    Route::put('/leaves/{leave}', [\App\Http\Controllers\LeaveController::class, 'update'])->name('leaves.update');

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

Route::get('/contact', function () {
    return view('contact');
})->name('contact');

Route::get('/about', function () {
    return redirect()->route('team', [], 301);
})->name('about');

Route::get('/sitemap.xml', function () {
    $urls = [
        ['loc' => url('/'), 'changefreq' => 'weekly', 'priority' => '1.0'],
        ['loc' => url('/team'), 'changefreq' => 'monthly', 'priority' => '0.8'],
        ['loc' => url('/work'), 'changefreq' => 'monthly', 'priority' => '0.8'],
        ['loc' => url('/contact'), 'changefreq' => 'yearly', 'priority' => '0.7'],
        ['loc' => url('/services'), 'changefreq' => 'monthly', 'priority' => '0.9'],
        ['loc' => url('/services/amazon'), 'changefreq' => 'monthly', 'priority' => '0.9'],
        ['loc' => url('/services/amazon/listing-optimization'), 'changefreq' => 'monthly', 'priority' => '0.85'],
        ['loc' => url('/services/amazon/ppc-management'), 'changefreq' => 'monthly', 'priority' => '0.85'],
        ['loc' => url('/services/amazon/seo-keyword-research'), 'changefreq' => 'monthly', 'priority' => '0.85'],
        ['loc' => url('/services/amazon/a-plus-storefront'), 'changefreq' => 'monthly', 'priority' => '0.85'],
        ['loc' => url('/services/amazon/account-management'), 'changefreq' => 'monthly', 'priority' => '0.85'],
        ['loc' => url('/services/amazon/brand-protection'), 'changefreq' => 'monthly', 'priority' => '0.85'],
        ['loc' => url('/services/amazon/listing-optimization'), 'changefreq' => 'monthly', 'priority' => '0.8'],
        ['loc' => url('/services/amazon/ppc-management'), 'changefreq' => 'monthly', 'priority' => '0.8'],
        ['loc' => url('/services/amazon/seo-keyword-research'), 'changefreq' => 'monthly', 'priority' => '0.8'],
        ['loc' => url('/services/amazon/a-plus-storefront'), 'changefreq' => 'monthly', 'priority' => '0.8'],
        ['loc' => url('/services/amazon/account-management'), 'changefreq' => 'monthly', 'priority' => '0.8'],
        ['loc' => url('/services/amazon/brand-protection'), 'changefreq' => 'monthly', 'priority' => '0.8'],
        ['loc' => url('/services/shopify'), 'changefreq' => 'monthly', 'priority' => '0.8'],
        ['loc' => url('/services/walmart'), 'changefreq' => 'monthly', 'priority' => '0.8'],
        ['loc' => url('/services/ebay'), 'changefreq' => 'monthly', 'priority' => '0.8'],
        ['loc' => url('/services/virtual-assistant'), 'changefreq' => 'monthly', 'priority' => '0.9'],
        ['loc' => url('/services/amazon-operations'), 'changefreq' => 'monthly', 'priority' => '0.8'],
        ['loc' => url('/services/marketing-solutions'), 'changefreq' => 'monthly', 'priority' => '0.8'],
        ['loc' => url('/services/web-development'), 'changefreq' => 'monthly', 'priority' => '0.8'],
        ['loc' => url('/services/content-branding'), 'changefreq' => 'monthly', 'priority' => '0.7'],
        ['loc' => url('/services/mobile-app-development'), 'changefreq' => 'monthly', 'priority' => '0.7'],
        ['loc' => url('/services/design-development'), 'changefreq' => 'monthly', 'priority' => '0.7'],
        ['loc' => url('/blog'), 'changefreq' => 'weekly', 'priority' => '0.8'],
        ['loc' => url('/privacy-policy'), 'changefreq' => 'yearly', 'priority' => '0.3'],
    ];

    $blogs = \App\Models\Blog::select('slug', 'updated_at')->orderBy('created_at', 'desc')->get();
    foreach ($blogs as $blog) {
        $urls[] = [
            'loc' => url('/blog/' . $blog->slug),
            'lastmod' => $blog->updated_at->toAtomString(),
            'changefreq' => 'monthly',
            'priority' => '0.7',
        ];
    }

    $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
    $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";
    foreach ($urls as $url) {
        $xml .= "  <url>\n";
        $xml .= "    <loc>" . e($url['loc']) . "</loc>\n";
        if (isset($url['lastmod'])) {
            $xml .= "    <lastmod>" . $url['lastmod'] . "</lastmod>\n";
        }
        $xml .= "    <changefreq>" . $url['changefreq'] . "</changefreq>\n";
        $xml .= "    <priority>" . $url['priority'] . "</priority>\n";
        $xml .= "  </url>\n";
    }
    $xml .= '</urlset>';

    return response($xml, 200)->header('Content-Type', 'application/xml');
})->name('sitemap');

Route::get('/privacy-policy', function () {
    return view('privacy-policy');
})->name('privacy-policy');

// Blog Frontend
Route::prefix('blog')->name('blog.')->group(function () {
    Route::get('/', [\App\Http\Controllers\BlogController::class, 'index'])->name('index');
    Route::get('/{slug}', [\App\Http\Controllers\BlogController::class, 'show'])->name('show');
});

// Public Lead Submissions
Route::post('/contact/submit', [PublicLeadController::class, 'contactSubmit'])->name('contact.submit');
Route::post('/audit/submit', [PublicLeadController::class, 'auditSubmit'])->name('audit.submit');

Route::get('/autologin-test', function () {
    auth()->login(\App\Models\User::first());
    return redirect('/email');
});
require __DIR__.'/test_webmail.php';
