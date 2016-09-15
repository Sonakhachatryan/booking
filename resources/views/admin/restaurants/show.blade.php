@extends('admin.layouts.app')

@section('content')
    {{--<div class="container">--}}
    @include('layouts.messages')
    <h1>Restaurant {{ $restaurant->id }}

        <a href="{{ url('admin/restaurants/' . $restaurant->id . '/edit') }}" class="btn btn-primary btn-xs"
           title="Edit Restaurant"><span class="glyphicon glyphicon-pencil" aria-hidden="true"/></a>
        {!! Form::open([
            'method'=>'DELETE',
            'url' => ['admin/restaurants', $restaurant->id],
            'style' => 'display:inline'
        ]) !!}
        {!! Form::button('<span class="glyphicon glyphicon-trash" aria-hidden="true"/>', array(
                'type' => 'submit',
                'class' => 'btn btn-danger btn-xs',
                'title' => 'Delete Restaurant',
                'onclick'=>'return confirm("Confirm delete?")'
        ))!!}
        {!! Form::close() !!}
        @if(!isset($restaurant->deleted_at))
            <a href="{{ url('/admin/restaurants/block/' . $restaurant->id) }}" class="btn btn-warning btn-xs"
               title="Block Restaurant"> <span class="glyphicon glyphicon-ban-circle" aria-hidden="true"/></a>
        @else
            <a href="{{ url('/admin/restaurants/activate/' . $restaurant->id) }}" class="btn btn-sucess btn-xs"
               title="Activate Restaurant"> <span class="glyphicon glyphicon-ok-sign"
                                            aria-hidden="true"/></a>
        @endif
    </h1>
    <div class="table-responsive">
        <img src="{{ '/images/restaurants/' . $restaurant->avatar }}" id="user-image">
        <table class="table table-bordered table-striped table-hover">
            <tbody>
            <tr>
                <th>ID</th>
                <td>{{ $restaurant->id }}</td>
            </tr>
            <tr>
                <th> Name</th>
                <td> {{ $restaurant->name }} </td>
            </tr>
            <tr>
                <th> Email</th>
                <td> {{ $restaurant->email }} </td>
            </tr>
            <tr>
                <th> Status</th>
                <td> {{ isset($restaurant->deleted_at) ? 'Blocked' : 'Active' }} </td>
            </tr>
            </tbody>
        </table>
    </div>

    {{--</div>--}}
@endsection
