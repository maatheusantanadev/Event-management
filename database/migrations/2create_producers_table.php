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
        Schema::create('producers', function (Blueprint $table) {
            $table->id();  // ID único para cada produtor
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');  // Chave estrangeira para a tabela users
            $table->string('company_name');  // Nome da empresa
            $table->string('cnpj')->unique();  // CNPJ único para cada produtor
            $table->timestamps();  // Timestamps 'created_at' e 'updated_at'
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('producers');
    }
};