<?php
/**
 * Created by PhpStorm.
 * User: michail
 * Date: 29.02.16
 * Time: 15:43
 */

namespace App\Contracts;

use Illuminate\Database\Eloquent\Model;

/**
 * Interface PhotoUploads
 * @package App\Contracts
 */
interface PhotoUpload
{
    /**
     * @param Model $model
     * @param $file_column
     * @return mixed
     */
    public static function createImages(Model $model, $file_column);

    /**
     * @param Model $model
     * @param $file_column
     * @return mixed
     */
    public static function deleteImages(Model $model, $file_column);

    /**
     * @param Model $model
     * @param string $name
     * @param string $version
     * @return string
     */
    public function getImage(Model $model, $name, $version);


    public function getVersions();

    /**
     * @param $key
     * @return bool|array
     */
    public function getVersion($key);

    /**
     * @param $key
     * @return bool
     */
    public function removeVersion($key);

    /**
     * @param array $version
     *@return void
     */
    public function addVersion(array $version);
}
