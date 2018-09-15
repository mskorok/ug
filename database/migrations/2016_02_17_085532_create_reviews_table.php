<?php

use App\Core\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->unsignedInteger('category_sid');
            $table->unsignedInteger('comments_count')->default(0);
            $table->unsignedInteger('like_count')->default(0);
            $table->unsignedInteger('recommend_count')->default(0);

            $table->json('gallery');
            $table->json('liked');
            $table->json('recommended');

            $table->string('promo_image', 64);
            $table->string('country_name', 128)->default('');
            $table->string('place_id', 255);
            $table->string('place_name', 128)->default('');
            $table->string('slug', 128)->default('');
            $table->string('geo_service')->default('google');
            $table->string('title', 128);
            $table->string('short_description');

            $table->text('description')->default('');

            $table->point('place_location');

            $table->dateTime('datetime_from');
            $table->dateTime('datetime_to');
            $table->timestamps();
        });

        Schema::create('interest_review', function (Blueprint $table) {
            $table->unsignedInteger('interest_id')->index();
            $table->foreign('interest_id')->references('id')->on('interests')->onDelete('cascade');
            $table->unsignedInteger('review_id')->index();
            $table->foreign('review_id')->references('id')->on('reviews')->onDelete('cascade');
            $table->unique(['review_id', 'interest_id']);
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
        Schema::drop('interest_review');
        Schema::drop('reviews');
    }
}
