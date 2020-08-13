<?php

namespace HappyCasts;

use Illuminate\Database\Eloquent\Model;

class Series extends Model
{
    protected $guarded = [];

    protected $with = ['lessons'];


    public function lessons()
    {
        return $this->hasMany(Lesson::class);
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function getImagePathAttribute()
    {
        return asset('storage/' . $this->image_url);
    }
}
