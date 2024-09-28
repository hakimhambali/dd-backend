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
        Schema::create('game_users', function (Blueprint $table) {
            $table->id();
            $table->string('email')->unique();
            $table->string('password');
            $table->string('username');
            $table->integer('gem_amount')->default(0);
            $table->integer('gold_amount')->default(0);
            $table->date('date_of_birth')->nullable();
            $table->string('country');
            $table->string('platform');
            $table->timestamp('register_date');
            $table->integer('total_play_time')->default(0);
            $table->boolean('is_active')->default(true);
            $table->integer('highest_score')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('game_users');
    }
};
