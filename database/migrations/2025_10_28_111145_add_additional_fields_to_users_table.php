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
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone', 50)->nullable()->after('email');
            $table->string('avatar')->nullable()->after('phone');
            $table->string('city')->nullable()->after('avatar');
            $table->text('address')->nullable()->after('city');
            $table->boolean('is_available')->default(true)->after('address');
            $table->softDeletes();
            $table->index('city');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropIndex(['city']);
            $table->dropSoftDeletes();
            $table->dropColumn(['phone', 'avatar', 'city', 'address', 'is_available']);
        });
    }
};
