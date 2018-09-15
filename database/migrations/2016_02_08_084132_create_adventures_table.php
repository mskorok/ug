<?php


use Illuminate\Database\Migrations\Migration;
use App\Core\Blueprint;

class CreateAdventuresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('adventures', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->unsignedInteger('category_sid');
            $table->unsignedInteger('comments_count')->default(0);
            $table->unsignedInteger('like_count')->default(0);

            $table->boolean('is_private')->default(1);
            $table->boolean('is_published')->default(0);

            $table->json('going');
            $table->json('following');
            $table->json('liked');


            $table->string('promo_image', 64);
            $table->string('slug', 128)->default('');
            $table->string('country_name', 128)->default('');
            $table->string('place_name', 128)->default('');
            $table->string('place_id', 255);
            $table->string('geo_service')->default('google');
            $table->string('title', 128);
            $table->string('short_description');

            $table->text('description')->default('');

            $table->dateTime('datetime_from')->nullable();
            $table->dateTime('datetime_to')->nullable();
            $table->point('place_location');
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
        Schema::drop('adventure_interest');
        Schema::drop('adventures');
    }
}
