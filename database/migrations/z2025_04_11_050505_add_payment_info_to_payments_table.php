<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up()
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->string('barcode')->nullable();
            $table->string('payment_url')->nullable();
        });
    }


    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            //
        });
    }
};
