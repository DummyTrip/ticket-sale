<?php

namespace App\Http\Controllers;

use App\Http\Requests\EventRequest;
use App\Seat;
use App\Tag;
use App\Venue;
use App\Event;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use JWTAuth;

/**
 * Class EventController
 * @package App\Http\Controllers
 */
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
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function index()
    {
        $events = Event::all();

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

        return view('events.create', compact('venues', 'tags'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param EventRequest $request
     * [
     * 'name' => 'test',
     * 'venue_id' => '1',
     * 'tag_list' => ['1', '2'],
     * 'blocks' => ['1',            // block_name
     *              '100',          // price
     *              '2',            // block_name
     *              '200'],         // price
     * 'description' = > 'Description of event'
     * ]
     * @return \Illuminate\Http\Response 'name' => 'test',
     */
    public function store(EventRequest $request)
    {
        $event = new Event();

        return $this->saveEvent($event, $request);
    }

    /**
     * Display the specified resource.
     *
     * @param Event $event
     * @return Event
     */
    public function show(Event $event)
    {
        return $event;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Event $event
     * @return \Illuminate\Http\Response
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
     * @param EventRequest|Request $request
     * @param Event $event
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function update(EventRequest $request, Event $event)
    {
        $input = $request->all();

        return $this->saveEvent($event, $request);
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
     * @param Event $event
     * @param EventRequest $request
     *  ['name' => string, 'venue_id' => int, 'tag_list' => [int, int, ...],
     *  'blocks' => ['block_name1', 'price1', 'block_name2', 'price2', ..],
     *  'description' => string]
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    private function saveEvent(Event $event, EventRequest $request)
    {
        $input = $request->all();

        $user = JWTAuth::parseToken()->authenticate();
        $event->organizer_id = $user->id;
        $event->name = $input['name'];
        $event->venue_id = $input['venue_id'];
        $event->date = \Carbon\Carbon::now();

        if ($request->has('description')) {
            $event->description = $input['description'];
        }


        if ($request->has('image')) {
            $event->image = $input['image'];
        }

        $event->save();

        $tags = array_key_exists('tag_list', $input) ? $input['tag_list'] : [];

        //add tickets
        $tickets_input = $this->getTicketSeatsAndPrice($input, $input['venue_id']);
        $ticketController = new TicketController();
        //return $tickets_input;
        $ticketController->saveTickets($event, $tickets_input);

        //add tags
        $event->tags()->sync($tags);

        return response('Event saved.', 200);
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


    /**
     * Upload an image.
     *
     * @param Event $event
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    private function uploadImage(Event $event)
    {
        $imageInputFieldName = "image";
        // getting all of the post data
        $file = array($imageInputFieldName => Input::file($imageInputFieldName));
        // setting up rules
        $rules = array($imageInputFieldName => 'image',); //mimes:jpeg,bmp,png and for max size max:10000
        // doing the validation, passing post data, rules and the messages
        $validator = Validator::make($file, $rules);
        if ($validator->fails()) {
            // send back to the page with the input data and errors
            return response("The file you selected is not an image.", 415);
        }
        else {
            // checking file is valid.
            if (Input::file($imageInputFieldName)->isValid()) {
                $extension = Input::file($imageInputFieldName)->getClientOriginalExtension(); // getting image extension
                $fileName = rand(11111,99999).'.'.$extension; // renaming image
                Storage::disk('images')->put($fileName, File::get($file[$imageInputFieldName]));
                // add image name to venue
                $event->image = $fileName;
                return response('File uploaded', 200);
            }
            else {
                // sending back with error message.
                return response("The uploaded file is not valid.", 422);
            }
        }
    }

}
