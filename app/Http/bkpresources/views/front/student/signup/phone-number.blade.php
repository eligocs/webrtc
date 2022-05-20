@extends('front.layouts.app')
@section('content')

<!-- signup step2-->
<section class="student-signup">
   
    <div class="container">
        @if(isset($name) && $name == null)
            <p class="text-center alert-danger">Please go back to fill your name.</p><br>
        @endif
        <form id="form-reply" method="post" action="{{route('front.student.signup.otp')}}">
            @csrf
            <div class="wrap-input-all clearfix row">
                <label class="col-md-4 col-lg-4">
                    <b>Hi {{$name ?? ''}}</b><br>
                    <span>Enter your phone Number for OTP Verification</span>
                </label>
                <div
                    class="wrap-input one-of-two pd-right-15 col-md-7 ml-auto col-lg-7 d-flex justify-content-end">
                    <!-- <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1">@</span>
                    </div>
                    <input type="text" name="numeric" required=""> -->
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text text-white bg-color-main" id="basic-addon1">+91</span>
                        </div>
                        <input type="text" name="phone_number" class="form-control" placeholder="" aria-label="Username" aria-describedby="basic-addon1" @if(isset($name) && $name == null) disabled  @endif>
                        <input type="hidden" name="otp_time" value="{{ date("Y-m-d h:i:s" )}}" />
                        <input type="hidden" name="name" value="{{$name ?? ''}}" />
                    </div>
                </div>
            </div>
            <div class="text-right mt-md-4 mt-lg-4 d-flex justify-content-between">
                <button type="button" class="flat-button btn-send btn ">
                    <a href="{{route('front.student.signup.name')}}">
                        <img class="right-arw" src="{{ URL::to('assets/front/images/left2.svg')}}">&nbsp;&nbsp;Back
                    </a>
                </button>
                <button type="submit" class="flat-button btn-send btn " @if(isset($name) && $name == null) disabled  @endif>
                    Next <img class="right-arw" src="{{ URL::to('assets/front/images/right-arrow.svg')}}"> 
                </button>
            </div>
        </form>
    </div>
</section>
<!-- end -->
@endsection