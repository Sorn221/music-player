<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('artist_influence', function (Blueprint $table) {
            // ID артиста, который повлиял (пример: Bathory)
            $table->foreignId('influencer_id')
                  ->references('id')->on('artists')
                  ->onDelete('cascade');

            // ID артиста, на которого повлияли (пример: Mayhem)
            $table->foreignId('influenced_id')
                  ->references('id')->on('artists')
                  ->onDelete('cascade');

            // Составной первичный ключ
            $table->primary(['influencer_id', 'influenced_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('artist_influence');
    }
};