<!-- Footer Start -->
<footer class="footer">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6">
                {{ date('Y') }} &copy; <a href="" class="theme-clr">AVESTUD</a>
            </div>
        </div>
    </div>
</footer>
<!-- end Footer -->


<!-- END wrapper -->

<!-- Right Sidebar -->
<div class="right-bar">
    <div class="rightbar-title">
        <a href="javascript:void(0);" class="right-bar-toggle float-right">
            <i class="dripicons-cross noti-icon"></i>
        </a>
        <h4 class="m-0 text-white">Settings</h4>
    </div>
    <div class="slimscroll-menu">
        <!-- User box -->
        <div class="user-box">
            <div class="user-img">
                <img src="{{ URL::to('assets/institute/images/users/user-1.jpg') }}" alt="user-img" title="Mat Helme"
                    class="rounded-circle img-fluid">
                <a href="javascript:void(0);" class="user-edit"><i class="mdi mdi-pencil"></i></a>
            </div>

            <h5><a href="javascript: void(0);">Nowak Helme</a> </h5>
            <p class="text-muted mb-0"><small>Admin Head</small></p>
        </div>

        <!-- Settings -->
        <hr class="mt-0" />
        <h5 class="pl-3">Basic Settings</h5>
        <hr class="mb-0" />

        <div class="p-3">
            <div class="checkbox checkbox-primary mb-2">
                <input id="Rcheckbox1" type="checkbox" checked>
                <label for="Rcheckbox1">
                    Notifications
                </label>
            </div>
            <div class="checkbox checkbox-primary mb-2">
                <input id="Rcheckbox2" type="checkbox" checked>
                <label for="Rcheckbox2">
                    API Access
                </label>
            </div>
            <div class="checkbox checkbox-primary mb-2">
                <input id="Rcheckbox3" type="checkbox">
                <label for="Rcheckbox3">
                    Auto Updates
                </label>
            </div>
            <div class="checkbox checkbox-primary mb-2">
                <input id="Rcheckbox4" type="checkbox" checked>
                <label for="Rcheckbox4">
                    Online Status
                </label>
            </div>
            <div class="checkbox checkbox-primary mb-0">
                <input id="Rcheckbox5" type="checkbox" checked>
                <label for="Rcheckbox5">
                    Auto Payout
                </label>
            </div>
        </div>

        <!-- Timeline -->
        <hr class="mt-0" />
        <h5 class="pl-3 pr-3">Messages <span class="float-right badge badge-pill badge-danger">25</span></h5>
        <hr class="mb-0" />
        <div class="p-3">
            <div class="inbox-widget">
                <div class="inbox-item">
                    <div class="inbox-item-img"><img src="{{ URL::to('assets/institute/images/users/user-2.jpg') }}"
                            class="rounded-circle" alt=""></div>
                    <p class="inbox-item-author"><a href="javascript: void(0);" class="text-dark">Tomaslau</a></p>
                    <p class="inbox-item-text">I've finished it! See you so...</p>
                </div>
                <div class="inbox-item">
                    <div class="inbox-item-img"><img src="{{ URL::to('assets/institute/images/users/user-3.jpg') }}"
                            class="rounded-circle" alt=""></div>
                    <p class="inbox-item-author"><a href="javascript: void(0);" class="text-dark">Stillnotdavid</a>
                    </p>
                    <p class="inbox-item-text">This theme is awesome!</p>
                </div>
                <div class="inbox-item">
                    <div class="inbox-item-img"><img src="{{ URL::to('assets/institute/images/users/user-4.jpg') }}"
                            class="rounded-circle" alt=""></div>
                    <p class="inbox-item-author"><a href="javascript: void(0);" class="text-dark">Kurafire</a></p>
                    <p class="inbox-item-text">Nice to meet you</p>
                </div>

                <div class="inbox-item">
                    <div class="inbox-item-img"><img src="{{ URL::to('assets/institute/images/users/user-5.jpg') }}"
                            class="rounded-circle" alt=""></div>
                    <p class="inbox-item-author"><a href="javascript: void(0);" class="text-dark">Shahedk</a></p>
                    <p class="inbox-item-text">Hey! there I'm available...</p>
                </div>
                <div class="inbox-item">
                    <div class="inbox-item-img"><img src="{{ URL::to('assets/institute/images/users/user-6.jpg') }}"
                            class="rounded-circle" alt=""></div>
                    <p class="inbox-item-author"><a href="javascript: void(0);" class="text-dark">Adhamdannaway</a>
                    </p>
                    <p class="inbox-item-text">This theme is awesome!</p>
                </div>
            </div> <!-- end inbox-widget -->
        </div> <!-- end .p-3-->

    </div> <!-- end slimscroll-menu-->
</div>
<!-- /Right-bar -->

<!-- Right bar overlay-->
<div class="rightbar-overlay"></div>

<!-- Vendor js -->
<script src="{{ URL::to('assets/institute/js/vendor.min.js') }}"></script>

<!-- knob plugin -->
<script src="{{ URL::to('assets/institute/libs/jquery-knob/jquery.knob.min.js') }}"></script>

<!--Morris Chart-->
<script src="{{ URL::to('assets/institute/libs/morris-js/morris.min.js') }}"></script>
<script src="{{ URL::to('assets/institute/libs/raphael/raphael.min.js') }}"></script>

<!-- Dashboard init js-->
<script src="{{ URL::to('assets/institute/js/pages/dashboard.init.js') }}"></script>
<script src="{{ URL::to('assets/institute/libs/custombox/custombox.min.js') }}"></script>

<!-- Plugins Js -->
<script src="{{ URL::to('assets/institute/libs/bootstrap-tagsinput/bootstrap-tagsinput.min.js') }}"></script>
<script src="{{ URL::to('assets/institute/libs/switchery/switchery.min.js') }}"></script>
<script src="{{ URL::to('assets/institute/libs/multiselect/jquery.multi-select.js') }}"></script>
<script src="{{ URL::to('assets/institute/libs/jquery-quicksearch/jquery.quicksearch.min.js') }}"></script>

<script src="{{ URL::to('assets/institute/libs/select2/select2.min.js') }}"></script>
<script src="{{ URL::to('assets/institute/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.js') }}"></script>
<script src="{{ URL::to('assets/institute/libs/jquery-mask-plugin/jquery.mask.min.js') }}"></script>
<script src="{{ URL::to('assets/institute/libs/moment/moment.js') }}"></script>
<script src="{{ URL::to('assets/institute/libs/bootstrap-timepicker/bootstrap-timepicker.min.js') }}"></script>
<script src="{{ URL::to('assets/institute/libs/bootstrap-colorpicker/bootstrap-colorpicker.min.js') }}"></script>
<script src="{{ URL::to('assets/institute/libs/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ URL::to('assets/institute/libs/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
<script src="{{ URL::to('assets/institute/libs/bootstrap-maxlength/bootstrap-maxlength.min.js') }}"></script>

<!-- Init js-->
<script src="{{ URL::to('assets/institute/js/pages/form-advanced.init.js') }}"></script>
<!-- Chart JS -->
{{-- <script src="{{URL::to('assets/institute/libs/chart-js/Chart.bundle.min.js')}}"></script>

<!-- Init js -->
<script src="{{URL::to('assets/institute/js/pages/chartjs.init.js')}}"></script>
<!--Chartist Chart-->
<script src="{{URL::to('assets/institute/libs/chartist/chartist.min.js')}}"></script>
<script src="{{URL::to('assets/institute/libs/chartist/chartist-plugin-tooltip.min.js')}}"></script>

<!-- Init js --> --}}
{{-- <script src="{{ URL::to('assets/institute/js/pages/chartist.init.js') }}"></script> --}}

<script src="{{ URL::to('assets/institute/js/jquery.fancybox.js') }}"></script>
<!-- App js -->
<script src="{{ URL::to('assets/institute/js/app.min.js') }}"></script>
@stack('js')
