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
        Schema::create('tarifas', function (Blueprint $table) {
            $table->id();
            $table->enum('tipo', ['fibra', 'gb', 'llamadas', 'tv']);
            $table->string('descripcion');
            $table->integer('velocidad')->nullable(); // Solo para fibra, null para otros tipos
            $table->integer('minutos')->nullable(); // Solo para llamadas, null para otros tipos
            $table->integer('gb')->nullable(); // Solo para gb, null para otros tipos
            $table->decimal('precio', 8, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tarifas');
    }
};
