<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up(): void
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id(); 
            $table->foreignId('producer_id')->constrained('producers')->onDelete('cascade'); 
            $table->string('title'); 
            $table->text('description');  
            $table->dateTime('date'); 
            $table->string('location');
            $table->string('banner_url'); 
            $table->timestamps();  
        });
    }

    
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};