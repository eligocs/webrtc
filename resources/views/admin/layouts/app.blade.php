<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>AVESTUD - Admin</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta content="AVESTUD - Admin" name="description" />
  <meta content="Coderthemes" name="author" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <!-- App favicon -->
  <link rel="shortcut icon" href="{{ URL::to('assets/admin/images/favicon.png')}}">

  <link rel="stylesheet" href="{{ URL::to('assets/admin/libs/chartist/chartist.min.css')}}">
  <!-- Custom box css -->
  <link href="{{ URL::to('assets/admin/libs/custombox/custombox.min.css')}}" rel="stylesheet">

  <!-- Plugins css -->
  <link href="{{ URL::to('assets/admin/libs/bootstrap-tagsinput/bootstrap-tagsinput.css')}}" rel="stylesheet" />
  <link href="{{ URL::to('assets/admin/libs/switchery/switchery.min.css')}}" rel="stylesheet" type="text/css" />

  <link href="{{ URL::to('assets/admin/libs/multiselect/multi-select.css')}}" rel="stylesheet" type="text/css" />
  <link href="{{ URL::to('assets/admin/libs/select2/select2.min.css')}}" rel="stylesheet" type="text/css" />
  <link href="{{ URL::to('assets/admin/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.css')}}"
    rel="stylesheet" />
  <link href="{{ URL::to('assets/admin/libs/switchery/switchery.min.css')}}" rel="stylesheet" />
  <link href="{{ URL::to('assets/admin/libs/bootstrap-timepicker/bootstrap-timepicker.min.css')}}" rel="stylesheet">
  <link href="{{ URL::to('assets/admin/libs/bootstrap-colorpicker/bootstrap-colorpicker.min.css')}}" rel="stylesheet">
  <link href="{{ URL::to('assets/admin/libs/bootstrap-datepicker/bootstrap-datepicker.css')}}" rel="stylesheet">
  <link href="{{ URL::to('assets/admin/libs/bootstrap-daterangepicker/daterangepicker.css')}}" rel="stylesheet">
  <!-- Chartist Chart CSS -->
  <link rel="stylesheet" href="{{ URL::to('assets/admin/libs/chartist/chartist.min.css')}}">
  <!-- App css -->
  <link href="{{ URL::to('assets/admin/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
  <link href="{{ URL::to('assets/admin/css/icons.min.css')}}" rel="stylesheet" type="text/css" />
  <link href="{{ URL::to('assets/admin/css/app.min.css')}}" rel="stylesheet" type="text/css" />
  <link href="{{ URL::to('assets/admin/css/fonts.css')}}" rel="stylesheet" type="text/css" />
  <link href="{{ URL::to('assets/admin/css/jquery.fancybox.css')}}" rel="stylesheet" type="text/css" />
  <link href="{{ URL::to('assets/admin/css/style.css')}}" rel="stylesheet" type="text/css" />

  @stack('css')
</head>

<body>

  @include('admin.layouts.header')

  <!-- Start Page Content here -->

  <div class="content-page">
    <div class="content">

      @yield('content')

    </div> <!-- content -->

    @include('admin.layouts.footer')

</body>

</html>