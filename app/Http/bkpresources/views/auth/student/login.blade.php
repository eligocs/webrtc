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
  <!-- App css -->
  <link href="{{URL::to('assets/student/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
  <link href="{{URL::to('assets/student/css/icons.min.css')}}" rel="stylesheet" type="text/css" />
  <link href="{{URL::to('assets/student/css/app.min.css')}}" rel="stylesheet" type="text/css" />
  <link href="{{URL::to('assets/student/css/fonts.css')}}" rel="stylesheet" type="text/css" />
  <link href="{{URL::to('assets/student/css/style.css')}}" rel="stylesheet" type="text/css" />
  <style>
  .hover_bkgr_fricc{
    background:rgba(0,0,0,.7);
    cursor:pointer;
    display:none;
    height:100%;
    position:fixed;
    text-align:center;
    top:0;
    width:100%;
    z-index:10000;
}
.hover_bkgr_fricc .helper{
    display:inline-block;
    height:100%;
    vertical-align:middle;
}
.hover_bkgr_fricc > div {
    background-color: white;
    /* box-shadow: 10px 10px 60px #dedede; */
    color: black;
    font-size: 19px;
    display: inline-block;
    width: 100%;
    max-width: 450px;
    height: 300px;
    vertical-align: middle;
 
    position: relative;
    border-radius: 5px;
    padding: 15px 5%;
}
.popup-container p {
    margin-bottom: 30px;
}
.popupCloseButton {
  background-color: #fff;
   
    border-radius: 50px;
    cursor: pointer;
    display: inline-block;
    font-family: arial;
    font-weight: bold;
    position: absolute;
    top: -10px;
    right: -15px;
    font-size: 20px;
    line-height: 26px;
    width: 25px;
    height: 25px;
    text-align: center;
}
.popupCloseButton:hover {
    background-color: #ccc;
}
.popup-text {
    height: 100%;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
}
.trigger_popup_fricc {
    cursor: pointer;
    font-size: 20px;
    margin: 20px;
    display: inline-block;
    font-weight: bold;
}
.CloseButton {
    width: 50%;
    margin-top: 5px;
}
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
            <a href="{{url('/')}}">
              <span><img src="{{URL::to('assets/student/images/logo-dark.png')}}" alt="" height="60"></span>
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
                  <label for="emailaddress">Phone Number</label>
                  <input class="form-control" type="text" id="emailaddress" name="phone" value="{{ old('phone') }}"
                    placeholder="Enter your phone">
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
                <input type="hidden" name="type" value="student" />
              </form>
            </div>
            <!-- end card-body -->
          </div>
          <!-- end card -->
          <div class="row mt-3">
            <div class="col-12 text-center">
              <p class="black">Don't have an account? <a href="pages-register.html" class="text-dark ml-1"><b>Sign
                    Up</b></a></p>
            </div>
            <!-- end col -->
          </div>
          <!-- end row -->
        </div>
        <!-- end col -->
      </div>
      <!-- end row -->
    </div>
    <!-- end container -->
  </div>

  <div class="hover_bkgr_fricc">
    <span class="helper"></span>
    <div class="popup-container"> 
    <div class="popupCloseButton">&times;</div>
    <div class="popup-text">
        <p>Registration Successfull </p>
        <p>Log into your account Now!</p>
        <div class=" btn btn-success  CloseButton">OK</div>
        </div>
    </div>
</div>

  <!-- end page -->
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

        // $('.hover_bkgr_fricc').show(); 
        $('.CloseButton').click(function(){
            $('.hover_bkgr_fricc').hide();
        });
        $('.popupCloseButton').click(function(){
            $('.hover_bkgr_fricc').hide();
        });



        });
  </script>
</body>

</html>