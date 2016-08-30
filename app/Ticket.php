<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $fillable = ['user_id', 'seat_id', 'event_id', 'price'];
    protected $appends = ['row', 'column', 'block', 'block_name', 'venue'];

    public function getBlockNameAttribute() {
        return $this->seat()->get()->first()->block_name;
    }
    public function getVenueAttribute(){
        return $this->event()->first()->venue()->first();
    }
    public function getBlockAttribute() {
        return $this->seat()->get()->first()->block;
    }
    public function getColumnAttribute() {
        return $this->seat()->get()->first()->column;
    }
    public function getRowAttribute() {
        return $this->seat()->get()->first()->row;
    }

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
}
