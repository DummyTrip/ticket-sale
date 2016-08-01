@extends('layouts.app')

@section('content')
    <div class="panel-body">
        <h2>{{$event->name}}</h2>
        <hr>
        <p>Name: {{ $event->name }} Date: {{ $event->date }}</p>
        <h4>Tags</h4>
        <ul>
            @foreach($event->tags()->get() as $tag)
                <li>{{ $tag->name }}</li>
            @endforeach
        </ul>
    </div>
    <div class="panel-body">
        <a href="{{ action("EventController@edit", ['event' => $event]) }}">Edit Event</a>
    </div>
    <div class="panel-body">
        <a href="{{ action("TicketController@index", ['event' => $event]) }}">View Tickets</a>
    </div>

@endsection