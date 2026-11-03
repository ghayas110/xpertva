<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('employee_activities', function (Blueprint $table) {
            // Where the row came from: 'extension' (browser plugin) or 'agent' (desktop app).
            $table->string('source', 20)->default('extension')->after('user_id');
            // The browser/application process, e.g. "chrome", "msedge", "firefox".
            $table->string('app_name')->nullable()->after('url');
            // Full window/tab title captured from the foreground browser window.
            $table->string('window_title', 512)->nullable()->after('app_name');
            // When the sample was actually taken on the client (may lag the request).
            $table->timestamp('captured_at')->nullable()->after('window_title');
            $table->index(['user_id', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::table('employee_activities', function (Blueprint $table) {
            $table->dropIndex(['user_id', 'created_at']);
            $table->dropColumn(['source', 'app_name', 'window_title', 'captured_at']);
        });
    }
};
