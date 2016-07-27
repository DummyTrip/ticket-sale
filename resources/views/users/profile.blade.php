@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Edit Profile</div>
                    <div class="panel-body">
                        <form class="form-horizontal" role="form" method="POST" action="{{ action('UserController@store') }}">
                            {{ csrf_field() }}

                            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                <label for="name" class="col-md-4 control-label">Name</label>

                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control" name="name" value="{{ old('name') ? old('name') : $user->name }}">

                                    @if ($errors->has('name'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control" name="email" value="{{ old('email') ? old('email') : $user->email }}">

                                    @if ($errors->has('email'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                <label for="password" class="col-md-4 control-label">Password</label>

                                <div class="col-md-6">
                                    <input id="password" type="password" class="form-control" name="password">

                                    @if ($errors->has('password'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                                <label for="password-confirm" class="col-md-4 control-label">Confirm Password</label>

                                <div class="col-md-6">
                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation">

                                    @if ($errors->has('password_confirmation'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('make_admin') ? ' has-error' : '' }}">
                                <label for="make-admin" class="col-md-4 control-label">Admin</label>

                                <div class="col-md-6">
                                    <input id="make-admin" type="checkbox" name="make-admin" {{ $isAdmin ? "checked" : "" }}>

                                    @if ($errors->has('make-admin'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('make_admin') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('make_manager') ? ' has-error' : '' }}">
                                <label for="make-manager" class="col-md-4 control-label">Manager</label>

                                <div class="col-md-6">
                                    <input id="make-manager" type="checkbox" name="make-manager" {{ $isManager ? "checked" : "" }}>

                                    @if ($errors->has('make-manager'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('make_manager') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('make_organizer') ? ' has-error' : '' }}">
                                <label for="make-organizer" class="col-md-4 control-label">Organizer</label>

                                <div class="col-md-6">
                                    <input id="make-organizer" type="checkbox" name="make-organizer" {{ $isOrganizer ? "checked" : "" }}>

                                    @if ($errors->has('make-organizer'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('make_organizer') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fa fa-btn fa-user"></i> Confirm
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
