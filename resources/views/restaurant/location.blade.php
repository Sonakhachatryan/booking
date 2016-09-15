@extends('admin.layouts.app')

@section('content')
    {{--<div class="container">--}}

    <h1>Contact Detalis</h1>
    @include('layouts.messages')
    {!! Form::model($restaurant, [
        'method' => 'post',
        'url' => ['/admin/restaurant/location'],
        'class' => 'form-horizontal',
        'files' => true
    ]) !!}

    <div class="form-group {{ $errors->has('latitude') ? 'has-error' : ''}}">
        {!! Form::label('latitude', 'Latitude', ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-6">
            {!! Form::text('latitude', null, ['class' => 'form-control']) !!}
            {!! $errors->first('latitude', '<p class="help-block">:message</p>') !!}
        </div>
    </div>

    <div class="form-group {{ $errors->has('longitude') ? 'has-error' : ''}}">
        {!! Form::label('longitude', 'Longitude', ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-6">
            {!! Form::text('longitude', null, ['class' => 'form-control']) !!}
            {!! $errors->first('longitude', '<p class="help-block">:message</p>') !!}
        </div>
    </div>

    <div class="form-group {{ $errors->has('country') ? 'has-error' : ''}}">
        {!! Form::label('country', 'Country', ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-6">
            {{--{!! Form::email('phone', null, ['class' => 'form-control']) !!}--}}
            <select class='form-control' name='country_id'>
                @foreach($countries as $country)
                    <option value= "{{ $country->id }}" {{ $country->id == $restaurant->country ? 'selected' :'' }}>
                        {{ $country->name }}
                    </option>
                @endforeach
            </select>
            {!! $errors->first('country', '<p class="help-block">:message</p>') !!}
        </div>
    </div>

    <div class="form-group {{ $errors->has('city') ? 'has-error' : ''}}">
        {!! Form::label('city', 'City', ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-6">
            {{--{!! Form::email('phone', null, ['class' => 'form-control']) !!}--}}
            <select class='form-control' name='city_id'>
                @foreach($cities as $city)
                    <option value= "{{ $city->id }}" {{ $city->id == $restaurant->city ? 'selected' :'' }}>
                        {{ $city->name }}
                    </option>
                @endforeach
            </select>
            {!! $errors->first('city', '<p class="help-block">:message</p>') !!}
        </div>
    </div>


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

        $("select[name='country_id']").change(function(){
            var token = $("input[name='_token']").val();
            $.ajax({
                url: "location/getCity",
                method: 'post',
                data:{
                    country_id : $(this).val(),
                    _token : token,
                },
                success: function(result){
                    var city = $("select[name='city_id']");
                    city.empty();
                    $.each(result, function( index, value ) {
                        city.append( "<option value= '" + value.id + "'> " + value.name + "</option>");
                    });

            }});
        });
    </script>

@endsection