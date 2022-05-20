@extends('front.layouts.app')
@section('content')
<!-- signup -->
<section class="student-signup">
    <div class="container">
        @if(session()->has('error'))
            <div class="alert alert-danger">
                {{ session()->get('error') }}
            </div>  
        @endif
        @if(isset($name) && isset($phone_number) && $name != null && $phone_number != null)
        <form id="student_form" method="post" action="{{route('front.student.signup.register_student')}}">
            @csrf
            <div class="wrap-input-all clearfix row">
                <label class="col-md-4 col-lg-4">
                    <b>Setup Account Password</b><br>
                    <span>Please setup your password to continue.</span>
                </label>
                <div class="wrap-input one-of-two pd-right-15 col-md-7 ml-auto col-lg-7">
                    <input type="hidden" id="name" name="name" value="{{$name ?? ''}}" />
                    <input type="hidden" id="phone_number" name="phone_number" value="{{$phone_number ?? ''}}" />                    
                    <input type="text" id="password" name="password" required="" placeholder="Enter your password">
                    <input type="text" id="confirm_password" name="confirm_password" required="" placeholder="Confirm your password" class="mt-2">
                </div>
            </div>  
            <div class="text-right mt-md-4 mt-lg-4 d-flex justify-content-between">
                <button type="button" class="flat-button btn-send btn ">
                    <a href="{{route('front.student.signup.otp')}}">
                        <img class="right-arw" src="{{ URL::to('assets/front/images/left2.svg')}}">&nbsp;&nbsp;Back
                    </a>
                </button>
                <button type="button" class="flat-button btn-send btn " id="submit_student_register_form">
                    Finish <img class="right-arw" src="{{ URL::to('assets/front/images/right-arrow.svg')}}">
                </button>
            </div>
            <div class="response text-center alert-success"></div>
        </form>
        @else
            <p class="text-center alert-danger">Sorry, not allowed to this page. Please go back to student register page.</p>
        @endif
    </div>
 </section>
 <!-- end -->
<input type="hidden" id="student_register_url" value="{{route('front.student.signup.register_student')}}" />
@endsection
@section('js')
<script>
    $(document).ready(function(){
        $('#submit_student_register_form').click(function(){
            $('#submit_student_register_form').html('<i class="fa fa-spinner fa-spin" style="font-size:24px"></i>');  
            let student_register_url = $('#student_register_url').val(); 
            let name = $('#name').val();
            let phone_number = $('#phone_number').val();
            let password = $('#password').val();
            let confirm_password = $('#confirm_password').val();
            $.ajax({            
                type:'POST',
                url:student_register_url,
                data:{
                    "_token": "{{ csrf_token() }}",
                    'name':name,
                    'phone_number':phone_number,
                    'password':password,
                    'confirm_password':confirm_password,
                },
                success:function(return_data) { 
                    $('#submit_student_register_form').html('Finish');
                    if(return_data.status == 'Success'){ 
                        $('.response').html(return_data.message);
                    }
                }
            });
        });
    });
</script>
@endsection