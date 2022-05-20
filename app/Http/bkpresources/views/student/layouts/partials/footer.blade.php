<!-- Footer Start -->
<footer class="footer">
    <div class="container-fluid">
       <div class="row">
          <div class="col-md-6">
             {{date('Y')}} &copy; <a href="" class="theme-clr">AVESTUD</a>
          </div>
       </div>
    </div>
 </footer>
 <!-- end Footer --><!-- Vendor js -->
<script src="{{URL::to('assets/student/js/vendor.min.js')}}"></script>
 <script src="{{URL::to('assets/student/js/jquery.fancybox.js')}}"></script>
 <!-- App js -->
 <script src="{{URL::to('assets/student/js/app.min.js')}}"></script>
@stack('js')  