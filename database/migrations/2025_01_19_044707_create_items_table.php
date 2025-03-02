<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id(); // Auto-incrementing primary key
            $table->string('name'); // Name of the item
            $table->text('description'); // Description of the item
            $table->foreignId('supplier_id')->constrained()->onDelete('cascade'); // Supplier ID
            $table->decimal('cost', 8, 2); // Cost of the item
            $table->string('unit', 250)->nullable();
            $table->tinyInteger('status'); // Status of the item
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
        Schema::dropIfExists('items');
    }
}
