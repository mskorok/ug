<?php

namespace App\Core;

/**
 * Class MysqlConnection
 * @package App\Core
 */
class MysqlConnection extends \Illuminate\Database\MySqlConnection
{

    /**
     * Get a schema builder instance for the connection.
     *
     * @return \Illuminate\Database\Schema\MySqlBuilder
     */
    public function getSchemaBuilder()
    {

        $builder = parent::getSchemaBuilder();

        $builder->blueprintResolver(function ($table, $callback) {

            return new Blueprint($table, $callback);
        });

        return $builder;
    }

    /**
     * Get the default schema grammar instance.
     *
     * @return \Illuminate\Database\Schema\Grammars\MySqlGrammar
     */
    protected function getDefaultSchemaGrammar()
    {
        return $this->withTablePrefix(new MySqlGrammar);
    }
}
