<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('production_company_pricing', function (Blueprint $table) {
            $table->id('pricing_id');
            $table->foreignId('production_company_id')->constrained('production_companies')->onDelete('cascade');
            $table->foreignId('apparel_type')->constrained('apparel_types')->onDelete('cascade');
            $table->foreignId('production_type')->constrained('production_types')->onDelete('cascade');
            $table->decimal('base_price', 10, 2);
            $table->decimal('bulk_price', 10, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('production_company_pricing');
    }
};
