<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('conversations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user1_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('user2_id')->constrained('users')->onDelete('cascade');
            $table->unsignedBigInteger('last_message_id')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index('user1_id');
            $table->index('user2_id');
            $table->index('last_message_id');
            $table->unique(['user1_id', 'user2_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('conversations');
    }
};
