@extends('student.layouts.app')
@section('page_heading', 'Extra Classes')
@section('css')
    <style>
        .ribbon {
            left: 2px;
            top: -1px;
            width: 94px;
        }

        .bg-board {
            height: 70vh;
            display: flex !important;
            justify-content: flex-start !important;
            align-content: baseline;
        }

        .ab_custom_row {
            align-items: flex-start !important;
        }

    </style>
@endsection
@section('content')
    <div class="container-fluid">
        <div class="row mx-0 align-items-center ab_custom_row">
            <div class="col-md-2">
                <img src="/assets/student/images/drawer.png" class="img-fluid">
            </div>
            <div class="col-md-9">
                <h3 class="heading-title mt-0 mb-0 text-center heading donis_font">
                    My Study Room
                </h3>
                <br>
                <div class="row card-box brder bg-board align-items-center">
                    <div class="col-lg-12 mb-md-2 poisition-relative">

                        {{-- <h4 class=" m-0 text-center fw-100 text-white donis_font">
            By {{$class->institute->name}}
          </h4> --}}
                        <div class="postn_absolut">
                            <a href="#setting-modal" class="btn-outline-theme btn-style" data-animation="fadein"
                                data-plugin="custommodal" data-overlaycolor="#36404a">Class Settings</a>
                        </div>
                    </div>

                    <div class="col-md-12 p-0">
                        <div class="row mx-0 classList customScrollBar">
                            @foreach ($all_subjects as $key => $institute_assigned_class_subject)
                                <div class="col-md-3 p-1">
                                    {{-- @php
              $iacs = \App\Models\InstituteAssignedClassSubject::where(['institute_assigned_class_id' =>
              $institute_assigned_class_id, 'subject_id' => $institute_assigned_class_subject->subject->id])->firstOrFail();
              if(!empty($iacs)){
              $iacs_id = $iacs->id;
              }
              @endphp --}}
                                    <a href="{{ route('student.subject_detail', $institute_assigned_class_subject->id) }}"
                                        class="d-flex flex-column w-100 subject">
                                        <span class="{{ $colors[$key % 6] }} br-6 px-2 py-3">

                                            @php
                                                
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
                                            @endphp

                                            @php
                                                
                                                try {
                                                    $date_of_days = [];
                                                    foreach ($institute_assigned_class_subject->subjects_infos->pluck('day') as $key => $day) {
                                                        $date_of_days[] = date('Y-m-d', strtotime("next $day"));
                                                    }
                                                    asort($date_of_days);
                                                    $day = date('l', strtotime(array_values($date_of_days)[0]));
                                                    $next_class_day = substr($day, 0, 3);
                                                    $subjects_info = $institute_assigned_class_subject->subjects_infos->where('day', strtolower($day))->first();
                                                
                                                    $showtrial = false;
                                                    $trialexpired = false;
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
                                                
                                                    $next_class_time = date('h:i A', strtotime($subjects_info->student_subjects_infos->where('student_id', auth()->user()->student_id)->first()->time_slot->slot));
                                                } catch (\Throwable $th) {
                                                    $next_class_day = '';
                                                    $next_class_time = '';
                                                }
                                            @endphp
                                            @if (isset($trialexpired) && $trialexpired == true)
                                                <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
                                                <script>
                                                    swal({
                                                        title: "Note",
                                                        text: 'You Free Trial Period is expired, Go to Enroll classes to continue',
                                                        icon: "warning",
                                                    });
                                                    setTimeout(() => {
                                                        window.location.reload();
                                                    }, 5000);
                                                </script>
                                            @endif
                                            @if (isset($showtrial) && $showtrial == true)
                                                <div class="ribbon"><span>Free Trial</span></div>
                                            @endif

                                            <h4 style='margin-left:{{ isset($showtrial) && $showtrial == true ? '26px;' : '' }}'
                                                class=" text-left fw-100 text-white mt-0 mb-2 title" data-toggle="tooltip"
                                                title="{{ $institute_assigned_class_subject->subject->name }}">
                                                <b>{{ $institute_assigned_class_subject->subject->name }}
                                                    {{ !empty($total) ? '(' . $total . ')' : '' }}
                                                </b>
                                            </h4>
                                            <h4 class="font-12 text-white mb-0  mt-1 fw-100 d-flex justify-content-between">
                                                <b>Next Class</b>
                                                <span>{{ $next_class_time }}<span
                                                        class="ml-1">{{ $next_class_day }}</span></span>
                                            </h4>
                                            @php
                                                $lectures = \App\Models\Lecture::where('institute_assigned_class_subject_id', $institute_assigned_class_subject->id)
                                                    ->whereDate(
                                                        'lecture_date',
                                                        '<',
                                                        date('Y-m-d
                                            00:00:00'),
                                                    )
                                                    ->get();
                                                
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
                                            <h4 class="font-12 text-white mb-0 mt-1 fw-100 d-flex justify-content-between">
                                                <b>Attendance</b>
                                                <span>{{ $total_attended_lectures }} P<span
                                                        class="ml-1">{{ $total_absents_in_lectures }}
                                                        Ab</span></span>
                                            </h4>
                                            <h4 class="font-12 text-white mb-0 mt-1 fw-100 d-flex justify-content-between">
                                                <b>Percentage</b>
                                                <span>{{ round($percentage, 2) }}%</span>
                                            </h4>
                                        </span>
                                    </a>
                                </div>
                            @endforeach
                            {{-- <div class="col-md-3 p-1">
              <a href="subjectdetail.html" class="d-flex flex-column w-100 h-100">
                <span class="pink-gradient br-6 px-2 py-3">
                  <h4 class=" text-left fw-100 text-white mt-0 mb-2">
                    <b>Maths</b>
                  </h4>
                  <h4 class="font-13 text-white mb-0  mt-1 fw-100 d-flex justify-content-between">
                    <b>Next Class</b>
                    <span>6:00 PM<span class="ml-1">Tue</span></span>
                  </h4>
                  <h4 class="font-13 text-white mb-0 mt-1 fw-100 d-flex justify-content-between">
                    <b>Attendance</b>
                    <span>2 P<span class="ml-1">3 Ab</span></span>
                  </h4>
                  <h4 class="font-13 text-white mb-0 mt-1 fw-100 d-flex justify-content-between">
                    <b>Percentage</b>
                    <span>77%</span>
                  </h4>
                </span>
              </a>
            </div> --}}
                            {{-- <div class="col-md-3 p-1">
              <a href="subjectdetail.html" class="d-flex flex-column w-100 h-100">
                <span class="blue-gradient br-6 px-2 py-3">
                  <h4 class=" text-left fw-100 text-white mt-0 mb-2">
                    <b>Physics</b>
                  </h4>
                  <h4 class="font-13 text-white mb-0  mt-1 fw-100 d-flex justify-content-between">
                    <b>Next Class</b>
                    <span>6:00 PM<span class="ml-1">Tue</span></span>
                  </h4>
                  <h4 class="font-13 text-white mb-0 mt-1 fw-100 d-flex justify-content-between">
                    <b>Attendance</b>
                    <span>2 P<span class="ml-1">3 Ab</span></span>
                  </h4>
                  <h4 class="font-13 text-white mb-0 mt-1 fw-100 d-flex justify-content-between">
                    <b>Percentage</b>
                    <span>77%</span>
                  </h4>
                </span>
              </a>
            </div> --}}
                            {{-- <div class="col-md-3 p-1">
              <a href="subjectdetail.html" class="d-flex flex-column w-100 h-100">
                <span class="green-gradient br-6 px-2 py-3">
                  <h4 class=" text-left fw-100 text-white mt-0 mb-2">
                    <b>Chemistry</b>
                  </h4>
                  <h4 class="font-13 text-white mb-0  mt-1 fw-100 d-flex justify-content-between">
                    <b>Next Class</b>
                    <span>6:00 PM<span class="ml-1">Tue</span></span>
                  </h4>
                  <h4 class="font-13 text-white mb-0 mt-1 fw-100 d-flex justify-content-between">
                    <b>Attendance</b>
                    <span>2 P<span class="ml-1">3 Ab</span></span>
                  </h4>
                  <h4 class="font-13 text-white mb-0 mt-1 fw-100 d-flex justify-content-between">
                    <b>Percentage</b>
                    <span>77%</span>
                  </h4>
                </span>
              </a>
            </div> --}}
                            {{-- <div class="col-md-3 p-1">
              <a href="subjectdetail.html" class="d-flex flex-column w-100 h-100">
                <span class="sea-gradient br-6 px-2 py-3">
                  <h4 class=" text-left fw-100 text-white mt-0 mb-2">
                    <b>Biology</b>
                  </h4>
                  <h4 class="font-13 text-white mb-0  mt-1 fw-100 d-flex justify-content-between">
                    <b>Next Class</b>
                    <span>6:00 PM<span class="ml-1">Tue</span></span>
                  </h4>
                  <h4 class="font-13 text-white mb-0 mt-1 fw-100 d-flex justify-content-between">
                    <b>Attendance</b>
                    <span>2 P<span class="ml-1">3 Ab</span></span>
                  </h4>
                  <h4 class="font-13 text-white mb-0 mt-1 fw-100 d-flex justify-content-between">
                    <b>Percentage</b>
                    <span>77%</span>
                  </h4>
                </span>
              </a>
            </div> --}}
                            {{-- <div class="col-md-3 p-1">
              <a href="subjectdetail.html" class="d-flex flex-column w-100 h-100">
                <span class="purple-gradient br-6 px-2 py-3">
                  <h4 class=" text-left fw-100 text-white mt-0 mb-2">
                    <b>English</b>
                  </h4>
                  <h4 class="font-13 text-white mb-0  mt-1 fw-100 d-flex justify-content-between">
                    <b>Next Class</b>
                    <span>6:00 PM<span class="ml-1">Tue</span></span>
                  </h4>
                  <h4 class="font-13 text-white mb-0 mt-1 fw-100 d-flex justify-content-between">
                    <b>Attendance</b>
                    <span>2 P<span class="ml-1">3 Ab</span></span>
                  </h4>
                  <h4 class="font-13 text-white mb-0 mt-1 fw-100 d-flex justify-content-between">
                    <b>Percentage</b>
                    <span>77%</span>
                  </h4>
                </span>
              </a>
            </div> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!---row end-->
        <!-- end row -->
    </div>
@endsection
@push('js')
    {{-- <script src="{{ URL::to('assets/admin/js/jquery-validate.js')}}"></script>
<script src="{{ URL::to('assets/admin/js/add-institute.js')}}"></script> --}}
@endpush
