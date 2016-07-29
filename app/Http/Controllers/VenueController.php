<?php

namespace App\Http\Controllers;

use App\Http\Requests\VenueRequest;
use App\Venue;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;

class VenueController extends Controller
{
    /**
     * VenueController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show a list of venues.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $venues = Venue::all();

        return view('venues.index', compact('venues'));
    }

    /**
     * Show a specific venue.
     *
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Venue $venue)
    {
        return view('venues.show', compact('venue'));
    }

    /**
     * Return edit view for the given venue.
     *
     * @param $venue
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($venue)
    {
        return view('venues.edit', compact('venue'));
    }

    public function update($venue, VenueRequest $request)
    {
        $input = $request->all();

        $venue->update($input);

        return view('venues.show', compact('venue'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('venues.create');
    }

    /**
     * @param CreateVenueRequest $request
     * @return array
     */
    public function store(VenueRequest $request)
    {
        $input = $request->all();

        $venue = new Venue;

        $venue->manager_id = \Auth::user()->id;
        $venue->name = $input['name'];
        $venue->city = $input['city'];
        $venue->country = $input['country'];
        $venue->address = $input['address'];

        $venue->save();

        return redirect('venues');
    }

}
