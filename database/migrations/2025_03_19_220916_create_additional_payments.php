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
        Schema::create('additional_payments', function (Blueprint $table) {
            $table->id();
            $table->string('order_id');
            $table->decimal('amount', 10, 2);
            $table->integer('additional_quantity');
            $table->string('payment_proof')->nullable();
            $table->string('status')->default('pending');
            $table->timestamps();
            
            $table->foreign('order_id')
                  ->references('order_id')
                  ->on('orders')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('additional_payments');
    }
};
