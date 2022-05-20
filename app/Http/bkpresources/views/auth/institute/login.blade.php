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

    ul.clearfix {
      list-style: none;
      padding-left: 0px;
    }


    a:hover {
      color: #843dd2;
      font-size: 14px;
      /* font-weight: bold; */
    }

    div#phone {
      display: none;
    }

    ul.cfix {
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

    .otp-fom input {
      width: 50px;
      height: 50px;
      background-color: transparent;
      /* boder: none; */
      line-height: 50px;
      text-align: center;
      font-size: 24px;
      color #616161;
      margin: 0 5px 5px 0 !important;
    }

    .wrapper {
      /* padding: 0 !important; */
      width: 100% !important;
    }

    .resndtp {
      font-size: 12px;
      height 90px;
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
      font-size: 16px;
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

    #resetPasswordFormcard,
    #otp {
      display: none;
    }


    button#forgotPasswordButton {
      width: 100%;
      background-color: blueviolet;
      height: 40px;
      border-radius: 7px;

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
              <span><img src="{{URL::to('assets/institute/images/logo-dark.png')}}" alt="" height="60"></span>
            </a>
          </div>
          <div class="card">

            <div class="card-body p-4" id="login">

              <div class="text-center mb-4">
                <h4 class="text-uppercase mt-0">Log In to Your Institute Account</h4>
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
              {{-- @include('admin.layouts.success') --}}

              <form action="{{ route('login') }}" method="POST">
                @csrf
                <div class="form-group mb-3">
                  <label for="emailaddress">Email address</label>
                  <input class="form-control" type="email" name="email" value="{{ old('email') }}" id="emailaddress"
                    placeholder="Enter your email">
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
                <ul class="clearfix">
                  {{-- <li class="float-left"><a href="/institute/forget" class="p-color forgetpass">Forgot Your
                      Password?</a></li> --}}
                  <li class="float-left">
                    <a class="p-color forgetpass">Forgot Your
                      Password?</a>
                  </li>
                </ul>
                <div class="form-group mb-0 text-center">
                  <button class="btn btn-theme w-100 btn-block" type="submit"> Log In </button>
                </div>

              </form>

            </div> <!-- end card-body -->


            <!--phone no div--->
            <div class="card" id="phone">

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
                {{-- @include('admin.layouts.success') --}}

                <form action="#" id="forgotPasswordForm" method="post">
                  @csrf
                  <input type="text" class="form-control" placeholder="Phone Number" name="phone"
                    id="forgotPasswordPhone" onkeyup="this.value.length>10?this.value = this.value.substring(0, 10): ''"
                    required>
                  <br>
                  <div class="alert alert-danger errResponse" style="display:none;"></div>
                  <div class="form-group mb-0 text-center">
                    <button id="forgotPasswordButton" class="btn btn-theme w-100 btn-block" type="submit"> Generate OTP
                    </button>
                  </div>
                </form>

              </div> <!-- end card-body -->
            </div>
          </div>
          <!-- end card -->
          <!---opt card----->
          <div class="card" id="otp">
            <div class="card-body p-4">
              <div class="text-center mb-4">
                <h4 class="text-uppercase mt-0">Enter Otp</h4>
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
              <form id="verify_otp_form">
                <div class="wrapper">
                  <div class="otp-form">
                    <input class="digit" type="text" name="digit1" id="digit1" data-next="digit2" maxlength="1" min="0"
                      max="9" />
                    <input type="text" name="digit2" id="digit2" class="digit" data-next="digit3" maxlength="1"
                      data-previous="digit1" min="0" max="9" />
                    <input type="text" class="digit" id="digit3" name="digit3" data-next="digit4" maxlength="1"
                      data-previous="digit2" min="0" max="9" />
                    <input type="text" class="digit" id="digit4" name="digit4" data-next="digit5" maxlength="1"
                      data-previous="digit3" min="0" max="9" />
                    <input type="text" class="digit" id="digit5" name="digit5" data-next="digit6" maxlength="1"
                      data-previous="digit4" min="0" max="9" />
                    <input type="text" class="digit" id="digit6" name="digit6" data-next="digit7" maxlength="1"
                      data-previous="digit5" min="0" max="9" />
                  </div>
                  <span class="input-group-text text-white bg-color-main resnd-otp" id="basic-addon1"
                    style="cursor: pointer;"><img src="{{ URL::to('assets/front/images/tool.png') }}">Resend 22</span>
                  <ul class="clearfix">
                    <li><a href="" class="black d-flex align-items-center"><img
                          src="{{ URL::to('assets/front/images/left3.svg') }}"
                          style="width: 20px;margin-right: 10px;">Back</a>
                    </li>
                  </ul>
                  <div id="optErr"></div>
                  <div class="alert alert-danger otpErrResponse" style="display:none;"></div>
                  <div class="alert alert-success otpSuccessResponse" style="display:none;"></div>
                  <button class="btn btn-theme w-100 btn-block" id="verify_otp_submit" type="submit">SUBMIT</button>
                </div>
              </form>
            </div> <!-- end card-body -->
          </div>
          <!-- end card -->




          <!---opt card----->
          <div class="card" id="resetPasswordFormcard">
            <div class="card-body p-4">
              <div class="text-center mb-4">
                <h4 class="text-uppercase mt-0">Reset Password</h4>
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
              <form action="#" id="resetPasswordForm" method="post">
                <div class="wrapper mx-auto">
                  <input type="password" placeholder="Password" id="fpassword" name="password" required>
                  <input type="password" placeholder="Confirm Password" id="fconfirm_password" name="confirm_password"
                    required>
                  <ul class="clearfix">
                    <li class="float-left" id="resetPasswordConfirmationMessage"></li>
                  </ul>
                  <div class="alert alert-danger errResponse" style="display:none;"></div>
                  <button id="forgotPasswordButton" class="p-bg-color hvr-trim-two">Change</button>
                </div>
              </form>
            </div> <!-- end card-body -->
          </div>
          <!-- end card -->

          <input type="hidden" id="verify_otp_post_url" value="{{ route('front.student.signup.verify_otp') }}" />
          <!-------------------------forget pasword---------------------------------->

        </div> <!-- end col -->
      </div>
      <!-- end row -->
    </div>
    <!-- end container -->
  </div>
  <script src="https://code.jquery.com/jquery-3.5.1.min.js"
    integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
  <script type="text/javascript" src="{{ URL::to('assets/front/js/jquery-validate.min.js') }}"></script>
  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
  <script>
    $(document).ready(function() {
      $(".forgetpass").click(function(e){        
        $("#login").hide();
        $("#phone").show();
        e.preventDefault();
      });


      $('input.digit').on('keyup', function() {
        if ($(this).val()) {
            $(this).next().focus();
        }
      });
  
      $('input.digit').keydown(function(e) {
          if ((e.which == 8 || e.which == 46) && $(this).val() =='') {
          $(this).prev('input').focus();
          }
      });


  var otp_for = 'signup';
    $('#forgotPasswordForm').submit(function(e) {
      e.preventDefault();
      otp_for = 'forgotPassword';
      let phone_number = $('#forgotPasswordPhone').val();
      $.ajax({
        url: "{{ route('front.student.signup.generate_otp') }}",
        method: 'post',
        dataType: 'json',
        data: {
          _token: "{{ csrf_token() }}",
          phone: phone_number
        },
        success: function(response) {
          if (response.status == 'Success') {
            swal("OTP has been sent to your registered phone number");
            $('#phone').hide();
            $('#verify_otp_submit').text('PROCEED');
            $('#otp').show();
          } else {
            $.each(response.error, function(key, value) {
              jQuery('.errResponse').show();
              jQuery('.errResponse').append('<p>' + value + '</p>');
            });
          }
        }
      });
    

    $("#resetPasswordForm").validate({
      rules: {
        password: {
          required: true,
        },
        confirm_password: {
          required: true,
          equalTo: "#fpassword"
        },

      },
      messages: {
        password: {
          required: "Please provide a password",
        },
        confirm_password: {
          required: "Please provide a password",
          equalTo: "Please enter the same password as above"
        },
      },
      submitHandler: function(form) {
        submitResetPasswordForm('#resetPasswordForm');
      }
    });

    function submitResetPasswordForm(form) {

      $('.errResponse').html('');
      let phone_number = $('#forgotPasswordPhone').val();
      let password = $('#fpassword').val();
      let confirm_password = $('#fconfirm_password').val();

      $.ajax({
        type: 'POST',
        url: "{{ route('front.student.signup.reset_password') }}",
        data: {
          "_token": "{{ csrf_token() }}",
          "phone": phone_number,
          "password": password,
          "confirm_password": confirm_password,
        },
        success: function(data) {
          if (data.status == 'Success') {
            $('#resetPasswordConfirmationMessage').text('Password Reset Successfully. Please Login.')
            setTimeout(function() {
              window.location.replace('/institute/login');
              // $('.resetPasswordModal').modal('hide');
            }, 2000);
          } else {
            $.each(data.error, function(key, value) {
              jQuery('.errResponse').show();
              jQuery('.errResponse').append('<p>' + value + '</p>');
            });
          }
        }
      });

    }
    $('.resnd-otp').click(function() {
      let phone_number;
      if (otp_for == 'forgotPassword') {
        phone_number = $('#forgotPasswordPhone').val();
      } else {
        phone_number = $('#phone').val();
      }
      $.ajax({
        url: "{{ route('front.student.signup.resend_otp') }}",
        method: 'post',
        dataType: 'json',
        data: {
          _token: "{{ csrf_token() }}",
          phone: phone_number
        },
        success: function(response) {
          alert(response.message);
        }
      });
    })
        
    /* Verify otp Functionality*/

    function validateOtpForm() {

      let set_output = true;
      $('#optErr').html('');

      if ($('.digit').val() == '') {
        $('#optErr').html('<p class="alert alert-danger">Please enter otp</p>');
        set_output = false;
      }
      return set_output;
    }

    $("#verify_otp_form").submit(function(e) {
      e.preventDefault();
    
      let output = validateOtpForm();

      if (output == true) {
        verifyOtp();
      } else {
        return false;
      }

    });

    function verifyOtp() {

      let verify_otp_post_url = $('#verify_otp_post_url').val();
      let digit1 = $('#digit1').val();
      let digit2 = $('#digit2').val();
      let digit3 = $('#digit3').val();
      let digit4 = $('#digit4').val();
      let digit5 = $('#digit5').val();
      let digit6 = $('#digit6').val();
   
      $.ajax({
        type: 'POST',
        url: verify_otp_post_url,
        data: {
          "_token": "{{ csrf_token() }}",
          "digit1": digit1,
          "digit2": digit2,
          "digit3": digit3,
          "digit4": digit4,
          "digit5": digit5,
          "digit6": digit6,
        },
        success: function(data) {
          // console.log(data.error);
          if (data.status == 'Success') {

            $('.otpSuccessResponse').show();

            if (otp_for == 'forgotPassword') {

              $('.otpSuccessResponse').html('<p>Otp has been verified.</p>');

              setTimeout(function() {
                $('#otp').hide();
                $('#resetPasswordFormcard').show();
              }, 1000);


              //window.location.replace('');
            } else {
              $('.otpSuccessResponse').html('<p>Otp has been verified. Please do login now.</p>');

              setTimeout(function() {
                window.location.replace('/student/login');
                // $('.otpModal').modal('hide');
                // $('.signUpModal').modal('show');
              }, 2000);



              //window.location.replace('');
            }
          } else {
            $('.otpErrResponse').show();
            $('.otpErrResponse').html('<p>' + data.error + '</p>');
          }
        }
      });

    }

  });
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