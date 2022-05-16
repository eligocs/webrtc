@extends('admin.layouts.app')
@section('page_heading', 'Enrolled Classes')
@section('content')
<div class="container-fluid">
    {{-- <div>{{ Breadcrumbs::render('view-institute', request()->id) }}</div> --}}
<div class="row mx-0 card-box">
    <div class="col-md-12 d-md-flex justify-content-end">
        {{-- <a href="{{route('admin.manage-institutes.view-institute-detail',$institute->id)}}"
        class="btn-theme btn-style ml-1">View Institute Detail</a>
        <a href="{{route('admin.manage-institutes.add-new-class',$institute->id)}}" class="btn-theme btn-style ml-1">Add
            New Class</a>
        <a href="{{route('admin.teachers.index',$institute->id)}}" class="btn-theme btn-style ml-1">View Teacher</a>
        --}}
    </div>
    <div class="col-md-12 mb-4">
        <h3 class="heading-title mt-0 mb-0 text-center heading">{{$student->name}}</h3>
        {{-- <h4 class=" m-0 text-center fw-100">By Akaash Institute</h4> --}}
    </div>

    @if( $student->institute_assigned_classes->count() > 0 )
    @foreach ($student->institute_assigned_classes as $institute_assigned_class)

    <div class="col-lg-4">
        <div class="card box-shadow">
            <div class="card-body">
                <p class="text-right">
                    <i class="fa fa-trash" style="color: #bb4141; cursor: pointer;"
                        onclick="if(confirm('Are you sure to delete this class fro student')){deleteClass({{$institute_assigned_class->id}},{{$student->id}});}"></i>
                </p>
                <div class="profile-statistics">
                    <div class="text-center mt-2 border-bottom">
                        <div class="my-4">
                            <div class="btn-theme pl-2 pr-2 py-2 mr-0 mb-4">
                                {{$institute_assigned_class->name}}({{$institute_assigned_class->institute->name}})
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
                    <h5 class="theme-clr justify-content-between  d-flex align-items-center text-capitalize">
                        {{$institute_assigned_class->state}}<span
                            class="pull-right f-s-16">{{$institute_assigned_class->city}}</span> </h5>
                </div>
                <div class="profile-interest mt-2 pb-2 border-bottom">
                    <div class="row mt-0">

                        @if($institute_assigned_class->institute_assigned_class_subject->count() > 0 )

                        @foreach( $institute_assigned_class->institute_assigned_class_subject as $subject )

                        <div class="col-lg-6 col-xl-6 col-sm-6 col-6 int-col">
                            <a href="{{route('admin.institute-subject.detail',[$subject->id,$subject->subject_id])}}"
                                class="btn btn-theme my-1 w-100 waves-effect waves-light cursor-default text-white">{{$subject->subject->name ?? ''}}</a>
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
                            @if(!empty($institute_assigned_class->video) && @unserialize($institute_assigned_class->video))
                            <?php  $video = unserialize($institute_assigned_class->video); ?>
                            <a target='_blank' data-fan cybox class="video-play-button fa ncybox-gallery"
                                rel="video-gallery" href="{{$video[0] ?? ''}}">
                                <span></span>
                            </a>
                            @endif
                            <div id="video-overlay" class="video-overlay">
                                <a class="video-overlay-close">×</a>
                            </div>
                            {{-- <i class="fa fa-edit pull-right"
                  onclick="$('#class_video_{{$institute_assigned_class->id}}').trigger('click');"></i> --}}
                            <form action="{{route('admin.manage-institutes.uploadClassVideo')}}" method="post"
                                enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="institute_assigned_class_id"
                                    value="{{$institute_assigned_class->id}}">
                                <input type="file" name="class_video" id="class_video_{{$institute_assigned_class->id}}"
                                    style="display: none;" onchange="this.form.submit()">
                            </form>
                        </div>
                    </div>
                </div>
                <div class="batch_date d-flex justify-content-between my-2 pb-2 border-bottom">
                    <p class="font-small text-dark mb-0 d-flex flex-column"><b>Batch
                            Start</b>{{date('d/m/Y', strtotime($institute_assigned_class->start_date) ) ?? ''}}</p>
                    <p class="font-small text-dark  d-flex flex-column mb-0"><b>Batch
                            End</b>{{date('d/m/Y', strtotime($institute_assigned_class->end_date) ) ?? ''}}</p>
                </div>
                <div class="total text-center mt-lg-2 mt-md-2 border-bottom">
                    <p class="mb-2">Total Enrollments 300</p>
                </div>
                <div class="total text-center mt-lg-3 mt-md-3">
                    <p class="m-0">Enrollment Fee - {{$institute_assigned_class->price ?? ''}} INR</p>
                </div>
                <div class="total text-center mt-lg-3 my-md-3 d-flex align-items-center justify-content-center">
                    <a href="#switch-institute-modal" class="btn-theme btn-style font-13" data-animation="fadein"
                        data-plugin="custommodal" data-overlaycolor="#36404a">Switch Institute</a>
                    <a href="{{route('admin.manage-students.generate-receipt', ['student_id' => $student->id, 'class_id' => $institute_assigned_class->id])}}"
                        class="btn btn-theme btn-style font-13 ml-1">Download Receipt</a>
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
function deleteClass(class_id, student_id) {
    $.ajax({
        url: "{{url('admin/manage-students/delete-class')}}",
        method: "POST",
        dataType: "JSON",
        data: {
            class_id,
            student_id,
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
</script>
@endpush