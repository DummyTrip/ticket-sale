@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">Dashboard</div>

                    <div class="panel-body">
                        You are logged in!

                        <h3>Pages</h3>
                        <ul>
                            <li>
                                <a href="{{ action('VenueController@index') }}">Venues</a>
                            </li>

                            <li>
                                <a href="{{ action('VenueController@create') }}">Create Venue</a>
                            </li>

                            <li>
                                <a href="{{ action('UserController@index') }}">Users</a>
                            </li>

                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
