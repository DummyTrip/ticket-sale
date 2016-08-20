<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Venue extends Model
{
    protected $fillable = ['name', 'description','city', 'country', 'address'];

    protected $appends = ['blocks', 'block_names'];

    public function manager()
    {
        return $this->belongsTo('App\User');
    }

    public function events()
    {
        return $this->hasMany('App\Event');
    }

    public function seats()
    {
        return $this->belongsToMany('App\Seat');
    }

    public function getBlocksAttribute()
    {
        return $this->seats()->get()->lists('block')->unique()->values()->all();
    }

    public function getBlockNamesAttribute()
    {
        return $this->seats()->get()->lists('block_name')->unique()->values()->all();
    }

    public function getSeatsAttribute()
    {
        return $this->seats()->get()->lists('id')->toArray();
    }
}
