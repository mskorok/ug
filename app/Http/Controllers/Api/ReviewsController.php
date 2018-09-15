<?php

namespace App\Http\Controllers\Api;

use App\Models\Reviews\Review;
use App\Models\Traits\Interestable;
use App\Http\Requests;
use Request;
use Illuminate\Http\RedirectResponse;

/**
 * Class ReviewController
 * @package App\Http\Controllers\Api
 */
class ReviewsController extends RestController
{
    use Interestable;



    /**
     * @param $interest
     * @param Review $model
     * @return string
     */
    public function addInterest($interest, Review $model)
    {
        return $this->addInterestToModel($model, $interest);
    }


    /**
     * @param $interest
     * @param Review $model
     * @return string
     */
    public function removeInterest($interest, Review $model)
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
        $model = Review::find($model);
        return $this->getInterests($model, $page);
    }


    /**
     *
     * @param Review $model
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|string
     */
    public function like(Review $model)
    {

        if (Request::ajax()) {
            if (\Auth::check()) {
                $user = $model->user;
                $id = \Auth::id();
                if ($id == $user->id) {
                    return json_encode(['result' => false, 'message' => 'Review owner can`t like review']);
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
                return json_encode(['result' => false, 'message' => 'Guest can`t like review']);
            }
        } else {
            return redirect($this->getRedirectUrl());
        }
    }


    /**
     * @param Review $model
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|string
     */
    public function recommend(Review $model)
    {
        if (Request::ajax()) {
            if (\Auth::check()) {
                $user = $model->user;
                $id = \Auth::id();
                if ($id == $user->id) {
                    return json_encode(['result' => false, 'message' => 'Review owner can`t recommend review']);
                }
                $recommended = ($model->recommended) ? json_decode($model->recommended, true) : [];
                if (!in_array($id, $recommended)) {
                    $recommended[] = $id;
                }
                $model->recommended = $recommended;
                $model->recommend_count = count($recommended);
                $model->save();
                return json_encode([
                    'result'  => true,
                    'message' => 'Like from user added',
                    'count'   => count($recommended),
                    'id'      => $model->id
                ]);
            } else {
                return json_encode(['result' => false, 'message' => 'Guest can`t recommend review']);
            }
        } else {
            return redirect($this->getRedirectUrl());
        }
    }


    /**
     *
     * @param Review $model
     * @return \Illuminate\Http\JsonResponse|RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Exception
     * @throws \Throwable
     */
    public function related(Review $model)
    {
        if (\Request::ajax()) {
            $diff = $model->related()->diff([$model->related()->first()]);
            $page = (int) \Request::get('page', 1);

            $html = view(
                'app._partials.reviews_row',
                [
                    'reviews' => $diff->forPage($page, $model->relatedPerPage),
                ]
            )->render();
            return response()->json([
                'success' => true,
                'html' => $html,
                'lastPage' => (int) ceil($diff->count() / $model->relatedPerPage),
                'showMore' => ($diff->count() > ($page + $model->relatedPerPage)),

            ]);
        } else {
            return redirect($this->getRedirectUrl());
        }

    }
}
