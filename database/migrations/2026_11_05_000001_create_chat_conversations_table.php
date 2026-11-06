<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('chat_conversations', function (Blueprint $table) {
            $table->id();
            // Public identifier handed to the browser. The visitor is never
            // authenticated, so this token is the only thing guarding the thread.
            $table->string('token', 64)->unique();
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('page_url')->nullable();
            $table->string('status', 20)->default('open');
            $table->foreignId('assigned_to')->nullable()->constrained('users')->nullOnDelete();
            $table->unsignedInteger('unread_for_agent')->default(0);
            $table->unsignedInteger('unread_for_visitor')->default(0);
            $table->timestamp('last_message_at')->nullable();
            $table->timestamps();

            $table->index(['status', 'last_message_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('chat_conversations');
    }
};
