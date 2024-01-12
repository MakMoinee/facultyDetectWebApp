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
        Schema::create('faculty', function (Blueprint $table) {
            $table->id('facultyID')->autoIncrement();
            $table->integer('userID');
            $table->string('firstName');
            $table->string('middleName');
            $table->string('lastName');
            $table->string('subject');
            $table->string('imagePath');
            $table->string('status');
            $table->string('remarks')->nullable(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sonograms');
    }
};
