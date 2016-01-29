<?php

namespace App;

use Cviebrock\EloquentSluggable\SluggableInterface;
use Cviebrock\EloquentSluggable\SluggableTrait;
use Illuminate\Database\Eloquent\Model;

class Place extends Model implements SluggableInterface
{
    use SluggableTrait;

    protected $sluggable = [
        'build_from' => 'name',
        'save_to'    => 'slug',
    ];

    protected $fillable = ['name', 'address', 'latitude', 'longitude', 'rating', 'image_url',
        'external_url',
        'description',
        'city_id'
    ];

    public function ranks()
    {
        return $this->hasMany(Rank::class);
    }
}
