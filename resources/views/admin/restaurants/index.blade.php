@extends('admin.layouts.app')

@section('content')
{{--<div class="container">--}}
@include('layouts.messages')
    <h1>Restaurants
        @if(!$blocked)
        <a href="{{ url('/admin/restaurants/create') }}" class="btn btn-primary btn-xs" title="Add New Restaurant">
            <span class="glyphicon glyphicon-plus" aria-hidden="true"/>
        </a>
        @endif
    </h1>
    <div class="table">
        <table class="table table-bordered table-striped table-hover">
            <thead>
                <tr>
                    <th>S.No</th><th> Name </th><th> Email </th><th>Actions</th>
                </tr>
            </thead>
            <tbody>
            @foreach($restaurants as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->name }}</td><td>{{ $item->email }}</td>
                    <td>
                        <a href="{{ url('/admin/restaurants/' . $item->id) }}" class="btn btn-success btn-xs" title="View Restaurant"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"/></a>
                        <a href="{{ url('/admin/restaurants/' . $item->id . '/edit') }}" class="btn btn-primary btn-xs" title="Edit Restaurant"><span class="glyphicon glyphicon-pencil" aria-hidden="true"/></a>
                        {!! Form::open([
                            'method'=>'DELETE',
                            'url' => ['/admin/restaurants', $item->id],
                            'style' => 'display:inline'
                        ]) !!}
                            {!! Form::button('<span class="glyphicon glyphicon-trash" aria-hidden="true" title="Delete Restaurant" />', array(
                                    'type' => 'submit',
                                    'class' => 'btn btn-danger btn-xs',
                                    'title' => 'Delete Restaurant',
                                    'onclick'=>'return confirm("Confirm delete?")'
                            )) !!}
                        {!! Form::close() !!}
                        @if(!isset($item->deleted_at))
                            <a href="{{ url('/admin/restaurants/block/' . $item->id) }}" class="btn btn-warning btn-xs"
                               title="Block Restaurant"> <span class="glyphicon glyphicon-ban-circle" aria-hidden="true"/></a>
                        @else
                            <a href="{{ url('/admin/restaurants/activate/' . $item->id) }}" class="btn btn-sucess btn-xs"
                               title="Activate Restaurants"> <span class="glyphicon glyphicon-ok-circle"
                                                            aria-hidden="true"/></a>
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div class="pagination-wrapper"> {!! $restaurants->render() !!} </div>
        @if(!$blocked)
            <a href="{{ url('/admin/restaurants/blocked') }}" class="btn btn-success btn-xs" title="View Blocked Users">
                Blocked Restaurants <span class="glyphicon  glyphicon-list-alt" aria-hidden="true"/></a>
        @else
            <a href="{{ url('/admin/restaurants') }}" class="btn btn-success btn-xs" title="View Active Users">
                Active Restaurants <span class="glyphicon  glyphicon-list-alt" aria-hidden="true"/></a>
        @endif
    </div>

{{--</div>--}}
@endsection
