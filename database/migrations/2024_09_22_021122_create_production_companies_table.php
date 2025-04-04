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
        Schema::create('production_companies', function (Blueprint $table) {
            $table->id();
            $table->string('company_name')->unique();
            $table->string('company_logo')->nullable();
            $table->string('email')->unique();
            $table->json('production_type');
            $table->json('apparel_type');
            $table->string('user_id');
            $table->foreign('user_id')->references('user_id')->on('users');
            $table->string('address');
            $table->string('phone');
            $table->float('avg_rating');
            $table->integer('review_count');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('production_companies');
    }
};
