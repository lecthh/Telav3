<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChatifyFavoritesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ch_favorites', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('user_id');  // Change to string to match your `user_id`
            $table->string('favorite_id');  // Change to string to match `user_id`
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
        Schema::dropIfExists('ch_favorites');
    }
}
