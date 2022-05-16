<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>AVESTUD - Institute</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="AVESTUD - Institute" name="description" />
    <meta content="Coderthemes" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ URL::to('assets/institute/images/favicon.png') }}">

    <link rel="stylesheet" href="{{ URL::to('assets/institute/libs/chartist/chartist.min.css') }}">
    <!-- Custom box css -->
    <link href="{{ URL::to('assets/institute/libs/custombox/custombox.min.css') }}" rel="stylesheet">

    <!-- Plugins css -->
    <link href="{{ URL::to('assets/institute/libs/bootstrap-tagsinput/bootstrap-tagsinput.css') }}" rel="stylesheet" />
    <link href="{{ URL::to('assets/institute/libs/switchery/switchery.min.css') }}" rel="stylesheet" type="text/css" />

    <link href="{{ URL::to('assets/institute/libs/multiselect/multi-select.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::to('assets/institute/libs/select2/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::to('assets/institute/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.css') }}"
        rel="stylesheet" />
    <link href="{{ URL::to('assets/institute/libs/switchery/switchery.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::to('assets/institute/libs/bootstrap-timepicker/bootstrap-timepicker.min.css') }}"
        rel="stylesheet">
    <link href="{{ URL::to('assets/institute/libs/bootstrap-colorpicker/bootstrap-colorpicker.min.css') }}"
        rel="stylesheet">
    <link href="{{ URL::to('assets/institute/libs/bootstrap-datepicker/bootstrap-datepicker.css') }}" rel="stylesheet">
    <link href="{{ URL::to('assets/institute/libs/bootstrap-daterangepicker/daterangepicker.css') }}" rel="stylesheet">
    {{-- jquery cdn --}}
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Chartist Chart CSS -->
    <link rel="stylesheet" href="{{ URL::to('assets/institute/libs/chartist/chartist.min.css') }}">
    <!-- App css -->
    <link href="{{ URL::to('assets/institute/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::to('assets/institute/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::to('assets/institute/css/app.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::to('assets/institute/css/fonts.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::to('assets/institute/css/jquery.fancybox.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::to('assets/institute/css/style.css') }}" rel="stylesheet" type="text/css" />
</head>
<style>
a#btn-2 {
    background-image: linear-gradient(to right, #52be65, #73e52c);
    border-radius: 3px;
    padding: 11px 14px;
    font-size: 14px;
    color: rgb(255, 255, 255);
}

div#live-btn {
    padding-right: 10px;
}

div#add-btn {
    padding-left: 45%;
}

#hem-size {
    padding: 100px;
}
</style>

<body>
    <!-- Begin page -->
    <div id="wrapper">

        @include('institute.layouts.partials.header')

        @include('institute.layouts.partials.leftsidebar')

        <div class="content-page">
            <div class="content">
                @if (session()->has('message'))
                <div class="alert alert-success success_message alert-dismissible">
                    <a type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </a>
                    {{ session()->get('message') }}
                </div>
                @endif
                @yield('content')

            </div> <!-- content -->


            @include('institute.layouts.partials.footer')
        </div> 

    </div>
            @yield('js')
</body>
<script>
$(document).ready(function() {
    $('.inputChange').change(function(e) {
        e.preventDefault();
        var fileExtension = ['pdf'];
        if ($.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) == -1) {
            alert("Only formats are allowed : " + fileExtension.join(', '));
        } else {
            $('.syllabusform').submit();
        }
    });

    $('.get_classes').click(function() {
        $('.attendanceCal').html('');
        $('.subject_options').val('');
        var student_id = $(this).data('student');
        var iacs = $(this).data('iacs');
        $('.student_id').val(student_id);
        $('.iacs').val(iacs);
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "{{ url('institute/getClass') }}",
            method: "post",
            data: {
                student_id: student_id,
                iacs: iacs
            },
            success: function(response) {
                $('.subject_options').html(response.options);
            }
        });

    });

    /*      $('.class_options').change(function(){
              var class_id = $(this).val();
              var iacs = $('.iacs').val();
              if(class_id){
                  $.ajax({
                      headers: {
                          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                      },
                      url: "{{ url('institute/getattendance') }}",
                      method: "post",
                      data: {class_id : class_id, iacs:iacs},
                      success: function(response) {
                          $('.subject_options').html(response.options);
                      }
                  });
              }else{
                  $('.subject_options').html('<option>--Select--</option>');
                  $('.attendanceCal').html('');
              }
          }); */

    $('.subject_options').change(function() {
        var subject_id = $(this).val();
        var student = $('.student_id').val();
        var iacs = $('.iacs').val();
        if (subject_id) {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{ url('institute/getSubAtt') }}",
                method: "post",
                data: {
                    subject_id: subject_id,
                    student: student,
                    iacs: iacs
                },
                success: function(response) {
                    $('.attendanceCal').html(response.html);
                }
            });
        } else {
            $('.attendanceCal').html('');
        }
    });

});
</script>

</html>