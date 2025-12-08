<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('albums', function (Blueprint $table) {
            $table->id();
            $table->foreignId('artist_id')->constrained()->onDelete('cascade');
            $table->foreignId('label_id')->nullable()->constrained()->onDelete('set null');
            
            $table->string('title');
            $table->string('slug')->unique();
            $table->unsignedSmallInteger('release_year');
            $table->string('cover_image_path'); // Путь к обложке
            $table->text('description')->nullable();
            $table->boolean('is_demo')->default(false); // Флаг для демо-записей
            
            $table->timestamps();
            
            // Обеспечение уникальности названия альбома для данного артиста
            $table->unique(['artist_id', 'title']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('albums');
    }
};