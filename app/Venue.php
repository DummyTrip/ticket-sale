<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Venue extends Model
{

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
        return $this->hasMany('App\Seat');
    }
}
