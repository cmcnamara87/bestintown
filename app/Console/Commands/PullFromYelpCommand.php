<?php

namespace App\Console\Commands;

use App\Hotspot;
use App\Jobs\PullFromYelp;
use App\Place;
use App\Places\PlaceService;
use Illuminate\Console\Command;
use Illuminate\Container\Container;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Support\Facades\Log;

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
    public function handle(PlaceService $placeService)
    {
        Log::useFiles('php://stdout');
        $this->dispatch(new PullFromYelp($placeService));
    }

}
