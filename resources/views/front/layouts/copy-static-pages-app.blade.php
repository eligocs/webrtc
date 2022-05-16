<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <!-- For IE -->
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <!-- For Resposive Device -->
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- For Window Tab Color -->
  <!-- Chrome, Firefox OS and Opera -->
  <meta name="theme-color" content="#2c2c2c">
  <!-- Windows Phone -->
  <meta name="msapplication-navbutton-color" content="#2c2c2c">
  <!-- iOS Safari -->
  <meta name="apple-mobile-web-app-status-bar-style" content="#2c2c2c">

  <title>AVESTUD - @yield('title')</title>

  <!-- Favicon -->
  <link rel="icon" type="image/png" sizes="56x56" href="{{ URL::to('assets/front/images/fav-icon/fevicon.png') }}">


  <!-- Main style sheet -->
  <link rel="stylesheet" type="text/css" href="/assets/front/css/style.css">
  <!-- responsive style sheet -->
  <link rel="stylesheet" type="text/css" href="/assets/front/css/responsive.css">


  <!-- Fix Internet Explorer ______________________________________-->

  <!--[if lt IE 9]>
   <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
   <script src="vendor/html5shiv.js"></script>
   <script src="vendor/respond.js"></script>
  <![endif]-->


</head>

<body>
  <div class="main-page-wrapper">

    <!-- ===================================================
    Loading Transition
   ==================================================== -->
    <div id="loader-wrapper">
      <div id="loader">
        <ul>
          <li></li>
          <li></li>
          <li></li>
          <li></li>
          <li></li>
          <li></li>
        </ul>
      </div>
    </div>


    <!-- 
   =============================================
    Theme Header
   ============================================== 
   -->
    <header class="theme-menu-wrapper full-width-menu header-2">
      <div class="header-wrapper">
        <div class="clearfix">
          <!-- Logo -->
          <div class="logo float-left tran4s"><a href="{{ url('') }}" class="mtm-10px"><img
                src="{{ URL::to('assets/front/images/logo/lgo.png') }}" style="height: 50px;" alt="Logo"></a></div>

          <!-- ============================ Theme Menu ========================= -->
          <nav class="theme-main-menu float-right navbar" id="mega-menu-wrapper">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
              <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                data-target="#navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
              </button>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="navbar-collapse-1">
              <ul class="nav">
                <li class="dropdown-holder menu-list"><a href="{{ route('front.institute-application') }}"
                    class="tran3s">join us</a>
                </li>
                <li class="dropdown-holder menu-list"><a href="{{ route('front.available-classes') }}"
                    class="tran3s">available classes</a>
                </li>
                {{-- <li class="dropdown-holder menu-list"><a
                    href="{{ route('front.admission') }}" class="tran3s">admission</a></li>
                --}}
                <li class="dropdown-holder menu-list"><a href="{{ route('front.why-avestud') }}" class="tran3s">why
                    AVESTUD</a>
                </li>
                {{-- <li class="dropdown-holder menu-list"><a
                    href="{{ route('front.how-it-works') }}" class="tran3s">how
                it works</a>
                </li> --}}

                <li class="menu-list"><a href="{{ route('front.contact-us') }}" class="tran3s">Contact Us</a></li>
                <li class="login-button"><a href="#" class="tran3s" data-toggle="modal"
                    data-target=".signUpModal">login</a></li>
                <li class="login-button"><a href="#" data-toggle="modal" data-target=".registerModal"
                    class="tran3s">Register</a></li>
              </ul>
            </div><!-- /.navbar-collapse -->
          </nav> <!-- /.theme-main-menu -->
        </div> <!-- /.clearfix -->
      </div>
    </header> <!-- /.theme-menu-wrapper -->

    @yield('content')

    <!-- 
   =============================================
    Footer
   ============================================== 
   -->
    <footer class="bg-one">
      <div class="container">
        <div class="row">
          <div class="col-md-5 ">
            <div class="footer-logo">
              <a href="#"><img src="{{ URL::to('assets/front/images/lgo-dark.png') }}" style="height: 50px"
                  alt="Logo"></a>
              <p class="description">AVESTUD is the perfect study room specially designed for Indian students and
                parents. As we cover primary to higher level education with best teachers across all the Indian
                cities. We have kept the education services very affordable as it is our mission to educate
                India and make education more accessible. </p>
              <!-- <h5><a href="#" class="tran3s">info@AVESTUD.com</a></h5>
                                        <h6 class="p-color">1234567890</h6> -->
            </div>
          </div>
          <div class="col-md-3 footer-list">
            <h4>Quick Links</h4>
            <ul>
              <li><a href="{{ route('front.how-it-works') }}" class="tran3s">Join us as Student</a></li>
              <li><a href="{{ route('front.how-it-works') }}" class="tran3s">Join us as Student</a></li>
              <li><a href="{{ route('front.available-classes') }}" class="tran3s">Available Classes</a></li>
              <!-- <li><a href="#" class="tran3s" data-toggle="modal" data-target=".signUpModal">Login</a></li> -->
              <li><a href="{{ route('front.admission') }}" class="tran3s">Admission</a></li>
              <li><a href="#" class="tran3s">Register for Free</a></li>
            </ul>
          </div>
          <div class="col-md-4 col-sm-6 col-xs-12 footer-subscribe">
            <h4>FOLLOW US</h4>
            <ul>
              <li><a href="" class="tran3s"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
              <li><a href="" class="tran3s"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
              <li><a href="" class="tran3s"><i class="fa fa-dribbble" aria-hidden="true"></i></a></li>
              <li><a href="" class="tran3s"><i class="fa fa-google-plus" aria-hidden="true"></i></a></li>
            </ul>
          </div>
        </div> <!-- /.row -->
      </div> <!-- /.container -->
    </footer>

    <div class="bottom-footer clearfix">
      <div class="container d-flex justify-content-between align-items-center">
        <p class="text-center"> Copyright &copy; 2020 <a href="#" class="tran3s text-white">AVESTUD</a>. ALL RIGHTS
          RESERVED.</p>
        <ul class="list-none d-flex justify-content-flex-end other links">
          <li><a href="{{ route('front.terms') }}" class="text-white">Terms & Conditions</a></li>
          <li><a href="{{ route('front.privacy-policy') }}" class="text-white">Privacy Policy</a></li>
        </ul>
      </div>

    </div>


    <!-- Sign-Up Modal -->
    <div class="modal fade signUpModal theme-modal-box" role="dialog">
      <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-body">
            <img src="{{ URL::to('assets/front/images/logo-dark.png') }}" class="dark-logo">
            <h5 class="text-center mb-2 pb-2">Login Into Your Student Account</h5>
            <form action="#">
              <div class="wrapper">
                <input type="text" placeholder="Phone Number">
                <input type="password" placeholder="Password" class="mb-0">
                <ul class="clearfix">
                  <!-- <li class="float-left">
                                                    <input type="checkbox" id="remember">
                                                    <label for="remember">Remember Me</label>
                                                </li> -->
                  <li class="float-left"><a href="#" class="p-color">Forgot Your Password?</a></li>
                </ul>

                <button class="p-bg-color hvr-trim-two">Login</button>
                <ul class="d-flex justify-content-center pb-0">
                  <li class="mr-1">
                    Not on AVESTUD?
                  </li>
                  <li><a href="register.html" class="p-color">Register Now</a></li>
                </ul>
              </div>
            </form>
          </div> <!-- /.modal-body -->
        </div> <!-- /.modal-content -->
      </div> <!-- /.modal-dialog -->
    </div> <!-- /.signUpModal -->

    <!-- register Modal -->
    <div class="modal fade registerModal theme-modal-box custom_modal" role="dialog">
      <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-body">
            <img src="{{ URL::to('assets/front/images/logo-dark.png') }}" class="dark-logo">
            <h5 class="text-center mb-2 pb-2">Register in Student Account</h5>
            <form id="register_student" action="#" method="post">
              {{ csrf_field() }}
              <div class="wrapper">
                <input type="text" name="name" id="name" placeholder="Full Name" required>
                <input type="number" name="phone" id="phone" placeholder="Phone Number"
                  onkeyup="this.value.length>10?this.value = this.value.substring(0, 10): ''" required>
                <input type="text" name="grade" id="grade" placeholder="Your Grade" required>
                <select name="state" id="state">
                  <option value="" disabled="" selected="" class="one">Select State</option>
                  <option value="Punjab">Punjab</option>
                  <option value="Haryana">Haryana</option>
                </select>
                <select name="city" id="city">
                  <option value="" disabled="" selected="" class="one">Select City</option>
                  <option value="Chandigarh">Chandigarh</option>
                  <option value="Panchkula">Panchkula</option>
                </select>
                <input type="password" name="password" id="password" placeholder="Password" required>
                <input type="password" name="confirm_password" id="confirm_password" placeholder="Confirm Password"
                  required>
                {{-- <button class="p-bg-color hvr-trim-two mt-4" data-toggle="modal"
                  data-target=".otpModal" data-dismiss="modal">Get OTP</button> --}}
                <div class="alert alert-danger errResponse" style="display:none;"></div>
                <button class="p-bg-color hvr-trim-two mt-4" id="submit_register_student_form">Get OTP</button>
                <ul class="d-flex justify-content-center align-items-center pb-0">
                  <li class="mr-1">
                    Already on AVESTUD?
                  </li>
                  <li><button class="btn btn-signin p-color">Login</a></li>
                </ul>
              </div>
            </form>
          </div> <!-- /.modal-body -->
        </div> <!-- /.modal-content -->
      </div> <!-- /.modal-dialog -->
    </div> <!-- /registerModal -->

    <!-- otp modal -->
    <div class="modal fade otpModal theme-modal-box custom_modal" role="dialog">
      <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-body">
            {{-- <p id="otpdata"></p> --}}
            <img src="{{ URL::to('assets/front/images/logo-dark.png') }}" class="dark-logo">
            <h5 class="text-center mb-2 pb-2">Register in Student Account</h5>
            <form id="verify_otp_form" action="#">
              <div class="wrapper">
                <div class="otp-form">
                  <input class="digit" type="number" name="digit1" id="digit1" data-next="digit2" min="0" max="9" />
                  <input type="number" name="digit2" id="digit2" class="digit" data-next="digit3" data-previous="digit1"
                    min="0" max="9" />
                  <input type="number" class="digit" id="digit3" name="digit3" data-next="digit4" data-previous="digit2"
                    min="0" max="9" />
                  <input type="number" class="digit" id="digit4" name="digit4" data-next="digit5" data-previous="digit3"
                    min="0" max="9" />
                  <input type="number" class="digit" id="digit5" name="digit5" data-next="digit6" data-previous="digit4"
                    min="0" max="9" />
                  <input type="number" class="digit" id="digit6" name="digit6" data-next="digit7" data-previous="digit5"
                    min="0" max="9" />
                </div>
                <span class="input-group-text text-white bg-color-main resnd-otp" id="basic-addon1"><img
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
                <button class="p-bg-color hvr-trim-two" id="verify_otp_submit">Sign Up</button>
                <ul class="d-flex justify-content-center align-items-center pb-0">
                  <li class="mr-1">
                    Already on AVESTUD?
                  </li>
                  <li><button class="btn btn-signin p-color">Login</a></li>
                </ul>
              </div>
            </form>
          </div> <!-- /.modal-body -->
        </div> <!-- /.modal-content -->
      </div> <!-- /.modal-dialog -->
    </div> <!-- /.signUpModal -->
    <!-- Scroll Top Button -->
    <button class="scroll-top tran3s">
      <i class="fa fa-angle-up" aria-hidden="true"></i>
    </button>

    <div id="svag-shape">
      <svg height="0" width="0">
        <defs>
          <clipPath id="shape-one">
            <path fill-rule="evenodd" fill="rgb(168, 168, 168)"
              d="M343.000,25.000 C343.000,25.000 100.467,106.465 25.948,237.034 C-30.603,336.119 15.124,465.228 74.674,495.331 C134.224,525.434 212.210,447.071 227.280,432.549 C242.349,418.028 338.889,359.517 460.676,506.542 C582.737,653.896 725.650,527.546 751.000,478.000 C789.282,403.178 862.636,-118.314 343.000,25.000 Z" />
          </clipPath>
        </defs>
      </svg>
    </div>
    <input type="hidden" id="student_register_post_url" value="{{ route('front.student.signup.register_student') }}" />
    <input type="hidden" id="verify_otp_post_url" value="{{ route('front.student.signup.verify_otp') }}" />
  </div> <!-- /.main-page-wrapper -->

  <!-- Js File_________________________________ -->

  <!-- j Query -->
  <script type="text/javascript" src="{{ URL::to('assets/front/vendor/jquery.2.2.3.min.js') }}"></script>
  <!-- Bootstrap Select JS -->
  <script type="text/javascript"
    src="{{ URL::to('assets/front/vendor/bootstrap-select/dist/js/bootstrap-select.js') }}">
  </script>

  <!-- Bootstrap JS -->
  <script type="text/javascript" src="{{ URL::to('assets/front/vendor/bootstrap/bootstrap.min.js') }}"></script>

  <!-- Vendor js _________ -->
  <!-- Camera Slider -->
  <script type='text/javascript'
    src="{{ URL::to('assets/front/vendor/Camera-master/scripts/jquery.mobile.customized.min.js') }}"></script>
  <script type='text/javascript' src="{{ URL::to('assets/front/vendor/Camera-master/scripts/jquery.easing.1.3.js') }}">
  </script>
  <script type='text/javascript' src="{{ URL::to('assets/front/vendor/Camera-master/scripts/camera.min.js') }}">
  </script>
  <!-- Mega menu  -->
  <script type="text/javascript" src="{{ URL::to('assets/front/vendor/bootstrap-mega-menu/js/menu.js') }}"></script>

  <!-- WOW js -->
  <script type="text/javascript" src="{{ URL::to('assets/front/vendor/WOW-master/dist/wow.min.js') }}"></script>
  <!-- owl.carousel -->
  <script type="text/javascript" src="{{ URL::to('assets/front/vendor/owl-carousel/owl.carousel.min.js') }}"></script>
  <!-- js count to -->
  <script type="text/javascript" src="{{ URL::to('assets/front/vendor/jquery.appear.js') }}"></script>
  <script type="text/javascript" src="{{ URL::to('assets/front/vendor/jquery.countTo.js') }}"></script>
  <!-- Fancybox -->
  <script type="text/javascript" src="{{ URL::to('assets/front/vendor/fancybox/dist/jquery.fancybox.min.js') }}">
  </script>

  <!-- Theme js -->
  <script type="text/javascript" src="{{ URL::to('assets/front/js/theme.js') }}"></script>
  <script type="text/javascript" src="{{ URL::to('assets/front/js/jquery-validate.min.js') }}"></script>
  <script>
    $('#play-video').on('click', function(e) {
      e.preventDefault();
      $('#video-overlay').addClass('open');
      $("#video-overlay").append(
        '<iframe width="560" height="315" src="https://www.youtube.com/embed/ngElkyQ6Rhs" frameborder="0" allowfullscreen></iframe>'
      );
    });

    $('.video-overlay, .video-overlay-close').on('click', function(e) {
      e.preventDefault();
      close_video();
    });

    $(document).keyup(function(e) {
      if (e.keyCode === 27) {
        close_video();
      }
    });

    function close_video() {
      $('.video-overlay.open').removeClass('open').find('iframe').remove();
    };

  </script>
  <script>
    $(document).ready(function() {

      // validate signup form on keyup and submit
      $("#register_student").validate({
        rules: {
          name: "required",
          grade: "required",
          state: "required",
          city: "required",
          phone: {
            required: true,
            number: true,
            minlength: 10,
            maxlength: 12
          },
          password: {
            required: true,
          },
          confirm_password: {
            required: true,
            equalTo: "#password"
          },

        },
        messages: {
          name: "Please enter your name",
          phone: {
            required: "Please enter your phone",
            number: "Please enter only numbers",
          },
          grade: "Please accept our grade",
          password: {
            required: "Please provide a password",
          },
          confirm_password: {
            required: "Please provide a password",
            equalTo: "Please enter the same password as above"
          },
          state: "Please enter your state",
          city: "Please enter your city"
        },
        submitHandler: function(form) {
          submitForm('#register_student');
        }
      });

      function submitForm(form) {

        $('.errResponse').html('');
        let student_register_post_url = $('#student_register_post_url').val();
        let name = $('#name').val();
        let phone = $('#phone').val();
        let grade = $('#grade').val();
        let state = $('#state').val();
        let city = $('#city').val();
        let password = $('#password').val();
        let confirm_password = $('#confirm_password').val();

        $.ajax({
          type: 'POST',
          url: student_register_post_url,
          data: {
            "_token": "{{ csrf_token() }}",
            "name": name,
            "phone": phone,
            "grade": grade,
            "state": state,
            "city": city,
            "password": password,
            "confirm_password": confirm_password,
          },
          success: function(data) {
            if (data.status == 'Success') {
              $('.registerModal').modal('hide');
              $('#otpdata').text(data.otp);
              $('.otpModal').modal('show');
            } else {
              $.each(data.error, function(key, value) {
                jQuery('.errResponse').show();
                jQuery('.errResponse').append('<p>' + value + '</p>');
              });
            }
          }
        });

      }

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
            if (data.status == 'Success') {

              $('.otpSuccessResponse').show();
              $('.otpSuccessResponse').html('<p>Otp has been verified. Please do login now.</p>');

              setTimeout(function() {
                window.location.replace('/student/login');
                // $('.otpModal').modal('hide');
                // $('.signUpModal').modal('show');
              }, 3000);



              //window.location.replace('');
            } else {
              $('.otpErrResponse').show();
              $('.otpErrResponse').html('<p>' + data.error + '</p>');
            }
          }
        });

      }

    });

  </script>
  @yield('js')
</body>

</html>