<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('stock_list', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('item_id');
            $table->integer('quantity');
            $table->string('unit', 250)->nullable();
            $table->float('price', 8, 2)->default(0);
            $table->float('total', 8, 2)->default(0);
            $table->tinyInteger('type')->default(1)->comment('1=IN , 2=OUT');
            $table->timestamp('date_created')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stock_list');
    }
};
