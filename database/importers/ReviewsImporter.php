<?php

namespace Database\Importers;

use Database\Importers\Engines\ExcelImporter;

class ReviewsImporter extends ExcelImporter
{
    protected $file = 'data.ods';

    protected static $cache = [];

    protected $columns = [
        0 => 'id',
        1 => 'title',
        2 => 'place_name',
        3 => 'datetime_from',
        4 => 'promo_image',
        5 => 'description',
        6 => 'category_sid',
        7 => 'interests',
        8 => 'user_id',
        9 => null,
    ];

    public function parse()
    {
        return self::parseData(2);
    }

    public function count()
    {
        return sizeof(self::parseData(2));
    }

    protected function callback0($val, $record_nr)
    {
        return $record_nr;
    }

    protected function callback3($val, $record_nr)
    {
        return $this->faker->dateTimeBetween('5 days', '3 years');
    }

    protected function callback4($val)
    {
        return $this->imgFaker->directReview($val);
    }

    protected function callback7($val)
    {
        return $this->getCSIDs($val);
    }

    protected function callback8($val, $record_nr)
    {
        return intval($val);
    }
}
