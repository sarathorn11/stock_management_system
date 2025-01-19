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
        Schema::create('back_order', function (Blueprint $table) {
            $table->id();
            $table->foreignId('receiving_id')->constrained();
            $table->foreignId('po_id')->constrained('purchase_order')->onDelete('cascade');
            $table->foreignId('supplier_id')->constrained();
            $table->string('bo_code');
            $table->decimal('amount', 15, 2);
            $table->decimal('discount_perc', 5, 2);
            $table->decimal('discount', 15, 2);
            $table->decimal('tax_perc', 5, 2);
            $table->decimal('tax', 15, 2);
            $table->text('remarks')->nullable();
            $table->tinyInteger('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('back_order');
    }
};
