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
        Schema::create('sonograms', function (Blueprint $table) {
            $table->id('sonogramID')->autoIncrement();
            $table->integer('userID');
            $table->string('petName');
            $table->string('imagePath');
            $table->string('status');
            $table->string('remarks')->nullable(true);
            $table->string('approver')->nullable(true);
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
