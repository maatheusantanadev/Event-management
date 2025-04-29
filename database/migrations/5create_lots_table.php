<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up(): void
    {
        Schema::create('lots', function (Blueprint $table) {
            $table->id(); 
            $table->foreignId('sector_id')->constrained('sectors')->onDelete('cascade');  
            $table->string('name');  
            $table->decimal('price', 8, 2);  
            $table->integer('quantity');  
            $table->dateTime('start_date'); 
            $table->dateTime('end_date');  
            $table->timestamps(); 
        });
    }

    
    public function down(): void
    {
        Schema::dropIfExists('lots');
    }
};