<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up(): void
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();  // Criação do campo 'id'
            $table->foreignId('producer_id')->constrained('producers')->onDelete('cascade');  // Referência à tabela 'producers'
            $table->string('title');  // Título do evento
            $table->text('description');  // Descrição do evento
            $table->dateTime('date');  // Data do evento
            $table->string('location');  // Local do evento
            $table->string('banner_url');  // URL do banner do evento
            $table->timestamps();  // Timestamps 'created_at' e 'updated_at'
        });
    }

    
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};