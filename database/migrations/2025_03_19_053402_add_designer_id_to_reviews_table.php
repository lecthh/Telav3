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
        Schema::table('reviews', function (Blueprint $table) {
            $table->unsignedBigInteger('designer_id')->nullable()->after('production_company_id');
            
            $table->string('review_type')->default('company')->after('is_visible');
            
            $table->foreign('designer_id')
                  ->references('designer_id')
                  ->on('designers')
                  ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reviews', function (Blueprint $table) {
            $table->dropForeign(['designer_id']);
            
            $table->dropColumn('designer_id');
            $table->dropColumn('review_type');
        });
    }
};
