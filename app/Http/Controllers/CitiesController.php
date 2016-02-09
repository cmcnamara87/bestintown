<?php

namespace App\Http\Controllers;

use App\Category;
use App\City;
use App\Place;
use App\Rank;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class CitiesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cities = City::all();
        return view('cities.index', compact('cities'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($city)
    {
        // show all the categories for that city
        $categoryIds = Rank::where('city_id', $city->id)->lists('category_id');
        $categories = Category::whereIn('id', $categoryIds)->with(['ranks' => function($query) use ($city)
        {
            $query->where('city_id', $city->id)
                ->where('rank', '>', 0);

        }])->get();
        // chunk the categories
        $categoriesByLetter = array_reduce($categories->all(), function($carry, $category) {
            $letter = substr($category->name, 0, 1);
            if(!isset($carry[$letter])) {
                $carry[$letter] = [];
            }
            $carry[$letter][] = $category;
            return $carry;
        }, []);

        return view('cities.show', compact('city', 'categoriesByLetter'));
    }
}
