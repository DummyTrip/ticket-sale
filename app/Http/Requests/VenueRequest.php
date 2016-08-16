<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use App\Role;
use Illuminate\Support\Facades\Auth;

class VenueRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $user = \Auth::user();
        //$roles = $user->role_names;
        return true;
        //return in_array('admin', $roles) || in_array('organizer', $roles);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required',
            'city' => 'required',
            'country' => 'required',
            'address' => 'required',
        ];
    }
}
