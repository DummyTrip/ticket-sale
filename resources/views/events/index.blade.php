@extends('layouts.app')

@section('content')
    <h2>Events</h2>

    @foreach($events as $event)
        <div class="panel-body">
            <h2><a href="{{ action("EventController@show", ['id' => $event->id]) }}">{{$event->name}}</a></h2>
            <hr>
        </div>
    @endforeach
@endsection