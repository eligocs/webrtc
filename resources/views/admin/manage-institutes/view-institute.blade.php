@extends('admin.layouts.app')
@section('page_heading', 'View Institute')
@section('content')
<style>
    .switch {
            position: relative;
            display: inline-block;
            width: 60px;
            height: 34px;
        }

        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            -webkit-transition: .4s;
            transition: .4s;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 26px;
            width: 26px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            -webkit-transition: .4s;
            transition: .4s;
        }

        input:checked+.slider {
            background-color: #2196F3;
        }

        input:focus+.slider {
            box-shadow: 0 0 1px #2196F3;
        }

        input:checked+.slider:before {
            -webkit-transform: translateX(26px);
        }
        /* .approve_checkbox { 
            float: right;
            margin-top: -80px;
        } */
        .approve_checkbox.ml-auto {
            margin-top: -70px;
        }


 
</style>
<div class="container-fluid">
    <div>{{ Breadcrumbs::render('view-institute', request()->id) }}</div>
    @if (session()->has('message'))
                <div class="alert alert-success success_message">
                    {{ session()->get('message') }}
                </div>
            @endif
    <div class="row mx-0 card-box">
        <div class="col-md-12 d-md-flex justify-content-end">
            <a href="{{route('admin.manage-institutes.create-institute-user',$institute->id)}}"
                class="btn-theme btn-style ml-1">Add User</a>
            <a href="{{route('admin.manage-institutes.view-institute-detail',$institute->id)}}"
                class="btn-theme btn-style ml-1">View Institute Detail</a>
            <a href="{{url('admin/manage-institutes/add-new-class'.'/'.$institute->id)}}"
                class="btn-theme btn-style ml-1">Add
                New Class</a>
            <a href="{{route('admin.teachers.index',$institute->id)}}" class="btn-theme btn-style ml-1">View Teacher</a>
        </div>
        <div class="col-md-12 mb-4">
            <h3 class="heading-title mt-0 mb-0 text-center heading">{{$institute->name}}</h3>
           <!--  <p class='text-center'>@if (!empty($institute->description))
                    {{$institute->description}}
                @endif</p> -->
            {{-- <h4 class=" m-0 text-center fw-100">By Akaash Institute</h4> --}}
            <div class='alertMsg'></div>
        </div>
        @if( $institute->institute_assigned_classes->count() > 0 )

        @foreach ($institute->institute_assigned_classes as $institute_assigned_class)

        <div class="col-lg-4">
            <div class="card box-shadow">
                <div class="card-body">

                    <p class="text-right">
                        @if($institute_assigned_class->freetrial == 1)
                        <button class='btn btn-danger'
                            onclick="if(confirm('Are you sure to disable free trial for this class !!!')){enableTrial({{$institute_assigned_class->id}});}">Disable
                            Free Trial</button>&nbsp;&nbsp;
                        @else
                        <button class='btn btn-success'
                            onclick="if(confirm('Are you sure to start free trial for this class !!!')){enableTrial({{$institute_assigned_class->id}});}">Enable
                            Free Trial</button>&nbsp;&nbsp;
                        @endif
                        <a
                            href='{{route("admin.manage-institutes.edit-class",["class_id"=>$institute_assigned_class->id,"institute_id"=>$institute->id])}}'><i
                                class="fa fa-edit" style="color: #644699; cursor: pointer;"></i></a> &nbsp;&nbsp;<i
                            class="fa fa-trash" style="color: #bb4141; cursor: pointer;"
                            onclick="if(confirm('Are you sure to delete this class')){deleteClass({{$institute_assigned_class->id}});}"></i>
                    </p>

                    <div class="profile-statistics">
                        <div class="text-center mt-2 border-bottom">
                            <div class="my-4">
                                <div class="btn-theme pl-2 pr-2 py-2 mr-0 mb-4">{{$institute_assigned_class->name}}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="profile-blog pt-1 border-bottom pb-1 ">
                        <h5 class="theme-clr justify-content-between  d-flex align-items-center">
                            {{$institute_assigned_class->language_table->name ?? '' }}<a href="javascript:void()"
                                class="theme-clr pull-right f-s-16">{{$institute_assigned_class->board}}</a> </h5>
                    </div>
                    <div class="profile-blog pt-1 border-bottom pb-1 ">
                        <h5 class="theme-clr  justify-content-between  d-flex align-items-center text-capitalize">
                            {{$institute_assigned_class->state}}
                            <span class="pull-right f-s-16">{{$institute_assigned_class->city}}</span>
                        </h5>
                    </div>
                    <div class="profile-interest mt-2 pb-2 border-bottom">
                        <div class="row mt-0">

                            @if($institute_assigned_class->institute_assigned_class_subject->count() > 0 )

                            @foreach( $institute_assigned_class->institute_assigned_class_subject as $subject ) 
                            <div class="col-lg-6 col-xl-6 col-sm-6 col-6 int-col">
                                <a href="{{route('admin.institute-subject.detail',[$subject->id,$subject->subject_id])}}"
                                    class="btn btn-theme my-1 w-100 waves-effect waves-light cursor-default text-white">{{$subject->subject->name ?? ''}}
                                     @if(!empty($subject->video) && empty($subject->videoApproval))
                                        (1)
                                     @endif
                                    </a>
                            </div>
                            @endforeach

                            @endif

                        </div>
                    </div>
                    <div class="profile-videobox border-bottom position-relative">
                        <div class="image-element1 border-bt-e6f3ff py-2">
                            <h5 class="text-center theme-clr pl-1">View Class Demo</h5>
                           
                            <div class="view_demo d-flex align-items-center">
                                {{-- <a data-fancybox class="video-play-button fancybox-gallery" rel="video-gallery" href="https://www.youtube.com/watch?v=iuimHfnP5aU&list=PLWx-A6wseQ6n-i692JSWuNvZcNTV-ULZu"> --}}
                                @if(!empty($institute->video) & @unserialize($institute->video))
                                <?php  $video = unserialize($institute->video); ?>
                                <a target='_blank' data-fan cybox class="video-play-button fa ncybox-gallery"
                                    rel="video-gallery" href="{{$video[0] ?? ''}}">
                                    <span></span>
                                </a>
                                @endif
                                <div id="video-overlay" class="video-overlay">
                                    <a class="video-overlay-close">×</a>
                                </div>
                                 
                                <i class="fa fa-edit" onclick="$('#class_video_{{$institute_assigned_class->id}}').trigger('click');"></i>
                                <form action="{{route('admin.manage-institutes.uploadClassVideo')}}" method="post"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="institute_assigned_class_id"
                                        value="{{$institute_assigned_class->id}}">
                                    <input accept='video/*' type="file" name="class_video"
                                        id="class_video_{{$institute_assigned_class->id}}" style="display: none;"
                                        onchange="this.form.submit()">
                                </form>
                            </div>
                         <!--    @if (!empty($institute_assigned_class->video) && @unserialize($institute_assigned_class->video))
                            <div class='approve_checkbox ml-auto'> 
                                        Approve Content<br>
                                        <label class="switch"> 
                                            <input type="checkbox" class='approveVideo'
                                                data-id="{{ $institute_assigned_class->id }}"
                                                value='@if ($institute_assigned_class->videoApproval == 1) {{ 0 }}@else{{ 1 }} @endif'
                                                <?php if ($institute_assigned_class->videoApproval == 1) {
                                                    echo 'checked';
                                                } ?>>
                                            <span class="slider round"></span>
                                        </label>
                                    </div>
                                @endif
                            <p class='text-center pt-2'> 
                                @if (!empty($institute_assigned_class->description))
                                    {{$institute_assigned_class->description}}
                                @endif
                            </p> -->
                            
                            
                        </div>
                    </div>
                    <div class="batch_date d-flex justify-content-between my-2 pb-2 border-bottom">
                        <p class="font-small text-dark mb-0 d-flex flex-column"><b>Batch
                                Start</b>{{date('d/m/Y', strtotime($institute_assigned_class->start_date) ) ?? ''}}</p>
                        <p class="font-small text-dark  d-flex flex-column mb-0"><b>Batch
                                End</b>{{date('d/m/Y', strtotime($institute_assigned_class->end_date) ) ?? ''}}</p>
                    </div>
                    <div class="total text-center mt-lg-2 mt-md-2 border-bottom showStudentlist" data-id=''>
                        <a href='{{url("admin/manage-institutes/enrollments"."/".$institute->id."/".$institute_assigned_class->id)}}'
                            class="btn btn-theme my-1 w-100 waves-effect waves-light cursor-default text-white">Total
                            Enrollments
                            {{$institute_assigned_class->students->count()}}</a>
                        <!-- <li class='childli' style='display:none;list-style-type:none;'>
              @if(!empty($institute_assigned_class->students))
              @foreach($institute_assigned_class->students as $student) 
                <ul>{{$student->name}}</ul>
              @endforeach
              @endif
            </li> -->
                    </div>
                    <div class="total text-center mt-lg-3 mt-md-3">
                        <p class="m-0">Enrollment Fee - {{$institute_assigned_class->price ?? ''}} INR</p>
                    </div>
                </div>
            </div>
        </div>

        @endforeach

        @endif

    </div>
    <!-- end row -->
</div>
<!-- container -->
@endsection

@push('js')
<script>  
    $(document).ready(function() { 
        $('.approveVideo').click(function() {
            var val = $(this).val();
            var id = $(this).data('id');
            window.location.href = "{{ url('admin/approveClassVideo') }}" + '/' + id + '/' + val;
        });
    })  
function enableTrial(class_id) {
    $.ajax({
        url: "{{url('admin/manage-institutes/enable-trial')}}",
        method: "POST",
        dataType: "JSON",
        data: {
            class_id,
            _token: "{{csrf_token()}}"
        },
        success: function(response) {
            if (response.status == 'success') {
                location.reload();
            }
            if (response.status == 'failed') {
                $('.alertMsg').addClass('alert alert-warning').html(response.message);
            }
            setTimeout(() => {
                $('.alertMsg').hide();
            }, 3000);
        }
    })
}

function deleteClass(class_id) {
    $.ajax({
        url: "{{url('admin/manage-institutes/delete-class')}}",
        method: "POST",
        dataType: "JSON",
        data: {
            class_id,
            _token: "{{csrf_token()}}"
        },
        success: function(response) {
            if (response.status == 'success') {
                location.reload();
            }
            if (response.status == 'failed') {
                $('.alertMsg').addClass('alert alert-warning').html(response.message);
            }
            setTimeout(() => {
                $('.alertMsg').hide();
            }, 3000);
        }
    })
}

$(document).ready(function() {
    $('.showStudentlist').click(function() {
        $(this).find('.childli').toggle();
    });
});
</script>
@endpush