@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Edit Venue</div>
                    <div class="panel-body">

                        {!! Form::model($venue, ['action' => ['VenueController@update', $venue->id], 'method' => 'PATCH', 'class' => 'form-horizontal']) !!}

                                @include('venues.form', ['submitButtonText' => '<i class="fa fa-btn fa-pencil"></i> Edit Venue'])

                        {!! Form::close() !!}

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
