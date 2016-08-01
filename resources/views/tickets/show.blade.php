@extends('layouts.app')

@section('content')
    <div class="panel-body">
        <h2>Ticket for {{$event->name}}</h2>
        <hr>
        <p>Date: {{ $event->date }},</p><br>
        <p>Price: {{ $ticket->price }}, Venue: {{ $event->venue()->first()->name }}</p><br>
        <p>Block: {{ $seat->block }}, Row: {{ $seat->row }}, Column: {{ $seat->column }}</p><br>
    </div>
    <div class="panel-body">
        {{--<a href="{{ action("TicketController@edit", ['event' => $event, 'ticket' => $ticket]) }}">Edit Ticket</a>--}}
    </div>
    <div class="panel-body">
        <a href="{{ action("TicketController@buy", ['event' => $event, 'ticket' => $ticket]) }}">Buy Ticket</a>
    </div>

@endsection