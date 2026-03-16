<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->json('email')->nullable()->after('company_name');
            $table->json('phone')->nullable()->after('email');
            $table->text('background_info')->nullable()->after('phone');
            $table->string('website')->nullable()->after('background_info');
            $table->string('source')->nullable()->after('website');
            $table->string('company_logo')->nullable()->after('company_name');
            $table->string('attached_file')->nullable()->after('source');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->dropColumn([
                'email', 
                'phone', 
                'background_info', 
                'website', 
                'source',
                'company_logo',
                'attached_file'
            ]);
        });
    }
};
