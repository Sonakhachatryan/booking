<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>HTML5 File Drag &amp; Drop API</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
</head>
<body>
<form id="upload" action="upload.php" method="POST" enctype="multipart/form-data">

    <fieldset>
        <legend>HTML File Upload</legend>

        <input type="hidden" id="MAX_FILE_SIZE" name="MAX_FILE_SIZE" value="300000" />

        <div>
            <label for="fileselect">Files to upload:</label>
            <input type="file" id="fileselect" name="fileselect[]" multiple="multiple" />
        </div>

        <div id="submitbutton">
            <button type="submit">Upload Files</button>
        </div>

    </fieldset>

</form>

<div id="progress"></div>

<div id="messages">
    <p>Status Messages</p>
</div>


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
                //UploadFile(f);
            }

        }


        // output file information
        function ParseFile(file) {

            // display an image
            if (file.type.indexOf("image") == 0) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('body').append(
                            "<p><strong>" + file.name + ":</strong><br />" +
                            '<img src="' + e.target.result + '" /></p>'
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
                xhr.open("POST", $("#upload").action, true);
                xhr.setRequestHeader("X_FILENAME", file.name);
                xhr.send(file);

            }

        }

        // file select
        fileselect.addEventListener("change", FileSelectHandler, false);
    })();

</script>
</body>
</html>