<?php

namespace App\Console\Commands;

use App\Jobs\PullFromYelp;
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
    }
}
