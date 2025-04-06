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
        Schema::table('users', function (Blueprint $table) {
            $table->string('status')->default('active')->after('avatar');
        });

        Schema::table('designers', function (Blueprint $table) {
            $table->string('status')->default('active')->after('is_verified');
        });

        Schema::table('production_companies', function (Blueprint $table) {
            $table->string('status')->default('active')->after('email');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('status');
        });

        Schema::table('designers', function (Blueprint $table) {
            $table->dropColumn('status');
        });

        Schema::table('production_companies', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};
