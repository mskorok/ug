<?php

namespace App\Http\Controllers;

use App\Facades\PhotoUpload;
use App\Helpers\ImageFaker;
use App\Http\Requests;
use App\Jobs\SendInviteEmail;
use App\Models\Adventures\Adventure;
use App\Models\Interests\Interest;
use App\Models\Users\User;
use Faker\Factory;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\MessageBag;
use App\Contracts\Geo;
use Mail;

/**
 * Class ActivitiesController
 * @package App\Http\Controllers
 */
class ActivitiesController extends Controller
{


    /**
     * @var Geo
     */
    protected $geoProvider;

    /**
     * ActivitiesController constructor.
     * @param Geo $geoProvider
     */
    public function __construct(Geo $geoProvider)
    {
        $this->geoProvider = $geoProvider;
    }


    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function activities(Request $request)
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

        /** @var LengthAwarePaginator $adventures */
        $adventures = Adventure::with('user', 'interests')->orderBy('created_at', 'DESC');

        if (count($cat_ids) != 0 && Adventure::whereIn('category_sid', $cat_ids)->count() > 12) {
            $adventures->whereIn('category_sid', $cat_ids);
        }
        $adventures = $adventures->paginate(12);
        $page = (int)$request->get('page', 1);

        $showMore = ($adventures->lastPage() > $page) ? true : false;
        if ($request->ajax()) {
            $returnHTML = view(
                'app._partials.adventures_row',
                [
                    'adventures' => $adventures,
                ]
            )->render();
            return response()->json([
                'success' => true,
                'html' => $returnHTML,
                'lastPage' => $adventures->lastPage(),
                'showMore' => $showMore,
                'categories' => $cats
            ]);
        } else {
            return view(
                'app.activities.activities',
                [
                    'adventures' => $adventures,
                    'categories' => $cats,
                    'showMore' => $showMore
                ]
            );
        }
    }


    /**
     * @param Request $request
     * @param Adventure $adventure
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Request $request, Adventure $adventure)
    {
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'activity' => $adventure
            ]);
        } else {
            return view(
                'app.activities.app_activity',
                [
                    'activity' => $adventure,
                    'joined' => true,
                    'goingCount' => $adventure->getGoingCount(),
                    'followingCount' => $adventure->getFollowingCount(),
                    'faker' => new ImageFaker,
                    'nameFaker' => Factory::create(),
                    'activityRelated' => $adventure->related()->first(),
                    'is_admin' => $this->isAdmin()
                ]
            );
        }
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showAdd()
    {
        return view('app.activities.app_new_activity', [
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
        if (array_key_exists('place_name', $params)  && !empty($params['place_name'])) {
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


                $params['user_id']   = \Auth::id();
                $params['slug']      = str_slug($params['title']);
                $params['going']     = [];
                $params['following'] = [];
                $params['liked']     = [];

                $validator = \Validator::make($params, Adventure::VALIDATION_RULES);
                if ($validator->passes()) {
                    $location = [
                        'lat' => $params['lat'],
                        'lng' => $params['lng']
                    ];
                    unset($params['lat'], $params['lng'], $params['place_location']);

                    $adventure = new Adventure($params);
                    $adventure->setLocationAttribute($location);
                    \Session::flash('alert', 'Adventures ' . $adventure->title . ' has been successfully created.');
                    \Session::flash('alert_type', 'success');
                    $adventure->setPhotoUploads(true);
                    $adventure->save($params);
                    $interests = $params['interests'] ?? [];
                    foreach ($interests as $name) {
                        $interest = Interest::where('name', '=', $name)->first();
                        $adventure->interests()->attach($interest);
                    }
                    $invites = $params['invite'] ?? [];
                    if (is_array($invites) && count($invites) > 0) {
                        $this->sendInviteEmail($adventure, \Auth::user(), $invites);
                    }

                    return redirect()->route('activities_list');
                } else {
                    \Session::flash('alert', 'Error occurred: ' . $validator->messages()->first() . ' ');
                    \Session::flash('alert_type', 'danger');
                    $bag = $validator->messages();
                }
            }
        } else {
            $bag->add('place_name', 'wrong place name');
        }

        return view(
            'app.activities.app_new_activity',
            [
                'adventure' => new Adventure(),
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


    public function edit(Request $request, Adventure $adventure)
    {

    }

    public function delete(Request $request, Adventure $adventure)
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
        return Auth::guard('admin')->check();
//        return true;
    }

    /**
     * @param Adventure $adventure
     * @param User $user
     * @param array $invites
     */
    public function sendInviteEmail(Adventure $adventure, User $user, array $invites)
    {
        foreach ($invites as $email) {
            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $job = (new SendInviteEmail($adventure, $user, $email))->onQueue('emails');
                $this->dispatch($job);
            }
        }
    }
}
