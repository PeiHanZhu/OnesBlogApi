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

class LocationController extends Controller
{
    /**
     * Display a listing of the locations.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return (new LocationCollection(
            Location::when($request->query('category_id'), function($query, $categoryId) {
                $query->where('category_id', intval($categoryId));
            })->when($request->query('city_id'), function($query, $city) {
                $query->where('city_id', $city);
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'city_area_id' => 'required|integer',
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
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Location $location)
    {
        $validator = Validator::make($request->all(), [
            'city_area_id' => 'integer',
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
