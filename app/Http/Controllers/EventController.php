<?php

namespace App\Http\Controllers;

use App\Http\Requests\EventRequest;
use App\Seat;
use App\Tag;
use App\Venue;
use App\Event;
use Illuminate\Http\Request;

use App\Http\Requests;
use JWTAuth;

class EventController extends Controller
{
    /**
     * EventController constructor.
     */
    public function __construct()
    {
        //$this->middleware('auth');
        $this->middleware('jwt.auth', ['except' => ['index', 'show']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $events = Event::all();
        // return \Auth::user();
        return $events;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $venues = Venue::lists('name', 'id')->prepend("");
        $tags = Tag::lists('name', 'id');
        //return true;
        return view('events.create', compact('venues', 'tags'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     *
     * example $input
     *
     * 'name' => 'test',
     * 'venue_id' => '1',
     * 'tag_list' => ['1', '2'],
     * 'blocks' => ['1',            // block_name
     *              '100',          // price
     *              '2',            // block_name
     *              '200'           // price
     *             ]
     */
    public function store(EventRequest $request)
    {
        $input = $request->all();

        $event = new Event();

        return $this->saveEvent($input, $event);

        // return redirect('events');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show(Event $event)
    {
//        return view('events.show', compact('event'));
        return $event;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Event $event
     * @return \Illuminate\Http\Response
     * @internal param int $id
     */
    public function edit(Event $event)
    {
        $venues = Venue::lists('name', 'id')->prepend("");
        $tags = Tag::lists('name', 'id');

        return view('events.edit', compact('event', 'venues', 'tags'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(EventRequest $request, Event $event)
    {
        $input = $request->all();

        $this->saveEvent($input, $event);

//        return view('events.show', compact('event'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Saves an event along with the tags and tickets.
     *
     * @param $input = ['name' => string, 'venue_id' => int, 'tag_list' => [int, int, ...],
     *                  'blocks' => ['block_name1', 'price1', 'block_name1', 'price1', ..], ]
     * @param Event $event
     */
    private function saveEvent($input, Event $event)
    {
        $user = JWTAuth::parseToken()->authenticate();
        $event->organizer_id = $user->id;
        $event->name = $input['name'];
        $event->venue_id = $input['venue_id'];
        $event->date = \Carbon\Carbon::now();

        $event->save();

        $tags = array_key_exists('tag_list', $input) ? $input['tag_list'] : [];

        //add tickets
        $tickets_input = $this->getTicketSeatsAndPrice($input, $input['venue_id']);
        $ticketController = new TicketController();
        //return $tickets_input;
        $ticketController->saveTickets($event, $tickets_input);

        //add tags

        $event->tags()->sync($tags);
    }

    /**
     * Parse the input and get seat_id and price for each ticket.
     *
     * @param $input = ['blocks' => ['block_name' => string, 'price' => int], ...]
     * @param $venue_id
     * @return array('seat_id' => App\Seat->id, 'price' => int)
     */
    private function getTicketSeatsAndPrice($input, $venue_id)
    {
        $tickets_input = [];
        $blocks = [];
        $venue = Venue::find($venue_id);

        $blocks_input = $input['blocks'];
        foreach (range(0, (count($blocks_input) / 2)-1) as $index) {
            $blocks[$index] = ['block_name' => $blocks_input[$index * 2],
                'price' => $blocks_input[$index * 2 + 1]];
        }

        foreach ($blocks as $block) {
            $seats = $venue->seats()->where('block_name', $block['block_name'])->get();
            foreach ($seats as $seat) {
                $tickets_input[] = ['seat_id' => $seat->id, 'price' => $block['price']];
            }
        }
            return $tickets_input;
//        return [$tickets_input, $blocks, $blocks_input, $venue_id];
    }
}
