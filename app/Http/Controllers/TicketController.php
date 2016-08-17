<?php

namespace App\Http\Controllers;

use App\Event;
use App\Ticket;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;

class TicketController extends Controller
{
    /**
     * TicketController constructor.
     */
    public function __construct()
    {
       // $this->middleware('auth');
        $this->middleware('jwt.auth', ['except' => ['index', 'show']]);
    }

    public function index(Event $event)
    {
        $reserve_time = Carbon::now()->subMinute(15);
        $tickets = $event->tickets()->where('sold', false)
                                    ->where('reserve_time', '<', $reserve_time)
                                    ->orWhereNull('reserve_time')
                                    ->paginate(5);

        //return view('tickets.index', compact('tickets', 'event'));
        return $tickets;
    }

    public function show(Event $event, Ticket $ticket){
        $seat = $ticket->seat()->first();

        return view('tickets.show', compact('ticket', 'event', 'seat'));
    }

    public function reserve(Event $event, Ticket $ticket)
    {
        $ticket->reserve_time = Carbon::now();

        $ticket->save();

        return view('tickets.buy', compact('event', 'ticket'));
    }

    public function buy(Event $event, Ticket $ticket)
    {
        $ticket->user_id = \Auth::user()->id;
        $ticket->reserve_time = Carbon::now();
        $ticket->sold = true;

        $ticket->save();

        return redirect('events/'.$event->id);
    }


}
