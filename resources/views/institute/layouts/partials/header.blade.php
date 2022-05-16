<!-- Topbar Start -->
<div class="navbar-custom">
    <ul class="list-unstyled topnav-menu float-right mb-0 topnav-menu-right">

        <li class="dropdown notification-list">
            <a class="nav-link dropdown-toggle nav-user mr-0 waves-effect" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                 <span class="pro-user-name ml-1">
                    Institute <i class="mdi mdi-chevron-down"></i> 
                </span>
            </a>
            <div class="dropdown-menu dropdown-menu-right profile-dropdown ">
                <!-- item-->
                <a href="/logout" class="dropdown-item notify-item">
                    <i class="fe-log-out"></i>
                    <span>Logout</span>
                </a>
            </div>
        </li>
        <!-- <li class="dropdown notification-list">
            <a href="javascript:void(0);" class="nav-link right-bar-toggle waves-effect">
                <i class="fe-settings noti-icon"></i>
            </a>
        </li> -->
    </ul>

    <!-- LOGO -->
    <div class="logo-box">
        <a href="/institute" class="logo text-center">
            <span class="logo-lg">
                <img src="{{URL::to('assets/institute/images/logo-dark.png')}}" alt="" height="37">
            </span>
            <span class="logo-sm">
                <img src="{{URL::to('assets/institute/images/logosmall.png')}}" alt="" height="30">
            </span>
        </a>
    </div>

    <ul class="list-unstyled topnav-menu topnav-menu-left m-0">
        <li>
            <button class="button-menu-mobile disable-btn waves-effect">
                <i class="fe-menu"></i>
            </button>
        </li>

        <li>
            <h4 class="page-title-main heading">@yield('page_heading')</h4>
        </li>

    </ul>
</div>
<!-- end Topbar -->