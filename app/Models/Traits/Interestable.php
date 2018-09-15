<?php

namespace App\Models\Traits;

use App\Models\Adventures\Adventure;
use App\Models\Interests\Interest;
use App\Models\Reviews\Review;
use App\Models\Users\User;
use Illuminate\Support\Collection;
use Illuminate\Support\MessageBag;

/**
 * Class Interestable
 * @package App\Models\Traits
 */
trait Interestable
{
    /**
     * @param $name
     * @param bool $bool
     * @return bool|string
     */
    protected function createInterest($name, $bool = false)
    {
        $params = ['name' => $name];
        $validator = \Validator::make($params, Interest::VALIDATION_RULES);
        $bag = new MessageBag();
        if ($validator->passes()) {
            $names = $this->getUniqueNames();
            if (!in_array($name, $names)) {
                $interest = new Interest();
                if ($interest->create($params)) {
                    if ($bool) {
                        return true;
                    } else {
                        return json_encode(['action' =>'success', 'message' => 'created']);
                    }
                }
            } else {
                $bag->add('interest_name', 'duplicated interest  name');
            }
        } else {
            $bag = $validator->messages();
        }
        if ($bool) {
            return false;
        } else {
            return json_encode(['action' =>'error', 'message' => $bag->first()]);
        }
    }

    /**
     * @param $name
     * @return string
     */
    protected function cleanName($name)
    {
        return trim(str_replace('/', '', $name));
    }

    /**
     * @return array
     */
    private function getUniqueNames()
    {
        $names = [];
        $interests = \DB::table('interests')->get(['name']);
        foreach ($interests as $i) {
            if (!in_array($i->name, $names)) {
                $names[] = $i->name;
            }
        }
        return $names;
    }

    /**
     * @param $model
     * @param $name
     * @return bool
     */
    private function hasInterest($model, $name)
    {
        if (method_exists($model, 'interests')) {
            $collection = $model->interests()->get(['name']);
            $names = [];
            /** @var Interest $item */
            foreach ($collection as $item) {
                $names[] = $item->name;
            }
            return in_array($name, $names);
        }
        return false;
    }

    /**
     * @param $model
     * @param $name
     * @return bool
     */
    private function _addInterest($model, $name)
    {
        /** @var Interest $interest */
        $interest = Interest::where('name', '=', $name)->first();

        if ($interest instanceof  Interest) {
            if (($model instanceof  Adventure || $model instanceof  Review || $model instanceof  User)) {
                $model->interests()->attach($interest);
                return true;
            }
        }
        return false;
    }

    /**
     * @param $model
     * @param $name
     * @return bool|int
     */
    private function _removeInterest($model, $name)
    {
        /** @var Interest $interest */
        $interest = Interest::where('name', '=', $name)->first();
        if ($interest instanceof  Interest) {
            if (($model instanceof  Adventure || $model instanceof  Review || $model instanceof  User)) {
                return $model->interests()->detach($interest);
            }
        }
        return false;
    }

    /**
     * @param $model
     * @param $page
     * @return array|Collection|mixed|static[]
     */
    protected function getInterests($model, $page)
    {
        if (!($model instanceof  Adventure || $model instanceof  Review || $model instanceof  User)) {
            $collection = Interest::all();
            if ($page) {
                $collection = $collection->forPage($page, 15);
                $res = [];
                foreach ($collection as $item) {
                    $res[] = $item;
                }
            } else {
                $res = $collection;
            }

            return $res;
        }
        $adventureInterests = $model->interests()->getResults();
        if ($page) {
            $interests = Interest::all();
            $interests = $interests->diff($adventureInterests);
            $collection = $interests->forPage($page, 15);
            $res = [];
            foreach ($collection as $item) {
                $res[] = $item;
            }
            return $res;
        } else {
            return $adventureInterests;
        }
    }

    /**
     * @param $model
     * @param $name
     * @return string
     */
    protected function removeInterestFromModel($model, $name)
    {
        if (!($model instanceof  Adventure || $model instanceof  Review || $model instanceof  User)) {
            return json_encode(['action' =>'error', 'message' => 'User not found']);
        }
        $name = $this->cleanName($name);

        if ($this->hasInterest($model, $name)) {
            if ($this->_removeInterest($model, $name)) {
                return json_encode(['action' =>'removed', 'message' => 'removed']);
            }
        }
        return json_encode(['action' =>'error', 'message' => 'something went wrong']);
    }

    /**
     * @param $model
     * @param $name
     * @return string
     */
    protected function addInterestToModel($model, $name)
    {
        if (!($model instanceof  Adventure || $model instanceof  Review || $model instanceof  User)) {
            return json_encode(['action' =>'error', 'message' => 'User not found']);
        }
        $name = $this->cleanName($name);
        $interests = $model->interests()->get();
        if ($interests->count() < 15) {
            $names = $this->getUniqueNames();
            if (in_array($name, $names)) {
                //add
                if (!$this->hasInterest($model, $name)) {
                    $this->_addInterest($model, $name);
                    return json_encode(['action' =>'added', 'message' => 'added']);
                } else {
                    return json_encode(['action' =>'error', 'message' => 'You already have such interest']);
                }
            } elseif ($this->permitToCreate()) {
                // add and create
                if ($this->createInterest($name, true)) {
                    if (!$this->hasInterest($model, $name)) {
                        $this->_addInterest($model, $name);
                        return json_encode(['action' =>'added', 'message' => 'added']);
                    } else {
                        return json_encode(['action' =>'error', 'message' => 'You already have such interest']);
                    }
                }
            }
            return json_encode(['action' =>'error', 'message' => 'something went wrong']);
        } else {
            return json_encode(['action' =>'overflow', 'message' => 'You already have 15 interests']);
        }
    }

    /**
     * @return bool
     */
    private function permitToCreate()
    {
        return \Auth::guard('admin')->check();
    }
}
