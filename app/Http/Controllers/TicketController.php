<?php

namespace App\Http\Controllers;

use App\Event;
use App\Http\Requests\EventRequest;
use App\Ticket;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use JWTAuth;
use Illuminate\Support\Facades\DB;

use App\Http\Requests;

class TicketController extends Controller
{
    /**
     * TicketController constructor.
     */
    public function __construct()
    {
        // $this->middleware('auth');
        $this->middleware('jwt.auth', ['except' => ['index', 'show', 'blockTickets']]);
    }

    public function index(Event $event)
    {
        $reserve_time = Carbon::now()->subMinute(15);
        $tickets = $event->tickets()->where('sold', false)
            ->where('reserve_time', '=', null)
            ->orWhere('reserve_time', '<', $reserve_time)
            ->get();
//            ->paginate(5);

//        return view('tickets.index', compact('tickets', 'event'));
        return $tickets;
    }

    public function edit(){
        //TODO
    }

    public function update(Event $event, Ticket $ticket, EventRequest $request){
        $input = $request->all();

        $this->saveTicket($event, $ticket, $input);
    }

    public function create(){
        //TODO
    }

    public function store(Event $event, Ticket $ticket, EventRequest $request){
        $ticket = new Ticket();

        $input = $request->all();

        $this->saveTicket($event, $ticket, $input);
    }

    public function saveTicket($event, $ticket){
        //TODO
    }

    /**
     * Adds tickets to an event.
     *
     * @param $event
     * @param $tickets_input
     *
     * $ticket_input = ['seat_id' => App\Seat->id, 'price' => int]      *
     */
    public function saveTickets($event, $tickets_input){
        foreach ($tickets_input as $ticket_input){
            $ticket = new Ticket();
            $ticket->seat_id = $tickets_input['seat_id'];
            $ticket->event_id = $event->id;
            $ticket->price = $ticket_input['price'];
            $ticket->save();
        }
    }

    public function show(Event $event, Ticket $ticket)
    {
        $seat = $ticket->seat()->first();

//        return view('tickets.show', compact('ticket', 'event', 'seat'));
        return [$ticket, $seat];
    }

    public function reserve(Event $event, Ticket $ticket)
    {
        $ticket->reserve_time = Carbon::now();

        $ticket->save();

//        return view('tickets.buy', compact('event', 'ticket'));
    }

    public function buy(Event $event, Ticket $ticket)
    {
        $user = JWTAuth::parseToken()->authenticate();
        $ticket->user_id = $user->id;
        $ticket->reserve_time = Carbon::now();
        $ticket->sold = true;

        $ticket->save();

//        return redirect('events/' . $event->id);
    }

    public function blockTickets(Event $event){
        return DB::table('tickets')
            ->join('seats', 'seats.id', '=', 'tickets.seat_id')
            ->where('event_id', $event->id)
            ->select('block_name', 'price', DB::raw("count(distinct(seats.column)) as columns"), DB::raw('count(distinct(row)) as rows'))
            ->groupBy('block_name', 'price')
            ->get();
    }

}
