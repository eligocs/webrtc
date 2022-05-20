@extends('student.layouts.app')
@section('css')
<link href="{{URL::to('assets/student/libs/custombox/custombox.min.css')}}" rel="stylesheet">
@endsection
@section('content')
<div class="container-fluid pl-0">
  <div class="row mx-0 align-items-center">
    <div class="col-md-1 pl-0">
      <img src="/assets/student/images/drawer.png" class="img-fluid">
    </div>
    <div class="col-md-10">
      @foreach ($classes as $class)
      <div class="row card-box brder bg-board align-items-center">
        <div class="col-lg-12 mb-md-2 poisition-relative">
          <h3 class="heading-title mt-0 mb-0 text-center heading text-white donis_font">
            <!-- {{$class->name}} -->6th Class
          </h3>
          <h4 class=" m-0 text-center fw-100 text-white donis_font">By {{$class->institute->name}}</h4>
          <div class="postn_absolute">
            <!-- <a href="#setting-modal" class="btn-outline-theme btn-style" data-animation="fadein"
                data-plugin="custommodal" data-overlaycolor="#36404a">Class Settings</a> -->
          </div>
        </div>
        <div class="col-md-7 p-0">
          <div class="row mx-0 ">
            @foreach ($class->institute_assigned_class_subject as $key => $institute_assigned_class_subject)
            <div class="col-md-4 p-1">
              @php
              $iacs = \App\Models\InstituteAssignedClassSubject::where(['institute_assigned_class_id' => $class->id,
              'subject_id' => $institute_assigned_class_subject->subject->id])->firstOrFail();
              if(!empty($iacs)){
              $iacs_id = $iacs->id;
              }
              @endphp
              <a href="{{route('student.subject_detail', $iacs_id)}}" class="d-flex flex-column w-100 h-100">
                <span class="{{$colors[$key]}} br-6 px-2 py-3">
                  <h4 class=" text-left fw-100 text-white mt-0 mb-2">
                    <b>{{$institute_assigned_class_subject->subject->name}}</b></h4>
                  @php
                  try {
                  $date_of_days = [];
                  foreach ($institute_assigned_class_subject->subjects_infos->pluck('day') as $key => $day) {
                  $date_of_days[] = date('Y-m-d', strtotime("next $day"));
                  }
                  asort($date_of_days);
                  $day = date('l', strtotime(array_values($date_of_days)[0]));
                  $next_class_day = substr($day, 0, 3);
                  $subjects_info = $institute_assigned_class_subject->subjects_infos->where('day',
                  strtolower($day))->first();
                  $next_class_time = date('h:i A', strtotime($subjects_info->student_subjects_info->time_slot->slot));
                  } catch (\Throwable $th) {
                  $next_class_day = '';
                  $next_class_time = '';
                  }
                  @endphp
                  <h4 class="font-13 text-white mb-0  mt-1 fw-100 d-flex justify-content-between"><b>Next Class</b>
                    <span>{{$next_class_time}}<span class="ml-1">{{$next_class_day}}</span></span></h4>
                  @php
                  $lectures = \App\Models\Lecture::where('institute_assigned_class_subject_id',
                  $iacs_id)->whereDate('lecture_date', '<', date('Y-m-d 00:00:00'))->get();
                    // dd($lectures->pluck('lecture_date')->toArray());
                    if($lectures->count() > 0){
                    $total_past_lectures = $lectures->count();
                    $attended_lectures = \App\Models\StudentLecture::whereIn('lecture_id',
                    $lectures->pluck('id')->toArray())->where('student_id',
                    auth()->user()->student_id)->where('attendence_in_percentage',
                    '>=', '90')->get();

                    $total_attended_lectures = $attended_lectures->count();
                    $total_absents_in_lectures = $total_past_lectures - $total_attended_lectures;
                    $percentage = ($total_attended_lectures / $total_past_lectures) * 100;

                    }else{
                    $total_past_lectures = 0;
                    $total_attended_lectures = 0;
                    $total_absents_in_lectures = 0;
                    $percentage = 0;
                    }
                    @endphp
                    {{-- @if ($total_past_lectures > 0) --}}
                    <h4 class="font-13 text-white mb-0 mt-1 fw-100 d-flex justify-content-between"><b>Attendance</b>
                      <span>{{$total_attended_lectures}} P<span class="ml-1">{{$total_absents_in_lectures}}
                          Ab</span></span>
                    </h4>
                    <h4 class="font-13 text-white mb-0 mt-1 fw-100 d-flex justify-content-between"><b>Percentage</b>
                      <span>{{round($percentage, 2)}}%</span>
                    </h4>
                    {{-- @endif --}}
                    {{-- <h4 class="font-13 text-white mb-0 mt-1 fw-100 d-flex justify-content-between"><b>Attendance</b>
                      <span>2 P<span class="ml-1">3 Ab</span></span></h4>
                    <h4 class="font-13 text-white mb-0 mt-1 fw-100 d-flex justify-content-between"><b>Percentage</b>
                      <span>77%</span></h4> --}}
                </span>
              </a>
            </div>
            @endforeach
            {{-- <div class="col-md-4 p-1">
                <a href="subjectdetail.html" class="d-flex flex-column w-100 h-100">
                  <span class="pink-gradient br-6 px-2 py-3">
                    <h4 class=" text-left fw-100 text-white mt-0 mb-2"><b>Maths</b></h4>
                    <h4 class="font-13 text-white mb-0  mt-1 fw-100 d-flex justify-content-between"><b>Next Class</b>
                      <span>6:00 PM<span class="ml-1">Tue</span></span></h4>
                    <h4 class="font-13 text-white mb-0 mt-1 fw-100 d-flex justify-content-between"><b>Attendance</b>
                      <span>2 P<span class="ml-1">3 Ab</span></span></h4>
                    <h4 class="font-13 text-white mb-0 mt-1 fw-100 d-flex justify-content-between"><b>Percentage</b>
                      <span>77%</span></h4>
                  </span>
                </a>
              </div> --}}
            {{-- <div class="col-md-4 p-1">
                <a href="subjectdetail.html" class="d-flex flex-column w-100 h-100">
                  <span class="blue-gradient br-6 px-2 py-3">
                    <h4 class=" text-left fw-100 text-white mt-0 mb-2"><b>Physics</b></h4>
                    <h4 class="font-13 text-white mb-0  mt-1 fw-100 d-flex justify-content-between"><b>Next Class</b>
                      <span>6:00 PM<span class="ml-1">Tue</span></span></h4>
                    <h4 class="font-13 text-white mb-0 mt-1 fw-100 d-flex justify-content-between"><b>Attendance</b>
                      <span>2 P<span class="ml-1">3 Ab</span></span></h4>
                    <h4 class="font-13 text-white mb-0 mt-1 fw-100 d-flex justify-content-between"><b>Percentage</b>
                      <span>77%</span></h4>
                  </span>
                </a>
              </div> --}}
            {{-- <div class="col-md-4 p-1">
                <a href="subjectdetail.html" class="d-flex flex-column w-100 h-100">
                  <span class="green-gradient br-6 px-2 py-3">
                    <h4 class=" text-left fw-100 text-white mt-0 mb-2"><b>Chemistry</b></h4>
                    <h4 class="font-13 text-white mb-0  mt-1 fw-100 d-flex justify-content-between"><b>Next Class</b>
                      <span>6:00 PM<span class="ml-1">Tue</span></span></h4>
                    <h4 class="font-13 text-white mb-0 mt-1 fw-100 d-flex justify-content-between"><b>Attendance</b>
                      <span>2 P<span class="ml-1">3 Ab</span></span></h4>
                    <h4 class="font-13 text-white mb-0 mt-1 fw-100 d-flex justify-content-between"><b>Percentage</b>
                      <span>77%</span></h4>
                  </span>
                </a>
              </div> --}}
            {{-- <div class="col-md-4 p-1">
                <a href="subjectdetail.html" class="d-flex flex-column w-100 h-100">
                  <span class="sea-gradient br-6 px-2 py-3">
                    <h4 class=" text-left fw-100 text-white mt-0 mb-2"><b>Biology</b></h4>
                    <h4 class="font-13 text-white mb-0  mt-1 fw-100 d-flex justify-content-between"><b>Next Class</b>
                      <span>6:00 PM<span class="ml-1">Tue</span></span></h4>
                    <h4 class="font-13 text-white mb-0 mt-1 fw-100 d-flex justify-content-between"><b>Attendance</b>
                      <span>2 P<span class="ml-1">3 Ab</span></span></h4>
                    <h4 class="font-13 text-white mb-0 mt-1 fw-100 d-flex justify-content-between"><b>Percentage</b>
                      <span>77%</span></h4>
                  </span>
                </a>
              </div> --}}
            {{-- <div class="col-md-4 p-1">
                <a href="subjectdetail.html" class="d-flex flex-column w-100 h-100">
                  <span class="purple-gradient br-6 px-2 py-3">
                    <h4 class=" text-left fw-100 text-white mt-0 mb-2"><b>English</b></h4>
                    <h4 class="font-13 text-white mb-0  mt-1 fw-100 d-flex justify-content-between"><b>Next Class</b>
                      <span>6:00 PM<span class="ml-1">Tue</span></span></h4>
                    <h4 class="font-13 text-white mb-0 mt-1 fw-100 d-flex justify-content-between"><b>Attendance</b>
                      <span>2 P<span class="ml-1">3 Ab</span></span></h4>
                    <h4 class="font-13 text-white mb-0 mt-1 fw-100 d-flex justify-content-between"><b>Percentage</b>
                      <span>77%</span></h4>
                  </span>
                </a>
              </div> --}}
          </div>
        </div>
        <div class="col-md-5">
          <!-- <div id="simple-pie" class="ct-chart ct-golden-section simple-pie-chart-chartist"></div> -->
          <div id="pie-chart" class="ct-chart ct-golden-section"><svg
              xmlns:ct="http://gionkunz.github.com/chartist-js/ct" width="100%" height="100%" class="ct-chart-pie"
              style="width: 100%; height: 100%;">
              <g class="ct-series ct-series-a">
                <path d="M341.095,150.524A118.172,118.172,0,0,0,223.57,20L223.57,138.172Z" class="ct-slice-pie"
                  ct:value="20"></path>
              </g>
              <g class="ct-series ct-series-b">
                <path d="M248.14,253.761A118.172,118.172,0,0,0,341.137,150.114L223.57,138.172Z" class="ct-slice-pie"
                  ct:value="15"></path>
              </g>
              <g class="ct-series ct-series-c">
                <path d="M223.57,20A118.172,118.172,0,1,0,248.543,253.675L223.57,138.172Z" class="ct-slice-pie"
                  ct:value="40"></path>
              </g>
              <g><text dx="326.93130724979727" dy="45.105217304634735" text-anchor="start"
                  class="ct-label">Maths</text><text dx="326.93130724979727" dy="231.23853269536528" text-anchor="start"
                  class="ct-label">Physics</text><text dx="85.24630231842681" dy="152.71031430901593" text-anchor="end"
                  class="ct-label">Hindi</text></g>
            </svg></div>
          <h4 class=" mt-5 mb-0 pt-md-5 text-center fw-100 text-white">My Academic Performance</h4>
        </div>
      </div>
      @endforeach
      <div class="teacher"><img src="/assets/student/images/teacher.png"></div>
    </div>
    <div class="col-md-10 student_img ml-auto">
      <img src="/assets/student/images/student2.png">
      <img src="/assets/student/images/student1.png">
    </div>
  </div>
  <!---row end-->
  <!-- end row -->


</div>
@endsection
@section('js')
<script src="{{URL::to('assets/student/libs/custombox/custombox.min.js')}}"></script>
<script src="{{URL::to('assets/student/js/app.min.js')}}"></script>
@endsection