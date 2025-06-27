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
        Schema::create('portfolios', function (Blueprint $table) {
            $table->id(); // SAMA DENGAN: INT AUTO_INCREMENT PRIMARY KEY
            
            // FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
            // Cara modern Laravel untuk membuat foreign key:
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            
            $table->string('title', 150);
            $table->text('description')->nullable(); // Menambahkan ->nullable() jika deskripsi boleh kosong
            $table->string('theme', 50);
            $table->string('slug', 100)->unique(); // Menambahkan ->unique() untuk constraint UNIQUE
            
            // SAMA DENGAN: created_at dan updated_at TIMESTAMP
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('portfolios');
    }
};
