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
            $table->foreignId('po_id')->constrained('purchase_order')->onDelete('cascade'); // Foreign key for purchase order
            $table->foreignId('item_id')->constrained('items')->onDelete('cascade'); // Foreign key for item
            $table->integer('quantity'); // Quantity of items
            $table->float('price', 8, 2)->default(0); // Price per item
            $table->string('unit', 50); // Unit of measurement
            $table->float('total', 8, 2)->default(0); // Total price (quantity * price)
            $table->timestamps(); // Created and updated timestamps
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
