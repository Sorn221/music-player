<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();

            // Внешний ключ на тему
            $table->foreignId('topic_id')->constrained()->onDelete('cascade');
            // Внешний ключ на пользователя, создавшего сообщение
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            $table->text('content');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
