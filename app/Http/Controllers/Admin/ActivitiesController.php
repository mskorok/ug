<?php

namespace App\Http\Controllers\Admin;

use App\Models\Adventures\Adventure;
use App\Contracts\Geo;
use App\Models\Interests\Interest;
use App\Models\Users\User;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\MessageBag;
use Session;

/**
 * Class ActivitiesController
 * @package App\Http\Controllers\Admin
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
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showAdventures(Request $request)
    {
        $adventures = Adventure::paginate(config('app.rows_per_page'));

        if ($request->ajax()) {
            return $adventures;
        } else {
            return view(
                'admin.adventures.list',
                [
                    'adventures' => $adventures,
                ]
            );
        }
    }


    /**
     * @method GET
     * @param Request $request
     * @param Adventure $model
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Request $request, Adventure $model)
    {
        if ($request->ajax()) {
            return $model;
        } else {
            return view(
                'admin.adventures.show',
                [
                    'adventure' => $model,
                ]
            );
        }

    }


    /**
     * @method GET
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showAddAdventure(Request $request)
    {

        return view(
            'admin.adventures.create',
            [
                'adventure' => new Adventure(),
                'action' => 'create',
                'selectData'  => $this->userDataForSelect(),
                'user' => $request->user() ?? \Auth::user() ?? null

            ]
        );
    }


    /**
     * @method POST
     * @param Request $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function postAddAdventure(Request $request)
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

                $params['user_id']   = $params['user_id'] ?? \Auth::id();
                $params['slug']      = str_slug($params['title']);
                $params['going']     = [];
                $params['following'] = [];
                $params['liked']     = [];

                $validator =\Validator::make($params, Adventure::VALIDATION_RULES);
                if ($validator->passes()) {
                    $location = [
                        'lat' => $params['lat'],
                        'lng' => $params['lng']
                    ];
                    unset($params['lat'], $params['lng'], $params['place_location']);
                    $model = new Adventure($params);
                    $model->setPhotoUploads(true);
                    $model->setLocationAttribute($location);

                    Session::flash('alert', 'Adventures '.$model->title.' has been successfully created.');
                    Session::flash('alert_type', 'success');
                    $model->setPhotoUploads(true);
                    $model->save($params);

                    $interests = $params['interests'] ?? [];
                    foreach ($interests as $name) {
                        $interest = Interest::where('name', '=', $name)->first();
                        $model->interests()->attach($interest);
                    }
                    return redirect()->route('adventure_list');
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
            'admin.adventures.create',
            [
                'adventure' => new Adventure(),
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
     * @param Adventure $model
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showEditAdventure(Request $request, Adventure $model)
    {

        return view(
            'admin.adventures.create',
            [
                'adventure' => $model,
                'action' => 'edit',
                'selectData'  => $this->userDataForSelect(),
                'user' => $request->user() ?? \Auth::user(),
            ]
        );
    }


    /**
     * @method POST
     * @param Request $request
     * @param Adventure $model
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function postEditAdventure(Request $request, Adventure $model)
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

                $params['user_id']   = \Auth::id();
                $params['slug']      = str_slug($params['title']);
                $params['going']     = [];
                $params['following'] = [];
                $params['liked']     = [];
                $validator =\Validator::make($params, Adventure::VALIDATION_RULES);
                if ($validator->passes()) {
                    $location = [
                        'lat' => $params['lat'],
                        'lng' => $params['lng']
                    ];
                    unset($params['lat'], $params['lng'], $params['place_location']);
                    $model->setLocationAttribute($location);

                    Session::flash('alert', 'Adventures '.$model->title.' has been successfully changed.');
                    Session::flash('alert_type', 'success');
                    $model->setPhotoUploads(true);
                    $model->update($params);
                    return redirect()->route('adventure_list');
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
            'admin.adventures.create',
            [
                'adventure' => $model,
                'action' => 'edit',
                'selectData'  => $this->userDataForSelect(),
                'user' => $request->user(),
                'errors' => $bag
            ]
        );
    }


    /**
     * @param Adventure $model
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function deleteAdventure(Adventure $model)
    {
        $model->delete();
        Session::flash('alert', 'Adventures '.$model->id.' deleted.');
        Session::flash('alert_type', 'danger');
        return redirect()->route('adventure_list');
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
