<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('push_subscriptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();

            // Push endpoints run to a few hundred characters and vary by
            // browser, so the URL itself is a TEXT column and uniqueness is
            // enforced on a hash of it — MySQL cannot index a whole TEXT.
            $table->text('endpoint');
            $table->char('endpoint_hash', 64)->unique();

            $table->string('p256dh', 255);   // the browser's public key
            $table->string('auth', 255);     // its 16 byte auth secret
            $table->string('user_agent', 255)->nullable();

            // Push services answer 404/410 for a subscription the browser has
            // thrown away; those are pruned immediately. Anything else that
            // merely fails is counted, and only dropped once it keeps failing.
            $table->unsignedTinyInteger('failures')->default(0);
            $table->timestamp('last_used_at')->nullable();
            $table->timestamps();

            $table->index('user_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('push_subscriptions');
    }
};
