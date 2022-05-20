<!-- Footer Start -->
<footer class="footer">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-6">
        2020 &copy; <a href="" class="theme-clr">AVESTUD</a>
      </div>
    </div>
  </div>
</footer>
<!-- end Footer -->

</div>

<!-- ============================================================== -->
<!-- End Page content -->
<!-- ============================================================== -->


</div>
<!-- END wrapper -->
<!-- Right bar overlay-->
<div class="rightbar-overlay"></div>

<!-- Vendor js -->
<script src="{{URL::to('assets/admin/js/vendor.min.js')}}"></script>

<!-- knob plugin -->
<script src="{{URL::to('assets/admin/libs/jquery-knob/jquery.knob.min.js')}}"></script>

<!--Morris Chart-->
<script src="{{URL::to('assets/admin/libs/morris-js/morris.min.js')}}"></script>
<script src="{{URL::to('assets/admin/libs/raphael/raphael.min.js')}}"></script>

<!-- Dashboard init js-->
<script src="{{URL::to('assets/admin/js/pages/dashboard.init.js')}}"></script>
<script src="{{URL::to('assets/admin/libs/custombox/custombox.min.js')}}"></script>

<!-- Plugins Js -->
<script src="{{URL::to('assets/admin/libs/bootstrap-tagsinput/bootstrap-tagsinput.min.js')}}"></script>
<script src="{{URL::to('assets/admin/libs/switchery/switchery.min.js')}}"></script>
<script src="{{URL::to('assets/admin/libs/multiselect/jquery.multi-select.js')}}"></script>
<script src="{{URL::to('assets/admin/libs/jquery-quicksearch/jquery.quicksearch.min.js')}}"></script>

<script src="{{URL::to('assets/admin/libs/select2/select2.min.js')}}"></script>
<script src="{{URL::to('assets/admin/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.js')}}"></script>
<script src="{{URL::to('assets/admin/libs/jquery-mask-plugin/jquery.mask.min.js')}}"></script>
<script src="{{URL::to('assets/admin/libs/moment/moment.js')}}"></script>
<script src="{{URL::to('assets/admin/libs/bootstrap-timepicker/bootstrap-timepicker.min.js')}}"></script>
<script src="{{URL::to('assets/admin/libs/bootstrap-colorpicker/bootstrap-colorpicker.min.js')}}"></script>
<script src="{{URL::to('assets/admin/libs/bootstrap-datepicker/bootstrap-datepicker.min.js')}}"></script>
<script src="{{URL::to('assets/admin/libs/bootstrap-daterangepicker/daterangepicker.js')}}"></script>
<script src="{{URL::to('assets/admin/libs/bootstrap-maxlength/bootstrap-maxlength.min.js')}}"></script>

<!-- Init js-->
<script src="{{URL::to('assets/admin/js/pages/form-advanced.init.js')}}"></script>
<!-- Chart JS -->
<script src="{{URL::to('assets/admin/libs/chart-js/Chart.bundle.min.js')}}"></script>

<!-- Init js -->
<script src="{{URL::to('assets/admin/js/pages/chartjs.init.js')}}"></script>
<!--Chartist Chart-->
<script src="{{URL::to('assets/admin/libs/chartist/chartist.min.js')}}"></script>
<script src="{{URL::to('assets/admin/libs/chartist/chartist-plugin-tooltip.min.js')}}"></script>

<!-- Init js -->
<script src="{{URL::to('assets/admin/js/pages/chartist.init.js')}}"></script>

<!-- fancybox -->
<script src="{{URL::to('assets/admin/js/jquery.fancybox.js')}}"></script>
<!-- App js -->
<script src="{{URL::to('assets/admin/js/app.min.js')}}"></script>



@yield('js')
@stack('js')