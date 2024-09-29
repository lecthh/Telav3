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
        Schema::create('customization_details', function (Blueprint $table) {
            $table->string('customization_details_ID')->primary();
            $table->string('remarks')->nullable();
            $table->unsignedBigInteger('sizes_ID');
            $table->string('name')->nullable();
            $table->string('number')->nullable();
            $table->integer('quantity');
            $table->string('order_ID');
            $table->string('short_size')->nullable();
            $table->string('short_number')->nullable();
            $table->string('jersey_number')->nullable();
            $table->boolean('has_pocket')->nullable();
            $table->timestamps();

            $table->foreign('order_ID')->references('order_ID')->on('orders')->onDelete('cascade');
            $table->foreign('sizes_ID')->references('sizes_ID')->on('sizes');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customization_details');
    }
};
