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
        DB::statement('UPDATE cart_items SET total_price = price * quantity WHERE total_price IS NULL OR total_price = 0');
        DB::statement('UPDATE cart_items SET downpayment = total_price / 2 WHERE downpayment IS NULL OR downpayment = 0');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
