@extends('layouts.app')

@section('content')

    {!! Form::open(['url' => 'test', 'method' => 'POST', 'class' => 'form-horizontal', 'files' => true]) !!}

        <input type="file" name="image"><br>
        {!! Form::button("Upload", ['class' => 'btn btn-primary', 'type' => 'submit']) !!}

    {!! Form::close() !!}

    @if(isset($file))
        <img src="{{ $file }}">
    @endif
@endsection
