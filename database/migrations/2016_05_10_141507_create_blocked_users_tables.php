<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBlockedUsersTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blocked_users', function (Blueprint $table) {

            $table->unsignedInteger('user_id');
            $table->unsignedInteger('blocked_user_id');

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('blocked_user_id')->references('id')->on('users');
            $table->unique(['user_id', 'blocked_user_id']);

            $table->index('user_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('blocked_users');
    }
}
