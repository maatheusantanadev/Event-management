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
        Schema::create('sectors', function (Blueprint $table) {
            $table->id();  // ID único para cada setor
            $table->foreignId('event_id')->constrained('events')->onDelete('cascade');  // Chave estrangeira para eventos
            $table->string('name');  // Nome do setor
            $table->integer('capacity');  // Capacidade do setor
            $table->timestamps();  // Timestamps 'created_at' e 'updated_at'
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sectors');
    }
};