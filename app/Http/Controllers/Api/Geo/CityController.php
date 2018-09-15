<?php

namespace App\Http\Controllers\Api\Geo;

use App\Http\Controllers\Api\RestController;
use App\Models\Geo\City;
use App\Models\Geo\Country;
use Illuminate\Http\Request;

use App\Http\Requests;

class CityController extends RestController
{
    const MODEL_CLASS = City::class;

    /**
     * @param Country|null $countries
     * @return mixed
     */
    public function index(Country $countries = null)
    {
        try {
            $qb = City::query();

            if ($countries) {
                $qb = $qb->where('country_id', $countries->id);
            }


            return parent::getCollection($qb, City::getFieldList());
        } catch (\Exception $e) {
            return parent::error($e);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * @param Country|null $countries
     * @param $id
     * @return array
     */
    public function show($id, Country $countries = null)
    {
        try {
            $qb = City::query()->where('id', $id);

            if ($countries) {
                $qb = $qb->where('country_id', $countries->id);
            }
            return parent::get($qb, City::getFieldList());
        } catch (\Exception $e) {
            return parent::error($e);
        }
    }

    /**
     * We specifiy column list explicitely for cities, since binary
     * value of the "position" column requires conversion to text,
     * otherwise conversion to json fails
     * @param Builder $qb
     * @return $this
     */
/*    public function addColumnList(Builder $qb) {
        return $qb->selectRaw(
            'id, country_id, geonameid, name, asciiname, astext(position) as position, timezone, slug'
        );
    }*/

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
