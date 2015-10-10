<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Hotspot extends Model
{
    protected $fillable = ['name', 'known_for', 'latitude', 'longitude', 'city_id', 'count'];
}
