<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Venue extends Model
{
    protected $fillable = ['name', 'description','city', 'country', 'address'];

    protected $appends = ['block_names', 'blockInfo'];

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

    public function getBlockNamesAttribute()
    {
        return $this->seats()->get()->lists('block_name')->unique()->values()->all();
    }

    public function getSeatsAttribute()
    {
        return $this->seats()->get()->lists('id')->toArray();
    }

    public function getBlockInfoAttribute()
    {
        return DB::table('venues')
            ->join('seat_venue', 'seat_venue.venue_id', '=', 'venues.id')
            ->join('seats', 'seat_venue.seat_id', '=', 'seats.id')
            ->where('venues.id', '=', $this->id)
            ->select('block_name', DB::raw("count(distinct(seats.column)) as columns"), DB::raw('count(distinct(row)) as rows'))
            ->groupBy('block_name')
            ->get();
    }
}
