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
        Schema::create('sales', function (Blueprint $table) {
            $table->id(); 
            $table->string('sales_code', 50); 
            $table->text('client'); 
            $table->float('amount'); 
            $table->foreignId('stock_id')->constrained();
            $table->text('remarks')->nullable(); 
            $table->timestamps(); 
            $table->foreign('stock_id')->references('id')->on('stock_list')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};
