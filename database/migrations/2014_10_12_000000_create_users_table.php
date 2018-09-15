<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            // PK
            $table->increments('id');

            // Bit/boolean/tinyint(1)
            $table->boolean('is_active')->default(1);
            $table->boolean('profile_show_age')->default(1);
            $table->boolean('gender_sid');

            // Unsigned numbers
            $table->unsignedInteger('categories_bit');
            $table->unsignedInteger('email_notifications_bit');
            $table->unsignedInteger('alert_notifications_bit');

            // Numbers

            // Decimals/floats

            // Char
            //$table->char('country_code', 2);
            $table->char('profile_locale', 2);

            // Varchar
            $table->string('name', 32);
            $table->string('last_login_ip', 32);
            $table->string('password', 60);
            $table->string('email', 64)->unique()->nullable();
            $table->string('photo_path', 64);
            $table->string('hometown_name', 128);
            //$table->string('country_name', 128);
            $table->string('about', 140);
            $table->string('work', 140);
            $table->string('activation_code', 255)->unique();
            $table->string('hometown_id', 255);
            $table->string('geo_service')->default('google');
            $table->rememberToken();

            // JSON

            // Text

            // Date/time/timestamp
            $table->dateTime('activated_at')->nullable();
            $table->date('birth_date');
            $table->dateTime('last_login_at');
            $table->timestamps();

            // BLOB
            $table->point('hometown_location');
        });

        /*DB::statement('ALTER TABLE `users`
                ADD FULLTEXT INDEX `first_last_name_email_fulltext`
                (`email` ASC, `last_name` ASC, `first_name` ASC);');*/
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('users');
    }
}
