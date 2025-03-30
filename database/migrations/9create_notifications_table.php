<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();  // ID único da notificação
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');  // Referência ao usuário (tabela 'users')
            $table->text('message');  // Mensagem da notificação
            $table->enum('status', ['pendente', 'enviado', 'falha']);  // Status da notificação
            $table->timestamps();  // Timestamps 'created_at' e 'updated_at'
        });
    }

    
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};