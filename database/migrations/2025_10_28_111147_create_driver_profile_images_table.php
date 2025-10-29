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
        Schema::create('driver_profile_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('driver_profile_id')->constrained()->onDelete('cascade');
            $table->string('image_path');
            $table->string('image_name')->nullable();
            $table->enum('type', ['vehicle_exterior', 'vehicle_interior', 'vehicle_cargo_space', 'license', 'other'])->default('vehicle_exterior');
            $table->integer('order')->default(0);
            $table->boolean('is_primary')->default(false);
            $table->timestamps();

            // Indexes
            $table->index('driver_profile_id');
            $table->index('type');
            $table->index('is_primary');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('driver_profile_images');
    }
};
