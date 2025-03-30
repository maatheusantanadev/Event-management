<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();  // ID único do pagamento
            $table->foreignId('ticket_id')->constrained('tickets')->onDelete('cascade');  // Referência ao ticket (tabela 'tickets')
            $table->string('transaction_id')->unique();  // ID único da transação
            $table->decimal('amount', 10, 2);  // Valor pago (com 2 casas decimais)
            $table->enum('status', ['pendente', 'confirmado', 'falha']);  // Status do pagamento
            $table->timestamps();  // Timestamps 'created_at' e 'updated_at'
        });
    }

    
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};