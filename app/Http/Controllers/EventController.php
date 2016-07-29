<?php

namespace App\Http\Controllers;

use App\Http\Requests\EventRequest;
use App\Tag;
use App\Venue;
use App\Event;
use Illuminate\Http\Request;

use App\Http\Requests;

class EventController extends Controller
{
    /**
     * EventController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $events = Event::all();

        return view('events.index', compact('events'));
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(EventRequest $request)
    {
        $input = $request->all();

        $event = new Event();

        $this->saveEvent($input, $event);

        return redirect('events');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Event $event)
    {
        return view('events.show', compact('event'));
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
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(EventRequest $request, Event $event)
    {
        $input = $request->all();

        $this->saveEvent($input, $event);

        return view('events.show', compact('event'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    private function saveEvent($input, Event $event)
    {
        $event->organizer_id = \Auth::user()->id;
        $event->name = $input['name'];
        $event->venue_id = $input['venue_id'];
        $event->date = $input['date'];

        $event->save();

        $tags = $input['tag_list'];

        $tags = $tags === null ? [] : $tags;

        $event->tags()->sync($tags);
    }
}
