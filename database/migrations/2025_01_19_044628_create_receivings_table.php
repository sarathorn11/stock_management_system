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
        Schema::create('receivings', function (Blueprint $table) {
            $table->id(); // Auto-incrementing primary key
            $table->integer('from_id'); // Foreign key for the form, referencing 'purchase_orders' or 'back_orders'
            // $table->unsignedBigInteger('from_id'); // Foreign key for the form, referencing 'purchase_orders' or 'back_orders'
            $table->tinyInteger('from_order')->default(1)->comment('1 = PO, 2 = BO'); // From order (PO or BO)
            $table->float('amount', 8, 2)->default(0); // Amount
            $table->float('discount_perc', 8, 2)->default(0); // Discount percentage
            $table->float('discount', 8, 2)->default(0); // Discount value
            $table->float('tax_perc', 8, 2)->default(0); // Tax percentage
            $table->float('tax', 8, 2)->default(0); // Tax value
            $table->text('stock_ids')->nullable(); // Stock IDs (can store a serialized or JSON array)
            $table->text('remarks')->nullable(); // Remarks
            $table->timestamps(); // created_at and updated_at
            // $table->foreign('from_id')
            //       ->references('id')
            //       ->on('purchase_orders')
            //       ->onDelete('cascade');
            // $table->foreign('from_id')
            //       ->references('id')
            //       ->on('back_orders')
            //       ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('receivings');
    }
};
