@extends('layouts.app')

@section('content')
    <div class="panel-body">
        <h2>{{$event->name}}</h2>
        <hr>
        <p>Name: {{ $event->name }} Date: {{ $event->date }}</p>
    </div>
    <div class="panel-body">
        <a href="{{ action("EventController@edit", ['id' => $event->id]) }}">Edit Event</a>
    </div>

@endsection