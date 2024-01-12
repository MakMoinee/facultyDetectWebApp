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
        Schema::create('susers', function (Blueprint $table) {
            $table->id('userID')->autoIncrement();
            $table->string('firstName');
            $table->string('middleName')->nullable(true);
            $table->string('lastName');
            $table->string('address');
            $table->date('birthDate');
            $table->string('phoneNumber');
            $table->string('email');
            $table->string('password');
            $table->integer('userType');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('s_users');
    }
};
