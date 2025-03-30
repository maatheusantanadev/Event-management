<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up(): void
    {
        Schema::create('lots', function (Blueprint $table) {
            $table->id();  // ID único para cada lote
            $table->foreignId('sector_id')->constrained('sectors')->onDelete('cascade');  // Chave estrangeira para setores
            $table->string('name');  // Nome do lote
            $table->decimal('price', 8, 2);  // Preço do lote, com precisão de 2 casas decimais
            $table->integer('quantity');  // Quantidade de itens no lote
            $table->dateTime('start_date');  // Data de início
            $table->dateTime('end_date');  // Data de término
            $table->timestamps();  // Timestamps 'created_at' e 'updated_at'
        });
    }

    
    public function down(): void
    {
        Schema::dropIfExists('lots');
    }
};