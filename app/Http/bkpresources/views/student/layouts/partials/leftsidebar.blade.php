<!-- ========== Left Sidebar Start ========== -->
<div class="left-side-menu">
    <div class="slimscroll-menu">
        <div class="user-box text-center ">
            <div class="designer_img rounded-circle img-thumbnail avatar-lg">
                <img src="{{!empty(auth()->user()->student->avatar) ? auth()->user()->student->avatar : '/assets/front/images/cost.png'}}"
                    alt="user-img" title="Mat Helme" class="w-100">
            </div>
            <div class="dropdown">
                <a href="#" class="text-dark h5 mt-2 mb-1 d-block">{{auth()->user()->student->name}}</a>
            </div>
            <p class="text-muted">Student</p>
            <ul class="list-inline">
                {{-- <li class="list-inline-item">
                <a href="#" class="text-muted">
                <i class="mdi mdi-settings"></i>
                </a>
             </li> --}}
                {{-- <li class="list-inline-item">
                <a href="#" class="text-custom">
                <i class="mdi mdi-power"></i>
                </a>
             </li> --}}
            </ul>
        </div>
        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <ul class="metismenu heading" id="side-menu">
                <!-- <li>
          <a href="{{route('student.my-classes')}}">
            <i class="mdi mdi-book"></i>
            <span> My Study Room </span>
          </a>
        </li> -->
                <li>
                    <a href="{{route('student.home')}}">
                        <i class="mdi mdi-receipt"></i>
                        <span>My Classes</span>
                    </a>
                </li>
                <li>
                    <a href="{{route('student.search_classes')}}">
                        <i class="mdi mdi-account-search"></i>
                        <span> Search Classes </span>
                    </a>
                </li>
                <li>
                    <a href="{{route('student.profile')}}">
                        <i class="mdi mdi-account"></i>
                        <span>My profile</span>
                    </a>
                </li>
                <li>
                    <a href="{{route('student.download-receipt')}}">
                        <i class="mdi mdi-receipt"></i>
                        <span> Download Receipt</span>
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