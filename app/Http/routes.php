<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', 'CitiesController@index');
Route::resource('cities', 'CitiesController', ["only" => ["index", "show"]]);
Route::resource('cities.categories', 'CitiesCategoriesController', ["only" => ["show"]]);
Route::resource('cities.categories.places', 'CitiesCategoriesPlacesController', ["only" => ["show"]]);


Route::get('/push', function() {
    $devices = \App\Device::all();
    foreach($devices as $device) {
        \Davibennun\LaravelPushNotification\Facades\PushNotification::app('appNameIOS')
            ->to($device->token)
            ->send('Hello World, i`m a push message');
    }
    echo 'pushed';
});

Route::get('/categories', function () {
    $categories = \App\Category::all();
    return view('categories.index', compact('categories'));
});
Route::get('/categories/{categoryId}', function ($categoryId) {
    $category = \App\Category::find($categoryId);
    $ranks = \App\Rank::where('category_id', '=', $categoryId)->with('place')->get();

    $lat = 48.83213;
    $lon = 2.32180;
    $radius = 3;

    $places = \App\Place::select(DB::raw("*, (6371 * acos( cos( radians($lat) ) * cos( radians( latitude ) ) * cos( radians( $lon ) - radians(longitude) ) + sin( radians($lat) ) * sin( radians(latitude) ) )) AS distance"))
        //->having('distance', '<', $radius)
        ->orderby('distance', 'asc')
        ->whereHas('ranks', function ($query) use ($categoryId) {
            $query->where('category_id', '=', $categoryId)
                ->where('rank', '>', 0);
        })
        ->with(['ranks' => function($query) {
            $query->where('rank', '>', 0);
        }, 'ranks.category'])
        ->get();

    return view('categories.show', compact('category', 'places'));
});
Route::get('/nearby', function () {
    // -27.49611, 153.00207 -> brisbane
    $lat = 48.842147;
    $lon = 2.321984;
    $radius = 1;

    $places = \App\Place::select(DB::raw("*, (6371 * acos( cos( radians($lat) ) * cos( radians( latitude ) ) * cos( radians( $lon ) - radians(longitude) ) + sin( radians($lat) ) * sin( radians(latitude) ) )) AS distance"))
        ->having('distance', '<', $radius)
        ->orderby('distance', 'asc')
        ->whereHas('ranks', function ($query) {
            $query->where('rank', '>', 0);
        })
        ->with(['ranks' => function($query) {
            $query->where('rank', '>', 0);
        }, 'ranks.category'])
        ->get();

    return view('places.index', compact('places'));
});

Route::group(array('prefix' => 'api/v1'), function () {
    Route::post('users', function () {
        $data = \Illuminate\Support\Facades\Input::all();
        $user = \App\User::create($data);
        return response()->json($user);
    });
    Route::get('users/{id}', function ($id) {
        $user = \App\User::find($id);
        return response()->json($user, 200, [], JSON_NUMERIC_CHECK);
    });
    Route::get('/cities', function() {
        $lat = \Illuminate\Support\Facades\Input::get('lat', -27.49611);
        $lon = \Illuminate\Support\Facades\Input::get('lon', 153.00207);

        // Check if a valid location
        $radius = 25;

        $city = \App\City::select(DB::raw("*, (6371 * acos( cos( radians($lat) ) * cos( radians( latitude ) ) * cos( radians( $lon ) - radians(longitude) ) + sin( radians($lat) ) * sin( radians(latitude) ) )) AS distance"))
            ->having('distance', '<', $radius)
            ->orderby('distance', 'asc')
            ->first();
        if(!$city) {
            abort(400, 'City not supported.');
        }
        return response()->json([$city]);
    });

    /**
     * Search for a business in a city
     */
    Route::get('/search/{cities}/{term}', function($city, $term) {
        $yelp = new \App\Yelp\Yelp();
        $data = $yelp->search($term, "{$city->name} {$city->country}");
        $response = json_decode($data);
        $placeService = new \App\Places\PlaceService();

        return array_map(function($business) use ($city, $placeService) {
            if(!isset($business->location->coordinate)) {
                return null;
            }
            $place = $placeService->createPlaceFromYelpBusiness($business, $city);
            $place->load('ranks', 'ranks.category');
            return $place;
        }, $response->businesses);
    });
    Route::post('/rank', function() {
        $data = \Illuminate\Support\Facades\Input::all();
        $winner = Place::find($data['winner_id']);
        $loser = Place::find($data['loser_id']);

        $player1 = new Player($winner->score);
        $player2 = new Player($loser->score);

    });
    Route::post('/devices', function() {
        // Save the device
        $data = \Illuminate\Support\Facades\Input::all();
        $device = \App\Device::firstOrCreate($data);
        return response()->json($device);
    });

    Route::get('/devices', function() {
        $devices = \App\Device::all();
        return response()->json($devices);
    });
    Route::get('/nearby', function () {
        // -27.49611, 153.00207 -> brisbane
        $lat = \Illuminate\Support\Facades\Input::get('lat', -27.49611);
        $lon = \Illuminate\Support\Facades\Input::get('lon', 153.00207);

        // Check if a valid location
        $radius = 25;
        $city = \App\City::select(DB::raw("*, (6371 * acos( cos( radians($lat) ) * cos( radians( latitude ) ) * cos( radians( $lon ) - radians(longitude) ) + sin( radians($lat) ) * sin( radians(latitude) ) )) AS distance"))
            ->having('distance', '<', $radius)
            ->orderby('distance', 'asc')
            ->first();
        if(!$city) {
            abort(400, 'City not supported.');
        }

        $radius = 1.5;

        $places = \App\Place::select(DB::raw("*, (6371 * acos( cos( radians($lat) ) * cos( radians( latitude ) ) * cos( radians( $lon ) - radians(longitude) ) + sin( radians($lat) ) * sin( radians(latitude) ) )) AS distance"))
            ->having('distance', '<', $radius)
            ->orderby('distance', 'asc')
            ->whereHas('ranks', function ($query) {
                $query->where('rank', '>', 0);
            })
            ->with('ranks', 'ranks.category')
            ->get();

        return response()->json($places);
    });
    Route::get('/hotspots', function() {
        $lat = \Illuminate\Support\Facades\Input::get('lat', -27.49611);
        $lon = \Illuminate\Support\Facades\Input::get('lon', 153.00207);
        $radius = 15;

        $hotspots = \App\Hotspot::select(DB::raw("*, (6371 * acos( cos( radians($lat) ) * cos( radians( latitude ) ) * cos( radians( $lon ) - radians(longitude) ) + sin( radians($lat) ) * sin( radians(latitude) ) )) AS distance"))
            ->having('distance', '<', $radius)
            ->orderby('distance', 'asc')
            ->get();

        return response()->json($hotspots);
    });
    Route::get('/hotspots/{hotspotId}', function ($hotspotId) {
        $hotspot = \App\Hotspot::find($hotspotId);
        return response()->json($hotspot);
    });
    Route::get('/categories', function () {
        $lat = \Illuminate\Support\Facades\Input::get('lat', -27.49611);
        $lon = \Illuminate\Support\Facades\Input::get('lon', 153.00207);

        $radius = 50;

        // Get city for lat lon
        $city = \App\City::select(DB::raw("*, (6371 * acos( cos( radians($lat) ) * cos( radians( latitude ) ) * cos( radians( $lon ) - radians(longitude) ) + sin( radians($lat) ) * sin( radians(latitude) ) )) AS distance"))
            ->having('distance', '<', $radius)
            ->orderby('distance', 'asc')
            ->first();

        if(!$city) {
            abort(400, 'City not supported.');
        }

        // get all the categories in the cities
        $categories = \App\Category::whereHas('ranks', function ($query) use ($city) {
            $query->where('city_id', '=', $city->id);
        })->get();
        return response()->json($categories);
    });
    Route::get('/categories/{categoryId}', function ($categoryId) {
        $category = \App\Category::find($categoryId);
        return response()->json($category);
    });
    Route::get('/categories/{categoryId}/places', function ($categoryId) {
        $lat = \Illuminate\Support\Facades\Input::get('lat', -27.49611);
        $lon = \Illuminate\Support\Facades\Input::get('lon', 153.00207);

        // Check if a valid location
        $radius = 25;
        $city = \App\City::select(DB::raw("*, (6371 * acos( cos( radians($lat) ) * cos( radians( latitude ) ) * cos( radians( $lon ) - radians(longitude) ) + sin( radians($lat) ) * sin( radians(latitude) ) )) AS distance"))
            ->having('distance', '<', $radius)
            ->orderby('distance', 'asc')
            ->first();
        if(!$city) {
            abort(400, 'City not supported.');
        }
        
        $places = \App\Place::select(DB::raw("*, (6371 * acos( cos( radians($lat) ) * cos( radians( latitude ) ) * cos( radians( $lon ) - radians(longitude) ) + sin( radians($lat) ) * sin( radians(latitude) ) )) AS distance"))
            ->orderby('distance', 'asc')
            ->whereHas('ranks', function ($query) use ($categoryId) {
                $query->where('category_id', '=', $categoryId)->where('rank', '>', 0);
            })
            ->where('city_id', '=', $city->id)
            ->with('ranks', 'ranks.category')
            ->get();

        return response()->json($places);
    });
    Route::get('/yelp', function () {
        $yelp = new \App\Yelp\Yelp();
        echo "<pre>";
        print_r($yelp->best('pizza', 'Brisbane, Australia'));
        echo "</pre>";
    });
});


// Routes for SEO
Route::get('/{cities}', 'CitiesController@show');
Route::get('/{cities}/{categories}', 'CitiesCategoriesController@show');
Route::get('/{cities}/{categories}/{places}', 'CitiesCategoriesPlacesController@show');