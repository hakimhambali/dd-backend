<?php

use App\Models\Gender;
use App\Models\Religion;
use App\Models\User;
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
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class)->constrained();
            $table->string('full_name')->nullable();
            $table->date('birth_date')->nullable();
            $table->string('nric_passport')->nullable();
            $table->foreignIdFor(Gender::class)->nullable()->constrained();
            $table->foreignIdFor(Religion::class)->nullable()->constrained();
            $table->string('phone_number')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_profiles');
    }
};
