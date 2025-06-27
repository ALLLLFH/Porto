<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('educations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('portfolio_id')->constrained('portfolios')->onDelete('cascade');
            $table->string('institution', 150);
            $table->string('degree', 100);
            $table->year('start_year'); // Tipe data YEAR
            $table->year('end_year')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('educations');
    }
};