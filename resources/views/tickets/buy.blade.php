@extends('layouts.app')

@section('content')
    <div class="panel-body">
        <h2>Ticket for {{$event->name}}</h2>
        <hr>
        <p>Date: {{ $event->date }},</p><br>
        <p>Price: {{ $ticket->price }}, Venue: {{ $event->venue()->first()->name }}</p><br>
    </div>
    <div class="panel-body">
        <a href="{{ action("TicketController@buy", ['event' => $event, 'ticket' => $ticket]) }}">Confirm purchase</a>
    </div>

@endsection