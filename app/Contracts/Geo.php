<?php
/**
 * Created by PhpStorm.
 * User: michail
 * Date: 26.02.16
 * Time: 10:45
 */

namespace App\Contracts;

/**
 * Interface Geo
 * @package App\Contracts
 */
interface Geo
{
    /**
     * @param string $place
     * @param string|null $id
     * @param int|null $lat
     * @param int|null $lng
     * @return mixed
     */
    public function getPlace(string $place, string $id = null, float $lat = null, float $lng = null);
}
