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
        Schema::create('bo_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bo_id')->constrained('back_orders');
            $table->foreignId('item_id')->constrained('items');
            $table->integer('quantity');
            $table->decimal('price', 8, 2);
            $table->string('unit');
            $table->decimal('total', 8, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bo_items');
    }
};
