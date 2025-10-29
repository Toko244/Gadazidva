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
        Schema::create('helper_posts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('driver_id')->constrained('users')->onDelete('cascade');
            $table->string('title');
            $table->text('description');
            $table->string('location_address');
            $table->string('location_city');
            $table->decimal('location_latitude', 10, 7)->nullable();
            $table->decimal('location_longitude', 10, 7)->nullable();
            $table->dateTime('required_date');
            $table->integer('duration_hours')->nullable(); // Expected duration in hours
            $table->integer('helpers_needed')->default(1);
            $table->decimal('offered_rate', 10, 2)->nullable(); // Offered payment
            $table->string('contact_phone', 50);
            $table->text('requirements')->nullable(); // Special requirements/skills needed
            $table->enum('status', ['pending', 'active', 'filled', 'completed', 'cancelled'])->default('active');
            $table->boolean('is_published')->default(true);
            $table->timestamps();
            $table->softDeletes();

            // Indexes
            $table->index('driver_id');
            $table->index('location_city');
            $table->index('required_date');
            $table->index('status');
            $table->index('is_published');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('helper_posts');
    }
};
