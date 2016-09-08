<?php

namespace App\Http\Controllers;

use App\Http\Requests\VenueRequest;
use App\Seat;
use App\User;
use App\Venue;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
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
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function index()
    {
        $venues = Venue::all();
        return $venues;
    }

    /**
     * Show a specific venue.
     *
     * @param Venue $venue
     * @return Venue
     */
    public function show(Venue $venue)
    {
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

    /**
     * @param Venue $venue
     * @param VenueRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Venue $venue, VenueRequest $request)
    {
        return $this->saveVenue($venue, $request);
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
     * * [
     * 'name' => string, 'city' => string,
     * 'country' => string, 'address' => string,
     * 'blocks' => [ 'block_name' => string, 'rows' => int, 'columns' => int, ...],
     * 'description' => string,
     * 'image' => image
     * ]
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(VenueRequest $request)
    {
        $venue = new Venue();

        return $this->saveVenue($venue, $request);
    }

    /**
     * Saves a venue to db.
     *
     * @param Venue $venue
     * @param VenueRequest $request
     * [
     * 'name' => string, 'city' => string,
     * 'country' => string, 'address' => string,
     * 'blocks' => [ 'block_name' => string, 'rows' => int, 'columns' => int, ...],
     * 'description' => string
     * 'image' => image
     * ]
     * @return \Illuminate\Http\JsonResponse
     */
    private function saveVenue(Venue $venue, VenueRequest $request){
        $input = $request->all();

        if (! $user = JWTAuth::parseToken()->authenticate()) {
            return response()->json(['user_not_found'], 404);
        }
        $venue->manager_id = $user->id;
        $venue->name = $input['name'];
        $venue->city = $input['city'];
        $venue->country = $input['country'];
        $venue->address = $input['address'];

        if ($request->has('description')) {
            $venue->description = $input['description'];
        }

        if ($request->has('image')) {
            $venue->image = $input['image'];
        }

        $venue->save();

        $seats = $this->getSeatIds($input);
        $venue->seats()->sync($seats);

        return response('Venue saved.', 200);
    }

    /**
     * Gets or creates the ids of seats that belong to a block.
     *
     * @param $input
     * ['blocks' => ['block_name' => string, 'rows' => int, 'columns' => int], ...]]
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

    /**
     * Upload an image.
     *
     * @param Venue $venue
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    private function uploadImage(Venue $venue)
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
                $venue->image = $fileName;
                return response('File uploaded', 200);
            }
            else {
                // sending back with error message.
                return response("The uploaded file is not valid.", 422);
            }
        }
    }

}
