<!DOCTYPE html>

<head>
    <title>AVESTUD - Student</title>
    <meta charset="utf-8" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ URL::to('assets/institute/images/favicon.png') }}">
    <link type="text/css" rel="stylesheet" href="https://source.zoom.us/1.7.7/css/bootstrap.css" />
    <link type="text/css" rel="stylesheet" href="https://source.zoom.us/1.7.7/css/react-select.css" />
    <meta name="format-detection" content="telephone=no">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{ asset('public/images/favicon.png') }}">
    <script>
        var WEBURL = "{{ url('/') }}";
        var LEAVEURL = "{{ url('admin/zoom/viewMeeting/' . $meeting_id) }}";
        console.log(LEAVEURL)
    </script>
</head>

<body>
    <style>
        body {
            padding-top: 50px;
        }
        button.third-part-app-info__button-icon.ax-outline-blue {
                display: none;
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
@php
$value = $_GET['get'];
// dd($value);
@endphp
    <div class="loader_zoom"></div>
    <div id="zoom_meeting_section" class="navbar navbar-inverse navbar-fixed-top">
        <div class="container">
            {{-- <div class="navbar-header">
                <a class="navbar-brand" href="{{ url('/') }}">Join Meeting</a>
            </div> --}}
            <div id="navbar">

                <form class="navbar-form navbar-center" id="meeting_form">
                    <input type="hidden" id="classId" value="{{ $value }}">
                    <div class="form-group">
                        <input type="text" name="display_name" id="display_name" value="{{ $user->email }}"
                            placeholder="Name" class="form-control" required readonly>
                    </div>
                    <div class="form-group">
                        <input type="hidden" name="meeting_number" id="meeting_number" value="{{ $meeting_id }}"
                            placeholder="Meeting Number" class="form-control">
                        <input type="hidden" name="prsnl" id="prsnl" value="@if (!empty($get)) {{ $get }} @endif">
                    </div>
                    <div class="form-group">
                        <input type="hidden" name="meeting_pwd" id="meeting_pwd" value="{{ $password }}"
                            placeholder="Meeting Password" class="form-control">
                    </div>
                    <button type="submit" class="btn btn-primary" id="join_meeting_student">Join</button>
                    <a href="{{ url("/student/subject-detail/{$value}") }}" class="btn btn-success"
                        style='float:right;'><i class="fa fa-arrow-left"></i> Go back</a>
                </form>
            </div>
            <!--/.navbar-collapse -->
        </div>
    </div>


    <script src="https://source.zoom.us/1.7.7/lib/vendor/jquery.min.js"></script>
    <script src="https://source.zoom.us/1.7.7/lib/vendor/react.min.js"></script>
    <script src="https://source.zoom.us/1.7.7/lib/vendor/react-dom.min.js"></script>
    <script src="https://source.zoom.us/1.7.7/lib/vendor/redux.min.js"></script>
    <script src="https://source.zoom.us/1.7.7/lib/vendor/redux-thunk.min.js"></script>
    <script src="https://source.zoom.us/1.7.7/lib/vendor/lodash.min.js"></script>
    <!-- <script src="https://source.zoom.us/zoom-meeting-1.7.7.min.js"></script> -->
    <script src="https://source.zoom.us/zoom-meeting-1.9.6.min.js"></script>
    <script src="{{ asset('studentzoom-js/tool.js') }}"></script>
    <script src="{{ asset('studentzoom-js/zoom_join_meeting.js') }}"></script>

    <script>

    </script>
</body>

</html>
