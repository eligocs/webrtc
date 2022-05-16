<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>AVESTUD - Institute</title>
    <meta name="View Applicationport" content="width=device-width, initial-scale=1.0">
    <meta content="AVESTUD - Institute" name="description" />
    <meta content="Coderthemes" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{URL::to('assets/institute/images/favicon.png')}}">

    <!-- App css -->
    <link href="{{URL::to('assets/institute/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{URL::to('assets/institute/css/icons.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{URL::to('assets/institute/css/app.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{URL::to('assets/institute/css/fonts.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{URL::to('assets/institute/css/style.css')}}" rel="stylesheet" type="text/css" />
    <style>
        ul.clearfix {
            list-style: none;
            padding-left: 0;
            padding-top: 6px;
        }

        input {
            /* overflow: visible; */
            width: 100%;
            height: 55px;
            border: 1px solid #e7e7e7;
            padding: 0 20px;
            border-radius: 3px;
            margin-bottom: 20px;
        }

        .otp-form input {
            width: 50px;
            height: 50px;
            background-color: transparent;
            /* border: none; */
            line-height: 50px;
            text-align: center;
            font-size: 24px;
            font-weight: 200;
            color: #616161;
            margin: 0 5px 5px 0 !important;
        }

        .wrapper {
            /* padding: 0 !important; */
            width: 100% !important;
        }

        .resnd-otp {
            font-size: 12px;
            width: 90px;
            border: none;
            margin-top: 15px;
        }

        .text-white {
            color: #fff !important;
        }

        .bg-color-main {
            background-color: #644699;
            height: 20px;
        }
    </style>
</head>


<body class="purple-gradient">

    <div class="account-pages mt-5 mb-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-5">
                    <div class="text-center mb-4">
                        <a href="/">
                            <span><img src="{{URL::to('assets/institute/images/logo-dark.png')}}" alt=""
                                    height="60"></span>
                        </a>
                    </div>
                    <div class="card">

                        <div class="card-body p-4">

                            <div class="text-center mb-4">
                                <h4 class="text-uppercase mt-0">Type phone to generate otp</h4>
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

                            <form id="verify_otp_form" action="#" class="m-0">
                                <div class="wrapper">
                                    <div class="otp-form">
                                        <input class="digit" type="text" name="digit1" id="digit1" data-next="digit2"
                                            min="0" max="9" />
                                        <input type="text" name="digit2" id="digit2" class="digit" data-next="digit3"
                                            data-previous="digit1" min="0" max="9" />
                                        <input type="text" class="digit" id="digit3" name="digit3" data-next="digit4"
                                            data-previous="digit2" min="0" max="9" />
                                        <input type="text" class="digit" id="digit4" name="digit4" data-next="digit5"
                                            data-previous="digit3" min="0" max="9" />
                                        <input type="text" class="digit" id="digit5" name="digit5" data-next="digit6"
                                            data-previous="digit4" min="0" max="9" />
                                        <input type="text" class="digit" id="digit6" name="digit6" data-next="digit7"
                                            data-previous="digit5" min="0" max="9" />
                                    </div>
                                    <span class="input-group-text text-white bg-color-main resnd-otp" id="basic-addon1"
                                        style="cursor: pointer;"><img
                                            src="{{ URL::to('assets/front/images/tool.png') }}">Resend 22</span>
                                    <ul class="clearfix">
                                        <li><a href="" class="black d-flex align-items-center"><img
                                                    src="{{ URL::to('assets/front/images/left3.svg') }}"
                                                    style="width: 20px;margin-right: 10px;">Back</a>
                                        </li>
                                    </ul>
                                    <div id="optErr"></div>
                                    <div class="alert alert-danger otpErrResponse" style="display:none;"></div>
                                    <div class="alert alert-success otpSuccessResponse" style="display:none;"></div>
                                    <button class="btn btn-theme w-100 btn-block"
                                        id="verify_otp_submit">PROCEED</button>
                                </div>
                            </form>

                        </div> <!-- end card-body -->
                    </div>
                    <!-- end card -->
                </div> <!-- end col -->
            </div>
            <!-- end row -->
        </div>
        <!-- end container -->
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"
        integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script>
        $(document).ready(function() {
            var otp_for = 'signup';
            $('#forgotPasswordForm').submit(function(e) {
                e.preventDefault();
                otp_for = 'forgotPassword';
                let phone_number = $('#forgotPasswordPhone').val();
                console.log(phone_number);
      $.ajax({
        url: "{{ route('front.student.signup.generate_otp') }}",
        method: 'post',
        dataType: 'json',
        data: {
          _token: "{{ csrf_token() }}",
          phone: phone_number
        },
        success: function(response) {
            console.log(response);
          if (response.status == 'Success') {
            // window.location.href = '/institute/otpverificatio';
          } else {
            $.each(response.error, function(key, value) {
              jQuery('.errResponse').show();
              jQuery('.errResponse').append('<p>' + value + '</p>');
            });
          }
        }
      });
    })
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