<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       

        // Criando a tabela 'users'
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('phone')->unique();
            $table->string('cpf_cnpj')->unique();
            $table->enum('role', ['admin', 'produtor', 'cliente']); // Usando o tipo ENUM aqui
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Removendo o tipo ENUM antes de deletar a tabela (se houver)
        DB::statement("DROP TYPE IF EXISTS role_enum;");
        
        // Deletando a tabela 'users'
        Schema::dropIfExists('users');
    }
};