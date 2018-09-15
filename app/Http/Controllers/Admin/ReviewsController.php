<?php

namespace App\Http\Controllers\Admin;

use App\Models\Interests\Interest;
use App\Models\Reviews\Review;
use App\Contracts\Geo;
use App\Models\Users\User;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\MessageBag;
use Session;

/**
 * Class ReviewsController
 * @package App\Http\Controllers\Admin
 */
class ReviewsController extends Controller
{

    /**
     * @var Geo
     */
    protected $geoProvider;


    /**
     * ReviewsController constructor.
     * @param Geo $geoProvider
     */
    public function __construct(Geo $geoProvider)
    {
        $this->geoProvider = $geoProvider;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showReviews(Request $request)
    {
        $reviews = Review::paginate(config('app.rows_per_page'));

        if ($request->ajax()) {
            return $reviews;
        } else {
            return view(
                'admin.reviews.list',
                [
                    'reviews' => $reviews,
                ]
            );
        }
    }


    /**
     * @method GET
     * @param Request $request
     * @param Review $model
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Request $request, Review $model)
    {
        if ($request->ajax()) {
            return $model;
        } else {
            return view(
                'admin.reviews.show',
                [
                    'review' => $model
                ]
            );
        }

    }


    /**
     * @method GET
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showAddReview(Request $request)
    {

        return view(
            'admin.reviews.create',
            [
                'review' => new Review(),
                'action' => 'create',
                'selectData'  => $this->userDataForSelect(),
                'user' => $request->user() ?? \Auth::user() ?? null
            ]
        );
    }


    /**
     * @method POST
     * @param Request $request
     * @param Review $model
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function postAddReview(Request $request, Review $model)
    {
        $params = $request->input();
        $country = null;
        $bag = new MessageBag();
        if (array_key_exists('place_name', $params)   && !empty($params['place_name'])) {
            // Validate place
            $geo = $this->geoProvider->getPlace(
                $params['place_name'],
                $params['place_id'],
                $params['lat'],
                $params['lng']
            );
            if ($geo) {
                $params['country_name'] = $geo['country_name'];
                $params['geo_service'] = $geo['geo_service'];


                $params['user_id']     = $params['user_id'] ?? \Auth::id();
                $params['liked']       = [];
                $params['recommended'] = [];
                $params['slug']        = str_slug($params['title']);

                $validator =\Validator::make($params, Review::VALIDATION_RULES);
                if ($validator->passes()) {
                    $location = [
                        'lat' => $params['lat'],
                        'lng' => $params['lng']
                    ];
                    unset($params['lat'], $params['lng'], $params['place_location']);
                    $model->setPhotoUploads(true);
                    $model->setLocationAttribute($location);
                    if (!$model->hasGallery('gallery')) {
                        $model->setZeroGalleryAttribute();
                    }

                    Session::flash('alert', 'Reviews '.$model->title.' has been successfully created.');
                    Session::flash('alert_type', 'success');
                    $model->setPhotoUploads(true);
                    $model->save($params);

                    $interests = $params['interests'] ?? [];
                    foreach ($interests as $name) {
                        $interest = Interest::where('name', '=', $name)->first();
                        $model->interests()->attach($interest);
                    }

                    return redirect()->route('review_list');
                } else {
                    Session::flash('alert', 'Error occurred: '.$validator->messages()->first().' ');
                    Session::flash('alert_type', 'danger');
                    $bag = $validator->messages();
                }
            }
        } else {
            $bag->add('place_name', 'wrong place name');
        }

        return view(
            'admin.reviews.create',
            [
                'review' => new Review(),
                'action' => 'create',
                'selectData'  => $this->userDataForSelect(),
                'user' => \Auth::user(),
                'errors' => $bag

            ]
        );
    }


    /**
     * @method GET
     * @param Request $request
     * @param Review $model
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showEditReview(Request $request, Review $model)
    {

        return view(
            'admin.reviews.create',
            [
                'review' => $model,
                'action' => 'edit',
                'selectData'  => $this->userDataForSelect(),
                'user' => $request->user()
            ]
        );
    }


    /**
     * @method POST
     * @param Request $request
     * @param Review $model
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function postEditReview(Request $request, Review $model)
    {
        $params = $request->input();
        $country = null;
        $bag = new MessageBag();
        if (array_key_exists('place_name', $params)   && !empty($params['place_name'])) {
            // Validate place
            $geo = $this->geoProvider->getPlace(
                $params['place_name'],
                $params['place_id'],
                $params['lat'],
                $params['lng']
            );

            if ($geo) {
                $params['country_name'] = $geo['country_name'];
                $params['geo_service'] = $geo['geo_service'];

                $params['user_id']     = $params['user_id'] ?? \Auth::id();
                $params['liked']       = [];
                $params['recommended'] = [];
                $params['slug']        = str_slug($params['title']);

                $validator =\Validator::make($params, Review::VALIDATION_RULES);
                if ($validator->passes()) {
                    $location = [
                        'lat' => $params['lat'],
                        'lng' => $params['lng']
                    ];
                    unset($params['lat'], $params['lng'], $params['place_location']);
                    if (!$model->hasGallery('gallery')) {
                        $model->setZeroGalleryAttribute();
                    }

                    $model->setLocationAttribute($location);


                    Session::flash('alert', 'Reviews '.$model->title.' has been successfully changed.');
                    Session::flash('alert_type', 'success');
                    $model->setPhotoUploads(true);
                    $model->update($params);
                    return redirect()->route('review_list');
                } else {
                    Session::flash('alert', 'Error occurred: '.$validator->messages()->first().' ');
                    Session::flash('alert_type', 'danger');
                    $bag = $validator->messages();
                }
            }
        } else {
            $bag->add('place_name', 'wrong place name');
        }

        return view(
            'admin.reviews.create',
            [
                'review' => $model,
                'action' => 'edit',
                'selectData'  => $this->userDataForSelect(),
                'user' => $request->user(),
                'errors' => $bag
            ]
        );
    }


    /**
     * @param Review $model
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function deleteReview(Review $model)
    {
        $model->delete();
        Session::flash('alert', 'Reviews '.$model->id.' deleted.');
        Session::flash('alert_type', 'danger');
        return redirect()->route('review_list');
    }

    /********************************* PROTECTED ***********************************/

    /**
     * @return array
     */
    protected function userDataForSelect()
    {
        $users = User::all();
        $selectData = [];
        /** @var User $user */
        foreach ($users as $user) {
            $selectData[$user->id] = $user->getName().' ( '.$user->email.' )';
        }

        return $selectData;
    }
}
