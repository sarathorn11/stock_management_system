<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('stocks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('item_id')->constrained()->cascadeOnDelete();
            $table->integer('quantity');
            $table->string('unit', 250)->nullable();
            $table->decimal('price', 10, 2)->default(0);
            $table->decimal('total', 10, 2)->default(0);
            $table->tinyInteger('type')->default(1)->comment('1=IN , 2=OUT');
            $table->timestamp('date_created')->useCurrent();
            $table->timestamps();  // Add created_at and updated_at fields
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stocks');
    }
};
