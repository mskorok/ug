<?php

namespace App\Http\Controllers\Api;

use App\Models\Interests\Interest;
use App\Http\Requests;
use App\Models\Traits\Interestable;
use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * Class InterestController
 * @package App\Http\Controllers\Api
 */
class InterestController extends RestController
{
    use Interestable;

    const MODEL_CLASS = Interest::class;
    /*************************************** AJAX  *************************************/

    /**
     * @method GET
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function interests()
    {
        $interests = Interest::all(['id','name']);
        return $interests;
    }

    /**
     * Returns a collection of interests in JSend/key-value format, according to specified URL params
     * @method GET
     * @return mixed
     */
    public function index()
    {
        try {
            $qb = Interest::query();
            $qb->getQuery()->orderBy('name');
            $coll = $this->getCollection($qb);
            return $coll;
        } catch (\Exception $e) {
            return parent::error($e);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $qb = Interest::query()->where('id', $id);

            return parent::get($qb);
        } catch (\Exception $e) {
            return parent::error($e);
        }
    }

    /**
     * @method GET
     * @param Interest $interest
     * @return Interest
     */
    public function interest(Interest $interest)
    {
        return $interest;
    }

    /**
     * @param $name
     * @return string
     */
    public function postAddInterest($name)
    {
        $name = $this->cleanName($name);
        $names = $this->getUniqueNames();
        if (in_array($name, $names)) {
            return json_encode(['action' =>'exist', 'message' => 'nothing changed']);
        }
        return $this->createInterest($name);
    }

    /**
     * @param $old
     * @param $new
     * @return string
     */
    public function editInterest($old, $new)
    {
        $old = $this->cleanName($old);
        $new = $this->cleanName($new);
        try {
            /** @var Interest $interest */
            $interest = Interest::where('name', '=', $old)->firstOrFail();
            $interest->name = $new;
            $interest->save();
            return json_encode(['action' =>'edited', 'message' => 'edited']);
        } catch (ModelNotFoundException $e) {
            return json_encode(['action' =>'not fount', 'message' => 'Interest not found']);
        }
    }

    /**
     * @param $name
     * @return string
     * @throws \Exception
     */
    public function deleteInterest($name)
    {
        $name = $this->cleanName($name);
        try {
            /** @var Interest $interest */
            $interest = Interest::where('name', '=', $name)->firstOrFail();
            $interest->delete();
            return json_encode(['action' =>'deleted', 'message' => 'deleted']);
        } catch (ModelNotFoundException $e) {
            return json_encode(['action' =>'not fount', 'message' => 'Interest not found']);
        }
    }
}
