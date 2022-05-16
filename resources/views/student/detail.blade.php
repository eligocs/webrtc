@extends('student.layouts.app')
@section('page_heading', 'Detail Page')
@section('content')
<style>
  .theme-outline-bg {
    border: 1px solid #644699;
  }
</style>
<div class="container-fluid">
  <div>
    {{ Breadcrumbs::render('enrollable_class_detail', request()->iacs_id) }}
  </div>
  @php
  $iacs = \App\Models\InstituteAssignedClassSubject::findOrFail(request()->iacs_id);  

  $iac = $iacs->institute_assigned_class;
  $institute_d = \App\Models\Institute::find($iac->institute_id);  
  @endphp
  <div class="row">
    <div class="col-xl-12 col-md-12 col-sm-12">
      <div class="card-box position-relative">
        <h3 class="heading-title mt-0 mb-0 text-center heading">{{$iacs->subject->name}}</h3>
        <h4 class=" mt-0 mb-0 text-center fw-100">{{$iacs->institute_assigned_class->institute->name}}</h4>
       
        <div class="card-box d-flex align-items-center justify-content-center">
          <div class="widget-detail-1 orange-gradient btn-style position-relative pl-2 pr-4 py-2 mr-2 d-flex">
            <h4 class="font-weight-normal font-14 my-0 mr-2 text-white text-left ">View Demo</h4>
            <div>
              {{-- <a data-fancybox class="video-play-button fancybox-gallery" rel="video-gallery" href="https://www.youtube.com/watch?v=iuimHfnP5aU&list=PLWx-A6wseQ6n-i692JSWuNvZcNTV-ULZu"> --}}
              @php 
                $video = $iacs->video ?? '';
                if($video && $iacs->videoApproval == 1){
                  $video_to = $video && @unserialize($video) == true ? unserialize($video)[0] :'';
                }
              @endphp
              <a data-fanc ybox class="video-play-button fancybox-gallery" rel="video-gallery" target='{{ !empty($video_to) ? "_blank":""}}'
                href="{{ $video_to ?? '' }}">
                <span></span>
              </a>
              <div id="video-overlay" class="video-overlay">
                <a class="video-overlay-close">×</a>
              </div>
            </div>
            {{-- <i class="fa fa-edit pull-right" onclick="$('#subject_video').trigger('click');"></i> --}}
            {{-- <form action="{{route('admin.manage-institutes.uploadSubjectVideo')}}" method="post"
            enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="institute_assigned_class_subject_id" value="{{request()->iacs_id}}">
            <input type="file" name="subject_video" id="subject_video" style="display: none;"
              onchange="this.form.submit()">
            </form> --}}
          </div>
          @php 
          $syllabus_url = $iacs->syllabus;
          @endphp
          @if ($syllabus_url)
          <a href="{{$syllabus_url ? ('https://aaradhanaclasses.s3.ap-south-1.amazonaws.com/'.$syllabus_url): '#'}}" {{$syllabus_url ? '' :"onclick=showAlert()"}}
            class="green-gradient text-center btn-style text-white mr-2" {{$syllabus_url ? 'target="_blank"' : ''}}>View
            Syllabus</a>
          @endif
         {{--  <a href="{{$iacs->syllabus}}" class=" green-gradient text-center btn-style text-white mr-2">Syllabus</a> --}}
          {{-- <a href="" class=" green-gradient w-30 text-center btn-style text-white mr-2">Add Demo</a> --}}
          {{-- <a href="" class=" blue-gradient w-30 text-center btn-style text-white">Switch Institute</a> --}}
        </div>
        @if($institute_d->description  && $institute_d->videoApproval == 1) 
          <div class='text-center  col-12 pt-3 discription'>{{$institute_d->description ?? ''}}</div> 
          @endif
      </div>
    </div>
  </div>
  <!--end row-->
  <!-- tabs end -->
  <div class="row mx-0">
    <div class="col-md-9 pl-md-0">
      <div class="row mx-0  card-box schedule_inner">
        <div class="col-md-12">
          <h4 class=" mt-0 mb-3 text-center fw-100">Class Schedule</h4>
        </div>
        @php
        $getSubjectsInfo = \App\Models\SubjectsInfo::where('institute_assigned_class_subject_id',$iacs->id)
        ->get()
        @endphp
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
        {{-- <div class="col-md-12 px-1">
          <h4 class=" mt-3 mb-0 text-center fw-100"><b>Next class on:</b>
            <span class="theme-clr mx-1">20/02/2020</span><span class="theme-clr mr-1">Thursday</span><span
              class="theme-clr mr-1">11:00 am</span>
          </h4>
        </div> --}}
      </div>
      <div class="card-box class_resources">
        <h4 class=" mt-0 mb-3 text-center fw-100">Class Resources</h4>
        <div class=" d-md-flex align-items-center">
          <a class="btn orange-gradient py-2 mx-1 font-13 w-25 text-center text-white" href="">Lectures</a>
          <a class="bbtn green-gradient py-2 mx-1 font-13 w-25 text-center text-white" href="">Assignments</a>
          <a class="btn pink-gradient py-2 mx-1 font-13 w-20 text-center text-white" href="">Doubts</a>
          <a class="bbtn purple-gradient py-2 mx-1 font-13 w-25 text-center text-white" href="">Tests</a>
          <a class="btn sea-gradient py-2 mx-1 font-13 w-25 text-center text-white" href="">Extra
            Classes</a>
          {{-- <a class="btn purple-gradient py-2 mx-1 font-13 w-20 text-center text-white" href="view-extraclasses.html"></a> --}}
        </div>
      </div>
    </div>
    <div class="col-md-3 card-box">
      <div>
        @php
        $institute_assigned_class_subject_teacher =
        \App\Models\InstituteAssignedClassSubjectTeacher::where(['institute_assigned_class_subject_id' =>
        request()->iacs_id])->first();
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
        {{-- {{dd($teacher_id)}} --}}
        {{-- {{dd($teacher)}} --}}
        @if (!empty($teacher))

        <h3 class=" mt-3 mb-0 text-center fw-100"><b>{{$teacher->name}}</b></h3>
        <p class="text-center font-14 mt-1 mb-0"> {{$teacher->qualifications}}</p>
        <p class="text-center font-14 mt-0"><b>Experience:</b><span class="ml-1">{{$teacher->experience}}</span></p>
        @endif
        {{-- <div class="mt-3 text-center">
                <a href="" class="btn-theme btn-style add_lecture-btn" data-toggle="modal" data-target="#exampleModal">Assign Teacher</a>
            </div> --}}
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
            $institute_assigned_class_id =
            \App\Models\InstituteAssignedClassSubject::find(request()->iacs_id)->institute_assigned_class_id;
            $institute_id = \App\Models\InstituteAssignedClass::find($institute_assigned_class_id)->institute_id;
            @endphp
            <label for="unit_name"> Select to Assign Teacher*</label>
            <input type="hidden" name="institute_assigned_class_subject_id" value="{{request()->iacs_id}}">
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