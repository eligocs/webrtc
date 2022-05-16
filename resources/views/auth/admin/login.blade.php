<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <title>AVESTUD - Admin</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="View Applicationport" content="width=device-width, initial-scale=1.0">
  <meta content="AVESTUD - Admin" name="description" />
  <meta content="Coderthemes" name="author" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <!-- App favicon -->
  <link rel="shortcut icon" href="{{URL::to('assets/admin/images/favicon.png')}}">

  <!-- App css -->
  <link href="{{URL::to('assets/admin/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
  <link href="{{URL::to('assets/admin/css/icons.min.css')}}" rel="stylesheet" type="text/css" />
  <link href="{{URL::to('assets/admin/css/app.min.css')}}" rel="stylesheet" type="text/css" />
  <link href="{{URL::to('assets/admin/css/fonts.css')}}" rel="stylesheet" type="text/css" />
  <link href="{{URL::to('assets/admin/css/style.css')}}" rel="stylesheet" type="text/css" />
  <style>
    .input-group-addon {
      padding: .5rem .75rem;
      margin-bottom: 0;
      font-size: 1rem;
      font-weight: 400;
      line-height: 1.25;
      color: #495057;
      text-align: center;
      background-color: #e9ecef;
      border: 1px solid rgba(0, 0, 0, .15);
      border-radius: .25rem;
    }

    a,
    a:hover {
      color: #333
    }
  </style>
</head>


<body class="authentication-bg">

  <div class="account-pages mt-5 mb-5">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6 col-xl-5">
          <div class="text-center mb-4">
            <a href="/">
              <span><img src="{{URL::to('assets/admin/images/logo-dark.png')}}" alt="" height="60"></span>
            </a>

          </div>
          <div class="card">

            <div class="card-body p-4">

              <div class="text-center mb-4">
                <h4 class="text-uppercase mt-0">Sign In</h4>
              </div>
              @if(Session::has('login_error'))
              <div class="alert alert-danger error">
                {{ Session::get('login_error')}}
              </div>
              @endif
              @if($errors->any())
              <ul class="alert alert-danger error">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
              </ul>
              @endif
              @include('admin.layouts.success')

              <form action="{{ route('login') }}" method="POST">

                @csrf
                <div class="form-group mb-3">
                  <label for="emailaddress">Email address</label>

                  <input class="form-control" name="email" value="{{ old('email') }}" autocomplete="email" autofocus
                    type="email" placeholder="Enter Your Email">
                </div>

                <div class="form-group mb-3">
                  <label for="password">Password</label>
                  <div class="input-group" id="show_hide_password">
                    <input class="form-control" type="password" name="password" id="password"
                      placeholder="Enter your password">
                    <div class="input-group-addon">
                      <a href="javascript:void(0)"><i class="fa fa-eye-slash" aria-hidden="true"></i></a>
                    </div>
                  </div>
                </div>

                <div class="form-group mb-3">
                  <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" id="checkbox-signin" checked>
                    <label class="custom-control-label" for="checkbox-signin">Remember me</label>
                  </div>
                </div>

                <div class="form-group mb-0 text-center">
                  <button class="btn btn-theme w-100 btn-block" type="submit"> Log In </button>
                </div>

              </form>

            </div> <!-- end card-body -->
          </div>
          <!-- end card -->

          <div class="row mt-3">
            <div class="col-12 text-center">

              <p class="black">Don't have an account? <a href="{{url('/')}}" class="text-dark ml-1"><b>Sign
                    Up</b></a></p>
            </div> <!-- end col -->
          </div>
          <!-- end row -->

        </div> <!-- end col -->
      </div>
      <!-- end row -->
    </div>
    <!-- end container -->
  </div>
  <!-- end page -->

  <!-- Vendor js -->
  <script src="{{URL::to('assets/js/vendor.min.js')}}"></script>

  <!-- App js -->
  <script src="{{URL::to('assets/js/app.min.js')}}"></script>
  <script src="https://code.jquery.com/jquery-3.5.1.min.js"
    integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
  <script>
    $(document).ready(function() {
  $("#show_hide_password a").on('click', function(event) {
  event.preventDefault();
  if($('#show_hide_password input').attr("type") == "text"){
  $('#show_hide_password input').attr('type', 'password');
  $('#show_hide_password i').addClass( "fa-eye-slash" );
  $('#show_hide_password i').removeClass( "fa-eye" );
  }else if($('#show_hide_password input').attr("type") == "password"){
  $('#show_hide_password input').attr('type', 'text');
  $('#show_hide_password i').removeClass( "fa-eye-slash" );
  $('#show_hide_password i').addClass( "fa-eye" );
  }
  });
  });
  </script>
</body>

</html>