<?php

namespace App\Console\Commands;

use App\Hotspot;
use App\Jobs\PullFromYelp;
use App\Place;
use Illuminate\Console\Command;
use Illuminate\Foundation\Bus\DispatchesJobs;

class PullFromYelpCommand extends Command
{
    use DispatchesJobs;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bestintown:pull';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->dispatch(new PullFromYelp());

        Hotspot::truncate();
        $places = Place::all();
        $clusters = $this->getClusters($places->all(), 2);
        $centroids = $this->getCentroids($clusters);

        $hotspots = array_map(function($centroid) {
            $locality = $this->getLocalityForLatLon($centroid['latitude'], $centroid['longitude']);
            $categories = [];
            foreach($centroid['places'] as $place) {
                foreach($place->ranks as $rank) {
                    if(!isset($categories[$rank->category->name])) {
                        $categories[$rank->category->name] = 0;
                    }
                    $categories[$rank->category->name]++;
                }
            }
            arsort($categories);
            $categoryNames = array_keys($categories);

            return Hotspot::create([
                'name' => $locality,
                'known_for' => implode(', ', $categoryNames),
                'latitude' => $centroid['latitude'],
                'longitude' => $centroid['longitude'],
                'count' => $centroid['count']
            ]);
        }, $centroids);
    }

    public function getLocalityForLatLon($latitude, $longitude) {
        $apiKey = env('GEO_API_KEY');
        $addresses = json_decode(file_get_contents("https://maps.googleapis.com/maps/api/geocode/json?latlng=$latitude,$longitude&key=$apiKey"));
        if(count($addresses->results) == 0) {
            return 'Unknown';
        }
        $address = $addresses->results[0];
        foreach ($address->address_components as $component) {
            if (in_array('locality', $component->types)) {
                return $component->long_name;
            }
        }
        return 'Unknown';
    }

    public function getCentroids($clusters) {

        return array_map(function($cluster) {
            $centroid = array(
                'latitude' => 0,
                'longitude' => 0,
                'count' => 0,
                'places' => $cluster
            );
            foreach ($cluster as $marker) {
                $centroid['latitude'] += $marker['latitude']; // Sum up the Lats
                $centroid['longitude'] += $marker['longitude']; // Sum up the Lngs
                $centroid['count']++;
            }
            $centroid['latitude'] /= $centroid['count']; // Average Lat
            $centroid['longitude'] /= $centroid['count']; // Average Lng
            return $centroid;
        }, $clusters);
    }

    public function getClusters($markers, $range)
    {
        $clustered = array();
        /* Loop until all markers have been compared. */
        while (count($markers)) {
            $marker = array_pop($markers);
            $cluster = array();
            /* Compare against all markers which are left. */
            foreach ($markers as $key => $target) {
                $pixels = $this->haversineDistance($marker['latitude'], $marker['longitude'],
                    $target['latitude'], $target['longitude']);
                /* If two markers are closer than given distance remove */
                /* target marker from array and add it to cluster.      */
                if ($pixels < $range) {
//                \Illuminate\Support\Facades\Log::info("Distance between %s,%s and %s,%s is %d pixels.\n",
//                    $marker['lat'], $marker['lon'],
//                    $target['lat'], $target['lon'],
//                    $pixels);
                    unset($markers[$key]);
                    $cluster[] = $target;
                }
            }

            /* If a marker has been added to cluster, add also the one  */
            /* we were comparing to and remove the original from array. */
            if (count($cluster) > 0) {
                $cluster[] = $marker;
                $clustered[] = $cluster;
            } else {
                // No nearby markers, not a cluster, dont include it
//                $clustered[] = [$marker];
            }
        }
        return $clustered;
    }

    public function haversineDistance($lat1, $lon1, $lat2, $lon2)
    {
        $latd = deg2rad($lat2 - $lat1);
        $lond = deg2rad($lon2 - $lon1);
        $a = sin($latd / 2) * sin($latd / 2) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * sin($lond / 2) * sin($lond / 2);
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
        return 6371.0 * $c;
    }

}
