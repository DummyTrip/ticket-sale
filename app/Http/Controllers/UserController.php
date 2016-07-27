<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Role;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * ProfileController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show a list of users.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $users = User::all();

        return view('users.index', compact('users'));
    }

    public function show($id)
    {
        $user = User::find($id);

        return view('users.show', compact('user'));
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function update()
    {
        $user = \Auth::user();

        $isAdmin = $user->hasRole('admin');
        $isManager = $user->hasRole('manager');
        $isOrganizer = $user->hasRole('organizer');

        return view('users.profile',
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
        $input = $request->all();

        $isAdmin = array_key_exists('make-admin', $input) ? 'admin' : '';
        $isManager = array_key_exists('make-manager', $input) ? 'manager' : '';
        $isOrganizer = array_key_exists('make-organizer', $input) ? 'organizer' : '';

        $roles = array($isAdmin, $isManager, $isOrganizer);

        $user->addRole($roles);

        return view('profile',
            compact('isAdmin',
                'isManager',
                'isOrganizer',
                'user'
            ));
    }
}
