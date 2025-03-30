<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   
    public function up(): void
    {
        Schema::create('discount_coupons', function (Blueprint $table) {
            $table->id();  // ID único para o cupom
            $table->string('code')->unique();  // Código do cupom (ex: ABC-123-XYZ)
            $table->decimal('discount', 5, 2);  // Desconto em percentual (ex: 10.00)
            $table->integer('max_uses');  // Máximo de usos
            $table->integer('used_count')->default(0);  // Contagem de usos já realizados
            $table->timestamp('expires_at');  // Data de expiração do cupom
            $table->timestamps();  // Timestamps 'created_at' e 'updated_at'
        });
    }

    
    public function down(): void
    {
        Schema::dropIfExists('discount_coupons');
    }
};