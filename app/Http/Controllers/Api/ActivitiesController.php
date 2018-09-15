<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests;
use App\Models\Adventures\Adventure;
use App\Models\Traits\Interestable;
use Request;

/**
 * Class ActivitiesController
 * @package App\Http\Controllers\Api
 */
class ActivitiesController extends RestController
{
    use Interestable;

    /**
     * @param $interest
     * @param Adventure $model
     * @return string
     */
    public function addInterest($interest, Adventure $model)
    {
        return $this->addInterestToModel($model, $interest);
    }


    /**
     * @param $interest
     * @param Adventure $model
     * @return string
     */
    public function removeInterest($interest, Adventure $model)
    {
        return $this->removeInterestFromModel($model, $interest);
    }


    /**
     * @param int $model
     * @param null $page
     * @return array|\Illuminate\Support\Collection|mixed|static[]
     */
    public function interests($model, $page = null)
    {
        $model = Adventure::find($model);
        return $this->getInterests($model, $page);
    }

    /**
     *
     * @param Adventure $model
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|string
     */
    public function like(Adventure $model)
    {

        if (Request::ajax()) {
            if (\Auth::check()) {
                $user = $model->user;
                $id = \Auth::id();
                if ($id == $user->id) {
                    return json_encode(['result' => false, 'message' => 'Adventure owner can`t like adventure']);
                }
                $liked = ($model->liked) ? json_decode($model->liked, true) : [];
                if (!in_array($id, $liked)) {
                    $liked[] = $id;
                }
                $model->liked = $liked;
                $model->like_count = count($liked);
                $model->save();
                return json_encode([
                    'result'  => true,
                    'message' => 'Like from user added',
                    'count'   => count($liked),
                    'id'      => $model->id
                ]);
            } else {
                return json_encode(['result' => false, 'message' => 'Guest can`t like adventure']);
            }
        } else {
            return redirect($this->getRedirectUrl());
        }
    }


    /**
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|string
     */
    public function invite()
    {
        if (Request::ajax()) {
            if (\Auth::check()) {
                $params = Request::input();
                if (array_key_exists('invited', $params)   && !empty($params['invited'])) {
                    $this->inviteFriends($params['invited']);
                }

                return json_encode(['result' => true, 'message' => '']);
            }
            return json_encode(['result' => false, 'message' => '']);
        }
        return redirect($this->getRedirectUrl());
    }

    /**
     * @param $invited
     */
    private function inviteFriends($invited)
    {
    }
}
