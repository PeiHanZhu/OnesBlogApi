<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\LocationServiceHourCollection;
use App\Http\Resources\LocationServiceHourResource;
use App\Models\Location;
use App\Models\LocationServiceHour;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

/**
 * Class LocationServiceHourController.
 *
 * @group 04. LocationServiceHours
 */
class LocationServiceHourController extends Controller
{
    /**
     * Display a listing of the location service hours.
     *
     * @urlParam location integer required The id of the location. Example: 5
     * @responseFile 200 scenario="when location service hours displayed." responses/location_service_hours.index/200.json
     *
     * @param \Illuminate\Http\Request $request
     * @param Location $location
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Location $location)
    {
        return (new LocationServiceHourCollection(
            $location->locationServiceHours()->paginate($request->query('limit') ?? 10)
        ))->preserveQuery();
    }

    /**
     * Store a newly created location service hour in storage.
     *
     * @authenticated
     * @header Authorization Bearer {personal-access-token}
     * @urlParam location integer required The id of the location. Example: 5
     * @responseFile 201 scenario="when location service hours created." responses/location_service_hours.store/201.json
     * @responseFile 401 scenario="without personal access token." responses/401.json
     * @responseFile 403 scenario="when location service hour stored by wrong user." responses/403.json
     * @responseFile 422 scenario="when any validation failed." responses/location_service_hours.store/422.json
     *
     * @param  \Illuminate\Http\Request  $request
     * @param Location $location
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Location $location)
    {
        $validator = Validator::make($request->all(), [
            'opened_at' => 'date',
            'closed_at' => 'date',
            'weekday' => 'required|integer',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'data' => $validator->errors()->messages(),
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        if ($request->user()->cant('create', [LocationServiceHour::class, $location])) {
            throw new AuthorizationException();
        }

        return new LocationServiceHourResource(
            LocationServiceHour::create(array_merge([
                'location_id' => $location->id,
            ], $request->only([
                'opened_at',
                'closed_at',
                'weekday',
            ])))
        );
    }

    /**
     * Display the specified location service hour.
     *
     * @urlParam location integer required The id of the location. Example: 5
     * @urlParam location_service_hour integer required The id of the location service hour. Example: 5
     * @responseFile 200 scenario="when location service hour displayed." responses/location_service_hours.show/200.json
     * @responseFile 404 scenario="when location not found." responses/location_service_hours.show/404_location.json
     * @responseFile 404 scenario="when location service hour not found." responses/location_service_hours.show/404_location_service_hour.json
     *
     * @param  \App\Models\Location  $location
     * @param  \App\Models\LocationServiceHour  $locationServiceHour
     * @return \Illuminate\Http\Response
     */
    public function show(Location $location, LocationServiceHour $locationServiceHour)
    {
        return new LocationServiceHourResource($locationServiceHour);
    }

    /**
     * Update the specified location service hour in storage.
     *
     * @authenticated
     * @header Authorization Bearer {personal-access-token}
     * @urlParam location integer required The id of the location. Example: 5
     * @urlParam location_service_hour integer required The id of the location service hour. Example: 5
     * @responseFile 200 scenario="when location service hour updated." responses/location_service_hours.update/200.json
     * @responseFile 401 scenario="without personal access token." responses/401.json
     * @responseFile 403 scenario="when location service hour updated by wrong user." responses/403.json
     * @responseFile 404 scenario="when location not found." responses/location_service_hours.update/404_location.json
     * @responseFile 404 scenario="when location service hour not found." responses/location_service_hours.update/404_location_service_hour.json
     * @responseFile 422 scenario="when any validation failed." responses/location_service_hours.update/422.json
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Location  $location
     * @param  \App\Models\LocationServiceHour  $locationServiceHour
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Location $location, LocationServiceHour $locationServiceHour)
    {
        $validator = Validator::make($request->all(), [
            'opened_at' => 'date',
            'closed_at' => 'date',
            'weekday' => 'required|integer',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'data' => $validator->errors()->messages(),
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        if ($request->user()->cant('update', $locationServiceHour)) {
            throw new AuthorizationException();
        }

        $locationServiceHour->update($request->only([
            'opened_at',
            'closed_at',
            'weekday',
        ]));

        return new LocationServiceHourResource($locationServiceHour->refresh());
    }

    /**
     * Remove the specified location service hour from storage.
     *
     * @authenticated
     * @header Authorization Bearer {personal-access-token}
     * @urlParam location integer required The id of the location. Example: 5
     * @urlParam location_service_hour integer required The id of the location service hour. Example: 5
     * @responseFile 200 scenario="when location service hour deleted." responses/location_service_hours.destroy/200.json
     * @responseFile 401 scenario="without personal access token." responses/401.json
     * @responseFile 403 scenario="when location service hour deleted by wrong user." responses/403.json
     * @responseFile 404 scenario="when location not found." responses/location_service_hours.destroy/404_location.json
     * @responseFile 404 scenario="when location service hour not found." responses/location_service_hours.destroy/404_location_service_hour.json
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Location  $location
     * @param  \App\Models\LocationServiceHour  $locationServiceHour
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Location $location, LocationServiceHour $locationServiceHour)
    {
        if ($request->user()->cant('delete', $locationServiceHour)) {
            throw new AuthorizationException();
        } else {
            $locationServiceHour->delete();
        }
        return response()->json([
            'data' => 'Success',
        ]);
    }
}
