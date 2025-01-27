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
        Schema::create('suppliers', function (Blueprint $table) {
            $table->id(); 
            $table->text('name')->nullable(); 
            $table->text('address')->nullable(); 
            $table->text('cperson')->nullable(); 
            $table->text('contact'); 
            $table->tinyInteger('status')->default(1); 
            // $table->dateTime('date_created')->useCurrent(); 
            // $table->dateTime('date_updated')->useCurrent()->useCurrentOnUpdate(); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('suppliers');
    }
};
