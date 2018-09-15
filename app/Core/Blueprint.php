<?php

namespace App\Core;

use Closure;

/**
 * Class Blueprint
 * @package App\Core
 */
class Blueprint extends \Illuminate\Database\Schema\Blueprint
{
    /**
     * Create a new schema blueprint.
     *
     * @param  string $table
     * @param  \Closure|null $callback
     */
    public function __construct($table, Closure $callback = null)
    {
        $this->engine = config('database.connections.mysql.engine');
        $this->charset = config('database.connections.mysql.charset');
        $this->collation = config('database.connections.mysql.collation');

        parent::__construct($table, $callback);
    }

    /**
     * Create a new point column on the table.
     *
     * @param  string  $column
     * @return \Illuminate\Support\Fluent
     */
    public function point($column)
    {
        return $this->addColumn('point', $column);

    }
}
