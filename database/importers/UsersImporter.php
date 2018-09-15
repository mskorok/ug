<?php

namespace Database\Importers;

use Database\Importers\Engines\ExcelImporter;

class UsersImporter extends ExcelImporter
{
    protected $file = 'data.ods';

    protected static $cache = [];

    protected $columns = [
        0 => 'id',
        1 => 'name',
        2 => 'hometown_name',
        3 => 'gender_sid',
        4 => 'photo_path',
        5 => 'interests',
        6 => 'categories_bit',
        7 => 'birth_date',
        8 => 'email',
        9 => 'about',
        10 => 'work',
        11 => 'languages',
        12 => null,
        13 => null,
        14 => null
    ];

    public function parse()
    {
        return $this->parseData();
    }

    public function count()
    {
        return sizeof(self::parseData());
    }

    // id
    protected function callback0($val, $record_nr)
    {
        return intval($val);
    }

    // gender
    protected function callback3($val)
    {
        $genders = trans('models/gender', [], 'messages', 'de');
        foreach ($genders as $sid => $gender) {
            if (strpos($gender, $val) !== false) {
                return $sid;
            }
        }
        return 1;
    }

    // profile image
    protected function callback4($val)
    {
        return $this->imgFaker->directUser($val);
    }

    // interests (tags)
    protected function callback5($val)
    {
        return $this->getCSIDs($val);
    }

    // categories
    protected function callback6($val)
    {
        return id_array_to_int_bitmask($this->getCSIDs($val));
    }

    // email
    protected function callback8($val, $record_nr)
    {
        if ($record_nr > 1) {
            return 'test' . ($record_nr + 1) . '@user.com';
        } else {
            return 'test@user.com';
        }
    }

    // languages
    protected function callback11($val)
    {
        return $this->getCSIDs($val);
    }
}
