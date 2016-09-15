@extends('admin.layouts.app')

@section('content')
    {{--<div class="container">--}}
        @include('layouts.messages')
        <h1>Edit User {{ $user->id }}</h1>

        {!! Form::model($user, [
            'method' => 'PATCH',
            'url' => ['/admin/users', $user->id],
            'class' => 'form-horizontal',
            'files' => true
        ]) !!}

        <div class="form-group{{ $errors->has('avatar') ? ' has-error' : '' }}">
            {!! Form::label('avatar', 'Avatar', ['class' => 'col-sm-3 control-label']) !!}
            <div class="col-md-6">
                <img src="{{ $user->provider ? $user->avatar : '/images/users/' . $user->avatar }}" id="user-image">
                <input id="avatar" type="file" class="form-control" name="avatar" value="{{ old('avatar') }}"  autofocus>
                @if ($errors->has('avatar'))
                    <span class="help-block">
                                        <strong>{{ $errors->first('avatar') }}</strong>
                                    </span>
                @endif
            </div>
        </div>

        <div class="form-group {{ $errors->has('username') ? 'has-error' : ''}}">
            {!! Form::label('username', 'Username', ['class' => 'col-sm-3 control-label']) !!}
            <div class="col-sm-6">
                {!! Form::text('username',  old('username') != null ? old('username'):null , ['class' => 'form-control']) !!}
                {!! $errors->first('username', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
        <div class="form-group {{ $errors->has('email') ? 'has-error' : ''}}">
            {!! Form::label('email', 'Email', ['class' => 'col-sm-3 control-label']) !!}
            <div class="col-sm-6">
                {!! Form::text('email', old('email') != null? old('email'): null, ['class' => 'form-control']) !!}
                {!! $errors->first('email', '<p class="help-block">:message</p>') !!}
            </div>
        </div>

        <div class="form-group {{ $errors->has('provider') ? 'has-error' : ''}}">
            {!! Form::label('provider', 'Provider', ['class' => 'col-sm-3 control-label']) !!}
            <div class="col-sm-6">
                <input type="text" name="provider" value="{{ $user->provider ? $user->provider : 'Booking'}}" class = 'form-control' disabled="disabled">
                {!! $errors->first('provider', '<p class="help-block">:message</p>') !!}
            </div>
        </div>

        <input type="hidden" name="provider" value="{{ $user->provider }}">

        <div class="form-group">
            <div class="col-sm-offset-3 col-sm-3">
                {!! Form::submit('Update', ['class' => 'btn btn-primary form-control']) !!}
            </div>
        </div>
        {!! Form::close() !!}

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

        $("#avatar").change(function(){
            readURL(this);
        });
    </script>
@endsection