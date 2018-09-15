<?php

namespace App\Models\Geo;

use Illuminate\Support\Facades\DB;

class City extends \Eloquent
{
    protected $geofields = ['position'];

    public function setLocationAttribute($value)
    {
        $this->attributes['position'] = DB::raw("POINT($value)");
    }

    public function getPositionAttribute($value)
    {
        $loc =  substr($value, 6);
        $loc = preg_replace('/[ ,]+/', ',', $loc, 1);

        return substr($loc, 0, -1);
    }

    public static function getFieldList()
    {
        $arr = [];
        $query = 'SHOW COLUMNS FROM cities';

        foreach (\DB::select($query) as $attr) {
            $field = $attr->Field;

            if ($field == 'position') {
                $field = 'astext('.$field.') as '.$field;
            }

            $arr[] = $field;
        }

        return $arr;
    }
}
