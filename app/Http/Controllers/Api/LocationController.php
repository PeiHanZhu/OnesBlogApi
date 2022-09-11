<?php

namespace App\Http\Controllers\Api;

use App\Enums\LocationCategoryEnum;
use App\Http\Controllers\Controller;
use App\Http\Resources\LocationCollection;
use App\Http\Resources\LocationResource;
use App\Models\Location;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

/**
 * Class LocationController.
 */
class LocationController extends Controller
{
    /**
     * Display a listing of the locations.
     *
     * @group 02. Locations
     * @queryParam category_id integer The id of the category. Example: 2
     * @queryParam city_id integer The id of the city. Example: 11
     * @queryParam random bool Whether the results are in random order or not. Example: true
     * @queryParam ranking integer The top amount of the results. Example: 6
     * @queryParam limit integer The amount of results per page. Defaults to '10'. Example: 10
     * @queryParam page integer The page of the results. Defaults to '1'. Example: 1
     * @responseFile 200 scenario="when locations displayed." responses/locations.index/200.json
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return (new LocationCollection(
            Location::when($request->query('category_id'), function($query, $categoryId) {
                $query->where('category_id', intval($categoryId));
            })->when($request->query('city_id'), function($query, $city) {
                $query->whereHas('cityArea', function($query) use ($city){
                    $query->where('city_id', $city);
                });
            })->when($randomLimit = $request->query('random'), function ($query) {
                $query->inRandomOrder();
            })->when($rankingLimit = $request->query('ranking'), function ($query) {
                $query->orderByDesc('avgScore');
            })->paginate(intval($request->query('limit') ?? $randomLimit ?? $rankingLimit ?? 10))
        ))->preserveQuery();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @group 02. Locations
     * @authenticated
     * @header token Bearer {personal-access-token}
     * @bodyParam city_area_id integer required The city area of the location. Example: 153
     * @bodyParam category_id integer required The category of the location. Example: 2
     * @bodyParam name string required The name of the location. Example: 新亞洲汽車
     * @bodyParam address string required The address of the location. Example: 賢好街四段43巷434號75樓
     * @bodyParam phone string required The phone of the location. Example: 9110576179
     * @bodyParam introduction string The introduction of the location. Example: Introduction
     * @responseFile 201 scenario="when location created." responses/locations.store/201.json
     * @responseFile 401 scenario="without personal access token." responses/401.json
     * @responseFile 422 scenario="when any validation failed." responses/locations.store/422.json
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'city_area_id' => 'required|integer|exists:city_areas,id',
            'category_id' => ['required', 'integer', Rule::in(LocationCategoryEnum::getAllCategoryValues())],
            'name' => 'required|string',
            'address' => 'required|string',
            'phone' => 'required|string',
            'introduction' => 'nullable',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'data' => $validator->errors()->messages(),
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        return new LocationResource(
            Location::firstOrCreate(['user_id' => $request->user()->id], array_merge(['avgScore' => 0], $request->only([
                'city_area_id',
                'category_id',
                'name',
                'address',
                'phone',
                'introduction',
            ]))),
            Response::HTTP_CREATED
        );
    }

    /**
     * Display the specified resource.
     *
     * @group 02. Locations
     * @urlParam location integer required The id of the location. Example: 5
     * @responseFile 200 scenario="when location displayed." responses/locations.show/200.json
     * @responseFile 404 scenario="when location not found." responses/locations.show/404.json
     *
     * @param  \App\Models\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function show(Location $location)
    {
        return new LocationResource($location);
    }

    /**
     * Update the specified resource in storage.
     *
     * @group 02. Locations
     * @authenticated
     * @header token Bearer {personal-access-token}
     * @urlParam location integer required The id of the location. Example: 5
     * @bodyParam city_area_id integer required The city area of the location. Example: 153
     * @bodyParam category_id integer required The category of the location. Example: 2
     * @bodyParam name string required The name of the location. Example: 統一娛樂
     * @bodyParam address string required The address of the location. Example: 豐裡二路180巷804弄601號49樓
     * @bodyParam phone string required The phone of the location. Example: 1335933680
     * @bodyParam introduction string The introduction of the location. Example: IntroductionTest
     * @responseFile 200 scenario="when location displayed." responses/locations.update/200.json
     * @responseFile 401 scenario="without personal access token." responses/401.json
     * @responseFile 403 scenario="when location updated by wrong user." responses/403.json
     * @responseFile 404 scenario="when location not found." responses/locations.update/404.json
     * @responseFile 422 scenario="when any validation failed." responses/locations.update/422.json
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Location $location)
    {
        $validator = Validator::make($request->all(), [
            'city_area_id' => 'integer|exists:city_areas,id',
            'category_id' => ['integer', Rule::in(LocationCategoryEnum::getAllCategoryValues())],
            'name' => 'string',
            'address' => 'string',
            'phone' => 'string',
            'introduction' => 'nullable',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'data' => $validator->errors()->messages(),
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        if ($request->user()->cant('update', $location)) {
            throw new AuthorizationException();
        }

        $location->update($request->only([
            'city_area_id',
            'category_id',
            'name',
            'address',
            'phone',
            'introduction',
        ]));

        return new LocationResource($location->refresh());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @group 02. Locations
     * @authenticated
     * @header token Bearer {personal-access-token}
     * @urlParam location integer required The id of the location. Example: 5
     * @responseFile 200 scenario="when location deleted." responses/locations.destroy/200.json
     * @responseFile 401 scenario="without personal access token." responses/401.json
     * @responseFile 403 scenario="when location deleted by wrong user." responses/403.json
     * @responseFile 404 scenario="when location not found." responses/locations.destroy/404.json
     *
     * @param  \App\Models\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Location $location)
    {
        if ($request->user()->cant('delete', $location)) {
            throw new AuthorizationException();
        } else {
            $location->delete();
        }

        return response()->json([
            'data' => 'Success',
        ]);
    }
}
