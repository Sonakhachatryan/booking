@extends('admin.layouts.app')

@section('content')
    {{--<div class="container">--}}

    <h1>Edit Restaurant {{ $restaurant->id }}</h1>
    @include('layouts.messages')
    {!! Form::model($restaurant, [
        'method' => 'PATCH',
        'url' => ['/admin/restaurants', $restaurant->id],
        'class' => 'form-horizontal',
        'files' => true
    ]) !!}
    <div class="form-group{{ $errors->has('avatar') ? ' has-error' : '' }}">
        {!! Form::label('avatar', 'Avatar', ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-md-6">
            <img src="{{ url('images/restaurants/' . $restaurant->avatar) }}" id="user-image">
            <input id="avatar" type="file" class="form-control" name="avatar" value="{{ old('avatar') }}" autofocus>
            @if ($errors->has('avatar'))
                <span class="help-block"> <strong>{{ $errors->first('avatar') }}</strong> </span>
            @endif
        </div>
    </div>


    <div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
        {!! Form::label('name', 'Name', ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-6">
            {!! Form::text('name', null, ['class' => 'form-control']) !!}
            {!! $errors->first('name', '<p class="help-block">:message</p>') !!}
        </div>
    </div>

    <div class="form-group {{ $errors->has('email') ? 'has-error' : ''}}">
        {!! Form::label('email', 'Email', ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-6">
            {!! Form::email('email', null, ['class' => 'form-control']) !!}
            {!! $errors->first('email', '<p class="help-block">:message</p>') !!}
        </div>
    </div>


    <div class="form-group">
        <div class="col-sm-offset-3 col-sm-3">
            {!! Form::submit('Update', ['class' => 'btn btn-primary form-control']) !!}
        </div>
    </div>
    {!! Form::close() !!}

    @if ($errors->any())
        <ul class="alert alert-danger">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    {{--</div>--}}
@endsection

@section('script')
    <script>
        function readURL(input) {
            console.log(111);
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('#user-image').attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#avatar").change(function () {
            readURL(this);
        });
    </script>
@endsection