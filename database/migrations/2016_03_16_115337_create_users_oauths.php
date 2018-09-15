<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersOauths extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_oauths', function (Blueprint $table) {
            $table->unsignedInteger('user_id');
            $table->string('oauth_id')->nullable();
            $table->tinyInteger('oauth_provider');

            $table->foreign('user_id')->references('id')->on('users');
            $table->unique(['user_id', 'oauth_provider']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('users_oauths');
    }
}
