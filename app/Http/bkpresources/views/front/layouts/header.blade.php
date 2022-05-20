<!-- 
   =============================================
    Theme Header
   ============================================== 
   -->
<header class="theme-menu-wrapper full-width-menu">
  <div class="header-wrapper">
    <div class="clearfix">
      <!-- Logo -->
      <div class="logo float-left tran4s"><a href="/" class="mtm-10px"><img
            src="{{ URL::to('assets/front/images/logo/lgo.png') }}" style="height: 50px;" alt="Logo"></a></div>

      <!-- ============================ Theme Menu ========================= -->
      <nav class="theme-main-menu float-right navbar" id="mega-menu-wrapper">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse-1"
            aria-expanded="false">
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
                class="tran3s slected_eff">join
                as Tuition
                Classes</a>
            </li>
            <li class="dropdown-holder menu-list"><a href="{{ route('front.available-classes') }}"
                class="tran3s">available
                classes</a> </li>
            {{-- <li class="dropdown-holder menu-list"><a
                href="{{ route('front.admission') }}" class="tran3s">admission</a></li> --}}
            <li class="dropdown-holder menu-list"><a href="{{ route('front.why-avestud') }}" class="tran3s">why
                AVESTUD</a>
            </li>
            {{-- <li class="dropdown-holder menu-list"><a
                href="{{ route('front.how-it-works') }}" class="tran3s">how it
            works</a>
            </li> --}}
            <li class="menu-list"><a href="{{ route('front.contact-us') }}" class="tran3s">Contact Us</a></li>
            <li class="login-button"><a href="#" class="tran3s" data-toggle="modal" data-target=".signUpModal">Log In</a>
            </li>
            <li class="login-button"><a href="#" data-toggle="modal" data-target=".registerModal"
                class="tran3s">Register</a></li>
          </ul>
        </div><!-- /.navbar-collapse -->
      </nav> <!-- /.theme-main-menu -->
    </div> <!-- /.clearfix -->
  </div>
</header> <!-- /.theme-menu-wrapper -->