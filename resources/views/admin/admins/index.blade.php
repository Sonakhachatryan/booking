@extends('admin.layouts.app')

@section('content')
    {{--<div class="container">--}}

        <h1>Admins
            @if(!$blocked)
                <a href="{{ url('admin/admins/create') }}" class="btn btn-primary btn-xs" title="Add New Admin">
                    <span class="glyphicon glyphicon-plus" aria-hidden="true"/>
                </a>
            @endif
        </h1>
    @include('layouts.messages')
        <div class="table">
            <table class="table table-bordered table-striped table-hover">
                <thead>
                <tr>
                    <th>S.No</th>
                    <th> Name</th>
                    <th> Email</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach($admins as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->email }}</td>
                        <td>
                            <a href="{{ url('/admin/admins/' . $item->id) }}" class="btn btn-success btn-xs"
                               title="View Admin"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"/></a>
                            <a href="{{ url('/admin/admins/' . $item->id . '/edit') }}" class="btn btn-primary btn-xs"
                               title="Edit Admin"><span class="glyphicon glyphicon-pencil" aria-hidden="true"/></a>
                            {!! Form::open([
                                'method'=>'DELETE',
                                'url' => ['/admin/admins', $item->id],
                                'style' => 'display:inline'
                            ]) !!}
                            {!! Form::button('<span class="glyphicon glyphicon-trash" aria-hidden="true" title="Delete Admin" />', array(
                                    'type' => 'submit',
                                    'class' => 'btn btn-danger btn-xs',
                                    'title' => 'Delete Admin',
                                    'onclick'=>'return confirm("Confirm delete?")'
                            )) !!}
                            {!! Form::close() !!}
                            @if(!isset($item->deleted_at))
                                <a href="{{ url('/admin/admins/block/' . $item->id) }}" class="btn btn-warning btn-xs"
                                   title="Block User"> <span class="glyphicon glyphicon-ban-circle" aria-hidden="true"/></a>
                            @else
                                <a href="{{ url('/admin/admins/activate/' . $item->id) }}" class="btn btn-sucess btn-xs"
                                   title="Activate User"> <span class="glyphicon glyphicon-ok-circle"
                                                                aria-hidden="true"/></a>
                            @endif

                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <div class="pagination-wrapper"> {!! $admins->render() !!} </div>
        </div>
        @if(!$blocked)
            <a href="{{ url('/admin/admins/blocked') }}" class="btn btn-success btn-xs" title="View Blocked Admins">
                Blocked Admins <span class="glyphicon  glyphicon-list-alt" aria-hidden="true"/></a>
        @else
            <a href="{{ url('/admin/admins') }}" class="btn btn-success btn-xs" title="View Active Admins">
                Active Admins <span class="glyphicon  glyphicon-list-alt" aria-hidden="true"/></a>
        @endif
    {{--</div>--}}
@endsection
