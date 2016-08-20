<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Seat extends Model
{
    protected $fillable = ['row', 'column', 'block', 'name'];

    public function venues()
    {
        return $this->belongsToMany('App\Venue');
    }

    public function tickets()
    {
        return $this->hasMany('App\Ticket');
    }
}
