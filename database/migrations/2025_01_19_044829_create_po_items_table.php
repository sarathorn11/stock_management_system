<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePoItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('po_items', function (Blueprint $table) {
            $table->id(); // Auto-incrementing primary key
            $table->unsignedBigInteger('po_id'); // Foreign key for purchase order
            $table->unsignedBigInteger('item_id'); // Foreign key for item
            $table->integer('quantity'); // Quantity of items
            $table->float('price', 8, 2)->default(0); // Price per item
            $table->string('unit', 50); // Unit of measurement
            $table->float('total', 8, 2)->default(0); // Total price (quantity * price)
            $table->timestamps(); // Created and updated timestamps

            // Foreign key relationships
            $table->foreign('po_id')
                  ->references('id')
                  ->on('purchase_orders')
                  ->onDelete('cascade'); // Remove related po_items when purchase_order is deleted

            $table->foreign('item_id')
                  ->references('id')
                  ->on('items')
                  ->onDelete('cascade'); // Remove related po_items when item is deleted
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('po_items');
    }
}
