<html>
    <head><title>
        csv file upload
    </title></head>
    <body>
        <form action="{{url('upload')}}" method="post" enctype="multipart/form-data">
            <input type="file" name="img" >
            <br>
@csrf
            <br>
            <button>submit</button>
        </form>
    </body>
</html>
