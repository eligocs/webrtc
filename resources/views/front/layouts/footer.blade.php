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
          <a href="/"><img src="{{ URL::to('assets/front/images/lgo-dark.png') }}" style="height: 50px" alt="Logo"></a>
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
          <li><a href="javascript:void(0)" class="tran3s" onclick="$('.registerModal').modal('show')">Join us as
              Student</a></li>
          <li><a href="{{url('institute/login')}}" class="tran3s">Join us as Institute</a></li>
          <li><a href="{{ route('front.available-classes') }}" class="tran3s">Available Classes</a></li>
          <!-- <li><a href="#" class="tran3s" data-toggle="modal" data-target=".signUpModal">Login</a></li> -->
          <li><a href="{{ route('front.why-avestud') }}" class="tran3s">why AVESTUD</a></li>
          <li><a href="#" data-toggle="modal" data-target=".registerModal" class="tran3s">Register for Free</a></li>
        </ul>
      </div>
      <div class="col-md-4 col-sm-6 col-xs-12 footer-subscribe">
        <h4>FOLLOW US</h4>
        <ul>
          <li><a href="https://fb.me/AVESTUDcom" target="_blank" class="tran3s"><i class="fa fa-facebook"
                aria-hidden="true"></i></a></li>
          <li><a href="https://twitter.com/AVESTUDcom" target="_blank" class="tran3s"><i class="fa fa-twitter"
                aria-hidden="true"></i></a></li>
          <li><a href="https://www.youtube.com/channel/UCwdnfPnf5A9pcjk0eJsDBAw?view_as=subscriber" target="_blank"
              class="tran3s"><i class="fa fa-youtube-play" aria-hidden="true"></i></a></li>
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
            <input type="text" name="grade" id="grade" placeholder=" Your Grade e.g 12th, Engineering, Bsc etc."
              required>
            <select name="state" id="state">
              <option value="" disabled="" selected="" class="one">Select State</option>
              <option value="Andhra Pradesh">Andhra Pradesh</option>
              <option value="Arunachal Pradesh">Arunachal Pradesh</option>
              <option value="Assam">Assam</option>
              <option value="Bihar">Bihar</option>
              <option value="Chhattisgarh">Chhattisgarh</option>
              <option value="Goa">Goa</option>
              <option value="Gujarat">Gujarat</option>
              <option value="Haryana">Haryana</option>
              <option value="Himachal Pradesh">Himachal Pradesh</option>
              <option value="Jammu and Kashmir">Jammu and Kashmir</option>
              <option value="Jharkhand">Jharkhand</option>
              <option value="Karnataka">Karnataka</option>
              <option value="Kerala">Kerala</option>
              <option value="Madhya Pradesh">Madhya Pradesh</option>
              <option value="Maharashtra">Maharashtra</option>
              <option value="Manipur">Manipur</option>
              <option value="Meghalaya">Meghalaya</option>
              <option value="Mizoram">Mizoram</option>
              <option value="Nagaland">Nagaland</option>
              <option value="Odisha">Odisha</option>
              <option value="Punjab">Punjab</option>
              <option value="Rajasthan">Rajasthan</option>
              <option value="Sikkim">Sikkim</option>
              <option value="Tamil Nadu">Tamil Nadu</option>
              <option value="Telangana">Telangana</option>
              <option value="Tripura">Tripura</option>
              <option value="Uttar Pradesh">Uttar Pradesh</option>
              <option value="Uttarakhand">Uttarakhand</option>
              <option value="West Bengal">West Bengal</option>
              <option value="Andaman and Nicobar Islands">Andaman and Nicobar Islands</option>
              <option value="Chandigarh">Chandigarh</option>
              <option value="Dadra and Nagar Haveli">Dadra and Nagar Haveli</option>
              <option value="Daman and Diu">Daman and Diu</option>
              <option value="Lakshadweep">Lakshadweep</option>
              <option value="National Capital Territory of Delhi">National Capital Territory of Delhi</option>
              <option value="Puducherry">Puducherry</option>
            </select>
            {{-- <select name="city" id="city">
              <option value="" disabled="" selected="" class="one">Select City</option>
              <option value="Chandigarh">Chandigarh</option>
              <option value="Panchkula">Panchkula</option>
            </select> --}}
            <input type="text" name="city" id="city" placeholder="Enter your city" required autocomplete="off">
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
              <li><button type="button" class="btn btn-signin p-color"
                  onclick="$('.registerModal').modal('hide');$('.signUpModal').modal('show');">Log In</a></li>
            </ul>
          </div>
        </form>
      </div> <!-- /.modal-body -->
    </div> <!-- /.modal-content -->
  </div> <!-- /.modal-dialog -->
</div> <!-- /registerModal -->

<!-- Sign-in Modal -->
<div class="modal fade signUpModal theme-modal-box" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-body">
        <img src="{{ URL::to('assets/front/images/logo-dark.png') }}" class="dark-logo">
        <h5 class="text-center mb-2 pb-2">Log In To Student Account</h5>
        <form action="{{ route('login') }}" method="POST">
          <div class="wrapper">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" name="type" value="student">
            <input type="text" name="phone" placeholder="Phone Number" required>
            <div class="input-group" id="show_hide_password">
              <input type="password" name="password" placeholder="Password" class="mb-0" required>
              <div class="input-group-addon" style="width:40px;line-height: 2;">
                <a href=""><i class="fa fa-eye-slash" aria-hidden="true"></i></a>
              </div>
            </div>
            <ul class="clearfix">
              <!-- <li class="float-left">
                                                    <input type="checkbox" id="remember">
                                                    <label for="remember">Remember Me</label>
                                                </li> -->
              <li class="float-left"><a href="#" data-toggle="modal" data-target=".forgotPasswordModal" class="p-color"
                  onclick="$('.signUpModal').modal('hide');">Forgot Your Password?</a></li>
            </ul>

            <button class="p-bg-color hvr-trim-two">Log In</button>
            <ul class="d-flex justify-content-center pb-0">
              <li class="mr-1">
                Not on AVESTUD?
              </li>
              <li><a href="#" data-toggle="modal" data-target=".registerModal" class="p-color"
                  onclick="$('.signUpModal').modal('hide');">Register Now</a></li>
            </ul>
          </div>
        </form>
      </div> <!-- /.modal-body -->
    </div> <!-- /.modal-content -->
  </div> <!-- /.modal-dialog -->
</div> <!-- /.signUpModal -->

<!-- Forgot Password Modal -->
<div class="modal fade forgotPasswordModal  theme-modal-box" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-body">
        <img src="{{ URL::to('assets/front/images/logo-dark.png') }}" class="dark-logo">
        <h5 class="text-center mb-2 pb-2">Type phone to generate otp</h5>
        <form action="#" id="forgotPasswordForm" method="post">
          <div class="wrapper mx-auto w-100">
            <input type="text" class="m-0 mt-2" placeholder="Phone Number" name="phone" id="forgotPasswordPhone"
              onkeyup="this.value.length>10?this.value = this.value.substring(0, 10): ''" required>
            <ul class="clearfix mb-0 pb-0">
              <li class="float-left"><a href="#" data-toggle="modal" data-target=".forgotPasswordModal"
                  class="p-color"></a></li>
            </ul>
            <div class="alert alert-danger errResponse" style="display:none;"></div>
            <button id="forgotPasswordButton" class="p-bg-color hvr-trim-two">Generate OTP</button>
            <ul class="d-flex justify-content-center">
              <li class="mr-1">
                Not on AVESTUD?
              </li>
              <li><a href="#" data-toggle="modal" data-target=".registerModal" class="p-color registerModal">Register
                  Now</a></li>
            </ul>
          </div>
        </form>
      </div> <!-- /.modal-body -->
    </div> <!-- /.modal-content -->
  </div> <!-- /.modal-dialog -->
</div> <!-- /.forgotPasswordModal -->

<!-- Reset Passworod Modal -->
<div class="modal fade resetPasswordModal theme-modal-box" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-body">
        <img src="{{ URL::to('assets/front/images/logo-dark.png') }}" class="dark-logo">
        <h5 class="text-center mb-2 pb-2">Reset Your Password</h5>
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
            <ul class="d-flex justify-content-center pb-0">
              <li class="mr-1">
                Not on AVESTUD?
              </li>
              <li><a href="#" data-toggle="modal" data-target=".registerModal" class="p-color registerModal">Register
                  Now</a></li>
            </ul>
          </div>
        </form>
      </div> <!-- /.modal-body -->
    </div> <!-- /.modal-content -->
  </div> <!-- /.modal-dialog -->
</div> <!-- /.forgotPasswordModal -->



<!-- otp modal -->
<div class="modal fade otpModal theme-modal-box custom_modal" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-body">
        {{-- <p id="otpdata"></p> --}}
        <img src="{{ URL::to('assets/front/images/logo-dark.png') }}" class="dark-logo">
        <h5 class="text-center mb-2 pb-2">Register in Student Account</h5>
        <form id="verify_otp_form" action="#" class="m-0">
          <div class="wrapper">
            <div class="otp-form">
              <input class="digit" type="text" name="digit1" id="digit1" data-next="digit2" min="0" max="9" />
              <input type="text" name="digit2" id="digit2" class="digit" data-next="digit3" data-previous="digit1"
                min="0" max="9" />
              <input type="text" class="digit" id="digit3" name="digit3" data-next="digit4" data-previous="digit2"
                min="0" max="9" />
              <input type="text" class="digit" id="digit4" name="digit4" data-next="digit5" data-previous="digit3"
                min="0" max="9" />
              <input type="text" class="digit" id="digit5" name="digit5" data-next="digit6" data-previous="digit4"
                min="0" max="9" />
              <input type="text" class="digit" id="digit6" name="digit6" data-next="digit7" data-previous="digit5"
                min="0" max="9" />
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
            <button class="p-bg-color hvr-trim-two" id="verify_otp_submit">Sign Up</button>
            <ul class="d-flex justify-content-center align-items-center pb-0">
              <li class="mr-1">
                Already on AVESTUD?
              </li>
              <li><button type="button" class="btn btn-signin p-color"
                  onclick="$('.registerModal').modal('hide');$('.otpModal').modal('hide');$('.signUpModal').modal('show');">Login</a>
              </li>
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
<script type="text/javascript" src="{{ URL::to('assets/front/vendor/bootstrap-select/dist/js/bootstrap-select.js') }}">
</script>

<!-- Bootstrap JS -->
<script type="text/javascript" src="{{ URL::to('assets/front/vendor/bootstrap/bootstrap.min.js') }}"></script>

<!-- Vendor js _________ -->
<!-- Camera Slider -->
<script type='text/javascript'
  src="{{ URL::to('assets/front/vendor/Camera-master/scripts/jquery.mobile.customized.min.js') }}"></script>
<script type='text/javascript' src="{{ URL::to('assets/front/vendor/Camera-master/scripts/jquery.easing.1.3.js') }}">
</script>
<script type='text/javascript' src="{{ URL::to('assets/front/vendor/Camera-master/scripts/camera.min.js') }}"></script>
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
<script type="text/javascript" src="{{ URL::to('assets/front/vendor/fancybox/dist/jquery.fancybox.min.js') }}"></script>

<!-- Theme js -->
<script type="text/javascript" src="{{ URL::to('assets/front/js/theme.js') }}"></script>
<script type="text/javascript" src="{{ URL::to('assets/front/js/jquery-validate.min.js') }}"></script>
<script>
  $('.video-play-button').on('click', function(e) {
    e.preventDefault();
    let videoIframe = $('<iframe width="560" height="315" src="https://www.youtube.com/embed/ngElkyQ6Rhs" frameborder="0" allowfullscreen allow="autoplay; fullscreen"></iframe>')
    let videoSrc = $(this).data('video-src')
    if(videoSrc) {
      videoIframe.attr('src', videoSrc)
    }
    $('#video-overlay').addClass('open');
    $("#video-overlay").append(videoIframe[0]);
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
  var otp_for = 'signup';
  $(document).ready(function() {
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
            $('.forgotPasswordModal').modal('hide');
            $('#verify_otp_submit').text('PROCEED');
            $('.otpModal').modal('show');
          } else {
            $.each(response.error, function(key, value) {
              jQuery('.errResponse').show();
              jQuery('.errResponse').append('<p>' + value + '</p>');
            });
          }
        }
      });
    })

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
              window.location.replace('/student/login');
              $('.resetPasswordModal').modal('hide');
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
            $('#verify_otp_submit').text('SIGN UP');
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

            if (otp_for == 'forgotPassword') {

              $('.otpSuccessResponse').html('<p>Otp has been verified.</p>');

              setTimeout(function() {
                $('.otpModal').modal('hide');
                $('.resetPasswordModal').modal('show');
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

</script>
{{-- <script src="https://code.jquery.com/jquery-3.5.1.min.js"
  integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script> --}}
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
@error('phone')
<script>
  alert('{{$message}}')
</script>
@enderror
@if (session()->has('login_error'))
<script>
  alert('{{session()->get("message")}}');
</script>
@endif
@yield('js')
@stack('js')