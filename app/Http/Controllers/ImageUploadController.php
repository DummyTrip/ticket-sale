<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ImageUploadController extends Controller
{
    public function upload(Request $request)
    {
        $imageInputFieldName = "file";
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

                return $fileName;
            }
            else {
                // sending back with error message.
                return response("The uploaded file is not valid.", 422);
            }
        }
    }
}
