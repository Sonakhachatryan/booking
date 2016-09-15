@extends('admin.layouts.app')

@section('content')
    {{--<div class="container">--}}
    @include('layouts.messages')
        <h1>Admin {{ $editing_admin->id }}
            <a href="{{ url('admin/admins/' . $editing_admin->id . '/edit') }}" class="btn btn-primary btn-xs"
               title="Edit Admin"><span class="glyphicon glyphicon-pencil" aria-hidden="true"/></a>
            {!! Form::open([
                'method'=>'DELETE',
                'url' => ['/admin/admins', $editing_admin->id],
                'style' => 'display:inline'
            ]) !!}
            {!! Form::button('<span class="glyphicon glyphicon-trash" aria-hidden="true"/>', array(
                    'type' => 'submit',
                    'class' => 'btn btn-danger btn-xs',
                    'title' => 'Delete Admin',
                    'onclick'=>'return confirm("Confirm delete?")'
            ))!!}
            {!! Form::close() !!}
            @if(!isset($editing_admin->deleted_at))
                <a href="{{ url('/admin/admins/block/' . $editing_admin->id) }}" class="btn btn-warning btn-xs"
                   title="Block User"> <span class="glyphicon glyphicon-ban-circle" aria-hidden="true"/></a>
            @else
                <a href="{{ url('/admin/admins/activate/' . $editing_admin->id) }}" class="btn btn-sucess btn-xs"
                   title="Activate User"> <span class="glyphicon glyphicon-ok-sign"
                                                aria-hidden="true"/></a>
            @endif
        </h1>

        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover">
                <tbody>
                <tr>
                    <th>ID</th>
                    <td>{{ $editing_admin->id }}</td>
                </tr>
                <tr>
                    <th> Name</th>
                    <td> {{ $editing_admin->name }} </td>
                </tr>
                <tr>
                    <th> Email</th>
                    <td> {{ $editing_admin->email }} </td>
                </tr>
                <tr>
                    <th> Status </th>
                    <td> {{ isset($editing_admin->deleted_at) ? 'Blocked' : 'Active' }} </td>
                </tr>
                </tbody>
            </table>
        </div>

    {{--</div>--}}
@endsection
