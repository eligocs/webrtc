<!-- Begin page -->
<div id="wrapper">
  <!-- Topbar Start -->
  <div class="navbar-custom">
    <ul class="list-unstyled topnav-menu float-right mb-0">

      <li class="dropdown notification-list">
        <a class="nav-link dropdown-toggle nav-user mr-0 waves-effect" data-toggle="dropdown" href="#" role="button"
          aria-haspopup="false" aria-expanded="false">
          <!-- <img src="assets/images/users/user-1.jpg" alt="user-image" class="rounded-circle"> -->
          <span class="pro-user-name ml-1">
            Admin <i class="mdi mdi-chevron-down"></i>
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
      <a href="{{url('admin')}}" class="logo text-center">
        <span class="logo-lg">
          <img src="{{URL::to('assets/admin/images/logo-dark.png')}}" alt="" height="37">
        </span>
        <span class="logo-sm">
          <img src="{{URL::to('assets/admin/images/logo-dark.png')}}" alt="" height="24">
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

  <!-- ========== Left Sidebar Start ========== -->
  <div class="left-side-menu">
    <div class="slimscroll-menu">
      <!--- Sidemenu -->
      <div id="sidebar-menu">

        <ul class="metismenu heading" id="side-menu">
          <li>
            <a href="javascript: void(0);">
              <i class="mdi mdi mdi-city"></i>
              <span>Institute Applications</span>
              <span class="menu-arrow"></span>
            </a>
            <ul class="nav-second-level" aria-expanded="false">
              <li><a href="{{route('admin.institute-applications.index')}}">New Applications</a></li>
              <li><a href="{{route('admin.institute-applications.resolved')}}">Resolved Applications</a></li>
            </ul>
          </li>
          <li>
		    <?php $count_ = \App\Models\Institute::where('videoApproval', 0)->whereNotNull('video')->count();
              $count_  += \App\Models\InstituteAssignedClassSubject::where('videoApproval', 0)->whereNotNull('video')->count();
              $count_  += \App\Models\InstituteAssignedClass::where('videoApproval', 0)->whereNotNull('video')->count();
                ?>
            <a href="javascript: void(0);">
              <i class="mdi mdi mdi-bank"></i>
              <span>Manage Institutes {{ $count_ ? '(' . $count_ . ')' : '' }}</span>
              <span class="menu-arrow"></span>
            </a>
            <ul class="nav-second-level" aria-expanded="false">
              <li><a href="{{route('admin.manage-institutes.index')}}">Old Institute</a></li>
              <li><a href="{{route('admin.manage-institutes.create')}}">Add Institute</a></li>
              <li><a href="{{ route('admin.manage-institutes.list/user') }}">Add Zoom User</a></li>
            </ul>
          </li>
          <li>
            <a href="{{route('admin.manage-students.index')}}">
              <i class="mdi mdi-account-multiple"></i><span>Manage Students</span>
            </a>
          </li>
          <li>
            <a href="{{route('admin.coupons.index')}}" class="waves-effect">
              <i class="mdi mdi-account-multiple"></i><span>Coupons</span>
            </a>
          </li>
        </ul>

      </div>
      <!-- End Sidebar -->

      <div class="clearfix"></div>

    </div>
    <!-- Sidebar -left -->

  </div>
  <!-- Left Sidebar End -->

  {{-- @include('admin.layouts.sidebar') --}}