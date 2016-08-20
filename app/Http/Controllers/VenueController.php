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
        $this->middleware('jwt.auth', ['except' => ['index', 'show']]);
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
     * @param CreateVenueRequest $request
     *
     * example $input:
     * {
     *      "block-1": "1",
     *      "block_name-1": "a",
     *      "rows-1": "1",
     *      "columns-1": "1",
     *      "block-2": "2",
     *      "block_name-2": "b"
     *      "rows-2": "2",
     *      "columns-2": "2",
     *      "name": "TestVenue",
     *      "city": "test",
     *      "country": "test",
     *      "address": "test",
     * }
     *
     * @return array
     */
    public function store(VenueRequest $request)
    {
        $input = $request->all();

        $venue = new Venue;

        $this->saveVenue($venue, $input);
    }

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
     * @param $input
     *
     * @return array
     */
    private function getSeatIds($input){
        $seats = [];
        $blocks = [];

        foreach ($input as $key => $value){
            if (str_contains($key, "-")){
                $split = explode("-", $key);
                $index = $split[1];
                $column = $split[0];

                $blocks = array_add($blocks, $index, []);
                $blocks[$index][$column] = $value;
            }
        }

        foreach ($blocks as $block){
            foreach(range(1,$block["rows"]) as $row) {
                foreach(range(1,$block["columns"]) as $column) {
                    $seat = ['block' => $block["block"], 'row' => $row, 'column' => $column, 'block_name' => $block["block_name"]];
                    $seats[] = Seat::firstOrCreate($seat)->id;
                }
            }
        }

        return $seats;
    }

}
