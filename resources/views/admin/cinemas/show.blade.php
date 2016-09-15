@extends('admin.layouts.app')

@section('content')
    {{--<div class="container">--}}

    <h1>Cinema {{ $cinema->id }}
        <a href="{{ url('/admin/cinemas/' . $cinema->id . '/edit') }}" class="btn btn-primary btn-xs"
           title="Edit Cinema"><span class="glyphicon glyphicon-pencil" aria-hidden="true"/></a>
        {!! Form::open([
            'method'=>'DELETE',
            'url' => ['admin/cinemas', $cinema->id],
            'style' => 'display:inline'
        ]) !!}
        {!! Form::button('<span class="glyphicon glyphicon-trash" aria-hidden="true"/>', array(
                'type' => 'submit',
                'class' => 'btn btn-danger btn-xs',
                'title' => 'Delete Cinema',
                'onclick'=>'return confirm("Confirm delete?")'
        ))!!}
        @if(!isset($cinema->deleted_at))
            <a href="{{ url('/admin/cinemas/block/' . $cinema->id) }}" class="btn btn-warning btn-xs"
               title="Block Cinema"> <span class="glyphicon glyphicon-ban-circle" aria-hidden="true"/></a>
        @else
            <a href="{{ url('/admin/cinemas/activate/' . $cinema->id) }}" class="btn btn-sucess btn-xs"
               title="Activate Cinema"> <span class="glyphicon glyphicon-ok-sign"
                                            aria-hidden="true"/></a>
        @endif
        {!! Form::close() !!}
    </h1>
    <div class="table-responsive">
        <img src="{{ '/images/cinemas/' . $cinema->avatar }}" id="user-image">
        <table class="table table-bordered table-striped table-hover">
            <tbody>
            <tr>
                <th>ID</th>
                <td>{{ $cinema->id }}</td>
            </tr>
            <tr>
                <th> Name </th>
                <td> {{ $cinema->name }} </td>
            </tr>
            <tr>
                <th> Email</th>
                <td> {{ $cinema->email }} </td>
            </tr>
            <tr>
                <th> Status</th>
                <td> {{ isset($cinema->deleted_at) ? 'Blocked' : 'Active' }} </td>
            </tr>
            </tbody>
        </table>
    </div>

    {{--</div>--}}
@endsection
