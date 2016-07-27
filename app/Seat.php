<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Seat extends Model
{
    public function venue()
    {
        return $this->belongsTo('App\Venue');
    }

    public function tickets()
    {
        return $this->hasMany('App\Ticket');
    }
}
