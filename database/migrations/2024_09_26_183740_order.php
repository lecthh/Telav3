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
        Schema::create('orders', function (Blueprint $table) {
            $table->string('order_id')->primary();
            $table->string('user_id');
            $table->foreign('user_id')->references('user_id')->on('users')->onDelete('cascade');
            $table->foreignId('production_company_id')->constrained('production_companies')->onDelete('cascade');
            $table->foreignId('assigned_designer_id')->nullable()->constrained('designers', 'designer_id')->onDelete('set null');
            $table->boolean('is_customized')->default(false);
            $table->boolean('is_bulk_order')->default(false);
            $table->integer('quantity')->nullable();
            $table->foreignId('status_id')->constrained('order_statuses', 'status_id')->onDelete('cascade');
            $table->foreignId('apparel_type')->constrained('apparel_types')->onDelete('cascade');
            $table->foreignId('production_type')->constrained('production_types')->onDelete('cascade');
            $table->decimal('downpayment_amount', 10, 2);
            $table->decimal('final_price', 10, 2)->nullable();
            $table->text('custom_design_info')->nullable();
            $table->integer('revision_count')->default(0);
            $table->string('token')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
