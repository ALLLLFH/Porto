<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('experiences', function (Blueprint $table) {
            $table->id();
            $table->foreignId('portfolio_id')->constrained('portfolios')->onDelete('cascade');
            $table->string('company', 100);
            $table->string('position', 100);
            $table->date('start_date');
            $table->date('end_date')->nullable(); // end_date bisa jadi kosong jika masih bekerja
            $table->text('description');
            $table->timestamps(); // Menambahkan timestamps adalah best practice
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('experiences');
    }
};