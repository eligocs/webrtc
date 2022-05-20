@extends('admin.layouts.app')
@section('page_heading', 'Subject')
@section('content')
<style>

.w-100.text-center.col-6 {
    padding-top: 10px;
    width: 50%; 
    margin-right: auto;
    margin-left: auto;
}
@media only screen and (min-width: 600px) {
  .w-100.text-center.col-6 {
      padding-top: 10px;
      width: 100% !important; 
      margin-right: auto;
      margin-left: auto;
  } 
}
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

        .approve_checkbox.ml-auto {float: right !important;}


        .paddi-l {
    padding-left: 115px;
}

@media  (max-width:425px) {
    .approve_checkbox {
    float: right;
    margin-top: -342px;
}
.paddi-l {
    padding-left: 0px;
}
    .discription {
    padding:10px  10px 0 !important;
}}
</style>
<div class="container-fluid">
  <div>{{ Breadcrumbs::render('institute-detail', request()->institute_assigned_class_id, request()->subject_id) }}
  </div>
  @php
  $iacs_id = request()->institute_assigned_class_id;
  $iacs = \App\Models\InstituteAssignedClassSubject::findOrFail($iacs_id);  
  $iac = $iacs->institute_assigned_class; 
  @endphp
  @if (session()->has('message'))
                    <div class="alert alert-success success_message">
                        {{ session()->get('message') }}
                    </div>
                @endif 
  <div class="row">
    <div class="col-xl-12 col-md-12 col-sm-12">
      <div class="card-box position-relative"> 
            @if (!empty($iacs->video) && @unserialize($iacs->video)) 
                <div class='approve_checkbox ml-auto'>
                  <p class='text-right'>Approve Content&nbsp;</p> 
                    <label class="switch"> 
                        <input type="checkbox" class='approveVideo'
                            data-id="{{ $iacs->id }}"
                            value='@if($iacs->videoApproval == 1){{0}}@else{{1}}@endif'
                            <?php if ($iacs->videoApproval == 1) {
                                echo 'checked';
                            } ?>>
                        <span class="slider round"></span>
                    </label>
                </div>
              @endif
        <h3 class="heading-title mt-0 mb-0 text-center heading paddi-l">{{$subject->name}}</h3>
        <h4 class=" mt-0 mb-0 text-center fw-100 paddi-l">{{$iac->name}}</h4> 
        <div class='w-70 text-center col-12 pt-3 px-5  px-sm-1 discription'>{{$iacs->description ?? ''}}</div>




        <div class="card-box d-flex align-items-center justify-content-center">
          <div class="widget-detail-1  orange-gradient btn-style position-relative pl-2 pr-4 py-2 mr-2 d-flex">
            <h4 class="font-weight-normal font-14 my-0 mr-2 text-white text-left ">View Demo</h4>
            <div>
              {{-- <a data-fancybox class="video-play-button fancybox-gallery" rel="video-gallery" href="https://www.youtube.com/watch?v=iuimHfnP5aU&list=PLWx-A6wseQ6n-i692JSWuNvZcNTV-ULZu"> --}}
              {{-- <a data-fancybox class="video-play-button fancybox-gallery" rel="video-gallery"
                href="{{\App\Models\InstituteAssignedClassSubject::findOrFail($iacs_id)->video}}">
              <span></span>
              </a> --}}
              @php
                $video = $iacs->video ?? '';
                if($video){
                  $video = $video && @unserialize($video) == true ? unserialize($video)[0] :'';
                }
              @endphp
         
              <a data-fancy box class="video-play-button fancybox-gallery" rel="video-gallery" href="{{$video ?? ''}}">
                <span></span>
              </a>
              <div id="video-overlay" class="video-overlay">
                <a class="video-overlay-close">×</a>
              </div>
            </div>
          </div>
          <div class="widget-detail-1  orange-gradient position-relative pl-2 py-2 mr-2 d-flex">
            <h4 class="font-weight-normal font-14 my-0 mr-2 text-white text-left "
              onclick="$('#subject_video').trigger('click');">Add Demo</h4>
            <form action="{{route('admin.manage-institutes.uploadSubjectVideo')}}" method="post"
              enctype="multipart/form-data">
              @csrf
              <input type="hidden" name="institute_assigned_class_subject_id" value="{{$iacs_id}}">
              <input type="file" name="subject_video" id="subject_video" style="display: none;"
                onchange="this.form.submit()">
            </form>
          </div>
          <a href="" class=" green-gradient w-30 text-center btn-style text-white mr-2">Syllabus</a>
          {{-- <a href="" class=" blue-gradient w-30 text-center btn-style text-white">Switch Institute</a> --}}
        </div>


      </div>
    </div>

  
  </div>
  <!-- tabs end -->
  <div class="row mx-0">
    <div class="col-md-9 pl-md-0">
      <div class="row mx-0  card-box schedule_inner">
        <!--end row-->
        
        <div class="col-md-12">
          <h4 class=" mt-0 mb-3 text-center fw-100">Class Schedule</h4>
        </div>

        @if($getSubjectsInfo->count() > 0)

        @foreach (['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'] as $day)

        <div class="col-md-2 px-1 mb-2">
          <div
            class="{{in_array($day, $getSubjectsInfo->pluck('day')->toArray()) ? 'theme-bg' : 'theme-outline-bg'}} m-0">
            <h4
              class="btn-style header-title font-13 m-0 text-center text-white {{in_array($day, $getSubjectsInfo->pluck('day')->toArray()) ? '' : 'theme-clr'}}">
              {{$day ?? '' }}</h4>
          </div>
        </div>

        @endforeach

        @else

        Not available days !!

        @endif


        {{-- <!-- end col -->
            <div class="col-md-2 px-1">
               <div class="theme-bg m-0">
                  <h4 class="btn-style header-title font-13 m-0 text-center text-white">Tuesday</h4>
               </div>
            </div>
            <!-- end col -->
            <div class="col-md-2 px-1">
               <div class="theme-bg m-0">
                  <h4 class="btn-style header-title font-13 m-0 text-center text-white">Wednesday</h4>
               </div>
            </div>
            <!-- end col -->
            <div class="col-md-2 px-1">
               <div class=" theme-outline-bg m-0">
                  <h4 class="btn-style header-title font-13 m-0 text-center theme-clr">Thursday</h4>
               </div>
            </div>
            <!-- end col -->
            <div class="col-md-2 px-1">
               <div class="theme-outline-bg m-0">
                  <h4 class="btn-style header-title font-13 m-0 text-center theme-clr">Friday</h4>
               </div>
            </div>
            <!-- end col -->
            <div class="col-md-2 px-1">
               <div class="theme-outline-bg m-0">
                  <h4 class="header-title font-13 m-0 text-center theme-clr btn-style">Saturday</h4>
               </div>
            </div> --}}
        <!-- end col -->
        <div class="col-md-12 px-1">
          @php
          // $days = \App\Models\SubjectsInfo::where('institute_assigned_class_subject_id',
          // $iacs_id)->get()->pluck('day')->toArray();
          // $nextDate = '';
          // $nextDay = '';
          // foreach ($days as $key => $day) {
          // if(date('Y-m-d') )
          // }
          // dd($days);
          $lecture = \App\Models\Lecture::where('institute_assigned_class_subject_id',
          $iacs_id)->where('lecture_date', '>', date('Y-m-d
          00:00:00'))->orderBy('lecture_date', 'asc')->first();
          @endphp
          @if(!empty($lecture))
          <h4 class=" mt-3 mb-0 text-center fw-100"><b>Next class on:</b>
            <span class="theme-clr mx-1">{{date('d/m/Y', strtotime($lecture->lecture_date))}}</span><span
              class="theme-clr mr-1">{{date('l', strtotime($lecture->lecture_date))}}</span>
            {{-- <span class="theme-clr mr-1">11:00 am</span> --}}
            @endif
          </h4>
        </div>
      </div>
      <div class="card-box class_resources">
        <h4 class=" mt-0 mb-3 text-center fw-100">Class Resources</h4>
        <div class=" d-md-flex align-items-center">
          <a class="btn orange-gradient py-2 mx-1 font-13 w-20 text-center text-white"
            href="{{route('admin.institute-subject.lectures', $iacs_id)}}">Lectures</a>
          <a class="btn blue-gradient py-2 mx-1 font-13 w-20 text-center text-white"
            href="{{route('admin.institute-subject.assignments', $iacs_id)}}">Assignments</a>
          <a class="btn pink-gradient py-2 mx-1 font-13 w-20 text-center text-white"
            href="{{route('admin.institute-subject.doubts', $iacs_id)}}">Doubts</a>
          <a class="bbtn green-gradient py-2 mx-1 font-13 w-20 text-center text-white"
            href="{{route('admin.institute-subject.tests', $iacs_id)}}">Tests</a>
          <a class="btn purple-gradient py-2 mx-1 font-13 w-20 text-center text-white"
            href="{{route('admin.institute-subject.extra-classes', $iacs_id)}}">Extra Classes</a>
        </div>
      </div>
    </div>
    <div class="col-md-3 card-box">
      <div>
        @php
        $institute_assigned_class_subject_teacher =
        \App\Models\InstituteAssignedClassSubjectTeacher::where(['institute_assigned_class_subject_id' =>
        $iacs_id])->first();
        $teacher_id = $institute_assigned_class_subject_teacher ? $institute_assigned_class_subject_teacher->teacher_id
        : '';
        if($teacher_id) {
        $teacher = \App\Models\Teacher::find($teacher_id);
        }
        @endphp
        @if (!empty($teacher))
        <div class="client-img rounded-circle mx-auto avatar-xl overflow-hidden mb-2">
          <img src="{{URL::to('storage/'.$teacher->avatar)}}" class="img-thumbnail w-100" alt="profile-image">
        </div>
        @endif
        @if (!empty($teacher))

        <h3 class=" mt-3 mb-0 text-center fw-100"><b>{{$teacher->name}}</b></h3>
        <p class="text-center font-14 mt-1 mb-0"> {{$teacher->qualifications}}</p>
        <p class="text-center font-14 mt-0"><b>Experience:</b><span class="ml-1">{{$teacher->experience}}</span></p>
        @endif
        <div class="mt-3 text-center">
          {{-- <a href="teacher-detail.html" class="btn-style btn-theme">Assign Teacher</a> --}}
          <a href="" class="btn-theme btn-style add_lecture-btn" data-toggle="modal" data-target="#exampleModal">Assign
            Teacher</a>
        </div>
      </div>
    </div>
  </div>
  <!-- end row -->
  <!-- end row -->
  <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Create Lecture</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="card-box">
            <form role="form" action="{{route('admin.institute-subject.assignTeacher')}}" method="post"
              enctype="multipart/form-data">
              @csrf
              {{-- <div class="form-group">
              <label for="class_id"> Select Class*</label>
              <select name="class_id" id="select0_id" class="select2" required>
                <option value="">Select Class</option>
                @foreach (\App\Models\InstituteClass::all() as $item)
                <option value="{{$item->id}}">{{$item->name}}</option>
              @endforeach
              </select>
          </div> --}}
          {{-- <div class="form-group">
              <label for="subject_id"> Select Subject*</label>
              <select name="subject_id" id="select1_id" class="select2" required>
                <option value="">Select Subject</option>
              </select>
            </div> --}}
          <div class="form-group">
            @php
            // $institute_assigned_class_id =
            // \App\Models\InstituteAssignedClassSubject::find($iacs_id)->institute_assigned_class_id;
            $institute_id = \App\Models\InstituteAssignedClass::find($iac->id)->institute_id;
            @endphp
            <label for="unit_name"> Select to Assign Teacher*</label>
            <input type="hidden" name="institute_assigned_class_subject_id" value="{{$iacs_id}}">
            <select name="teacher_id" id="select2_id" class="select2" required>
              <option value="">Select Teacher</option>
              @foreach (\App\Models\Teacher::where('institute_id', $institute_id)->get() as $elements)
              <option value="{{$elements->id}}">{{$elements->name}}</option>
              @endforeach
            </select>
          </div>
          <div class="form-group text-center">
            <button type="submit" class="btn btn-theme">Assign</button>
          </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
</div>
<!-- container -->

@endsection

@push('js') 
    <script>
        $(document).ready(function() { 
            $('.approveVideo').click(function() {
                var val = $(this).val();
                var id = $(this).data('id');
                window.location.href = "{{ url('admin/approveSubjectVideo') }}" + '/' + id + '/' + val;
            });
        })
    </script>
@endpush