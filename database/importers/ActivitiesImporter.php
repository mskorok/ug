<?php

namespace Database\Importers;

use Database\Importers\Engines\ExcelImporter;

class ActivitiesImporter extends ExcelImporter
{
    protected $file = 'data.ods';

    protected static $cache = [];

    protected $columns = [
        0 => 'id',
        1 => 'title',
        2 => 'place_name',
        3 => 'datetime_from',
        4 => 'datetime_to',
        5 => 'promo_image',
        6 => 'short_description',
        7 => 'description',
        8 => 'category_sid',
        9 => 'interests',
        10 => 'is_public',
        11 => 'user_id',
        12 => null,
    ];

    public function parse()
    {
        return self::parseData(1);
    }

    public function count()
    {
        return sizeof(self::parseData(1));
    }

    protected function callback0($val, $record_nr)
    {
        return intval($val);
    }

    protected function callback5($val)
    {
        return $this->imgFaker->directActivity($val);
    }

    protected function callback8($val, $record_nr)
    {
        return intval($val);
    }

    protected function callback9($val, $record_nr)
    {
        return $this->getCSIDs($val);
    }

    protected function callback10($val, $record_nr)
    {
        return 1;
    }

    protected function callback11($val, $record_nr)
    {
        return intval($val);
    }
}
