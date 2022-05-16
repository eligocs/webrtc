@extends('student.layouts.app')
@section('css')
    <link href="{{ URL::to('assets/student/libs/custombox/custombox.min.css') }}" rel="stylesheet">
    <style>
        .ribbon {
            left: 2px;
            top: -1px;
            width: 94px;
        }

        #scrolerhem {
            height: 550px;
            /* overflow: auto;
                          margin: -55px -24px 0 !important;
                          padding: 0 15px; */
        }

        h3.heading-title.mt-0.mb-0.text-center.heading.donis_font {
            padding-bottom: 25px;
            /* margin-rigth: 200px; */
        }

        button#enrollalertbtn {
            width: 100px;
            height: 50px;
            background-color: blueviolet;
            border-radius: 8px;
        }

        .card-box.d-flex.align-items-center.justify-content-center {
            background: none;
        }

    </style>
@endsection
@section('content')
    <!-- <div>{{ Breadcrumbs::render('student_home') }}</div> -->

    <div class="container-fluid myClassesP">
        <div class="row mx-0 align-items-center justify-content-start classesRow">
            <div class="col-md-2">
                <img src="{{ URL::to('assets/student/images/techer2.png') }}" class="img-fluid postn-fixd"
                    style='margin-top: 26px;'>
            </div>
            <div class="col-md-10">
                <div class="row">
                    @php
                        // $classes = auth()->user()->student->institute_assigned_class;
                        $colors = ['orange-gradient', 'pink-gradient', 'blue-gradient', 'green-gradient', 'sea-gradient', 'purple-gradient'];
                    @endphp
                    {{-- @if ($classes->count() > 0)
         @foreach ($classes as $class) 

            <div class="col-md-6 board">
               <div class="row card-box brder bg-board align-items-center mx-0">
                  <div class="col-lg-12 mb-md-2 poisition-relative">
                     <h3 class="heading-title mt-2 mb-0 text-center heading text-white donis_font">{{$class->name ?? ''}}
        Class</h3>
        <h4 class=" m-0 text-center fw-100 text-white donis_font">By {{$class->institute->name}}</h4>
        <div class="postn_absolute">
          <a href="#setting-modal" class="btn-outline-theme btn-style" data-animation="fadein" data-plugin="custommodal"
            data-overlayColor="#36404a">Class Settings</a>
        </div>
      </div>
      <div class="col-md-12 p-0 subjectGridList">
        <div class="row mx-0 ">

          @if ($class->subjects->count())
          @foreach ($class->subjects as $key => $subject)
          @php
          $iacs = \App\Models\InstituteAssignedClassSubject::where(['institute_assigned_class_id' => $class->id,
          'subject_id' => $subject->id])->first();
          if(!empty($iacs)){
          $iacs_id = $iacs->id;
          }
          @endphp
          <div class="col-md-6 p-1">
            <a href="{{route('student.subject_detail', $iacs_id)}}" class="d-flex flex-column w-100 h-100 subject">
              <span class="{{$colors[$key%6]}} br-6 px-2 py-3">
                <h4 class=" text-left fw-100 text-white mt-0 mb-2 title"><b>{{ $subject->name ?? ''}}</b></h4>
                <h4 class="font-13 text-white mb-0  mt-1 fw-100 d-flex justify-content-between"><b>Next Class</b>
                  <span>6:00 PM<span class="ml-1">Tue</span></span>
                </h4>
                <h4 class="font-13 text-white mb-0 mt-1 fw-100 d-flex justify-content-between"><b>Attendance</b>
                  <span>2 P<span class="ml-1">3 Ab</span></span>
                </h4>
                <h4 class="font-13 text-white mb-0 mt-1 fw-100 d-flex justify-content-between"><b>Percentage</b>
                  <span>77%</span>
                </h4>
              </span>
            </a>
          </div>

          @endforeach
          @endif
        </div>
      </div>
      <!-- <div class="col-md-12 mt-3 text-center">
                     <a href="enter-class.html" class="btn-style btn-theme">Enter Study Room</a>
                  </div> -->
    </div>
  </div>

  @endforeach
  @endif --}}

                    <div class="col-md-9">
                        <h3 class="heading-title mt-0 mb-0 text-center heading donis_font">
                            My Study Room
                        </h3>
                    </div>
                    <br>
                    <br>
                    <div class="col-md-11 board">
                        <div class="card-box brder bg-board align-items-center mx-0">
                            <div class="row mx-0 classList customScrollBar" id="scrolerhem">
                                @if ($classes->count() > 0)
                                    @foreach ($classes as $class)
                                        @php
                                            // dd($class);
                                        @endphp
                                        <div class="col-lg-12 mb-md-2 poisition-relative">
                                            <h3 class="heading-title mt-2 mb-0 text-center heading text-white donis_font">
                                                {{ $class->name ?? '' }}</h3>
                                            <h4 class=" m-0 text-center fw-100 text-white donis_font">By
                                                {{ $class->institute->name }}</h4>
                                            <div class="postn_absolute">
                                                @php
                                                    // foreach($student_details->institute_assigned_class as $class){
                                                    if ($class->institute_assigned_class_subject->count()) {
                                                        foreach ($class->institute_assigned_class_subject as $key => $institute_assigned_class_subject) {
                                                            // dd($institute_assigned_class_subject);
                                                            $iacs = \App\Models\InstituteAssignedClassSubject::where(['institute_assigned_class_id' => $class->id, 'subject_id' => $institute_assigned_class_subject->subject->id])->first();
                                                            if (!empty($iacs)) {
                                                                $iacs_id = $iacs->id;
                                                            }
                                                            // dd($iacs_id);
                                                            $iacss = \App\Models\instituteAssignedClassSubject::findOrFail($iacs_id);
                                                            $iac = $iacss->institute_assigned_class;
                                                    
                                                            try {
                                                                $lecture = $iacs->lectures->where('lecture_date', date('Y-m-d 00:00:00'))->first();
                                                                if (empty($lecture)) {
                                                                    $lecture = $iacs->lectures->where('lecture_date', '>', date('Y-m-d 00:00:00'))->first();
                                                                }
                                                                $lecture_url = $lecture->lecture_video;
                                                                $lecture_id = $lecture->id;
                                                                $lecture_date = date('Y-m-d', strtotime($lecture->lecture_date));
                                                                $lecture_day = date('l', strtotime($lecture->lecture_date));
                                                                $lecture_time_in_unix_timestamp = strtotime(date('Y-m-d', strtotime($lecture->lecture_date)));
                                                                // dd($lecture_time_in_unix_timestamp);
                                                            } catch (\Throwable $th) {
                                                                $lecture_url = '';
                                                                $lecture_id = '';
                                                                $lecture_date = '';
                                                                $time = '';
                                                                $lecture_time_in_unix_timestamp = strtotime('23:59:59');
                                                            }
                                                        }
                                                    }
                                                    // }
                                                    $period = new DatePeriod(new DateTime($iac->start_date->format('Y-m-d')), new DateInterval('P1D'), new DateTime($iac->end_date->modify('+1 day')->format('Y-m-d')));
                                                    $lecture_dates = [];
                                                    foreach ($period as $key => $value) {
                                                        foreach ($iacs->subjects_infos->pluck('day')->toArray() as $key1 => $day) {
                                                            if ($day === strtolower($value->format('l'))) {
                                                                $lecture_dates[] = $value->format('m/d/Y');
                                                            }
                                                        }
                                                    }
                                                @endphp
                                                @if ($iacs->id)
                                                    @if (time() > $lecture_time_in_unix_timestamp - 300 && time() < $lecture_time_in_unix_timestamp + 3000)
                                                        <div
                                                            class="widget-detail-1  orange-gradient btn-style position-relative pl-2 pr-4 py-2 mr-2">
                                                            <h3
                                                                class="font-weight-normal m-0 text-white text-left pl-0 pr-2 font-14">
                                                                Your class is live</h3>
                                                            <div>
                                                                <a id="play-video" data-fancybox=""
                                                                    class="video-play-button fancybox-gallery"
                                                                    rel="video-gallery" href="{{ $lecture_url }}"
                                                                    data-id="{{ $lecture_id }}">
                                                                    <span></span>
                                                                </a>
                                                                <div id="video-overlay" class="video-overlay">
                                                                    <a class="video-overlay-close">×</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @else
                                                        @if ($lecture_date && time() < $lecture_time_in_unix_timestamp + 3000)
                                                            <div
                                                                class="widget-detail-1  orange-gradient btn-style position-relative pl-2 py-2 mr-2">
                                                                <h3
                                                                    class="font-weight-normal m-0 text-white text-left pl-0 pr-2 font-14">
                                                                    Next class on
                                                                    {{ date('m/d/Y', strtotime($lecture_date)) }}</h3>
                                                                {{-- {{date('m/d/Y', strtotime($lecture_date)) . ' ' . $time}} --}}</h3>
                                                            </div>
                                                        @else
                                                            @foreach ($lecture_dates as $item)
                                                                @if (strtotime(explode('/', $item)[2] . '-' . explode('/', $item)[0] . '-' . explode('/', $item)[1]) > strtotime(date('Y-m-d')))
                                                                    <div
                                                                        class="widget-detail-1  orange-gradient btn-style position-relative pl-2 py-2 mr-2">
                                                                        <h3
                                                                            class="font-weight-normal m-0 text-white text-left pl-0 pr-2 font-14">
                                                                            Next class on
                                                                            {{ $item }}</h3>
                                                                    </div>
                                                                @break
                                                            @endif
                                                        @endforeach
                                                    @endif
                                                @endif
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-12 p-0">
                                        <div class="row subjectGridList">
                                            @if ($class->institute_assigned_class_subject->count())
                                                @foreach ($class->institute_assigned_class_subject as $key => $institute_assigned_class_subject)
                                                    @php
                                                        // dd($institute_assigned_class_subject->subject);
                                                        $iacs = \App\Models\InstituteAssignedClassSubject::where(['institute_assigned_class_id' => $class->id, 'subject_id' => $institute_assigned_class_subject->subject->id])->first();
                                                        // dd($iacs->institute_assigned_class_id);
                                                        if (!empty($iacs)) {
                                                            $iacs_id = $iacs->id;
                                                        }
                                                        
                                                        $notifications = DB::table('class_notifications')
                                                            ->where('i_a_c_s_id', $institute_assigned_class_subject->id)
                                                            ->where('isread', 1)
                                                            ->where('type', 'text')
                                                            ->get();
                                                        $total = 0;
                                                        if (!empty($notifications)) {
                                                            foreach ($notifications as $noti) {
                                                                if ($noti->readUsers) {
                                                                    $hiddenProducts = explode(',', $noti->readUsers);
                                                                    if (in_array(auth()->user()->student_id, $hiddenProducts)) {
                                                                        $total = $total + 0;
                                                                    } else {
                                                                        $total = $total + 1;
                                                                    }
                                                                } else {
                                                                    $total = $total + 1;
                                                                }
                                                            }
                                                        }
                                                        $notifications = $total;
                                                        
                                                        $total2 = 0;
                                                        $items2 = [];
                                                        $assignmentnotifications = DB::table('class_notifications')
                                                            ->whereDate('notify_date', '<=', date('Y-m-d'))
                                                            ->where('i_a_c_s_id', $institute_assigned_class_subject->id)
                                                            ->where('isread', 1)
                                                            ->where('type', 'assignment')
                                                            ->get();
                                                        if (!empty($assignmentnotifications)) {
                                                            foreach ($assignmentnotifications as $noti) {
                                                                if ($noti->readUsers) {
                                                                    $hiddenProducts = explode(',', $noti->readUsers);
                                                                    if (in_array(auth()->user()->student_id, $hiddenProducts)) {
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
                                                        $assignmentnotifications = $total2;
                                                        
                                                        $total4 = 0;
                                                        $items4 = [];
                                                        $test = DB::table('class_notifications')
                                                            ->whereDate('notify_date', '<=', date('Y-m-d'))
                                                            ->where('i_a_c_s_id', $institute_assigned_class_subject->id)
                                                            ->where('isread', 1)
                                                            ->where('type', 'test')
                                                            ->get();
                                                        if (!empty($test)) {
                                                            foreach ($test as $noti) {
                                                                if ($noti->readUsers) {
                                                                    $hiddenProducts = explode(',', $noti->readUsers);
                                                                    if (in_array(auth()->user()->student_id, $hiddenProducts)) {
                                                                        $total4 = $total4 + 0;
                                                                    } else {
                                                                        $total4 = $total4 + 1;
                                                                        $items4[] = $noti;
                                                                    }
                                                                } else {
                                                                    $total4 = $total4 + 1;
                                                                    $items4[] = $noti;
                                                                }
                                                            }
                                                        }
                                                        $testsnotification = $total4;
                                                        
                                                        $total3 = 0;
                                                        $items3 = [];
                                                        $dnotifications = DB::table('class_notifications')
                                                            ->where('i_a_c_s_id', $institute_assigned_class_subject->id)
                                                            ->where('student_id', auth()->user()->student_id)
                                                            ->whereNotNull('institute_id')
                                                            ->where('isread', 2)
                                                            ->where('type', 'doubts')
                                                            ->get();
                                                        if (!empty($dnotifications)) {
                                                            foreach ($dnotifications as $noti) {
                                                                if ($noti->readUsers) {
                                                                    $hiddenProducts = explode(',', $noti->readUsers);
                                                                    if (in_array(auth()->user()->student_id, $hiddenProducts)) {
                                                                        $total3 = $total3 + 0;
                                                                    } else {
                                                                        $total3 = $total3 + 1;
                                                                        $items3[] = $noti;
                                                                    }
                                                                } else {
                                                                    $total3 = $total3 + 1;
                                                                    $items3[] = $noti;
                                                                }
                                                            }
                                                        }
                                                        $dnotifications = $total3;
                                                        
                                                        $total4 = 0;
                                                        $items4 = [];
                                                        $extranotifications = DB::table('class_notifications')
                                                            ->whereDate('notify_date', '<=', date('Y-m-d'))
                                                            ->where('i_a_c_s_id', $institute_assigned_class_subject->id)
                                                            ->where('type', 'extraClass')
                                                            ->get();
                                                        if (!empty($extranotifications)) {
                                                            foreach ($extranotifications as $noti) {
                                                                if ($noti->readUsers) {
                                                                    $hiddenProducts = explode(',', $noti->readUsers);
                                                                    if (in_array(auth()->user()->student_id, $hiddenProducts)) {
                                                                        $total4 = $total4 + 0;
                                                                    } else {
                                                                        $total4 = $total4 + 1;
                                                                        $items3[] = $noti;
                                                                    }
                                                                } else {
                                                                    $total4 = $total4 + 1;
                                                                    $items4[] = $noti;
                                                                }
                                                            }
                                                        }
                                                        $extranotifications = $total4;
                                                        $total = $extranotifications + $dnotifications + $testsnotification + $notifications + $assignmentnotifications;
                                                        //echo $total;
                                                    @endphp

                                                    <div class="col-md-3 p-1 subdiv">
                                                        <a href="{{ route('student.subject_detail', $iacs_id) }}"
                                                            class="d-flex flex-column w-100 subject">
                                                            <span class="{{ $colors[$key % 6] }} br-6 px-2 py-3">

                                                                @php
                                                                    try {
                                                                        $date_of_days = [];
                                                                        foreach ($institute_assigned_class_subject->subjects_infos->pluck('day') as $key => $day) {
                                                                            $date_of_days[] = date('Y-m-d', strtotime("next $day"));
                                                                        }
                                                                        asort($date_of_days);
                                                                        $day = date('l', strtotime(array_values($date_of_days)[0]));
                                                                        $next_class_day = substr($day, 0, 3);
                                                                        // dd($institute_assigned_class_subject);
                                                                        $subjects_info = $institute_assigned_class_subject->subjects_infos->where('day', strtolower($day))->first();
                                                                    
                                                                        $showtrial = false;
                                                                        $trialexpired = false;
                                                                        // dd($institute_assigned_class_subject->institute_assigned_class_id);
                                                                    
                                                                        $getId = \App\Models\StudentTrialPeriod::where('student_id', auth()->user()->student_id)
                                                                            ->where('class_id', $institute_assigned_class_subject->institute_assigned_class_id)
                                                                            ->first();
                                                                        // dd($getId->class_id);
                                                                        $istrial = \App\Models\StudentSubjectsInfo::where('student_id', auth()->user()->student_id)
                                                                            ->where('subjects_info_id', $subjects_info->id)
                                                                            ->orderBy('id', 'desc')
                                                                            ->first();
                                                                        if (!empty($istrial->start_date)) {
                                                                            $today = date('Y-m-d');
                                                                            if ($istrial->end_date < $today) {
                                                                                \App\Models\StudentSubjectsInfo::where('student_id', auth()->user()->student_id)
                                                                                    ->where('end_date', $istrial->end_date)
                                                                                    ->delete();
                                                                                \App\Models\InstituteAssignedClassStudent::where('student_id', auth()->user()->student_id)
                                                                                    ->where('institute_assigned_class_id', $institute_assigned_class_subject->institute_assigned_class_id)
                                                                                    ->delete();
                                                                                $trialexpired = 'true';
                                                                            }
                                                                            $showtrial = true;
                                                                        }
                                                                    
                                                                        $next_class_time = date('h:i a', strtotime($subjects_info->student_subjects_infos->where('student_id', auth()->user()->student_id)->first()->time_slot->slot));
                                                                    } catch (\Throwable $th) {
                                                                        $next_class_day = '';
                                                                        $next_class_time = '';
                                                                    }
                                                                @endphp
                                                                @if (isset($trialexpired) && $trialexpired == true)
                                                                    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
                                                                    <script>
                                                                        const el = document.createElement('div')
                                                                        el.innerHTML =
                                                                            "<button id='enrollalertbtn' class ='enroll' data-id='{{ $getId->class_id }}'> <a href='' id='linkbtn'>Enroll Now  </a></button>"
                                                                        swal({
                                                                            title: "Note",
                                                                            text: 'You Free Trial Period is expired, Go to Enroll classes to continue',
                                                                            icon: "warning",
                                                                            content: el,

                                                                        });
                                                                        //     swal({
                                                                        //   title: "Note",
                                                                        //   text: 'You Free Trial Period is expired, Go to Enroll classes to continue',
                                                                        //   icon: "warning",
                                                                        // }); 
                                                                        // setTimeout(() => {
                                                                        //   window.location.reload(); 
                                                                        // }, 5000);
                                                                    </script>
                                                                @endif
                                                                @if (isset($showtrial) && $showtrial == true)
                                                                    <div class="ribbon"><span>Free Trial</span>
                                                                    </div>
                                                                @endif

                                                                <h4 class=" text-left fw-100 text-white mt-0 mb-2 title"
                                                                    style='margin-left:{{ isset($showtrial) && $showtrial == true ? '26px;' : '' }}'
                                                                    data-toggle="tooltip"
                                                                    title="{{ $institute_assigned_class_subject->subject->name ?? '' }}">
                                                                    <b>{{ $institute_assigned_class_subject->subject->name ?? '' }}
                                                                        {{ !empty($total) ? '(' . $total . ')' : '' }}</b>
                                                                    <p class='counr_p'></p>
                                                                </h4>






                                                                <h4
                                                                    class="font-12 text-white mb-0  mt-1 fw-100 d-flex justify-content-between">
                                                                    <b>Next
                                                                        Class</b>
                                                                    <span>{{ $next_class_time }}<span
                                                                            class="ml-1">{{ $next_class_day }}</span></span>
                                                                </h4>
                                                                @php
                                                                    $lectures = \App\Models\Lecture::where('institute_assigned_class_subject_id', $iacs_id)
                                                                        ->whereDate('lecture_date', '<', date('Y-m-d 00:00:00'))
                                                                        ->get();
                                                                    // dd($lectures->pluck('lecture_date')->toArray());
                                                                    if ($lectures->count() > 0) {
                                                                        $total_past_lectures = $lectures->count();
                                                                        $attended_lectures = \App\Models\StudentLecture::whereIn('lecture_id', $lectures->pluck('id')->toArray())
                                                                            ->where('student_id', auth()->user()->student_id)
                                                                            ->where('attendence_in_percentage', '>=', '90')
                                                                            ->get();
                                                                    
                                                                        $total_attended_lectures = $attended_lectures->count();
                                                                        $total_absents_in_lectures = $total_past_lectures - $total_attended_lectures;
                                                                        $percentage = ($total_attended_lectures / $total_past_lectures) * 100;
                                                                    } else {
                                                                        $total_past_lectures = 0;
                                                                        $total_attended_lectures = 0;
                                                                        $total_absents_in_lectures = 0;
                                                                        $percentage = 0;
                                                                    }
                                                                @endphp
                                                                {{-- @if ($total_past_lectures > 0) --}}
                                                                <h4
                                                                    class="font-12 text-white mb-0 mt-1 fw-100 d-flex justify-content-between">
                                                                    <b>Attendance</b>
                                                                    <span>{{ $total_attended_lectures }} P<span
                                                                            class="ml-1">{{ $total_absents_in_lectures }}
                                                                            Ab</span></span>
                                                                </h4>
                                                                <h4
                                                                    class="font-12 text-white mb-0 mt-1 fw-100 d-flex justify-content-between">
                                                                    <b>Percentage</b>
                                                                    <span>{{ round($percentage, 2) }}%</span>
                                                                </h4>
                                                                {{-- @endif --}}
                                                            </span>
                                                        </a>
                                                    </div>
                                                @endforeach
                                            @endif
                                        </div>
                                    </div>
                                    <!-- <div class="col-md-12 mt-3 text-center">
            <a href="{{ route('student.enter_class', $class->id) }}" class="btn-style btn-theme">Enter Study Room</a>
          </div> -->
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>

                <!---col end-->
                <!-- end row -->
            </div>
            <!-- row -->
        </div>
        <!-- content -->
        <!-- block modal -->
        <div id="setting-modal" class="modal-demo">
            <button type="button" class="close black" onclick="Custombox.modal.close();">
                <span>&times;</span><span class="sr-only">Close</span>
            </button>
            <!-- <h4 class="custom-modal-title">Change Password</h4> -->
            <div class="custom-modal-text p-4 text-center">
                <div class="w-50 ml-2">
                    <h4 class=" my-2 text-center fw-100 d-flex align-items-center text_lft"><strong>Batch Started On
                            :</strong> <span class="ml-2">24/03/2020</span></h4>
                    <h4 class=" my-2 text-center fw-100 d-flex align-items-center text_lft"><strong>Batch Ends On
                            :</strong> <span class="ml-2">24/03/2020</span></h4>
                    <h4 class="  my-2 text-center fw-100 d-flex align-items-center text_lft"><strong>Batch Enrolled On
                            :</strong>
                        <span class="ml-2">24/03/2020</span>
                    </h4>
                    <h4 class=" my-2 text-center fw-100 d-flex align-items-center text_lft"><strong>Enrollment
                            Fee:</strong> <span class="ml-2">INR 2000</span></h4>
                </div>

                <div class="mt-3">
                    <a href="" class="btn-theme btn-style">Switch Classroom ( 15 Days left )</a>
                </div>

            </div>
        </div>
    @endsection

    @section('js')
        <script src="{{ URL::to('assets/student/libs/custombox/custombox.min.js') }}"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
        <script src="{{ URL::to('assets/student/js/app.min.js') }}"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <script>
            var message = "{{ !empty(session('success')) ? session('success') : '' }}";
            if (message) {
                swal({
                    title: "Note",
                    text: message,
                    icon: "success",
                });
            }
            $(document).ready(function() {
                $('.enroll').click(function(e) {
                    $('.swal-modal').hide();
                    $('.swal2-show').show();

                });
                $('.enroll').click(function(e) {
                    e.preventDefault();
                    var id = $(this).data('id');
                    // console.log(id);
                    (async () => {

                        const {
                            value: Class
                        } = await Swal.fire({
                            title: 'Select Class Mode',
                            input: 'select',
                            inputOptions: {
                                // 'Mode of Class ': {
                                1: 'Live ',
                                2: 'Recoded',
                                // },
                            },
                            inputPlaceholder: 'Select Class Mode',
                            showCancelButton: true,
                        })
                        console.log(Class);

                        if (Class) {
                            // Swal.fire(`You selected: ${Class}`)
                            window.location.href = "{{ url('student/select/timings') }}/" + id +
                                '/' +
                                Class;
                            // window.location = "{{ url('select-timings') }}/" + id;
                        }

                    })()

                })
            });

            /* $(document).ready(function(){
              function getnotifies(){ 
                $('.institutes_id').each(function(){
                      var id = $(this).data('id');
                      var this_ = $(this);
                    $.ajax({
                      url: "{{ url('student/getnotification') }}",
                      type: 'post',
                      dataType: 'json',
                      data: { 
                        iacs_id: id,
                        _token: "{{ csrf_token() }}"
                      },
                      success:function(response){ 
                        var textnotify = response.count;
                        var assignmentnotifications = response.assignmentnotifications; 
                        var testsnotification = response.testsnotification;  
                        var dnotifications = response.dnotifications;   
                        var extranotifications = response.extranotifications;    
                        var total = textnotify + assignmentnotifications +  testsnotification + dnotifications + extranotifications; 
                        this_.parent().find('.subdiv').find('.subject').find('.py-3').find('.counr_p').html('('+total+')');
                      }
                    }) 
                });
              }
              setInterval(getnotifies,1000); 

            }); */
        </script>
    @endsection
