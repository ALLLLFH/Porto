<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('skills', function (Blueprint $table) {
            $table->id();
            $table->foreignId('portfolio_id')->constrained('portfolios')->onDelete('cascade');
            $table->string('skill_name', 100);
            
            // Untuk tipe data ENUM
            $table->enum('level', ['Beginner', 'Intermediate', 'Expert']);
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('skills');
    }
};