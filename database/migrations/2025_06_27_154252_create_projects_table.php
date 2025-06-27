<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->foreignId('portfolio_id')->constrained('portfolios')->onDelete('cascade');
            $table->string('title', 150);
            $table->text('description');
            $table->string('technologies'); // VARCHAR(255)
            $table->string('image')->nullable();
            $table->string('project_link')->nullable();
            
            // Query Anda hanya memiliki created_at.
            // Best practice di Laravel adalah menggunakan timestamps()
            // yang mencakup created_at dan updated_at.
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};