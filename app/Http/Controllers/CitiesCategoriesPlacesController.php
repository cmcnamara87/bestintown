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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($city, $category, $place)
    {
        $categoryIds = Rank::where('city_id', $city->id)->lists('category_id');
        $categories = Category::whereIn('id', $categoryIds)->with(['ranks' => function($query) use ($city)
        {
            $query->where('city_id', $city->id)
                ->where('rank', '>', 0);
        }])->get();

        $ranks = Rank::where('category_id', '=', $category->id)
            ->where('city_id', $city->id)
            ->where('rank', '>', 0)
            ->with(['place', 'place.ranks' => function($query) use ($city) {
                $query->where('rank', '>', 0);
            }, 'place.ranks.category'])
            ->get();

        return view('categories.places.show', compact('city', 'category', 'ranks', 'categories', 'place'));
    }
}
