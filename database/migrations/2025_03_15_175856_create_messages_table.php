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
        Schema::create('messages', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('from_id', 255);
            $table->string('to_id', 255);
            $table->string('body', 5000);
            $table->json('attachments')->nullable();
            $table->boolean('seen')->default(false);
            $table->timestamps();

            $table->foreign('from_id')->references('user_id')->on('users')->onDelete('cascade');
            $table->foreign('to_id')->references('user_id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};
