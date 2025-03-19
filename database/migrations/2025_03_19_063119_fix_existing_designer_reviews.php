<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Fix any existing designer reviews by setting production_company_id to NULL
        // We need to do this because our original table had production_company_id NOT NULL
        DB::statement("
            UPDATE reviews
            SET production_company_id = NULL
            WHERE review_type = 'designer'
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No reverse operation needed
    }
};
