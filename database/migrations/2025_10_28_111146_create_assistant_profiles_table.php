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
        Schema::create('assistant_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained()->onDelete('cascade');
            $table->text('bio')->nullable();
            $table->text('skills')->nullable(); // e.g., Heavy lifting, Packing, Assembly
            $table->integer('years_of_experience')->default(0);
            $table->decimal('hourly_rate', 10, 2)->default(0);
            $table->decimal('rating', 3, 2)->default(0)->comment('Average rating out of 5');
            $table->integer('total_jobs')->default(0);
            $table->boolean('has_own_tools')->default(false);
            $table->boolean('is_verified')->default(false);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();

            // Indexes
            $table->index('user_id');
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
        Schema::dropIfExists('assistant_profiles');
    }
};
