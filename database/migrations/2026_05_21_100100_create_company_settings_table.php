<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('company_settings', function (Blueprint $table) {
            $table->id();
            $table->time('shift_start')->default('09:00:00');
            $table->time('shift_end')->default('17:00:00');
            $table->time('late_cutoff')->default('16:55:00');
            $table->timestamps();
        });

        \DB::table('company_settings')->insert([
            'shift_start' => '09:00:00',
            'shift_end'   => '17:00:00',
            'late_cutoff' => '16:55:00',
            'created_at'  => now(),
            'updated_at'  => now(),
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('company_settings');
    }
};
