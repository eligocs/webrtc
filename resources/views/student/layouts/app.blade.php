<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>AVESTUD - Student</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="View Applicationport" content="width=device-width, initial-scale=1.0">
    <meta content="AVESTUD - Student" name="description" />
    <meta content="Coderthemes" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{URL::to('assets/student/images/favicon.png')}}">

    {{--  --}}



    {{--  --}}


    <!-- App css -->
    <link href="{{URL::to('assets/student/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" />

    <link href="{{URL::to('assets/student/css/icons.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{URL::to('assets/student/css/app.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{URL::to('assets/student/css/fonts.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{URL::to('assets/student/css/jquery.fancybox.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{URL::to('assets/student/css/style.css')}}" rel="stylesheet" type="text/css" />
    @yield('css')
</head>

<body>
    <!-- Begin page -->
    <div id="wrapper">

        @include('student.layouts.partials.header')
        @include('student.layouts.partials.leftsidebar')

        <!-- ============================================================== -->
        <!-- Start Page Content here -->
        <!-- ============================================================== -->
        <div class="content-page">
            <div class="content">
                <!-- Start Content-->
                @yield('content')

                @include('student.layouts.partials.footer')
            </div>
            <!-- ============================================================== -->
            <!-- End Page content -->
            <!-- ============================================================== -->
        </div>
        <!-- END wrapper -->

        <!-- /Right-bar -->
        <!-- Right bar overlay-->
    </div>
    <div class="rightbar-overlay"></div>

    {{-- js --}}

    <!-- Vendor js -->
    <script src="{{URL::to('assets/student/js/vendor.min.js')}}"></script>


    {{-- <!-- App js -->
    <script src="{{URL::to('assets/student/js/app.min.js')}}"></script> --}}

    {{-- /js --}}
    @yield('js')
</body>

</html>