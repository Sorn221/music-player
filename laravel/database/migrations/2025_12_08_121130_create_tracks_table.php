<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tracks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('album_id')->constrained()->onDelete('cascade');
            
            $table->string('title');
            $table->unsignedSmallInteger('track_number');
            $table->unsignedSmallInteger('duration')->nullable(); // В секундах
            $table->longText('lyrics')->nullable();
            $table->string('file_path')->nullable(); // Путь к аудиофайлу
            
            $table->timestamps();

            // Обеспечение уникальности номера трека в рамках одного альбома
            $table->unique(['album_id', 'track_number']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tracks');
    }
};