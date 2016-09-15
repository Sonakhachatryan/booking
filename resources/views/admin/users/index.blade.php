@extends('admin.layouts.app')

@section('content')
    @include('layouts.messages')
    <div>
        <h1>Users
            @if(!$blocked)
                <a href="{{ url('/admin/users/create') }}" class="btn btn-primary btn-xs" title="Add New User">
                    <span class="glyphicon glyphicon-plus" aria-hidden="true"/>
                </a>
            @endif
        </h1>
        <div class="table">
            <table class="table table-bordered table-striped table-hover">
                <thead>
                <tr>
                    <th>S.No</th>
                    <th> Username</th>
                    <th> Email</th>
                    <th> Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach($users as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->username }}</td>
                        <td>{{ $item->email }}</td>
                        <td>
                            <a href="{{ url('/admin/users/' . $item->id) }}" class="btn btn-success btn-xs"
                               title="View User"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"/></a>
                            <a href="{{ url('/admin/users/' . $item->id . '/edit') }}" class="btn btn-primary btn-xs"
                               title="Edit User"><span class="glyphicon glyphicon-pencil" aria-hidden="true"/></a>
                            {!! Form::open([
                                'method'=>'DELETE',
                                'url' => ['/admin/users', $item->id],
                                'style' => 'display:inline'
                            ]) !!}
                            {!! Form::button('<span class="glyphicon glyphicon-trash" aria-hidden="true" title="Delete User" />', array(
                                    'type' => 'submit',
                                    'class' => 'btn btn-danger btn-xs',
                                    'title' => 'Delete User',
                                    'onclick'=>'return confirm("Confirm delete?")'
                            )) !!}
                            {!! Form::close() !!}
                            @if(!isset($item->deleted_at))
                                <a href="{{ url('/admin/users/block/' . $item->id) }}" class="btn btn-warning btn-xs"
                                   title="Block User"> <span class="glyphicon glyphicon-ban-circle" aria-hidden="true"/></a>
                            @else
                                <a href="{{ url('/admin/users/activate/' . $item->id) }}" class="btn btn-sucess btn-xs"
                                   title="Activate User"> <span class="glyphicon glyphicon-ok-circle"
                                                                aria-hidden="true"/></a>
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <div class="pagination-wrapper"> {!! $users->render() !!} </div>
        </div>

        @if(!$blocked)
            <a href="{{ url('/admin/users/blocked') }}" class="btn btn-success btn-xs" title="View Blocked Users">
                Blocked Users <span class="glyphicon  glyphicon-list-alt" aria-hidden="true"/></a>
        @else
            <a href="{{ url('/admin/users') }}" class="btn btn-success btn-xs" title="View Active Users">
                Active Users <span class="glyphicon  glyphicon-list-alt" aria-hidden="true"/></a>
        @endif
    </div>
@endsection
