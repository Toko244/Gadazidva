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
        Schema::create('service_posts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('cargo_type_id')->constrained()->onDelete('restrict');
            $table->string('title');
            $table->string('origin_address');
            $table->string('origin_city');
            $table->decimal('origin_latitude', 10, 7)->nullable();
            $table->decimal('origin_longitude', 10, 7)->nullable();
            $table->string('destination_address');
            $table->string('destination_city');
            $table->decimal('destination_latitude', 10, 7)->nullable();
            $table->decimal('destination_longitude', 10, 7)->nullable();
            $table->dateTime('loading_date');
            $table->decimal('cargo_weight', 10, 2)->nullable(); // in kg
            $table->text('description')->nullable();
            $table->string('contact_phone', 50);
            $table->string('contact_email')->nullable();
            $table->enum('status', ['pending', 'active', 'completed', 'cancelled'])->default('active');
            $table->boolean('is_published')->default(true);
            $table->timestamps();
            $table->softDeletes();

            // Indexes for better query performance
            $table->index('user_id');
            $table->index('cargo_type_id');
            $table->index('origin_city');
            $table->index('destination_city');
            $table->index('loading_date');
            $table->index('status');
            $table->index('is_published');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_posts');
    }
};
