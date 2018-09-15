<?php
/**
 * Created by PhpStorm.
 * User: michail
 * Date: 29.02.16
 * Time: 15:44
 */

namespace App\Services;

use App\Contracts\PhotoUpload;
use Illuminate\Database\Eloquent\Model;
use Intervention\Image\Facades\Image;
use Intervention\Image\ImageManager;

/**
 * Class PhotoUploadService
 * @package App\Services
 */
class PhotoUploadService implements PhotoUpload
{
    /**
     * @var ImageManager
     */
    protected $manager;

    protected $driver = 'imagick';

    protected $versions = [
        [
            'type' => APP_PHOTO_SMALL,
            'size' => 60,
            'blurred' => false,
        ],
        [
            'type' => APP_PHOTO_MEDIUM,
            'size' => 100,
            'blurred' => false,
        ],
        [
            'type' => APP_PHOTO_LARGE,
            'size' => 200,
            'blurred' => false,
        ]
    ];

    /**
     * PhotoUploadService constructor.
     */
    public function __construct()
    {
        $this->manager = new ImageManager(['driver' => $this->driver]);

    }

    /**
     * @return ImageManager
     */
    public function getManager()
    {
        return $this->manager;
    }


    /**
     * @param Model $model
     * @param $file_column
     * @return mixed
     */
    public static function createImages(Model $model, $file_column = null)
    {
        if (!$file_column) {
            if (isset($model->file_columns) && is_array($model->file_columns) && count($model->file_columns) > 0) {
                $file_column = $model->file_columns[0];
            } else {
                return null;
            }
        }

        $items = (new static())->getSubdirectories($model, $file_column);
        $path = getcwd().$model->{$file_column};


        //Image::configure(['driver' => 'imagick']);
        foreach ($items as $item) {
            /** @var \Intervention\Image\Image $img */
            $img = Image::make($path);

            $img->resize($item['size'], $item['size']);
            if ($item['blurred']) {
                $img->blur(7);
            }
            $file = getcwd().$item['file'];
            $img->save($file);
        }
    }


    /**
     * @param Model $model
     * @param $file_column
     * @param bool $original
     * @return mixed
     */
    public static function deleteImages(Model $model, $file_column, $original = false)
    {
        $items = (new static())->getSubdirectories($model, $file_column, $original);
        foreach ($items as $item) {
            $file = getcwd().$item['file'];
            if (\File::exists($file)) {
                \File::delete($file);
            }
        }
    }


    /**
     * @param Model $model
     * @param string $versionName
     * @param null $file_column
     * @return \Carbon\Carbon|\Illuminate\Support\Collection|int|mixed|null|string|static
     */
    public function getImage(Model $model, $versionName, $file_column = null)
    {
        try {
            if (!$file_column) {
                if (method_exists($model, 'getFileColumns') &&
                    is_array($model->getFileColumns()) &&
                    count($model->getFileColumns()) > 0
                ) {
                    $file_column = $model->getFileColumns()[0];
                } else {
                    return null;
                }
            }

            if ($model->{$file_column} === '') {
                return config('_project.no_avatar_image_path');
            }

            if ($versionName == APP_PHOTO_DEFAULT) {
                return $model->{$file_column};
            }

            $traits = class_uses(get_class($model));
            if (in_array('App\Models\Traits\Uploadable', $traits)) {
                $basename = pathinfo($model->{$file_column}, PATHINFO_BASENAME);
                $dir  = pathinfo($model->{$file_column}, PATHINFO_DIRNAME);
                $version = $this->getVersion($versionName);
                if ($version) {
                    $folder = config('_project.img_version_folder.' . $version['type']);
                    if ($folder === null) {
                        throw new \Exception('Unknown type "'.$version['type'].'" in PhotoUploadService::getImage()');
                    }
                    $file = $dir.'/'.$folder.'/'.$basename;
                    if (\File::exists(getcwd().$file)) {
                        return $file;
                    } else {
                        return $model->{$file_column};
                    }
                }
            }
            return null;
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return null;
        }
    }

    /**
     * @return string
     */
    public function getDriver()
    {
        return $this->driver;
    }

    /**
     * @param string $driver
     * @return void
     */
    public function setDriver($driver)
    {
        if (in_array($driver, ['gd', 'imagick'])) {
            $this->driver = $driver;
            $this->manager->configure(['driver' => $this->driver]);
        }

    }

    /**
     * @return array
     */
    public function getVersions()
    {
        return $this->versions;
    }

    /**
     * @param $version
     * @return bool|array
     */
    public function getVersion($version)
    {
        foreach ($this->versions as $item) {
            if ($item['type'] == $version) {
                return $item;
            }
        }
        return null;
    }

    /**
     * @param $version
     * @return bool
     *
     */
    public function removeVersion($version)
    {
        foreach ($this->versions as $k => $item) {
            if ($item['type'] == $version) {
                unset($this->versions[$k]);
                return true;
            }
        }
        return false;
    }

    /**
     *
     *   [ 'type' => APP_PHOTO_SMALL, 'size' => 60,'blurred' => false ]
     *
     * @param array $version
     * @return void
     */
    public function addVersion(array $version)
    {
        $this->versions[] = $version;
    }


    /**
     * @param Model $model
     * @param string $file_column
     * @param bool $original
     * @return array
     */
    public function getSubdirectories(Model $model, string $file_column, $original = false)
    {
        try {
            $path = ($original) ? $model->getOriginal($file_column) : $model->{$file_column};
            if (!$path) {
                return [];
            }
            $file = pathinfo($path, PATHINFO_BASENAME);
            $dir  = pathinfo($path, PATHINFO_DIRNAME);
            $res = [];
            $cd = getcwd();

            foreach ($this->getVersions() as $version) {
                $folder = config('_project.img_version_folder.' . $version['type']);
                if ($folder === null) {
                    throw new \Exception(
                        'Unknown type "'.$version['type'].'" in PhotoUploadService::getSubdirectories()'
                    );
                }
                $sub = $dir.'/'.$folder;
                if ($this->makeDir($cd.$sub)) {
                    $res[] = [
                        'file' => $sub.'/'.$file,
                        'size' => $version['size'],
                        'blurred' => $version['blurred']
                    ];
                }
            }
            return $res;
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return [];
        }


    }

    /**
     * @param $path
     * @return bool
     */
    protected function makeDir($path)
    {
        return is_dir($path) || mkdir($path, 0777, true);
    }
}
