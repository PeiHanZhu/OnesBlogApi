<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\LocationScoreCollection;
use App\Http\Resources\LocationScoreResource;
use App\Models\Location;
use App\Models\LocationScore;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

/**
 * Class LocationScoreController.
 *
 * @group 03. LocationScores
 */
class LocationScoreController extends Controller
{
    /**
     * Display a listing of the location scores.
     *
     * @queryParam location_id integer The id of the location. Example: 3
     * @queryParam user_id integer The id of the user. Example: 31
     * @queryParam limit integer The amount of results per page. Defaults to '10'. Example: 10
     * @queryParam page integer The page of the results. Defaults to '1'. Example: 1
     * @responseFile 200 scenario="when location scores displayed." responses/location_scores.index/200.json
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return (new LocationScoreCollection(
            LocationScore::when($request->query('location_id'), function ($query, $locationId) {
                $query->where('location_id', $locationId);
            })->when($request->query('user_id'), function ($query, $userId) {
                $query->where('user_id', $userId);
            })->paginate($request->query('limit') ?? 10)
        ))->preserveQuery();
    }

    /**
     * Store a newly created or update the specified location score in storage, or remove the specified location score from storage.
     *
     * @authenticated
     * @header Authorization Bearer {personal-access-token}
     * @urlParam location integer required The id of the location. Example: 5
     * @bodyParam score float required The location score of the location, <b>0</b> for deleting. Example: 3.8
     * @responseFile 200 scenario="when location score created, updated or deleted." responses/location_scores.store/200.json
     * @responseFile 404 scenario="when location not found." responses/location_scores.store/404.json
     * @responseFile 401 scenario="without personal access token." responses/401.json
     * @responseFile 422 scenario="when any validation failed." responses/location_scores.store/422.json
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Location $location
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Location $location)
    {
        $validator = Validator::make($request->all(), [
            'score' => 'required|numeric|between:0,5'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'data' => $validator->errors()->messages(),
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $conditions = [
            'user_id' => $request->user()->id,
            'location_id' => $location->id,
        ];
        $value = [
            'score' => $request->input('score'),
        ];
        if (ceil($request->input('score'))) {
            $locationScore = LocationScore::updateOrCreate($conditions, $value);
        } else {
            $request->user()->locationScores()->where('location_id', $location->id)->delete();
            // Due to not going through LocationScoreObserver@deleted.
            $location->update([
                'avgScore' => $location->locationScores()->avg('score'),
            ]);
            $locationScore = new LocationScore(array_merge($conditions, $value));
        }

        // @see https://stackoverflow.com/questions/66542534/test-api-returns-201-instead-200
        return (new LocationScoreResource($locationScore))->toResponse($request)->setStatusCode(Response::HTTP_OK);
    }
}
