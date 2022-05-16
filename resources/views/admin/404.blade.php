<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>AVESTUD - {{$status ?? ''}} Error</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta content="Admin Dashboard" name="description" />
        <meta content="ThemeDesign" name="author" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />

        <link rel="shortcut icon" href="{{ URL::to('assets/admin/images/favicon.png')}}">
        <link href="{{ URL::to('assets/admin/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css">
        <link href="{{ URL::to('assets/admin/css/icons.css')}}" rel="stylesheet" type="text/css"> 
        <link href="{{ URL::to('assets/admin/css/style.css')}}" rel="stylesheet" type="text/css">
    </head>
    <body>
        <!-- Begin page -->
        <div class="accountbg"></div>
        <div class="wrapper-page">
            <div class="ex-page-content text-center">
                <h1 class="text-white">{{$status ?? ''}}!</h1>
                <h2 class="text-white">{{$message ?? ''}}</h2><br>
                <a class="btn btn-primary waves-effect waves-light" href="{{route('admin.institute-applications.index')}}">Back to Dashboard</a>
            </div>
        </div>        
    </body>
</html>