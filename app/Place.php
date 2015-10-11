<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Place extends Model
{
    protected $fillable = ['name', 'address', 'latitude', 'longitude', 'rating', 'image_url',
        'external_url',
        'description'];

    public function ranks()
    {
        return $this->hasMany(Rank::class);
    }
}
