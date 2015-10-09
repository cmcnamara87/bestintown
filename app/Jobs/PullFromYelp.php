<?php

namespace App\Jobs;

use App\Category;
use App\Jobs\Job;
use App\Place;
use App\Rank;
use App\City;
use App\Yelp\Yelp;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PullFromYelp extends Job implements SelfHandling
{
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $categoriesData = json_decode(file_get_contents("app/Jobs/categories.json"));
        DB::table('categories')->truncate();
        DB::table('ranks')->truncate();
        DB::table('places')->truncate();
        foreach($categoriesData as $categoryData) {
            if(!isset($categoryData->parents) || !$categoryData->parents) {
                continue;
            }
            if(!in_array("restaurants", $categoryData->parents)) {
                continue;
            }
            Category::create([
                'name' => $categoryData->title,
                'code' => $categoryData->alias
            ]);
        }

        $allCities = City::all();
        foreach($allCities as $city) {
            Log::info('City: ' . $city->name);

            $allCategories = Category::all();

            foreach($allCategories as $category) {
                $yelp = new Yelp();
                Log::info('Category: ' . $category->code);

                $businesses = $yelp->best($category->code, $city->name . ', ' . $city->country);

                for($i = 0; $i < count($businesses); $i++) {
                    $business = $businesses[$i];
                    if(!isset($business->location->coordinate)) {
                        continue;
                    }

                    Log::info('Business: ' . $business->name);
                    $place = Place::where('name', '=', $business->name)->first();
                    if(!$place) {
                        $place = Place::create([
                            'name' => $business->name,
                            'rating' => $business->rating,
                            'latitude' => $business->location->coordinate->latitude,
                            'longitude' => $business->location->coordinate->longitude,
                            'address' => join(', ', $business->location->display_address),
                            'city_id' => $city->id
                        ]);
                    }

                    Rank::create([
                        'category_id' => $category->id,
                        'place_id' => $place->id,
                        'rank' => $i + 1,
                        'city_id' => $city->id
                    ]);
                }
                sleep(1);
            }
        }

    }
}
