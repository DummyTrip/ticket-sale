<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Role;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = \Auth::user();

        $isAdmin = $user->hasRole('admin');;
        $isManager = $user->hasRole('manager');;
        $isOrganizer = $user->hasRole('organizer');;

        return view('profile',
            compact('isAdmin',
                'isManager',
                'isOrganizer',
                'user'
            ));
    }

    /**
     * Add selected roles to the user.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function store(Request $request)
    {
        $user = \Auth::user();
        $all_requests = $request->all();

        $isAdmin = array_key_exists('make-admin', $all_requests) ? 'admin' : '';
        $isManager = array_key_exists('make-manager', $all_requests) ? 'manager' : '';
        $isOrganizer = array_key_exists('make-organizer', $all_requests) ? 'organizer' : '';

        $roles = array($isAdmin, $isManager, $isOrganizer);

        $user->addRole($roles, $user);

        return view('profile',
            compact('isAdmin',
                'isManager',
                'isOrganizer',
                'user'
            ));
    }
}
