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
                    class="tran3s">join
                    as Tuition
                    Classes</a>
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
    @include('front.layouts.footer')
    @stack('js')
    @yield('js')
</body>

</html>