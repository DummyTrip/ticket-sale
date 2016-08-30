<?php

namespace App\Http\Controllers;

use App\Http\Requests\VenueRequest;
use App\Seat;
use App\User;
use App\Venue;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use JWTAuth;

class VenueController extends Controller
{
    /**
     * VenueController constructor.
     */
    public function __construct()
    {
       // $this->middleware('auth');
       // $this->middleware('jwt.auth', ['except' => ['index', 'show']]);
    }

    /**
     * Show a list of venues.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $venues = Venue::all();
        return $venues;
       // return view('venues.index', compact('venues'));
    }

    /**
     * Show a specific venue.
     *
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Venue $venue)
    {
//        return view('venues.show', compact('venue'));
        return $venue;
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

        $this->saveVenue($venue, $input);

//        return view('venues.show', compact('venue'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('venues.create');
    }


    /**
     * Store a venue in db.
     *
     * @param VenueRequest $request
     */
    public function store(VenueRequest $request)
    {
        $input = $request->all();

        $venue = new Venue();

        $this->saveVenue($venue, $input);
    }

    /**
     * Saves a venue to db.
     *
     * @param $venue
     * @param $input = ['name' => string, 'city' => string, 'country' => string, 'address' => string,
     *                  'blocks' => ['block_name' => string, 'rows' => int, 'columns' => int], ...]]
     * @return \Illuminate\Http\JsonResponse
     */
    private function saveVenue($venue, $input){
        if (! $user = JWTAuth::parseToken()->authenticate()) {
            return response()->json(['user_not_found'], 404);
        }
        $venue->manager_id = $user->id;
        $venue->name = $input['name'];
        $venue->city = $input['city'];
        $venue->country = $input['country'];
        $venue->address = $input['address'];

        $venue->save();

        $seats = $this->getSeatIds($input);
        $venue->seats()->sync($seats);
    }

    /**
     * Gets or creates the ids of seats that belong to a block.
     *
     * @param $input = ['blocks' => ['block_name' => string, 'rows' => int, 'columns' => int], ...]]
     *
     * @return array(App\Seat->id, App\Seat->id, ....)
     */
    private function getSeatIds($input){
        $seats = [];
        $blocks = [];

        $blocks_input = $input['blocks'];
        foreach (range(0, (count($blocks_input) / 3) - 1) as $index) {
            $blocks[$index] = ['block_name' => $blocks_input[$index * 3],
                'rows' => $blocks_input[$index * 3 + 1],
                'columns' => $blocks_input[$index * 3 + 2]];
        }

        foreach ($blocks as $block){
            foreach(range(1,$block["rows"]) as $row) {
                foreach(range(1,$block["columns"]) as $column) {
                    $seat = ['row' => $row, 'column' => $column, 'block_name' => $block["block_name"]];
                    $seats[] = Seat::firstOrCreate($seat)->id;
                }
            }
        }

        return $seats;
    }

}
