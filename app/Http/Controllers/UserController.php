<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;

use App\Http\Requests;
use App\Role;
use Illuminate\Support\Facades\Auth;
use JWTAuth;

class UserController extends Controller
{
    /**
     * ProfileController constructor.
     */
    public function __construct()
    {
        //$this->middleware('auth');
        $this->middleware('jwt.auth');
    }

    /**
     * Show a list of users.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $users = User::all();
        return $users;
       // return view('users.index', compact('users'));
    }

    public function show($user)
    {
        return $user;
        //return view('users.show', compact('user'));
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        $user = \Auth::user();

        $roles = Role::lists('role', 'id');

        return view('users.profile',
            compact('user',
                'roles'
            ));
    }

    /**
     * Update user information.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function update(UserRequest $request)
    {
        $user = JWTAuth::parseToken()->authenticate();
//        $user = \Auth::user();
        if (in_array('admin', $user->role_names) && $request->has('id')){
            $user = User::find($request->input('id'));
        }
        $roles = $request->input('role_list');
        $name = $request->input('name');
        $email = $request->input('email');
        $password = $request->input('password');

        $roles = $roles === null ? [] : $roles;

        $user->roles()->sync($roles);

        $user->name = $name;
        $user->email = $email;

        if ($password !== ""){
           return "Ova se vrakja: ".$request->input('password');
            $user->password = bcrypt($password);
        }else{
            //return "Super ne vleguva";
        }


        $user->save();

        //return $password;
    }

}
