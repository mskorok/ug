<?php
/**
 * Created by PhpStorm.
 * User: michail
 * Date: 26.02.16
 * Time: 10:56
 */

namespace App\Services;

use App\Contracts\Geo;
use App\Enumerations\SocialProviders;
use App\Models\Geo\Country;

/**
 * Class GoogleGeoService
 * @package App\Services
 */
class GoogleGeoService implements Geo
{

    /**
     * @param string $place
     * @param string|null $p_id
     * @param float|null $p_lat
     * @param float|null $p_lng
     * @return array|null
     */
    public function getPlace(string $place, string $p_id = null, float $p_lat = null, float $p_lng = null)
    {
        $place = implode('+', explode(' ', $place));
        $url = 'http://maps.google.com/maps/api/geocode/json?address='.$place;
        $content = json_decode(file_get_contents($url));
        $results = $content->results ?? [];
        $country = null;
        $lat = null;
        $lng = null;
        $place_id = '';
        $point = null;
        $country_code = '';
        $country_name = '';
        $city_name = '';

        if (count($results) > 0) {
            $result = $results[0];
            $addresses = $result->address_components ?? null;
            if (count($addresses) > 0) {
                foreach ($addresses as $address) {
                    if (in_array('country', $address->types)) {
                        $country_code = $address->short_name;
                        $country_name = $address->long_name;
                    }
                    if (in_array('locality', $address->types)) {
                        $city_name = $address->short_name;
                    }
                }
            }

            $lat = $result->geometry->location->lat ?? null;
            $lng = $result->geometry->location->lng ?? null;
            $place_id = $result->place_id ?? null;
            $point = 'POINT('.$lat.' , '.$lng.')';

            $country = Country::where('iso_alpha2', '=', $country_code)->first();

            if ((isset($p_id) && $p_id != $place_id) ||
                (isset($p_lat) && $p_lat != $lat) ||
                (isset($p_lng) && $p_lng != $lng)
            ) {
                return null;
            }
        }

        return [
            'country_code' => $country_code,
            'country_name' => $country_name,
            'city_name' => $city_name,
            'country' => $country,
            'lat' => $lat,
            'lng' => $lng,
            'place_id' => $place_id,
            'place_location' => $point,
            'geo_service' => 'google'
        ];
    }
}
