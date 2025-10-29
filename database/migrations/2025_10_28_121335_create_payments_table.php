<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('payer_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('payee_id')->constrained('users')->onDelete('cascade');
            $table->string('payable_type'); // ServicePost, HelperPost, etc.
            $table->unsignedBigInteger('payable_id');
            $table->decimal('amount', 10, 2);
            $table->string('currency', 3)->default('GEL'); // Georgian Lari
            $table->enum('status', ['pending', 'processing', 'completed', 'failed', 'refunded'])->default('pending');
            $table->string('payment_method')->nullable(); // card, cash, bank_transfer
            $table->string('transaction_id')->nullable()->unique();
            $table->string('payment_gateway')->nullable(); // stripe, bog, tbc, etc.
            $table->text('description')->nullable();
            $table->json('metadata')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index('payer_id');
            $table->index('payee_id');
            $table->index(['payable_type', 'payable_id']);
            $table->index('status');
            $table->index('transaction_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
