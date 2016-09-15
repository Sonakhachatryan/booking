@extends('admin.layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ url('/jQuery-File-Upload/css/style.css') }}">
    <link rel="stylesheet" href="{{ url('/jQuery-File-Upload/css/jquery.fileupload.css') }}">
    @endsection
@section('content')
    @include('layouts.messages')
    <h1> Logo </h1>
    {!! Form::model($restaurant, [
       'method' => 'post',
       'url' => ['/admin/restaurant/avatar'],
       'class' => 'form-horizontal',
       'files' => true
   ]) !!}

    <div class="form-group{{ $errors->has('avatar') ? ' has-error' : '' }}">
        {!! Form::label('avatar', 'Avatar', ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-md-6">
            <img src="{{ url("images/restaurants/",$restaurant->avatar) }}" id="user-image">
            <input id="avatar" type="file" class="form-control" name="avatar" value="{{ old('avatar') }}" autofocus>
            @if ($errors->has('avatar'))
                <span class="help-block"> <strong>{{ $errors->first('avatar') }}</strong> </span>
            @endif
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-offset-3 col-sm-3">
            {!! Form::submit('Save', ['class' => 'btn btn-primary form-control']) !!}
        </div>
    </div>

    {!! Form::close() !!}

    <h1> My images </h1>
    <table class="table table-bordered table-striped table-hover">
        <thead>
        <tr>
            <th>S.No</th>
            <th> Image </th>
            <th> Name </th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        {{--{{ dd($restaurant->images->lastPage()) }}--}}
        @foreach($restaurant->images as $item)
            <tr>
                <td>{{ $loop->iteration + ($_GET['page']-1)*$restaurant->images->perPage() }}</td>
                <td> <img class = "upload-image" src="{{ url('images/restaurants/' . $item->url) }}" /></td>
                <td>{{ $item->url }}</td>
                <td>
                    {!! Form::open([
                        'method'=>'get',
                        'url' => ['/admin/restaurant/image/remove', $item->id],
                        'style' => 'display:inline'
                    ]) !!}
                    {!! Form::button('<span class="glyphicon glyphicon-trash" aria-hidden="true" title="Delete Cinema" />', array(
                            'type' => 'submit',
                            'class' => 'btn btn-danger btn-xs',
                            'title' => 'Delete Cinema',
                            'onclick'=>'return confirm("Confirm delete?")'
                    )) !!}
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <div class="pagination-wrapper"> {!! $restaurant->images->appends(['sort' => 'id'])->render() !!}
    </div>
    {{--</div>--}}
    {{--<div class="container">--}}
        <h1> Add image </h1>
    {!! Form::model($restaurant, [
      'method' => 'post',
      'url' => ['/admin/restaurant/images/add'],
      'files' => true,
       'id' => "upload"
  ]) !!}

    {{--<form id="upload" url="{{ url('/admin/restaurant/images/add') }}" method="POST" enctype="multipart/form-data">--}}

        <fieldset>
            <input type="hidden" id="MAX_FILE_SIZE" name="MAX_FILE_SIZE" value="300000" />
            {{--<input type="hidden" id="token" name="_token" value="{{ csrf_token() }}" />--}}

            <div>
                <label for="fileselect" class="btn btn-success">Select Images</label>
                <input type="file" id="fileselect" name="fileselect[]" multiple="multiple" class="hidden"/>
            </div>

            <table id="images" class="no-border-web table table-striped table-hover"></table>

            <div id="submitbutton">
                <button type="submit">Upload Files</button>
            </div>

        </fieldset>

    {{--</form>--}}
    {!! Form::close() !!}
    <div id="progress"></div>
    {{--</div>--}}
@endsection

@section('script')
        <script>
        function readURL(input) {
            console.log(111);
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('#user-image').attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#avatar").change(function () {
            readURL(this);
        });
    </script>

        <script>
            (function() {

                var fileselect = document.getElementById("fileselect");
                var submitbutton = document.getElementById("submitbutton");

                // file selection
                function FileSelectHandler(e) {

                    // fetch FileList object
                    var files = e.target.files || e.dataTransfer.files;

                    // process all File objects
                    for (var i = 0, f; f = files[i]; i++) {
                        ParseFile(f);
//                        UploadFile(f);
                    }

                }


                // output file information
                function ParseFile(file) {

                    // display an image
                    if (file.type.indexOf("image") == 0) {
                        var reader = new FileReader();
                        reader.onload = function(e) {
                            $('#images').append(
                                    "<tr class='border-bottom'><td>" +
                                    '<img class = "upload-image" src="' + e.target.result + '" /></td>' +
                                    '<td><strong>' + file.name + '</strong></td>' +
                                    '<td><strong>' + file.size + ' Kb </strong></td>' +
                                    '<tr/>'
                            );
                        }
                        reader.readAsDataURL(file);
                    }

                }


                // upload JPEG files
                function UploadFile(file) {

                    var xhr = new XMLHttpRequest();
                    if (xhr.upload && file.type == "image/jpeg" && file.size <= $("#MAX_FILE_SIZE").value) {

                        // create progress bar
                        var o = $("#progress");
                        var progress = o.appendChild(document.createElement("p"));
                        progress.appendChild(document.createTextNode("upload " + file.name));


                        // progress bar
                        xhr.upload.addEventListener("progress", function(e) {
                            var pc = parseInt(100 - (e.loaded / e.total * 100));
                            progress.style.backgroundPosition = pc + "% 0";
                        }, false);

                        // file received/failed
                        xhr.onreadystatechange = function(e) {
                            if (xhr.readyState == 4) {
                                progress.className = (xhr.status == 200 ? "success" : "failure");
                            }
                        };

                        // start upload
//                        xhr.open("POST", $("#upload").action, true);
//                        xhr.setRequestHeader("X_FILENAME", file.name);
//                        var data ={
//                            file:file,
//                            _token: $('#token').val(),
//                        }
//                        xhr.send(data);

                    }

                }

                // file select
                fileselect.addEventListener("change", FileSelectHandler, false);
            })();

        </script>


@endsection