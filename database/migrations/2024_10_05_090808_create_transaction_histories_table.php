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
        Schema::create('transaction_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products');
            $table->foreignId('game_user_id')->constrained('game_users');
            $table->decimal('paid_real_price', 8, 2)->nullable();
            $table->string('game_price_type')->nullable();
            $table->integer('paid_game_price')->nullable();
            $table->dateTime('transaction_date');
            $table->foreignId('voucher_used_id')->nullable()->constrained('vouchers');
            $table->foreignId('voucher_earned_id')->constrained('vouchers');
            $table->string('platform');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaction_histories');
    }
};
