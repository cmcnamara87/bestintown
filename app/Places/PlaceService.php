<?php
/**
 * Created by PhpStorm.
 * User: craig
 * Date: 30/01/16
 * Time: 6:43 PM
 */

namespace App\Places;


use App\Category;
use App\Place;
use App\Rank;
use Illuminate\Support\Facades\Log;

class PlaceService {

    public function createPlaceFromYelpBusiness($business, $city) {
        Log::info('Business: ' . $business->name);
        $place = Place::where('name', '=', $business->name)->first();
        if(!$place) {
            $place = Place::create([
                'name' => $business->name,
                'image_url' => $this->getImageUrl($business),
                'external_url' => $business->mobile_url,
                'description' => $this->getDescription($business),
                'rating' => $business->rating,
                'latitude' => $business->location->coordinate->latitude,
                'longitude' => $business->location->coordinate->longitude,
                'address' => join(', ', $business->location->display_address),
                'city_id' => $city->id
            ]);
            if(!isset($business->categories)) {
                return $place;
            }
            foreach($business->categories as $categoryData) {
                $categoryName = $categoryData[0];
                $categoryCode = $categoryData[1];

                $category = Category::where('code', $categoryCode)->first();
                if(!$category) {
                    Log::info("Couldnt find category {$categoryName}");
                    continue;
                }
                // create the category ranks
                Rank::create([
                    'category_id' => $category->id,
                    'place_id' => $place->id,
                    'rank' => 0,
                    'city_id' => $city->id
                ]);
            }
        }
        return $place;
    }

    public function setRankForPlace($place, $category, $rankNumber, $city) {
        $rank = Rank::where('place_id', $place->id)
            ->where('category_id', $category->id)->first();
        if(!$rank) {
            return Rank::create([
                'category_id' => $category->id,
                'place_id' => $place->id,
                'rank' => $rankNumber,
                'city_id' => $city->id
            ]);
        }
        $rank->rank = $rankNumber;
        $rank->save();
        return $rank;
    }

    function getDescription($business) {
        if(isset($business->snippet_text)) {
            return $business->snippet_text;
        }
        return null;
    }

    function getImageUrl($business) {
        if(isset($business->image_url)) {
            return $business->image_url;
        }
        if(isset($business->snippet_image_url)) {
            return $business->snippet_image_url;
        }
        return null;
    }
}