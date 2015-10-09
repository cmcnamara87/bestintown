<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rank extends Model
{
    protected $fillable = ['rank', 'category_id', 'place_id', 'city_id'];

    public function place()
    {
        return $this->belongsTo(Place::class);
    }
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
