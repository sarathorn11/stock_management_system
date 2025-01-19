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
        Schema::create('return_lists', function (Blueprint $table) {
            $table->id();
            $table->string('return_code', 50); 
            $table->foreignId('supplier_id')->constrained();
            $table->foreignId('stock_id')->constrained();
            $table->float('amount'); 
            $table->text('remarks')->nullable(); 
            $table->dateTime('date_created')->useCurrent(); 
            $table->dateTime('date_updated')->useCurrent()->useCurrentOnUpdate(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('return_lists');
    }
};
