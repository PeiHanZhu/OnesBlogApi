<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CityAreaResource;
use App\Models\CityArea;

/**
 * Class CityAreaController.
 *
 * @group 10. CityAreas
 */
class CityAreaController extends Controller
{
    /**
     * Display the specified city area.
     *
     * @urlParam city_area integer required The id of the city area. Example: 108
     * @responseFile 200 scenario="when city area displayed." responses/city_areas.show/200.json
     * @responseFile 404 scenario="when city area not found." responses/city_areas.show/404.json
     *
     * @param  \App\Models\CityArea  $cityArea
     * @return \Illuminate\Http\Response
     */
    public function show(CityArea $cityArea)
    {
        return new CityAreaResource($cityArea);
    }
}
