<html>
 <head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Laravel 5.8 - Multiple File Upload with Progressbar using Ajax jQuery</title>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
        <script src="http://malsup.github.com/jquery.form.js"></script>
 </head>
 <body>
  <div class="container">    
     <br />
     <h3 align="center">Laravel 5.8 - Multiple File Upload with Progressbar using Ajax jQuery</h3>
     <br />
     <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Upload Multiple Images in Laravel 5.8</h3>
                </div>
                <div class="panel-body">
                    <br />
                    <form method="post" action="/upload" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-3" align="right"><h4>Select Images</h4></div>
                            <div class="col-md-6">
                                <input type="file" name="file[]" id="file" accept="image/*" multiple />
                            </div>
                            <div class="col-md-3">
                                <input type="submit" name="upload" value="Upload" class="btn btn-success" />
                            </div>
                        </div>
                    </form>
                    <br />
                    <div class="progress">
                        <div class="progress-bar" aria-valuenow="" aria-valuemin="0" aria-valuemax="100" style="width: 0%">
                            0%
                        </div>
                    </div>
                    <br />
                    <div id="success" class="row">

                    </div>
                    <br />
                </div>
            </div>
  </div>
 </body>
</html>

<script>
$(document).ready(function(){
    $('form').ajaxForm({
        beforeSend:function(){
            $('#success').empty();
            $('.progress-bar').text('0%');
            $('.progress-bar').css('width', '0%');
        },
        uploadProgress:function(event, position, total, percentComplete){
            $('.progress-bar').text(percentComplete + '0%');
            $('.progress-bar').css('width', percentComplete + '0%');
        },
        success:function(data)
        {
            if(data.success)
            {
                $('#success').html('<div class="text-success text-center"><b>'+data.success+'</b></div><br /><br />');
                $('#success').append(data.image);
                $('.progress-bar').text('Uploaded');
                $('.progress-bar').css('width', '100%');
            }
        }
    });
});
</script>