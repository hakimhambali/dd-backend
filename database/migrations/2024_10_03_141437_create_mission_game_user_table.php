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
        Schema::create('mission_game_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mission_id')->constrained()->onDelete('cascade');
            $table->foreignId('game_user_id')->constrained('game_users')->onDelete('cascade');
            $table->boolean('is_completed')->default(false);
            $table->decimal('score', 8, 2)->default(0);
            $table->timestamps();

            $table->unique(['mission_id', 'game_user_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mission_game_user');
    }
};
