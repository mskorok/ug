<?php namespace App\Models\Traits;

use App\Facades\PhotoUpload;
use Illuminate\Database\Eloquent\Model;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Request;
use Exception;
use File;

/**
 * Uploadable trait for Eloquent models
 *
 * Files stored in public/{config._project.user_files_path}/model_table_name/column_name(s)
 * Files are named as: modelPK_YYYYMMDD_1234567890.ext ( recommended column size varchar(64) )
 *
 * $fillable IS IGNORED. There is no need in adding file column to $fillable.
 *
 * DOES NOT include validation (allowed mime types, file size, etc.), write custom validators/requests for this
 *
 * Laravel Eloquent properties used when creating files
 * Eloquent::$primaryKey
 * Eloquent::getTable()
 * Column name should be same as file input name, for example photo_path
 *
 * If Request::input(file_input_name) defined and not null, i.e. file was submitted
 * Then this trait will automatically handle file upload:
 * If new model created - new file will be created
 * If model updated - old file will be removed and new created
 * If model deleted - all files associated with model will be deleted
 *
 * To let Eloquent and this Trait know which columns are files
 * $file_columns array property SHOULD BE DEFINED in Model
 * and should be filled with all column names which requires file handling
 *
 * Two magic methods available to retrieve full URL to file, for example, to insert in src="" attribute
 * and full path to file
 * Eloquent::getPhotoPathUrl()
 * Method begins with get and ends with Url() and between them column name in camel case.
 */
trait Uploadable
{

    /**
     * When true - images will be created with all formats;
     * @var boolean
     */
    protected $photoUploads = false;

    /**
     * Binds file handling methods to Eloquent events
     */
    public static function boot()
    {
        parent::boot();

        // delete files on disk associated with model when model deleted
        static::deleted(function (Model $model) {
            foreach ($model->file_columns as $file_column) {
                $model->deleteFile($file_column);
            }

            if (isset($model->gallery_columns) && is_array($model->gallery_columns)) {
                foreach ($model->gallery_columns as $gallery) {
                    $model->deleteGallery($gallery);
                }
            }
        });

        // handle file uploading when creating or editing model
        static::saving(function (Model $model) {
            foreach ($model->file_columns as $file_column) {
                $model->uploadFile($file_column); // if file not submitted not executed
                if ($model->isPhotoUploads()) {
                    app('photoUpload')->createImages($model, $file_column);
                }
            }

            if (isset($model->gallery_columns) && is_array($model->gallery_columns)) {
                foreach ($model->gallery_columns as $gallery) {
                    $model->createGallery($gallery);
                }
            }
        });

        // if uploaded another file, remove previous
        static::saved(function (Model $model) {
            // detect if model exists
            if ($model->getKey() !== null) {
                foreach ($model->file_columns as $file_column) {
                    if (Request::hasFile($file_column)) {
                        $model->deleteFile($file_column, true);
                        if ($model->isPhotoUploads()) {
                            app('photoUpload')->deleteImages($model, $file_column, true);
                        }
                    }
                }
            }
        });
    }

/*    public function __call($method, $args)
    {
        $starts = starts_with($method, 'get');
        if ($starts && ends_with($method, 'Url')) {
            $field_name = camel_case(substr($method, 3, strlen($method)-6));
            return $this->_getFilesUrl($this->{$field_name}, true);
        //} elseif ($starts && ends_with($method, 'Path')) {
        //    $field_name = str_from_camel_case(substr($method, 3, strlen($method) - 7));
        //    return $this->getModelFileDir() . $this->{$field_name};
        } else {
            return parent::__call($method, $args);
        }
    }*/

    /**
     * @param $method
     * @param $args
     * @internal param $name
     * @return string
     */
    public function __call($method, $args)
    {

        $starts = starts_with($method, 'get');
        $name = camel_case(substr($method, 3));
        $camel = [];
        foreach ($this->file_columns as $key => $file_column) {
            $camel[$key] =  camel_case($file_column);
        }
        $uploadService= \App::make('App\Contracts\PhotoUpload');
        if ($starts && in_array($name, $camel)) {
            $key = array_search($name, $camel);
            $version = $args[0];

            if ($key !== false && $uploadService) {
                $name = $this->file_columns[$key];
                return $uploadService->getImage($this, $name, $version);
            }
        }
        return parent::__call($method, $args);
    }




    /**
     * Get file public path for current model
     * If $column_name is passed then will return full path to directory of files for this column
     * If $add_file_to_path also is true, will return full path to file itself
     * @param null|string $column_name
     * @param bool        $add_file_to_path
     * @return string
     */
    private function _getFilesPublicPath($column_name = null, $add_file_to_path = false)
    {
        $path = config('_project.user_files_path') . '/' . $this->getTable();
        if ($column_name) {
            $path .= '/' . str_plural($column_name);
            if ($add_file_to_path) {
                $path .= '/' . $this->{$column_name};
            }
        }
        return $path;
    }

    /**
     * Get full file path for current model
     * If $column_name is passed then will return full path to directory of files for this column
     * If $add_file_to_path also is true, will return full path to file itself
     * @param null|string $column_name
     * @param bool        $add_file_to_path
     * @return string
     */
    private function _getFilesPath($column_name = null, $add_file_to_path = false)
    {
        return public_path($this->_getFilesPublicPath($column_name, $add_file_to_path));
    }

    /**
     * Get full file URL for current model
     * If $column_name is passed then will return full path to directory of files for this column
     * If $add_file_to_path also is true, will return full path to file itself
     * @param null|string $column_name
     * @param bool        $add_file_to_path
     * @return string
     */
    private function _getFilesUrl($column_name = null, $add_file_to_path = false)
    {
        return url($this->_getFilesPublicPath($column_name, $add_file_to_path));
    }




    /**
     * Generates random file name in format modelPK_YYMMDD_1234567890.ext (strlen from 21 to 25)
     * @param  $file_extension
     * @return string
     */
    private function _generateFileName($file_extension)
    {
        // strlen 4+2+2+1+10+1+(1-4) = 21-25
        return $this->{$this->primaryKey} . '_' . date('Ymd') . '_' . str_random(10) . '.' . $file_extension;
    }

    /**
     * Checks if file is submitted, is valid, allowed in max file size, generates random name and
     * moves file into model directory
     * html file input name bust be the same as column name in which file name is stored
     * Field is automatically assigned to generated file name
     * DOES NOT include validation (allowed mime types, file size, etc.)
     * Old files are not removed, it might be useful to store old versions. Old files might be removed via cron
     *
     * @param   string       $input_name  name of file html input and column name to store file name
     * @return  string|false $file_name   generated file name or false, if file input not submitted
     * @throws  Exception
     */
    public function uploadFile($input_name)
    {
        if (Request::hasFile($input_name)) {
            // get file
            $file = Request::file($input_name);
            if ($file->isValid()) {
                $data = $this->_uploadFile($file, $input_name);

                // set model field with file name to be stored in database with save()
                $this->{$input_name} = $data['path'];


                return $data['file_name'];
            } else {
                throw new Exception('File input with name "'.$input_name.'" is not valid.');
            }
        } elseif (Request::input($input_name . '_delete')) {
            $this->deleteFile($input_name);
            $this->{$input_name} = '';
        } else {
            if ($this->{$input_name} === null) {
                $this->{$input_name} = '';
            }
            return false;
        }
    }

    /**
     * @param $url
     * @param $column_name
     * @return string
     */
    public function uploadFileFromUrl($url, $column_name)
    {
        $urlPath = parse_url($url)['path'];
        $file_name = $this->_generateFileName(pathinfo($urlPath, PATHINFO_EXTENSION));
        $file_path = $this->_getFilesPath($column_name, true);

        if (!file_exists($file_path)) {
            mkdir($file_path, 0766, true);
        }
        file_put_contents($file_path . $file_name, file_get_contents($url));

        $this->{$column_name} = '/' . $this->_getFilesPublicPath($column_name) . '/' . $file_name;

        return $file_name;
    }

    /**
     * @param $column_name
     * @return bool
     */
    public function fileExists($column_name)
    {
        return File::exists($this->_getFilesPath($column_name) . '/' . $this->{$column_name});
    }

    /**
     * @param $input_name
     * @return bool
     */
    public function fileSubmitted($input_name)
    {
        return Request::hasFile($input_name);
    }

    /**
     * Return null if file not exists or true if file deleted or false if was an error
     *
     * @param string $column_name column name
     * @param bool   $original    [false] if true delete old (original) file
     *
     * @return null|bool
     */
    public function deleteFile($column_name, $original = false)
    {
        $file_name = ($original) ? $this->getOriginal($column_name) : $this->{$column_name};
        $file_path = public_path($file_name);
        if (File::exists($file_path)) {
            return File::delete($file_path);
        } else {
            return null;
        }
    }


    /**
     * @param $gallery
     * @return bool
     */
    public function hasGallery($gallery)
    {
        if (! is_array($files = Request::file($gallery))) {
            $files = [$files];
        }
        if (count($files) < 1) {
            return false;
        }
        $res = true;
        foreach ($files as $file) {
            if (!($file instanceof \SplFileInfo && $file->getPath() != '')) {
                $res = false;
            }
        }
        return $res;
    }

    /**
     * @param boolean $photoUploads
     */
    public function setPhotoUploads($photoUploads)
    {
        $this->photoUploads = $photoUploads;
    }

    /**
     * @return boolean
     */
    public function isPhotoUploads()
    {
        return $this->photoUploads;
    }

    /**
     * @param UploadedFile $file
     * @param string $input_name
     * @return array
     * @throws Exception
     */
    protected function _uploadFile(UploadedFile $file, string $input_name)
    {
        $file_size = $file->getSize();
        $max_file_size = get_max_upload_file_size();
        if ($file_size > $max_file_size) {
            throw new Exception('File input with name "'.$input_name.'" is too big.
                        (File size: '.format_bytes($file_size).'; max_upload_file_size: '.format_bytes($file_size).')');
        }

        // get file original extension
        $file_extension = $file->getClientOriginalExtension();
        if ($file_extension === null || $file_extension === '' || $file_extension === false) {
            $mimeType = $file->getClientMimeType();

            switch ($file->getClientMimeType()) {
                case 'image/jpeg':
                    $file_extension = 'jpg';
                    break;
                case 'image/png':
                    $file_extension = 'png';
                    break;
                default:
                    throw new \Exception("MIME type $mimeType not supported.");
            }
        }

        // generate random file name
        $file_name = $this->_generateFileName($file_extension);
        // get file full path
        $file_path = $this->_getFilesPath($input_name);
        // move file to public model directory
        $file->move($file_path, $file_name);
        $path = '/' . $this->_getFilesPublicPath($input_name) . '/' . $file_name;


        return ['path' => $path, 'file_name' => $file_name];
    }

    /**
     * @param $gallery
     */
    protected function deleteGallery($gallery)
    {
        if (isset($this->{$gallery})) {
            $files = $this->{$gallery};
            array_map('unlink', $files);
        }

    }




    /**
     * @param $gallery
     * @throws Exception
     */
    protected function createGallery($gallery)
    {
        if ($this->hasGallery($gallery)) {
            // get file
            $files = Request::file($gallery);
            $gallery_array = (isset($this->{$gallery})) ? json_decode($this->{$gallery}) : [];
            $gallery_array = (is_array($gallery_array)) ? $gallery_array : [];
            if (is_array($files)) {
                foreach ($files as $file) {
                    if ($file instanceof UploadedFile) {
                        $data = $this->_uploadFile($file, $gallery);
                        $gallery_array[] = $data['path'];
                    }
                }
            }
            $this->{$gallery} = json_encode($gallery_array);
        }
    }
}
