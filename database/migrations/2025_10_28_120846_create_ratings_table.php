<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ratings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rater_id')->constrained('users')->onDelete('cascade'); // Who gave the rating
            $table->foreignId('rated_id')->constrained('users')->onDelete('cascade'); // Who received the rating
            $table->string('rateable_type'); // DriverProfile, AssistantProfile, or ServicePost
            $table->unsignedBigInteger('rateable_id'); // ID of the rated entity
            $table->decimal('rating', 3, 2); // Rating value (1.00 to 5.00)
            $table->text('comment')->nullable();
            $table->timestamps();
            $table->softDeletes();

            // Indexes
            $table->index('rater_id');
            $table->index('rated_id');
            $table->index(['rateable_type', 'rateable_id']);
            $table->index('rating');

            // Prevent duplicate ratings for same transaction
            $table->unique(['rater_id', 'rated_id', 'rateable_type', 'rateable_id'], 'unique_rating');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ratings');
    }
};
