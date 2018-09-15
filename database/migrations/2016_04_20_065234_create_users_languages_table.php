<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersLanguagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_languages', function (Blueprint $table) {
            $table->unsignedInteger('user_id');
            $table->string('language_id')->nullable();

            $table->foreign('user_id')->references('id')->on('users');
            $table->unique(['user_id', 'language_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('users_languages');
    }
}