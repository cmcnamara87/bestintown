<?php

namespace App\Http\Controllers;

use App\Category;
use App\City;
use App\Place;
use App\Rank;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class CitiesCategoriesPlacesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($cityId, $categoryId, $placeId)
    {
        $place = Place::find($placeId);

        $categoryIds = Rank::where('city_id', $cityId)->lists('category_id');
        $categories = Category::whereIn('id', $categoryIds)->get();

        $city = City::find($cityId);
        $category = Category::find($categoryId);
        $ranks = Rank::where('category_id', '=', $categoryId)
            ->where('city_id', $cityId)
            ->with('place', 'place.ranks', 'place.ranks.category')
            ->get();

        return view('categories.places.show', compact('city', 'category', 'ranks', 'categories', 'place'));
    }

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
