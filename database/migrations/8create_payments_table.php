<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();  
            $table->foreignId('ticket_id')->constrained('tickets')->onDelete('cascade');  
            $table->foreignId('discount_coupon_id')->nullable()->constrained('discount_coupons')->onDelete('set null');
            $table->string('transaction_id')->unique();  
            $table->decimal('amount', 10, 2); 
            $table->enum('status', ['pendente', 'confirmado', 'falha']); 
            $table->timestamps(); 
        });
    }

    
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};