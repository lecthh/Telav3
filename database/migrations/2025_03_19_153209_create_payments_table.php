<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('payments')) {
            Schema::create('payments', function (Blueprint $table) {
                $table->string('payment_id')->primary();
                $table->string('order_id');
                $table->string('user_id');
                $table->decimal('amount', 10, 2);
                $table->string('payment_proof')->nullable();
                $table->timestamp('payment_date');
                $table->string('status')->default('pending');
                $table->string('payment_type')->default('additional_payment');
                $table->text('notes')->nullable();
                $table->timestamps();
                
                $table->foreign('order_id')->references('order_id')->on('orders');
                $table->foreign('user_id')->references('user_id')->on('users');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payments');
    }
}