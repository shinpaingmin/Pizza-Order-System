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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('username');
            $table->string('email')->unique();
            $table->string('image')->nullable();
            $table->string('phone', 15);
            $table->string('address');
            $table->string('gender', 10);
            $table->string('role', 15)->default('user');
            $table->string('password');


            // $table->timestamp('email_verified_at')->nullable();
            // $table->rememberToken();
            // $table->foreignId('current_team_id')->nullable();
            // $table->string('profile_photo_path', 2048)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
