<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = ['name', 'date', 'description'];

    protected $appends = ['tag_list'];

    protected $dates = ['date'];

    public function venue()
    {
        return $this->belongsTo('App\Venue');
    }

    public function organizer()
    {
        return $this->belongsTo('App\User');
    }

    public function tickets()
    {
        return $this->hasMany('App\Ticket');
    }

    public function tags()
    {
        return $this->belongsToMany('App\Tag');
    }

    public function getTagListAttribute()
    {
        return $this->tags->lists('id')->toArray();
    }
}
