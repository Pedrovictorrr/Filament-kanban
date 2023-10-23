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
        Schema::create('historia_user', function (Blueprint $table) {
            $table->unsignedBigInteger('historia_id');
            $table->foreign('historia_id')->references('id')->onDelete('cascade')->on('historia');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->onDelete('cascade')->on('users');
        });
    }

    /**
     * Reverse the migrations.git
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('historia_user');
    }
};
