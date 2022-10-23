<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CityCollection;
use App\Http\Resources\CityResource;
use App\Models\City;
use Illuminate\Http\Request;

/**
 * Class CityController.
 *
 * @group 09. Cities
 */
class CityController extends Controller
{
    /**
     * Display a listing of the cities.
     *
     * @responseFile 200 scenario="when cities displayed." responses/cities.index/200.json
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return (new CityCollection(City::all()))->preserveQuery();
    }

    /**
     * Display the specified city.
     *
     * @urlParam city integer required The id of the city. Example: 20
     * @responseFile 200 scenario="when city displayed." responses/cities.show/200.json
     * @responseFile 404 scenario="when city not found." responses/cities.show/404.json
     *
     * @param  \App\Models\City  $city
     * @return \Illuminate\Http\Response
     */
    public function show(City $city)
    {
        return new CityResource($city->load('cityAreas'));
    }
}
