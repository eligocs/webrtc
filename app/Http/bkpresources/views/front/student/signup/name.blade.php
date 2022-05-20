@extends('front.layouts.app')
@section('content')
<!-- signup -->
<section class="student-signup">
    <div class="container">
        <form id="form-reply" method="post" action="{{route('front.student.signup.phone_number')}}">
            @csrf
            <div class="wrap-input-all clearfix row">
                <label class="col-md-4 col-lg-4">
                    <b>Enter Your Name</b><br>
                    <span>Please enter your full name to setup account.</span>
                </label>
                <div class="wrap-input one-of-two pd-right-15 col-md-7 ml-auto col-lg-7"> 
                    <input type="text" name="name" required=""> 
                </div>
            </div>
            <div class="text-right mt-md-4 mt-lg-4">
                <button type="submit" class="flat-button btn-send btn">
                    Next<img class="right-arw" src="{{ URL::to('assets/front/images/right-arrow.svg')}}">
                </button>
                {{-- <button type="button" class="flat-button btn-send btn">
                <a href="{{route('front.student.signup.phone_number')}}">Next
                    <img class="right-arw" src="{{ URL::to('assets/front/images/right-arrow.svg')}}">
                </a>
            </button> --}}            
            </div>
        </form>
    </div>
</section>
<!-- end -->

@endsection