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

Route::get('/', function () {
    return view('welcome');
});

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
            $query->where('category_id', '=', $categoryId);
        })
        ->with('ranks', 'ranks.category')
        ->get();

    return view('categories.show', compact('category', 'places'));
});
Route::get('/nearby', function () {
    // -27.49611, 153.00207 -> brisbane
    $lat = 48.842147;
    $lon = 2.321984;
    $radius = 3;

    $places = \App\Place::select(DB::raw("*, (6371 * acos( cos( radians($lat) ) * cos( radians( latitude ) ) * cos( radians( $lon ) - radians(longitude) ) + sin( radians($lat) ) * sin( radians(latitude) ) )) AS distance"))
        ->having('distance', '<', $radius)
        ->orderby('distance', 'asc')
        ->with('ranks', 'ranks.category')
        ->get();

    return view('places.index', compact('places'));
});

Route::group(array('prefix' => 'api/v1'), function () {
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
                $query->where('category_id', '=', $categoryId);
            })
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
