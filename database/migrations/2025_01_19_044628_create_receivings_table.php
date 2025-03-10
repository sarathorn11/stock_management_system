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
            $table->id();
            $table->unsignedBigInteger('from_id'); // ID of the related model
            $table->string('from_type'); // Class name of the related model (e.g., App\Models\PurchaseOrder)
            $table->tinyInteger('from_order')->default(1)->comment('1 = PO, 2 = BO');
            $table->float('amount', 8, 2)->default(0);
            $table->float('discount_perc', 8, 2)->default(0);
            $table->float('discount', 8, 2)->default(0);
            $table->float('tax_perc', 8, 2)->default(0);
            $table->float('tax', 8, 2)->default(0);
            $table->json('stock_ids')->nullable(); // Use JSON for better querying
            $table->text('remarks')->nullable();
            $table->timestamps();

            // Indexes
            $table->index('from_id');
            $table->index('from_order');
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
