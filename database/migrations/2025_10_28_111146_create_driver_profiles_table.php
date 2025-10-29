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
        Schema::create('driver_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained()->onDelete('cascade');
            $table->foreignId('vehicle_type_id')->constrained()->onDelete('restrict');
            $table->string('vehicle_make')->nullable(); // e.g., Ford, Toyota
            $table->string('vehicle_model')->nullable(); // e.g., Transit, Hilux
            $table->year('vehicle_year')->nullable();
            $table->string('vehicle_plate_number')->nullable();
            $table->string('vehicle_color')->nullable();
            $table->decimal('vehicle_capacity', 10, 2)->nullable(); // in kg or cubic meters
            $table->text('bio')->nullable();
            $table->decimal('base_rate_per_km', 10, 2)->default(0); // Base rate per kilometer
            $table->decimal('base_rate_fixed', 10, 2)->default(0); // Fixed base rate
            $table->decimal('rating', 3, 2)->default(0)->comment('Average rating out of 5');
            $table->integer('total_trips')->default(0);
            $table->boolean('is_verified')->default(false);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();

            // Indexes
            $table->index('user_id');
            $table->index('vehicle_type_id');
            $table->index('rating');
            $table->index('is_verified');
            $table->index('is_active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('driver_profiles');
    }
};
