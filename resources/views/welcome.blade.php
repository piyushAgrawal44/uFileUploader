<!DOCTYPE html>
<html >
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

        <!-- Styles -->
        <style>
            
        </style>

        <!--  -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    </head>
    <body class="">
        
       <div class="container-fluid d-flex justify-content-center align-items-center bg-dark" style="height: 100vh; width:100%; ">
            <div class="card" style="margin:auto; max-width: 18rem;">
                <div class="card-body ">
                    <h5 class="card-title  mb-2">Upload Your File</h5>
                    <div class="my-3">
                        <input type="file" class="form-control" id="browsefile" >
                    </div>

                    <p class="mb-0">Progress:</p>
                    <div class="progress" >
                    
                        <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" id="p-bar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">0%</div>
                    </div>
                </div>
            </div>

           
        </div>
       

       


        <script src="https://cdnjs.cloudflare.com/ajax/libs/resumable.js/1.1.0/resumable.min.js"></script>
        <script>
           let fileUpload=$('#browsefile');

            let  resumable = new Resumable({

                chunkSize: 3 * 1024 * 1024, // 1MB
                simultaneousUploads: 3,
                testChunks: false,
                throttleProgressCallbacks: 1,
                target: "{{route('upload')}}",
                query:{_token : "{{csrf_token()}}"},
                fileType: ['mp4','zip','pdf','png','exe'],
                headers: {
                    'Accept': 'application/json'
                }
            });

        // Resumable.js isn't supported, fall back on a different method
            if (!resumable.support) {
                console.log("error");
            } else {
               
                // $fileUploadDrop.show();
                resumable.assignBrowse(fileUpload[0]);
                // resumable.assignBrowse(fileUploadDrop[0]);

                // Handle file add event
                resumable.on('fileAdded', function (file) {
                    console.log("uploading");
                    resumable.upload();
                });

                resumable.on('fileSuccess', function (file, message) {
                    // Reflect that the file upload has completed
                   console.log(message);
                   alert("file uploaded");
                   window.location.reload();
                });

                resumable.on('fileError', function (file, message) {
                    // Reflect that the file upload has resulted in error
                    console.log(message)
                });
                
                resumable.on('fileProgress', function (file) {
                    let percentage=resumable.progress() * 100;
                    percentage=percentage.toFixed(2); // fixed by 2 decimal
                    $('#p-bar').data('aria-valuenow',percentage)
                    $('#p-bar').css({width: percentage + '%'});
                    $('#p-bar').text(percentage+"%");
                });
            }

        

        </script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    </body>
</html>
