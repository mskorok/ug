<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $file = new SplFileObject('database/dumps/cities.sql');
        $rawSql = '';

        while (!$file->eof()) {
            $line = $file->fgets();

            if (substr($line, 0, 2) == '--' || $line == '') {
                continue;
            }

            $rawSql .= $line;

            if (substr(trim($line), -1, 1) == ';') {
                DB::unprepared($rawSql);

                $rawSql = '';
            }
        }

        Schema::table('cities', function (Blueprint $table) {
            $table->foreign('country_id')->references('id')->on('countries');
            $table->dropColumn('alternatenames');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('cities');
    }
}
