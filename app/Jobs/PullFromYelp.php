<?php

namespace App\Jobs;

use App\Category;
use App\Jobs\Job;
use App\Place;
use App\Places\PlaceService;
use App\Rank;
use App\City;
use App\Yelp\Yelp;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PullFromYelp extends Job implements SelfHandling
{
    protected $placeService;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(PlaceService $placeService)
    {
        $this->placeService = $placeService;
    }

    function loadChildren($parents, $categoriesData)
    {
        foreach ($parents as $parent) {
            $children = array_reduce($categoriesData, function ($carry, $categoryData) use ($parent) {
                if (!in_array($parent->code, $categoryData->parents)) {
                    return $carry;
                }
                Log::info('Creating Category ' . $categoryData->title);
                $carry[] = Category::create([
                    'name' => $categoryData->title,
                    'code' => $categoryData->alias,
                    'parent_id' => $parent->id
                ]);
                return $carry;
            }, []);
            $this->loadChildren($children, $categoriesData);
        }
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

        // make category tree
        // get no roots
        $roots = array_reduce($categoriesData, function ($carry, $categoryData) {
            if (!in_array("restaurants", $categoryData->parents) &&
                !in_array("food", $categoryData->parents)
            ) {
                return $carry;
            }
            $carry[] = Category::create([
                'name' => $categoryData->title,
                'code' => $categoryData->alias
            ]);
            return $carry;
        }, []);
        $this->loadChildren($roots, $categoriesData);

        $allCities = City::all();
        foreach ($allCities as $city) {
            Log::info('City: ' . $city->name);

            $allCategories = Category::all();

            foreach ($allCategories as $category) {
                $yelp = new Yelp();
                Log::info('Category: ' . $category->code);

                $businesses = $yelp->best($category->code, $city->name . ', ' . $city->country);

                for ($i = 0; $i < count($businesses); $i++) {
                    $business = $businesses[$i];
                    if (!isset($business->location->coordinate)) {
                        continue;
                    }
                    $place = $this->placeService->createPlaceFromYelpBusiness($business, $city);
                    $this->placeService->setRankForPlace($place, $category, $i + 1, $city);
                }
                sleep(1);
            }
        }
    }
}
