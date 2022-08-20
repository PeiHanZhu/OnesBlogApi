<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\LocationCollection;
use App\Models\Location;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    /**
     * Display a listing of the locations.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // return (new LocationCollection(
        //     Location::when($request->query('category_id'), function($query, $categoryId) {
        //         $query->where('category_id', intval($categoryId));
        //     })->when($request->query('city_id'), function($query, $city) {
        //         $query->where('city_id', $city);
        //     })->when($randomLimit = $request->query('random'), function ($query) {
        //         $query->inRandomOrder();
        //     })->when($rankingLimit = $request->query('ranking'), function ($query) {
        //         $query->orderByDesc('avgScore');
        //     })->paginate(intval($request->query('limit') ?? $randomLimit ?? $rankingLimit ?? 10))
        // ))->preserveQuery();
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
     * Display the specified resource.
     *
     * @param  \App\Models\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function show(Location $location)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function destroy(Location $location)
    {
        //
    }
}
