<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Log;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Database\Query\Builder as DbBuilder;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class RestController
 *
 * Supported URL parameters (all input is case insensitive):
 *   fields - [optional] a comma-separated list of fields to select. If empty than all fields ('*').
 *   like - [optional]. Is similar to SQL LIKE. Supported only for collections.
 *   limit - [optional]. Is similar to SQL LIMIT.  Supported only for collections.
 *   notIn - [optional]. Is similar to SQL NOT IN.  Supported only for collections.
 *   offset - [optional]. Is similar to SQL OFFSET.  Supported only for collections.
 *   equalTo - [optional]. A filtering condition. Checks if value of the specified field equal to parameter
 *                         value provided in URL. Supported only for collections.
 *   format - [optional]. Possible values: 'jsend', 'keyvalue'.  Supported only for collections.
 *
 *   URL example: <base url>/api/v1/countries/1/cities?fileds=id,name&like[name]=Sa&like[slug]=ju&limit=3
 *
 * A parent class for REST API controllers
 * @package App\Http\Controllers
 */
abstract class RestController extends Controller
{
    use ValidatesRequests;

    const MODEL_CLASS       = null;
    const STATUS_SUCCESS    = 'success';
    const STATUS_FAIL       = 'fail';
    const STATUS_ERROR      = 'error';
    const STATUS_REGISTERED = 'registered';

    private $request;

    /**
     * RestController constructor.
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Gets response for an individual REST resource item
     * @param Builder $qb
     * @param null $fieldList
     * @return mixed
     */
    public function get(Builder $qb, $fieldList = null)
    {
        try {
            $fields = $this->getFields();
            $fields = empty($fields) ? $fieldList : $fields;

            $entity = $qb->getQuery()->addSelect(\DB::raw(implode(', ', $fields)))->get();

            if (! $entity) {
                abort(404);
            } else {
                $status = Response::HTTP_OK;

                $result = $this->constructJSendResponse(
                    self::STATUS_SUCCESS,
                    [$this->getEntityName() => $entity]
                );
            }

            return response()->json($result, $status);
        } catch (\Exception $e) {
            return $this->error($e);
        }
    }

    /**
     * Gets response for a collection of items
     * @param Builder $eloquentQb
     * @param null $fieldList
     * @return mixed
     */
    public function getCollection(Builder $eloquentQb, $fieldList = null)
    {
        try {
            $qb = $eloquentQb->getQuery();
            $qb = $this->applyLike($qb);
            $qb = $this->applyNotIn($qb);
            $qb = $this->applyEqualTo($qb);

            $r = $this->request;

            // Format
            $format = $r->has('format') ? $r->get('format') : 'jsend';
            $fields = $this->getFields();
            $fields = empty($fields) ? $fieldList : $fields;

            if ($format == 'keyvalue') {
                if (count($fields) != 1) {
                    throw new \Exception('One and only one field must be specified in case of [keyvalue] format.');
                }

                if (! in_array('id', $fields)) {
                    $fields[] = 'id';
                }
            }

            if (! $fields) {
                $fields = ['*'];
            }

            $qb = $qb->addSelect(\DB::raw(implode(', ', $fields)));
            $qb = $this->applyLimit($qb);
            $qb = $this->applyOffset($qb);

            $entities = $qb->get();
            $result = [];

            switch ($format) {
                case 'jsend':
                    $entityName = str_plural($this->getEntityName());

                    $result = $this->constructJSendResponse(
                        self::STATUS_SUCCESS,
                        [$entityName => $entities]
                    );
                    break;
                case 'keyvalue':
                    $result = [];
                    $field = $r->get('fields');

                    foreach ($entities as $entity) {
                        $result[$entity->id] = $entity->$field;
                    }

                    break;
            }


            return response()->json($result);
        } catch (\Exception $e) {
            return $this->error($e);
        }
    }

    /**
     * @param DbBuilder $qb
     * @return DbBuilder
     * @throws \Exception
     */
    private function applyOffset(DbBuilder $qb)
    {
        $offset = $this->getIntParam('offset');

        if (isset($offset)) {
            $qb->offset($offset);
        }

        return $qb;
    }

    /**
     * @param DbBuilder $qb
     * @return DbBuilder
     * @throws \Exception
     */
    private function applyLimit(DbBuilder $qb)
    {
        $limit = $this->getIntParam('limit');

        if (isset($limit)) {
            $qb->limit($limit);
        }

        return $qb;
    }

    /**
     * @param DbBuilder $qb
     * @return DbBuilder
     * @throws \Exception
     */
    private function applyLike(DbBuilder $qb)
    {
        $r = $this->request;

        if ($r->has('like')) {
            foreach ($r->get('like') as $attribute => $value) {
                if ($this->validateColumnName($attribute)) {
                    $value = $this->escapeStr($value);

                    $qb->whereRaw(
                        \DB::raw("LOWER($attribute) LIKE LOWER('%$value%')")
                    );
                } else {
                    throw new \Exception("Wrong attribute name: $attribute");
                }
            }
        }
        return $qb;
    }

    /**
     * @param DbBuilder $qb
     * @return DbBuilder
     * @throws \Exception
     */
    private function applyEqualTo(DbBuilder $qb)
    {
        $r = $this->request;

        if ($r->has('equalTo')) {
            foreach ($r->get('equalTo') as $attribute => $value) {
                if ($this->validateColumnName($attribute)) {
                    $qb->where($attribute, $value);
                } else {
                    throw new \Exception("Wrong attribute name: $attribute");
                }
            }
        }

        return $qb;
    }

    /**
     * @param DbBuilder $qb
     * @return DbBuilder
     * @throws \Exception
     */
    private function applyNotIn(DbBuilder $qb)
    {
        $r = $this->request;

        if ($r->has('notIn')) {
            foreach ($r->get('notIn') as $attribute => $value) {
                if ($this->validateColumnName($attribute)) {
                    $valueArr = explode(',', $value);
                    $str='';

                    foreach ($valueArr as $item) {
                        $str .= $this->escapeStr($item, true) . ', ';
                    }

                    $str = trim($str, ', ');

                    $qb->whereRaw(
                        \DB::raw("$attribute NOT IN ($str)")
                    );
                } else {
                    throw new \Exception("Wrong attribute name: $attribute");
                }
            }
        }
        return $qb;
    }

    /**
     * @param $string
     * @param bool $quote
     * @return mixed|string
     */
    protected function escapeStr($string, $quote = false)
    {
        $search = ['%', '_', "'", '"'];
        $replace   = ['\%', '\_', "\'", '\"'];

        $res = str_replace($search, $replace, $string);

        if ($quote == true) {
            $res = "'" . $res . "'";
        }

        return $res;
    }

    /**
     * @param $param
     * @return mixed|null
     * @throws \Exception
     */
    private function getIntParam($param)
    {
        $r = $this->request;

        if ($r->has($param)) {
            $limit = $r->get($param);

            if ((string)(int)$limit != $limit) {
                throw new \Exception("Value of [$param] parameter must be integer.");
            }

            return $limit;
        } else {
            return null;
        }
    }

    /**
     * @return array|null
     * @throws \Exception
     */
    private function getFields()
    {
        $r = $this->request;

        if ($r->has('fields')) {
            $fields = explode(',', $r->get('fields'));

            foreach ($fields as $field) {
                if (! $this->validateColumnName($field)) {
                    throw new \Exception("Wrong field name: $field");
                }
            }

            return array_map('trim', $fields);
        } else {
            return null;
        }
    }

    /**
     * @param \Exception $e
     * @return mixed
     */
    public function error(\Exception $e)
    {

        $this->logException($e);

        return $this->constructJSendResponse(self::STATUS_ERROR, null, $e->getMessage());
    }


    /**
     * @param \Throwable $e
     * @return mixed
     */
    public function throwable(\Throwable $e)
    {

        $this->logThrowable($e);

        return $this->constructJSendResponse(self::STATUS_ERROR, null, $e->getMessage());
    }

    /**
     * @param $data
     * @return mixed
     */
    public function fail($data)
    {
        return $this->constructJSendResponse(self::STATUS_FAIL, $data, null);
    }

    /**
     * @param $message
     * @return mixed
     */
    public function success($message)
    {
        return $this->constructJSendResponse(self::STATUS_SUCCESS, $message, null);
    }

    /**
     * @param $message
     * @return mixed
     */
    public function registered($message)
    {
        return $this->constructJSendResponse(self::STATUS_SUCCESS, $message, null);
    }

    /**
     * @return string
     */
    private function getShortModelClassName()
    {
        $reflect = new \ReflectionClass($this->getModelClass());

        return $reflect->getShortName();
    }

    /**
     * @return null
     * @throws \Exception
     */
    private function getModelClass()
    {
        if (empty(static::MODEL_CLASS)) {
            throw new \Exception('Model class must be specified on Controller.');
        }

        return static::MODEL_CLASS;
    }

    /**
     * @param null $data
     * @param null $status
     * @param null $errorMessage
     * @return mixed
     */
    private function constructJSendResponse($status, $data = null, $errorMessage = null)
    {

        $result['status'] = $status;

        if ($data) {
            $result['data'] = $data;
        }

        if ($errorMessage) {
            $result['message'] = $errorMessage;
        }

        return $result;
    }

    /**
     * @return string
     */
    private function getEntityName()
    {
        return lcfirst($this->getShortModelClassName());
    }

    /**
     * @return string
     */
    private function getTableName()
    {
        $modelClass = static::MODEL_CLASS;
        /** @var Model $model */
        $model = new $modelClass();
        return $model->getTable();
    }

    /**
     * @param $columnName
     * @return bool
     */
    private function validateColumnName($columnName)
    {
        $tableName = $this->getTableName();
        $columns = \Schema::getColumnListing($tableName);

        return in_array($columnName, $columns);
    }

    /**
     * @param \Exception $e
     */
    private function logException(\Exception $e)
    {
        Log::error(
            "Code: " . $e->getCode() .
            "; Message: " . $e->getMessage() .
            "\n" . $e->getTraceAsString()
        );
    }


    /**
     * @param \Throwable $e
     */
    private function logThrowable(\Throwable $e)
    {
        Log::error(
            "Code: " . $e->getCode() .
            "; Message: " . $e->getMessage() .
            "\n" . $e->getTraceAsString()
        );
    }
}
