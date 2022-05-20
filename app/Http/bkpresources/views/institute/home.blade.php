@extends('institute.layouts.app')
@section('content')
<!-- Start Content-->
<style>
p.text-center.text-orange {
    color: #d78f0b;
}
i.fa.fa-video {
    color: #644699;
}
</style>
<div class="institute">
    <div class="row mx-0 card-box">
        <div class="col-md-12 mb-4">
            <h3 class="heading-title mt-0 mb-0 text-center heading">{{ ucFirst(auth()->user()->institute->name) }} </h3> 
            <div class='text-right' > 
                <a href='{{url("institute/profile")}}' ><i class='fa fa-edit'></i></a>
            </div> 
            <h5 class="  mt-0 mb-0 text-center heading">{{ auth()->user()->institute->description ?? '' }}</h5> 
        </div>
         
        @if (auth()->user()->institute->institute_assigned_classes->count() > 0)

        @foreach (auth()->user()->institute->institute_assigned_classes as $institute_assigned_class)
        <div class="col-lg-4">
            <div class="card box-shadow">
                <div class="card-body">
                    <div class="profile-statistics">
                        <div class="text-center mt-2 border-bottom">
                            <div class="my-4">
                                <div class="btn-theme pl-5 pr-5 py-2 mr-0 mb-4">
                                    {{ $institute_assigned_class->name }}
                                  
                                </div>

                            </div>
                        </div>
                        <div class="profile-blog pt-1 border-bottom pb-1 ">
                            <h5 class="theme-clr justify-content-between  d-flex align-items-center">
                                {{ $institute_assigned_class->language_table->name ?? '' }}<a href="javascript:void()"
                                    class="theme-clr pull-right f-s-16">{{ $institute_assigned_class->board }}</a>
                            </h5>
                        </div>
                        <div class="profile-blog pt-1 border-bottom pb-1 ">
                            <h5 class="theme-clr justify-content-between  d-flex align-items-center text-capitalize">
                                {{ $institute_assigned_class->state }}
                                <span class="pull-right f-s-16">{{ $institute_assigned_class->city }}</span>
                            </h5>
                        </div>
                        <div class="profile-interest mt-2 pb-2 border-bottom">
                            <div class="row mt-0">
                                @if ($institute_assigned_class->institute_assigned_class_subject->count() > 0)

                                @foreach ($institute_assigned_class->institute_assigned_class_subject as $subject)
                                @php
                                $total2 = 0;
                                $items2 = [];
                                $segmentid = request()->segment(4);
                                $doubtsnotify = DB::table('class_notifications')
                                ->where('i_a_c_s_id', $subject->id)
                                ->where('isread', 3)
                                ->where('type', 'doubts')
                                ->get();
                                if (!empty($doubtsnotify)) {
                                foreach ($doubtsnotify as $noti) {
                                if ($noti->readUsers) {
                                $hiddenProducts = explode(',', $noti->readUsers);
                                if (in_array(request()->i_a_c_s_id, $hiddenProducts)) {
                                $total2 = $total2 + 0;
                                } else {
                                $total2 = $total2 + 1;
                                $items2[] = $noti;
                                }
                                } else {
                                $total2 = $total2 + 1;
                                $items2[] = $noti;
                                }
                                }
                                }
                                $doubtsnotify = $total2;
                                @endphp

                                <div class="col-lg-6 col-xl-6 col-sm-6 col-6 int-col">
                                    <a href="{{ route('institute.detail', [$subject->id, $subject->subject_id]) }}"
                                        class="btn btn-theme my-1 w-100 waves-effect waves-light cursor-default text-white">{{ $subject->subject->name ?? '' }}
                                        {{ !empty($doubtsnotify) ? '(' . $doubtsnotify . ')' : '' }}</a>
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
                                    {{-- <a data-fancybox class="video-play-button fancybox-gallery"
                                                    rel="video-gallery" href="{{ $institute_assigned_class->video }}">
                                    <span></span>
                                    </a> --}}
                <!--                     @if(!empty(auth()->user()->institute->video) &&
                    @unserialize(auth()->user()->institute->video)==true && auth()->user()->institute->videoApproval == 1)
                    <?php  $video = unserialize(auth()->user()->institute->video); ?>
                    <a target='_blank' data-fan cybox class="video-p lay-button fa ncybox-gallery"
                    rel="video-gallery" href="{{$video[0] ?? ''}}">
                    <span><i class='fa fa-video'></i></span>
                </a>
                @endif 
 -->    
                         
                                    @if(!empty(auth()->user()->institute->video) &&  @unserialize(auth()->user()->institute->video) == true && auth()->user()->institute->videoApproval == 1  )
                                    <?php  $video = unserialize(auth()->user()->institute->video); ?>
                                    <a target='_blank' data-fan cybox class="video-play-button fa ncybox-gallery"
                                        rel="video-gallery" href="{{$video[0] ?? ''}}">
                                        <span></span>
                                    </a>
                                    @elseif(empty(auth()->user()->institute->video))
                                    <a  data-fan cybox class="video-play-button fa ncybox-gallery"
                                        rel="video-gallery" href="#">
                                        <span></span>
                                    </a> 
                                    @endif
                                    <div id="video-overlay" class="video-overlay">
                                        <a class="video-overlay-close">×</a>
                                    </div>
                            <!--         <i class="fa fa-edit   addDemovideo" data-id='{{$institute_assigned_class->id}}' data-toggle='modal' data-target='#addDemovideo'></i> -->
                                    <!-- <i class="fa fa-edit pull-right" onclick="$('#class_video_{{$institute_assigned_class->id}}').trigger('click');"></i>
                                        <form action="{{route('institute.uploadClassVideo')}}" method="post"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <input type="hidden" name="institute_assigned_class_id"
                                                value="{{$institute_assigned_class->id}}">
                                            <input accept='video/*' type="file" name="class_video"
                                                id="class_video_{{$institute_assigned_class->id}}" style="display: none;"
                                                onchange="this.form.submit()">
                                        </form> -->
                                    </div> 
                                    @if(auth()->user()->institute->videoApproval == 0)
                                    <p class='text-center text-orange mt-2'>Content under approval</p> 
                                    @endif 
                                 <!--    @if(!empty(auth()->user()->institute->description))
                                        {{auth()->user()->institute->description ?? ''}}
                                    @endif
                                @if(!empty(auth()->user()->institute->video) &&
                                    @unserialize(auth()->user()->institute->video)==true && auth()->user()->institute->videoApproval == 0)
                                    <p class='text-center text-orange mt-2'>Content under approval</p> 
                                    @endif -->
                               <!--  <?php $inst = \App\Models\Institute::where('id',auth()->user()->institute->institute_id)->first(); ?>
                                <p>{{$inst->description ?? ''}}asdas</p> -->
                            </div>
                        </div>
                        <div class="batch_date d-flex justify-content-between my-2 pb-2 border-bottom">
                            <p class="font-small text-dark mb-0 d-flex flex-column"><b>Batch
                                    Start</b>{{ $institute_assigned_class->start_date->format('d/m/Y') }}</p>
                            <p class="font-small text-dark  d-flex flex-column mb-0"><b>Batch
                                    End</b>{{ $institute_assigned_class->end_date->format('d/m/Y') }}</p>
                        </div>
                        <div class="total text-center mt-lg-2 mt-md-2 border-bottom showStudentlist">
                            <a href='{{ url('institute/enrollments' . '/' . auth()->user()->institute->id . '/' . $institute_assigned_class->id) }}'
                                class="btn btn-theme my-1 w-100 waves-effect waves-light cursor-default text-white">Total
                                Enrollments {{ $institute_assigned_class->students->count() }}</a>

                            <!-- <p class="mb-2 text-blue">Total Enrollments {{ $institute_assigned_class->students->count() }}</p> -->
                            <!--   <li class='childli' style='display:none;list-style-type:none;'>
                                  @if (!empty($institute_assigned_class->students))
                                  @foreach ($institute_assigned_class->students as $student)
                                    <ul>{{ $student->name }}</ul>
                                  @endforeach
                                  @endif
                                </li> -->
                        </div>
                        <div class="total text-center mt-lg-3 mt-md-3">
                            <p class="m-0">Enrollment Fee -
                                {{ number_format($institute_assigned_class->price) }} INR</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
        @endif
    </div>
    

    <div class="modal" id="addDemovideo">
        <div class="modal-dialog">
            <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Class Demo Video</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">

                <form action="{{url('institute/uploadClassVideo')}}" method='post' enctype='multipart/form-data'>
                    @csrf()
                    <div class="form-group">
                        <label for="email">Video:</label>
                        <input type="file" name='class_video' class="form-control"  >
                        <input type="hidden" name='iacs_id' class="form-control"  value='{{$iac->id ?? ""}}'  accept="video/*">
                        <input type="hidden" name='institute_assigned_class_id' class="form-control institute_assigned_class_new"  value='{{$iacs->id ?? ""}}'>
                    </div>
                   <!--  <div class="form-group">
                        <label for="desc">Description:</label>
                        <textarea type="text" required class="form-control" placeholder="Enter description" value='' name='description' id="desc">{{$iacs->description ?? ""}}</textarea>
                    </div>  -->
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            
            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>

            </div>
        </div>
    </div>
    <!-- end row -->

</div> <!-- container -->
@endsection
@push('js')
<script>
$(document).ready(function() {
    $('.showStudentlist').click(function() {
        $(this).find('.childli').toggle();
    });
    $('.addDemovideo').click(function(){
        $('.institute_assigned_class_new').val($(this).data('id'));
    });
});
</script>
@endpush