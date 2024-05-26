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
            $table->uuid('id')->primary();
            $table->foreignUuid('urole_id');
            $table->foreign('urole_id')->references('id')->on('user_roles');
            $table->string('username')->unique();
            $table->string('email')->unique();
            $table->string('password');
            $table->string('fullname');
            $table->string('shortname');
            $table->string('avatar');
            $table->string('gender');
            $table->string('age');
            $table->string('phone');
            $table->string('status');
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
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
