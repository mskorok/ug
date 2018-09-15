<?php

namespace Database\Importers;

use Database\Importers\Engines\ExcelImporter;

class InterestsImporter extends ExcelImporter
{
    protected $file = 'data.ods';

    protected static $cache = [];

    public function parse()
    {
        $data = $this->parseData(4);
        $res = [];
        foreach ($data as $tag) {
            $res[] = [
                'id' => $tag[0],
                'name' => $tag[1]
            ];
        }
        return $res;
    }

    public function count()
    {
        return sizeof(self::parseData(4));
    }

    public function callback0($val)
    {
        return intval($val);
    }
}
