<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Ticket extends Model
{
    protected $fillable = ['user_id', 'seat_id', 'event_id', 'price'];

    protected $appends = ['row', 'column', 'block_name', 'venue'];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function seat()
    {
        return $this->belongsTo('App\Seat');
    }

    public function event()
    {
        return $this->belongsTo('App\Event');
    }

    public function getBlockNameAttribute()
    {
        return $this->seat()->first()->block_name;
    }

    public function getVenueAttribute()
    {
        return $this->event()->first()->venue()->first();
    }

    public function getColumnAttribute()
    {
        return $this->seat()->first()->column;
    }

    public function getRowAttribute()
    {
        return $this->seat()->first()->row;
    }
}
