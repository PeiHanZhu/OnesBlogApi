<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\LocationCollection;
use App\Http\Resources\LocationLikeCollection;
use App\Models\Location;
use App\Models\LocationLike;
use Illuminate\Http\Request;

/**
 * Class LocationLikeController.
 *
 * @group 05. LocationLikes
 */
class LocationLikeController extends Controller
{
    /**
     * Display a listing of the location.
     *
     * @queryParam user_id integer The id of the user. Example: 2
     * @queryParam limit integer The amount of results per page. Defaults to '10'. Example: 10
     * @queryParam page integer The page of the results. Defaults to '1'. Example: 1
     * @responseFile 200 scenario="when location likes displayed." responses/location_likes.index/200.json
     * @responseFile 200 scenario="when location likes displayed queried by user's id." responses/location_likes.index/200_queried_by_user_id.json
     *
     * @param \Illuminate\Http\Request $request
     */
    public function index(Request $request)
    {
        if (!is_null($userId = $request->query('user_id'))) {
            return (new LocationCollection(
                Location::whereHas('locationLikes', function ($query) use ($userId) {
                    $query->where('user_id', $userId);
                })->where('active', true)->paginate($request->query('limit') ?? 10)
            ))->preserveQuery();
        } else {
            return (new LocationLikeCollection(
                LocationLike::paginate($request->query('limit') ?? 10)
            ))->preserveQuery();
        }
    }
}
