@extends('layouts.app')

@section('content')
    <div class="panel-body">
        <h2>{{$venue->name}}</h2>
        <hr>
        <p>City: {{ $venue->city }} Country: {{ $venue->country }}</p>
    </div>
    <div class="panel-body">
        <a href="{{ action("VenueController@update", ['id' => $venue->id]) }}">Edit Venue</a>
    </div>

@endsection