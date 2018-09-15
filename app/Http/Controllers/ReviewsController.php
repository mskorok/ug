<?php

namespace App\Http\Controllers;

use App\Helpers\ImageFaker;
use App\Http\Requests;
use App\Models\Reviews\Review;
use App\Models\Interests\Interest;
use App\Models\Users\User;
use Faker\Factory;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\MessageBag;
use App\Contracts\Geo;

/**
 * Class ReviewsController
 * @package App\Http\Controllers
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
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function reviews(Request $request)
    {

        $categories = $this->getCategories();
        $input = Input::get('categories');
        $categoriesDiff = null;
        if ($input) {
            $categoriesDiff = array_intersect_key($categories, $input);
        }
        $cat_ids = $categoriesDiff ?: [];

        $cat_ids = array_keys($cat_ids);
        $cats = [];
        foreach ($categories as $key => $category) {
            $cats[$key]['name'] = $category;
            $cats[$key]['checked'] = (in_array($key, $cat_ids)) ? 'checked' : '';
        }

        /** @var LengthAwarePaginator $reviews */
        $reviews = Review::with('user', 'interests')->orderBy('created_at', 'DESC');

        if (count($cat_ids) != 0) {
            $reviews->whereIn('category_sid', $cat_ids);
        }
        $reviews = $reviews->paginate(6);
        $page = (int)$request->get('page', 1);

        $showMore = ($reviews->lastPage() > $page) ? true : false;
        if ($request->ajax()) {
            $returnHTML = view(
                'app._partials.reviews_row',
                [
                    'reviews' => $reviews,
                ]
            )->render();
            return response()->json([
                'success' => true,
                'html' => $returnHTML,
                'lastPage' => $reviews->lastPage(),
                'showMore' => $showMore,
                'categories' => $cats,

            ]);
        } else {
            return view(
                'app.reviews.app_reviews',
                [
                    'reviews' => $reviews,
                    'categories' => $cats,
                    'showMore' => $showMore
                ]
            );
        }
    }


    /**
     * @param Request $request
     * @param Review $review
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Request $request, Review $review)
    {
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'review'  => $review
            ]);
        } else {
            $matched = (\Auth::id()) ? User::matched(\Auth::id()) : [];
            $diff = $review->related();
            $recommended = $review->recommendedReviews();

            $userIds = ($recommended) ? json_decode($recommended->recommended) : [];
            $recommendedUsers = [];
            foreach ($userIds as $userId) {
                if ($user = User::find((int) $userId)) {
                    $recommendedUsers[] = $user;
                }
            }
            $options = [
                'review'            => $review,
                'faker'             => new ImageFaker,
                'nameFaker'         => Factory::create(),
                'activityRelated'   => $review->relatedActivities()->first(),
                'recommended'       => $recommended,
                'reviewRelated'     => $diff->forPage(1, $review->relatedPerPage),
                'is_admin'          => $this->isAdmin(),
                'showMore'          => ($diff->count() > $review->relatedPerPage),
                'matched'           => $matched,
                'recommendation'  => $recommendedUsers
            ];
            return view('app.reviews.app_review', $options);
        }
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showAdd()
    {
        return view('app.reviews.app_new_review', [
            'categories' => $this->getCategories(),
            'faker' => new ImageFaker,
            'nameFaker' => Factory::create()
        ]);
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function postAdd(Request $request)
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

                $params['user_id']     = \Auth::id();

                $params['liked']       = [];
                $params['recommended'] = [];
                $params['slug']        = str_slug($params['title']);

                $validator = \Validator::make($params, Review::VALIDATION_RULES);
                if ($validator->passes()) {
                    $location = [
                        'lat' => $params['lat'],
                        'lng' => $params['lat']
                    ];
                    unset($params['lat'], $params['lng'], $params['place_location']);

                    $review = new Review($params);

                    if (!$review->hasGallery('gallery')) {
                        $review->setZeroGalleryAttribute();
                    }

                    $review->setLocationAttribute($location);

                    \Session::flash('alert', 'Reviews ' . $review->title . ' has been successfully created.');
                    \Session::flash('alert_type', 'success');
                    $review->setPhotoUploads(true);
                    $review->save($params);
                    $interests = $params['interests'] ?? [];
                    foreach ($interests as $name) {
                        $interest = Interest::where('name', '=', $name)->first();
                        $review->interests()->attach($interest);
                    }
                    if ($request->ajax()) {
                        return json_encode(['result' => true]);
                    }

                    return redirect()->route('reviews_list');
                } else {
                    \Session::flash('alert', 'Error occurred: ' . $validator->messages()->first() . ' ');
                    \Session::flash('alert_type', 'danger');
                    $bag = $validator->messages();
                }
            }
        } else {
            $bag->add('place_name', 'wrong place name');
        }
        if ($request->ajax()) {
            return json_encode(['result' => false, 'errors' => $bag]);
        }
        return view(
            'app.reviews.app_new_review',
            [
                'review' => new Review(),
                'categories' => $this->getCategories(),
                'action' => 'create',
                'user' => \Auth::user(),
                'errors' => $bag,
                'is_admin' => $this->isAdmin(),
                'faker' => new ImageFaker,
                'nameFaker' => Factory::create()
            ]
        );
    }


    public function edit(Request $request, Review $review)
    {

    }

    public function delete(Request $request, Review $review)
    {

    }




    /**
     * @return array
     */
    protected function getCategories()
    {
        $categories = [];
        for ($i = 1; $i < 9; $i++) {
            $path = 'models/categories.' . $i;
            $categories[] = trans($path);
        }
        return $categories;
    }

    /**
     * @return bool
     */
    protected function isAdmin()
    {
//        return Auth::guard('admin')->check(); todo
        return true;
    }
}
