<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInterestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('interests', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 50);
            $table->unique('name');
            $table->timestamps();
        });
        Schema::create('adventure_interest', function (Blueprint $table) {
            $table->unsignedInteger('interest_id')->index();
            $table->foreign('interest_id')->references('id')->on('interests')->onDelete('cascade');
            $table->unsignedInteger('adventure_id')->index();
            $table->foreign('adventure_id')->references('id')->on('adventures')->onDelete('cascade');
            $table->unique(['adventure_id', 'interest_id']);
            $table->timestamps();
        });
        Schema::create('interest_user', function (Blueprint $table) {
            $table->unsignedInteger('interest_id')->index();
            $table->foreign('interest_id')->references('id')->on('interests')->onDelete('cascade');
            $table->unsignedInteger('user_id')->index();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->unique(['user_id', 'interest_id']);
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
        Schema::drop('interests');
        Schema::drop('adventure_interest');
        Schema::drop('interest_user');
    }
}
