<?php

namespace App\Http\Controllers\Admin\Geo;

use App\Models\Geo\Country;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

/**
 * Class CountryController
 * @package App\Http\Controllers\Admin\Geo
 */
class CountryController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showCountries(Request $request)
    {
        $countries = Country::paginate(config('app.rows_per_page'));

        if ($request->ajax()) {
            return $countries;
        } else {
            return view('admin.geo.countries', ['countries' => $countries]);
        }
        /*$countries = Country::iterate(['id', 'iso_alpha2', 'name']);

        return view('admin.geo.countries', ['countries' => $countries]);*/
    }

    /**
     * @param Request $request
     * @param Country $country
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postAddCountry(Request $request, Country $country)
    {
        $this->validate($request, [
            'iso_alpha2' => 'required|unique:countries|size:2',
            'name' => 'required|unique:countries|max:45',
        ]);

        $country->create($request->input());

        return Redirect('/admin/countries')->with(['alert' => 'Country created.']);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showAddCountry()
    {
        return view('admin.geo.add_edit_country', ['country' => new Country(), 'action' => 'add']);
    }

    /**
     * @param Country $country
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showEditCountry(Country $country)
    {
        return view('admin.geo.add_edit_country', ['country' => $country, 'action' => 'edit']);
    }

    /**
     * @param Request $request
     * @param Country $country
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postEditCountry(Request $request, Country $country)
    {
        $country->update($request->input());
        return Redirect('/admin/countries')->with(['alert' => 'Country '.$country->id.' updated.']);
    }

    /**
     * @param Country $country
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function deleteCountry(Country $country)
    {
        if ($country->cities()->getResults()->isEmpty()) {
            $country->delete();

            return Redirect('/admin/countries')->with(['alert'      => 'Country ' . $country->id . ' deleted.',
                                                       'alert_type' => 'danger'
            ]);
        } else {
            return Redirect('/admin/countries')
                ->with(
                    [
                        'alert' => 'Country cannot be deleted, since it is referenced by one or more cities.',
                        'alert_type' => 'danger'
                    ]
                );
        }
    }
}
