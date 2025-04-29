<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   
    public function up(): void
    {
        Schema::create('discount_coupons', function (Blueprint $table) {
            $table->id();  
            $table->string('code')->unique();  
            $table->decimal('discount', 5, 2);  
            $table->integer('max_uses');  
            $table->integer('used_count')->default(0);  
            $table->timestamp('expires_at');  
            $table->timestamps();  
        });
    }

    
    public function down(): void
    {
        Schema::dropIfExists('discount_coupons');
    }
};