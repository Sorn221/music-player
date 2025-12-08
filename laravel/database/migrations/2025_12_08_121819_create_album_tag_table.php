<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('album_tag', function (Blueprint $table) {
            // Составной первичный ключ
            $table->foreignId('album_id')->constrained()->onDelete('cascade');
            $table->foreignId('tag_id')->constrained()->onDelete('cascade');
            $table->primary(['album_id', 'tag_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('album_tag');
    }
};