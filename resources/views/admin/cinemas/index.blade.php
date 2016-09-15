@extends('admin.layouts.app')

@section('content')
    {{--<div class="container">--}}

    <h1>Cinemas
        @if(!$blocked)
            <a href="{{ url('admin/cinemas/create') }}" class="btn btn-primary btn-xs" title="Add New Cinema"><span
                        class="glyphicon glyphicon-plus" aria-hidden="true"/>
            </a>
        @endif
    </h1>
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
            @foreach($cinemas as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->email }}</td>
                    <td>
                        <a href="{{ url('/admin/cinemas/' . $item->id) }}" class="btn btn-success btn-xs"
                           title="View Cinema"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"/></a>
                        <a href="{{ url('/admin/cinemas/' . $item->id . '/edit') }}" class="btn btn-primary btn-xs"
                           title="Edit Cinema"><span class="glyphicon glyphicon-pencil" aria-hidden="true"/></a>
                        {!! Form::open([
                            'method'=>'DELETE',
                            'url' => ['/admin/cinemas', $item->id],
                            'style' => 'display:inline'
                        ]) !!}
                        {!! Form::button('<span class="glyphicon glyphicon-trash" aria-hidden="true" title="Delete Cinema" />', array(
                                'type' => 'submit',
                                'class' => 'btn btn-danger btn-xs',
                                'title' => 'Delete Cinema',
                                'onclick'=>'return confirm("Confirm delete?")'
                        )) !!}
                        @if(!isset($item->deleted_at))
                            <a href="{{ url('/admin/cinemas/block/' . $item->id) }}" class="btn btn-warning btn-xs"
                               title="Block Cinema"> <span class="glyphicon glyphicon-ban-circle"
                                                           aria-hidden="true"/></a>
                        @else
                            <a href="{{ url('/admin/cinemas/activate/' . $item->id) }}" class="btn btn-sucess btn-xs"
                               title="Activate Cinema"> <span class="glyphicon glyphicon-ok-circle"
                                                              aria-hidden="true"/></a>
                        @endif
                        {!! Form::close() !!}
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div class="pagination-wrapper"> {!! $cinemas->render() !!} </div>
        @if(!$blocked)
            <a href="{{ url('/admin/cinemas/blocked') }}" class="btn btn-success btn-xs" title="View Blocked Users">
                Blocked Cinemas <span class="glyphicon  glyphicon-list-alt" aria-hidden="true"/></a>
        @else
            <a href="{{ url('/admin/cinemas') }}" class="btn btn-success btn-xs" title="View Active Users">
                Active Cinemas <span class="glyphicon  glyphicon-list-alt" aria-hidden="true"/></a>
        @endif
    </div>

    {{--</div>--}}
@endsection
