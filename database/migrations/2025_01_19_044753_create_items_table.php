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
            $table->text('name'); // Name column
            $table->text('description'); // Description column
            $table->unsignedBigInteger('supplier_id'); // Foreign key column (unsignedBigInteger for large ID)
            $table->float('cost', 8, 2)->default(0); // Cost with precision and default value
            $table->boolean('status')->default(1); // Status as boolean
            $table->timestamps(0); // Adds created_at and updated_at with datetime precision

            // Foreign key constraint
            $table->foreign('supplier_id')
                  ->references('id')
                  ->on('suppliers')
                  ->onDelete('cascade'); // Cascade on delete to remove related items when supplier is deleted
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
