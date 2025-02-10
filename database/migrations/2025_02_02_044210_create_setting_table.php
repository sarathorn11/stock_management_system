<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('setting', function (Blueprint $table) {
            $table->id();
            $table->string('system_name')->default('Stock Management System');
            $table->string('system_short_name')->nullable();
            $table->string('system_logo')->nullable();
            $table->string('system_cover')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('setting');
    }
};
