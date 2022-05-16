@extends('front.layouts.app')
@section('content')
    <!-- signup -->
    <section class="student-signup">
        <div class="container">
            
            @if(Session::has('otp'))
                <div class="alert alert-danger">
                    {{ Session::get('otp')}} 
                    @php 
                        $otp_time = Session::get('otp_time');
                        $current_time = date("Y-m-d h:i:s" );
                        $left = '';
                        $left = strtotime($current_time) - strtotime($otp_time);
                        echo $left;
                    @endphp
                </div>
            @endif
            @if(session()->has('error'))
                <div class="alert alert-danger">
                    {{ session()->get('error') }}
                </div>  
            @endif
            <form id="form-reply" method="post" action="{{route('front.student.signup.password')}}">   
                @csrf              
                <div class="wrap-input-all clearfix row">
                    <label class="col-md-4 col-lg-4">
                        <b>Verify OTP,</b><br>
                        <span>We sent a code on your +91-xxx-xxx-xxx number.</span>
                    </label>
                    <div class="wrap-input one-of-two pd-right-15 col-md-7 ml-auto col-lg-7">

                        <div class="flat-adds mb-2 flat-text-right">
                            <p class="font-weight-700 datetime bg-color-resend black">Resend <span class="">22</span></p>
                        </div>
                        <input type="text" name="otp" required="">
                        <input type="hidden" name="name" value="{{$name ?? ''}}" />
                        <input type="hidden" name="phone_number" value="{{$phone_number ?? ''}}" />
                    </div>
                </div>
                <div class="text-right mt-md-4 mt-lg-4 d-flex justify-content-between">
                    <button type="button" class="flat-button btn-send btn ">
                        <a href="{{route('front.student.signup.phone_number')}}">
                            <img class="right-arw" src="{{ URL::to('assets/front/images/left2.svg')}}">&nbsp;&nbsp;Back
                        </a>
                    </button>
                    <button type="submit" class="flat-button btn-send btn "> 
                        Next<img class="right-arw" src="{{ URL::to('assets/front/images/right-arrow.svg')}}">
                    </button>
                </div>
            </form>
        </div>
    </section>
    <!-- end -->

@endsection