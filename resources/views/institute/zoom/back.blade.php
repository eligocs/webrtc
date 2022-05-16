<!DOCTYPE html>

<head>
    <title>AVESTUD - Institute</title>
    <meta charset="utf-8" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ URL::to('assets/institute/images/favicon.png') }}">
    <!-- import #zmmtg-root css -->
    <link type="text/css" rel="stylesheet" href="https://source.zoom.us/1.9.5/css/bootstrap.css" />
    <link type="text/css" rel="stylesheet" href="https://source.zoom.us/1.9.5/css/react-select.css" />
    <meta name="format-detection" content="telephone=no">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{ asset('public/images/favicon.png') }}">
</head>

<body>
    <style>
        body {
            padding-top: 50px;
        }

        .loader_zoom {
            display: none;
            position: absolute;
            z-index: 999;
            border: 16px solid #f3f3f3;
            /* Light grey */
            border-top: 16px solid #3498db;
            /* Blue */
            border-radius: 50%;
            width: 120px;
            height: 120px;
            animation: spin 2s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

    </style>
    <div class="loader_zoom"></div>
    <div id="zoom_meeting_section" class="navbar navbar-inverse navbar-fixed-top">
        <div class="container">
            <div class="navbar-header">
                <a class="navbar-brand" href="{{ url('/') }}">Home</a>
            </div>
            {{-- <div id="navbar">
                <a href="{{ url('/institute.zoom.list_meetting') }}" class="btn btn-success" style='float:right;'><i
                        class="fa fa-arrow-left"></i> Go back</a>
            </div> --}}
            <!--/.navbar-collapse -->
        </div>
    </div>

    <div>
        <h1> You End This Meeting </h1>
    </div>
</body>

</html>
