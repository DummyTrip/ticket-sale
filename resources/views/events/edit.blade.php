@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Edit Event</div>
                    <div class="panel-body">

                        {!! Form::model($event, ['action' => ['EventController@update', $event->id], 'method' => 'PATCH', 'class' => 'form-horizontal']) !!}

                            @include('events.form', ['submitButtonText' => '<i class="fa fa-btn fa-pencil"></i> Edit Event'])

                        {!! Form::close() !!}

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
