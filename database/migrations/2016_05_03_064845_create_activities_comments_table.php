<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActivitiesCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('activities_comments', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('adventure_id');
            $table->foreign('adventure_id')->references('id')->on('adventures')->onDelete('cascade');

            $table->unsignedInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->unsignedInteger('parent_id')->nullable();
            $table->foreign('parent_id')->references('id')->on('activities_comments')->onDelete('cascade');

            $table->unsignedInteger('like_count')->default(0);
            $table->unsignedInteger('reply_count')->default(0);
            $table->json('liked');

            $table->string('text');
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
        Schema::drop('activities_comments');
    }
}
