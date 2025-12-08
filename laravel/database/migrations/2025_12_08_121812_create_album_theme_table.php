<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('album_theme', function (Blueprint $table) {
            // Составной первичный ключ
            $table->foreignId('album_id')->constrained()->onDelete('cascade');
            $table->foreignId('theme_id')->constrained()->onDelete('cascade');
            $table->primary(['album_id', 'theme_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('album_theme');
    }
};