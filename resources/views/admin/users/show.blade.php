@extends('admin.layouts.app')

@section('content')
    {{--<div class="container">--}}
    @include('layouts.messages')
        <h1>User {{ $user->id }}
            <a href="{{ url('/admin/users/' . $user->id . '/edit') }}" class="btn btn-primary btn-xs" title="Edit User"><span
                        class="glyphicon glyphicon-pencil" aria-hidden="true"/></a>
            {!! Form::open([
                'method'=>'DELETE',
                'url' => ['admin/users', $user->id],
                'style' => 'display:inline'
            ]) !!}
            {!! Form::button('<span class="glyphicon glyphicon-trash" aria-hidden="true"/>', array(
                    'type' => 'submit',
                    'class' => 'btn btn-danger btn-xs',
                    'title' => 'Delete User',
                    'onclick'=>'return confirm("Confirm delete?")'
            ))!!}
            {!! Form::close() !!}
            @if(!isset($user->deleted_at))
                <a href="{{ url('/admin/users/block/' . $user->id) }}" class="btn btn-warning btn-xs"
                   title="Block User"> <span class="glyphicon glyphicon-ban-circle" aria-hidden="true"/></a>
            @else
                <a href="{{ url('/admin/users/activate/' . $user->id) }}" class="btn btn-sucess btn-xs"
                   title="Activate User"> <span class="glyphicon glyphicon-ok-sign"
                                                aria-hidden="true"/></a>
            @endif
        </h1>
        <div class="table-responsive">
            <img src="{{ $user->provider ? $user->avatar : '/images/users/' . $user->avatar }}" id="user-image">
            <table class="table table-bordered table-striped table-hover">
                <tbody>
                <tr>
                    <th>ID</th>
                    <td>{{ $user->id }}</td>
                </tr>
                <tr>
                    <th> Username</th>
                    <td> {{ $user->username }} </td>
                </tr>
                <tr>
                    <th> Email</th>
                    <td> {{ $user->email }} </td>
                </tr>
                <tr>
                    <th> Mobile</th>
                    <td> {{ $user->mobile }} </td>
                </tr>
                <tr>
                    <th> Provider</th>
                    <td> {{ $user->provider ? $user->provider : 'Booking' }} </td>
                </tr>
                <tr>
                    <th> Status</th>
                    <td> {{ isset($user->deleted_at) ? 'Blocked' : 'Active' }} </td>
                </tr>
                </tbody>
            </table>
        </div>
    {{--</div>--}}
@endsection
