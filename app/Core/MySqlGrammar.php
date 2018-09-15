<?php

namespace App\Core;

use Illuminate\Support\Fluent;

/**
 * Class MySqlGrammar
 * @package App\Core
 */
class MySqlGrammar extends \Illuminate\Database\Schema\Grammars\MySqlGrammar
{

    /**
     * @param Fluent $column
     * @return string
     */
    protected function typePoint(Fluent $column)
    {
        return 'point';
    }
}
