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
        Schema::create('designers', function (Blueprint $table) {
            $table->id('designer_id');
            $table->string('user_id');
            $table->foreign('user_id')->references('user_id')->on('users')->onDelete('cascade');
            $table->boolean('is_freelancer')->default(false);
            $table->boolean('is_available')->default(true);
            $table->foreignId('production_company_id')->nullable()->constrained()->onDelete('set null');
            $table->decimal('talent_fee', 10, 2)->nullable();
            $table->integer('max_free_revisions')->default(0);
            $table->decimal('addtl_revision_fee', 10, 2)->default(0.00);
            $table->text('designer_description')->nullable();
            $table->json('order_history')->nullable();
            $table->float('average_rating')->default(0.0);
            $table->unsignedInteger('review_count')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('designers');
    }
};
