<?php
/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

use App\Seat;
use Illuminate\Support\Facades\Input;

;

Route::get('/', function () {
    return view('welcome');
});

Route::auth();

Route::get('/home', 'HomeController@index');

Route::get('/users', 'UserController@index');
Route::get('/users/{id}', 'UserController@show');
//Route::get('/profile', 'UserController@edit');
Route::post('/profile', 'UserController@update');

//Route::resource('venues', 'VenueController');
Route::get('test', function(){
    return view("test");
});
Route::post('test', function(Illuminate\Http\Request $request){
    $input = $request->all();
    $imageInputFieldName = "image";

    // getting all of the post data
    $file = array($imageInputFieldName => Input::file($imageInputFieldName));

    // setting up rules
    $rules = array($imageInputFieldName => 'image',); //mimes:jpeg,bmp,png and for max size max:10000
    // doing the validation, passing post data, rules and the messages
    $validator = Validator::make($file, $rules);
    if ($validator->fails()) {
        // send back to the page with the input data and errors
        return "The file you selected is not an image.";
    }
    else {
        // checking file is valid.
        if (Input::file($imageInputFieldName)->isValid()) {
            $extension = Input::file($imageInputFieldName)->getClientOriginalExtension(); // getting image extension
            $fileName = rand(11111,99999).'.'.$extension; // renaming image
            Storage::disk('images')->put($fileName, File::get($file[$imageInputFieldName]));
            return view('test')->with("file", 'storage/public/'.$file[$imageInputFieldName]);
        }
        else {
            // sending back with error message.
            return "The uploaded file is not valid.";
        }
    }


//    return $input;
});

Route::get('/venues', 'VenueController@index');
Route::post('/venues/create', 'VenueController@store');
Route::get('/venues/create', 'VenueController@create');
Route::get('/venues/{venues}', 'VenueController@show');
Route::patch('/venues/{venues}', 'VenueController@update');
Route::get('/venues/{venues}/edit', 'VenueController@edit');

Route::get('/events', 'EventController@index');
Route::post('/events/create', 'EventController@store');
Route::get('/events/create', 'EventController@create');
Route::get('/events/{events}', 'EventController@show');
Route::patch('/events/{events}', 'EventController@update');
Route::get('/events/{events}/edit', 'EventController@edit');

Route::get('/events/{events}/tickets', 'TicketController@index');
//Route::post('/events/{events}/tickets', 'TicketController@store');
//Route::get('/events/{events}/tickets/create', 'TicketController@create');
Route::get('/events/{events}/tickets/{tickets}', 'TicketController@show');
Route::post('/events/{events}/tickets/{tickets}/buy', 'TicketController@buy');
Route::get('/events/{events}/blocktickets', 'TicketController@blockTickets');

Route::post('/singUp','AuthAndRegisterController@register');
Route::post('/logIn','AuthAndRegisterController@login');
Route::get('/auth', 'AuthAndRegisterController@getAuthenticatedUser');
Route::get('test1', function(){
    $seats = [];
    $blocks = [];

    $blocks_input = ['a', '1', '1', 'b', '1', '1'];
    foreach (range(0, (count($blocks_input) / 3) - 1) as $index) {
        $blocks[$index] = ['block_name' => $blocks_input[$index * 3],
            'rows' => $blocks_input[$index * 3 + 1],
            'columns' => $blocks_input[$index * 3 + 2]];
    }
    return $blocks;
    foreach ($blocks as $block){
        foreach(range(1, $block["rows"]) as $row) {
            foreach(range(1, $block["columns"]) as $column) {
                $seat = ['row' => $row, 'column' => $column, 'block_name' => $block["block_name"]];
                $seats[] = Seat::firstOrCreate($seat)->id;
            }
        }
    }

    return $seats;
});