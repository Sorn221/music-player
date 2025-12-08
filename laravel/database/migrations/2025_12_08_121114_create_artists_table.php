<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('artists', function (Blueprint $table) {
            $table->id();
            $table->foreignId('country_id')->nullable()->constrained()->onDelete('set null');
            
            $table->string('name')->unique();
            $table->string('slug')->unique();
            $table->text('bio')->nullable();
            $table->unsignedSmallInteger('formed_year')->nullable();
            $table->boolean('is_underground')->default(false); // Для раздела "Демо и незнакомцы"
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('artists');
    }
};