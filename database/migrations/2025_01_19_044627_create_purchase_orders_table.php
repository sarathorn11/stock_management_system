<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchaseOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_orders', function (Blueprint $table) {
            $table->id();
            $table->string('po_code', 50);  // Add po_code field
            $table->foreignId('supplier_id')->constrained('suppliers')->onDelete('cascade');  // Foreign key for supplier_id, with constraint and cascading delete
            $table->float('amount', 8, 2);  // Add amount field
            $table->float('discount_perc', 8, 2)->default(0);  // Add discount percentage
            $table->float('discount', 8, 2)->default(0);  // Add discount amount
            $table->float('tax_perc', 8, 2)->default(0);  // Add tax percentage
            $table->float('tax', 8, 2)->default(0);  // Add tax amount
            $table->text('remarks');  // Add remarks field
            $table->tinyInteger('status')->default(0)->comment('0 = pending, 1 = partially received, 2 = received');  // Add status field
            $table->timestamps();  // Add created_at and updated_at fields
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('purchase_orders');
    }
}
