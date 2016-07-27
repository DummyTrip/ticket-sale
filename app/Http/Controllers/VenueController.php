<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateVenueRequest;
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
    public function show($id)
    {
        $venue = Venue::find($id);

        return view('venues.show', compact('venue'));
    }

    public function update($id)
    {
        $venue = Venue::find($id);

        return $venue;
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
    public function store(CreateVenueRequest $request)
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
