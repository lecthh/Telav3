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
        Schema::create('carts', function (Blueprint $table) {
            $table->id('cart_id');
            $table->string('user_id');
            $table->foreign('user_id')->references('user_id')->on('users')->onDelete('cascade');
            $table->decimal('total_price', 10, 2)->default(0);
            $table->timestamps();
        });

        Schema::create('cart_items', function (Blueprint $table) {
            $table->id('cart_item_id');
            $table->foreignId('cart_id')->constrained('carts', 'cart_id')->onDelete('cascade');
            $table->foreignId('apparel_type_id')->constrained('apparel_types')->onDelete('cascade');
            $table->foreignId('production_type')->constrained('production_types')->onDelete('cascade');
            $table->foreignId('production_company_id')->constrained('production_companies')->onDelete('cascade');
            $table->string('customization');
            $table->string('description')->nullable();
            $table->string('orderType');
            $table->integer('quantity')->default(1);
            $table->json('images')->nullable();
            $table->decimal('price', 10, 2);
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cart_items');
        Schema::dropIfExists('carts');
    }
};
