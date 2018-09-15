<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
</head>
<body>


    <form method="POST" action="" name="upload" id="upload">

        {{ csrf_field() }}

        <input type="text" name="user" value="5">
        <input type="file" id="file" name="file" maxfilesize="20">
        <input type="hidden" name="file2" id="hid">
        <button type="button" id="fb">Upload image from FB</button>
        <button type="button" id="btn">Submit</button>
        <input type="submit">
        <img id="preview">
    </form>

    <script>

        var FileUpload = {

            download: function(url, callback, error_callback = null) {
                var xhr = new XMLHttpRequest();
                xhr.onload = function() {
                    if (this.readyState === 4) {
                        if (this.status === 200) {
                            var blob = this.response;
                            callback(blob);
                        } else {
                            if (error_callback !== null) {
                                error_callback(this.response, this.status);
                            }
                        }
                    }
                };
                xhr.open('GET', url, true);
                xhr.responseType = 'blob';
                xhr.send();

            },

            addToForm: function(form_id, input_name, blob) {
                var post_data = new FormData(document.getElementById(form_id));
                post_data.append(input_name, blob);
                return post_data;
            },

            previewImageFromInput(preview_img_id, file_input_id) {
                document.getElementById(preview_img_id).src = URL.createObjectURL(document.getElementById(file_input_id).files[0]);
            },

            previewImageFromBlob(preview_image_id, blob) {
                document.getElementById(preview_image_id).src = URL.createObjectURL(blob);
            },

            attachImagePreviewEvent(preview_img_id, file_input_id) {
                document.getElementById(file_input_id).addEventListener('change', () => {
                    this.previewImageFromInput(preview_img_id, file_input_id);
                });
            }

        };

        var img_url = 'http://upload.wikimedia.org/wikipedia/commons/4/4a/Logo_2013_Google.png';
        var file_src = 0;

        FileUpload.download(img_url, function(blob) {

            document.getElementById("preview").src = URL.createObjectURL(blob);

            //var fd = new FormData(document.getElementById('upload'));
            //console.log(fd.getAll('file'));
            //RemoteFile.addToForm('upload', 'file', blob);

            //console.log(fd.getAll('file'));
        });

        function convertFileToDataURLviaFileReader(url, callback){
            var xhr = new XMLHttpRequest();

            xhr.onload = function() {
                var reader  = new FileReader();
                reader.onloadend = function () {
                    callback(reader.result);
                }
                reader.readAsDataURL(xhr.response);
            };
            xhr.open('GET', url);
            xhr.responseType = 'blob';
            xhr.send();
        }

        function convertImgToDataURLviaCanvas(url, callback, outputFormat){
            var img = new Image();
            img.crossOrigin = 'Anonymous';
            img.onload = function(){
                var canvas = document.createElement('CANVAS');
                var ctx = canvas.getContext('2d');
                var dataURL;
                canvas.height = this.height;
                canvas.width = this.width;
                ctx.drawImage(this, 0, 0);
                dataURL = canvas.toDataURL(outputFormat);
                callback(dataURL);
                canvas = null;
            };
            img.src = url;
        }

        function dataURItoBlob(dataURI) {
            // convert base64/URLEncoded data component to raw binary data held in a string
            var byteString;
            if (dataURI.split(',')[0].indexOf('base64') >= 0)
                byteString = atob(dataURI.split(',')[1]);
            else
                byteString = unescape(dataURI.split(',')[1]);

            // separate out the mime component
            var mimeString = dataURI.split(',')[0].split(':')[1].split(';')[0];

            // write the bytes of the string to a typed array
            var ia = new Uint8Array(byteString.length);
            for (var i = 0; i < byteString.length; i++) {
                ia[i] = byteString.charCodeAt(i);
            }

            return new Blob([ia], {type:mimeString});
        }



        document.getElementById('fb').addEventListener('click', function() {
            convertFileToDataURLviaFileReader(img_url, function(base64img) {
                file_src = 2;
                document.getElementById("file").value = '';
                document.getElementById("preview").src = base64img;
                console.log(dataURItoBlob(base64img).size / 1024);
            });
        });

        document.getElementById('btn').addEventListener('click', function() {
            convertFileToDataURLviaFileReader(img_url, function(base64img) {
                var xhr = new XMLHttpRequest();
                var fd = new FormData(document.forms[0]);
                if (file_src === 2) {
                    var file_blob = dataURItoBlob(base64img);
                    fd.append("file", file_blob);
                }
                xhr.open("POST", "/test");
                xhr.send(fd);
            });
        });

        document.getElementById('file').addEventListener('change', function() {
            file_src = 1;
            var reader = new FileReader();

            reader.onload = function (e) {
                // get loaded data and render thumbnail.
                document.getElementById("preview").src = e.target.result;
            };

            // read the image file as a data URL.
            reader.readAsDataURL(this.files[0]);
        });

    </script>
</body>

</html>
