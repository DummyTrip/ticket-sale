<div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
    {!! Form::label('name', 'Name:', ['class' => 'col-md-4 control-label']) !!}

    <div class="col-md-6">
        {!! Form::text('name', old('name'), ['class' => 'form-control']) !!}

        @include('partials.error', ['error' => 'name'])
    </div>
</div>

<div class="form-group{{ $errors->has('venue_id') ? ' has-error' : '' }}">
    {!! Form::label('venue_id', 'Venue:', ['class' => 'col-md-4 control-label']) !!}

    <div class="col-md-6">
        {!! Form::select('venue_id', $venues, null, ['id' => 'venue_id', 'class' => 'form-control']) !!}

        @include('partials.error', ['error' => 'venue_id'])
    </div>
</div>

<div class="form-group{{ $errors->has('date') ? ' has-error' : '' }}">
    {!! Form::label('date', 'Date:', ['class' => 'col-md-4 control-label']) !!}

    <div class="col-md-6">
        {!! Form::date('date', \Carbon\Carbon::now(), ['class' => 'form-control']) !!}

        @include('partials.error', ['error' => 'date'])
    </div>
</div>

<div class="form-group{{ $errors->has('tag_list') ? ' has-error' : '' }}">
    {!! Form::label('tag_list', 'Tags:', ['class' => 'col-md-4 control-label']) !!}

    <div class="col-md-6">
        {!! Form::select('tag_list[]', $tags, null, ['id' => 'tag_list', 'class' => 'form-control', 'multiple']) !!}

        @include('partials.error', ['error' => 'tag_list'])
    </div>
</div>

<div class="form-group">
    <div class="col-md-6 col-md-offset-4">
        {!! Form::button($submitButtonText, ['class' => 'btn btn-primary', 'type' => 'submit']) !!}
    </div>
</div>

@section('footer')
    <script type="text/javascript">
        $('#venue_id').select2({
            placeholder: 'Select venue_id'
        });
        $('#tag_list').select2({
            placeholder: 'Select tags',
            allowClear: true
        });
    </script>
@endsection
