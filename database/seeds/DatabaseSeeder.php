<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        \App\City::create([
            'name' => 'Brisbane',
            'country' => 'Australia',
            'latitude' => -27.47101,
            'longitude' => 153.02345
        ]);

        \App\City::create([
            'name' => 'Sydney',
            'country' => 'Australia',
            'latitude' => -33.86749,
            'longitude' => 151.20699
        ]);

        // $this->call(UserTableSeeder::class);

        Model::reguard();
    }
}
