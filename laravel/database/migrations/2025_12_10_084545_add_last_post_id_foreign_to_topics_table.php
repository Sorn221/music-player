<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('topics', function (Blueprint $table) {
            // Создаем внешний ключ, используя столбец, который мы создали ранее
            $table->foreign('last_post_id')
                ->references('id')
                ->on('posts')
                ->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('topics', function (Blueprint $table) {
            $table->dropForeign(['last_post_id']);
        });
    }
};
