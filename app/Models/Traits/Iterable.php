<?php

// http://php.net/manual/en/mysqlinfo.concepts.buffering.php
// https://github.com/laravel/framework/issues/2152

namespace App\Models\Traits;

use Illuminate\Support\Facades\DB;
use PDO;

trait Iterable
{
    public static function iterate(array $columns = [], $page = 1, $rows_per_page = 20, \Closure $query_callback = null)
    {
        $query = DB::table((new self)->getTable());
        if (!empty($columns)) {
            $query->select($columns);
        }

        $query->skip($rows_per_page * ($page-1))->take($rows_per_page);

        if ($query_callback !== null) {
            $query = $query_callback($query);
        }

        $pdo = $query->getConnection()->getPdo();
        $pdo->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, false);

        $statement = $pdo->prepare($query->toSql());
        $statement->execute($query->getBindings());

        while ($row = $statement->fetch(PDO::FETCH_OBJ)) {
            yield $row;
        }
    }
}
