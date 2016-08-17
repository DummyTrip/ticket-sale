@extends('layouts.app')

@section('content')
    <h2>Tickets</h2>

    @foreach($tickets as $ticket)
        <div class="panel-body">
            <h2><a href="{{ action("TicketController@show", ['ticket' => $ticket->id, 'event' => $event->id]) }}">Seat: {{$ticket->seat_id}}, Price: {{ $ticket->price }} mkd</a></h2>
            <hr>
        </div>
    @endforeach

{{--    {{ $tickets->links() }}--}}
@endsection