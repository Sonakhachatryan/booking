@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Contact detalis</div>

                    <div class="panel-body">
                        @if(session('success'))
                            <div class="error_message alert alert-success alert-dismissible" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                            aria-hidden="true">&times;</span></button>
                                <p>{{ session('success') }}</p>
                            </div>
                        @endif
                        {!! Form::model(auth('user')->user(),[
                        'url' => '/user/contact-details',
                        'method' => 'post', '
                        class' => 'form-horizontal'
                        ]) !!}

                        <div class="form-group {{ $errors->has('email') ? 'has-error' : ''}}">
                            {!! Form::label('email', 'E-Mail', ['class' => 'col-sm-3 control-label']) !!}
                            <div class="col-sm-6">
                                {!! Form::email('email', null, ['class' => 'form-control']) !!}
                                {!! $errors->first('email', '<p class="help-block">:message</p>') !!}
                            </div>
                        </div>

                        <div class="form-group {{ $errors->has('mobile') ? 'has-error' : ''}}">
                            {!! Form::label('mobile', 'Mobile', ['class' => 'col-sm-3 control-label']) !!}
                            <div class="col-sm-6">
                                {!! Form::text('mobile', null, ['class' => 'form-control']) !!}
                                {!! $errors->first('mobile', '<p class="help-block">:message</p>') !!}
                            </div>
                        </div>


                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-3">
                                {!! Form::submit('Save', ['class' => 'btn btn-primary form-control']) !!}
                            </div>
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection