@extends('front.layouts.app')
@section('content')
<style>
  .error {
    color: red;
  }

  .note {
    color: #ff5151;
    text-shadow: 2px 2px 2px black;
  }
</style>
<!-- 
        =============================================
            Theme Inner Banner 
        ============================================== 
     -->
<div class="inner-page-banner join_banner  mb-80">
  <div class="opacity">
    <h1>Join Us</h1>
    <p class="test-center note"> Below Application form is only for Institute's and tuition center's</p>
  </div> <!-- /.opacity -->
</div> <!-- /inner-page-banner -->
<div class="content-wrap blog-single-page join_bg mt-0 pt-0">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8 col-md-offset-2">
        <div class="flat-form-reply">
          <h3 class="title text-center">INSTITUTE APPLICATION FORM</h3>
          <form id="join-institute-form" method="post" action="{{route('front.institute-application')}}">
            {{ csrf_field() }}
            <div class="row">
              <div class="col-md-2 p-0"><label>Name of Applicant</label></div>
              <div class="wrap-input-all clearfix col-md-5">
                <div class="wrap-input ">
                  <input type="text" name="firstname" id="firstname" placeholder="First Name" required="">
                </div>
              </div>
              <div class="wrap-input-all clearfix col-md-5">
                <div class="wrap-input ">
                  <input type="text" name="lastname" id="lastname" placeholder="Last Name" required="">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-2 p-0"><label>Name of Institute</label></div>
              <div class="wrap-input-all clearfix col-md-10">
                <div class="wrap-input ">
                  <input type="text" name="name" id="name" required="">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-2 p-0"><label>Email</label></div>
              <div class="wrap-input-all clearfix col-md-10">
                <div class="wrap-input">

                  <input type="email" name="email" id="email" required="" class="brdr-df4c4c">

                  {{-- <p class="color-df4c4c pt-1 mb-0">Please specify a valid email address.</p> --}}

                </div>

              </div>
            </div>

            <div class="row">
              <div class="col-md-2 p-0"><label>Address</label></div>
              <div class="col-md-10">
                <div class="wrap-input-all clearfix">

                  <div class="wrap-input">

                    <input type="text" name="address" id="address" placeholder="Address Line1" required="">

                  </div>
                </div>
                <div class="wrap-input-all clearfix">
                  <div class="wrap-input">

                    <input type="text" name="address2" id="address2" placeholder="Address Line2" required="">
                  </div>
                </div>
                <div class="wrap-input-all clearfix  col-md-6 pl-0  p-sm-0">
                  <div class="wrap-input">
                    <input type="text" name="city" id="city" placeholder="City" required="">
                  </div>
                </div>
                <div class="wrap-input-all clearfix  col-md-6 pr-0   p-sm-0">
                  <div class="wrap-input">
                    <input type="text" name="state" id="state" placeholder="State" required="">
                  </div>
                </div>
                <div class="wrap-input-all clearfix  col-md-6 pl-0   p-sm-0">
                  <div class="wrap-input">
                    <input type="text" name="zipcode" id="zipcode" placeholder="Zip Code" required="">
                  </div>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-2 p-0"><label>Phone Number</label></div>
              <div class="wrap-input-all clearfix col-md-10">
                <div class="wrap-input">
                  <input type="text" name="phone_no" id="phone_no" required="">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-2 p-0"><label>Mobile Number</label></div>
              <div class="wrap-input-all clearfix col-md-10">
                <div class="wrap-input">
                  <input type="text" name="mobile_no" id="mobile_no" required="">
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-2 p-0"><label>Type of Class</label></div>
              <div class="wrap-input-all clearfix col-md-10">
                <div class="wrap-input">
                  <input type="text" name="type_of_class" id="type_of_class" required="">
                </div>
              </div>
            </div>

            <div class="row d-flex">
              <div class="col-md-2 p-0"><label>Desrciption</label></div>
              <div class="wrap-textarea col-md-10 ml-10 clearfix">
                <textarea name="description" id="description" rows="4" required=""></textarea>
              </div>
            </div>

            <div class="wrap-btn text-center">

              <button type="submit"
                class="flat-button btn-send br-24 btn tran3s hvr-trim wow fadeInUp animated p-bg-color button-one hvr-icon-wobble-horizontal send_application_btn">
                SEND APPLICATION<i class="fa fa-long-arrow-right ryt-arw" aria-hidden="true"></i>
              </button>
              {{-- <button type="submit" class="flat-button btn-send br-24 btn tran3s hvr-trim wow fadeInUp animated p-bg-color button-one hvr-icon-wobble-horizontal" data-toggle="modal" data-target="#testModal" data-wow-delay="0.3s">

                                    SEND APPLICATION<i class="fa fa-long-arrow-right ryt-arw" aria-hidden="true"></i>

                                </button> --}}
              <div class="response"></div>
              <!-- Modal -->

              <div class="modal fade" id="confirmModal" tabindex="-1" role="dialog" aria-labelledby="confirmModalLabel"
                aria-hidden="true">

                <div class="modal-dialog" role="document">
                  <div class="modal-content">
                    <div class="modal-body join-institute-form-modal">
                      Your Application has been successfully sent.
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-primary " data-dismiss="modal">Ok</button>
                    </div>
                  </div>
                </div>
              </div>
              <!-- Modal-end -->
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div> <!-- /.container -->
@endsection
@section('js')
<script src="{{ URL::to('assets/front/js/jquery-validate.js')}}"></script>
<script src="{{ URL::to('assets/front/js/custom.js')}}"></script>
@endsection