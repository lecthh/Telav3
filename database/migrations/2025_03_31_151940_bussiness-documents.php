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
        Schema::create('business_documents', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('production_company_id');
            $table->string('name');
            $table->string('path');
            $table->timestamps();

            // Foreign key constraint linking to production_companies table
            $table->foreign('production_company_id')
                ->references('id')->on('production_companies')
                ->onDelete('cascade');
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('business_documents');
    }
};
