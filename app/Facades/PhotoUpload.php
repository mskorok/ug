<?php
/**
 * Created by PhpStorm.
 * User: michail
 * Date: 01.03.16
 * Time: 10:18
 */

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Class PhotoUpload
 * @package App\Facades
 */
class PhotoUpload extends Facade
{


    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'photoUpload';
    }
}
