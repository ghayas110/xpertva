<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Per-employee token the desktop monitoring agent uses to authenticate.
            $table->string('agent_token', 64)->nullable()->unique()->after('remember_token');
            // Timestamp the employee acknowledged the on-screen monitoring notice.
            $table->timestamp('monitoring_consent_at')->nullable()->after('agent_token');
        });

        // Backfill a token for every existing user so agents can be provisioned.
        DB::table('users')->whereNull('agent_token')->orderBy('id')->get(['id'])
            ->each(function ($u) {
                DB::table('users')->where('id', $u->id)
                    ->update(['agent_token' => Str::random(48)]);
            });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['agent_token', 'monitoring_consent_at']);
        });
    }
};
