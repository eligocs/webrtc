@extends('student.layouts.app')
@section('css')
{{-- <link href="{{URL::to('assets/student/libs/custombox/custombox.min.css')}}" rel="stylesheet">
<link rel="stylesheet" href="/assets/libs/chartist/chartist.min.css">
<link href="/assets/plugins/fullcalendar/css/fullcalendar.min.css" rel="stylesheet" /> --}}
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link href="/assets/admin/css/jquery.fancybox.css" rel="stylesheet" type="text/css" />
<link href="/css/datepicker.css" rel="stylesheet" type="text/css" />
<style>
  .alert {
    word-break: break-word;
  }

  .ui-datepicker-inline {
    width: 100%;
  }

  a.btn.sea-gradient.py-2.mx-2.mw-220.text-center.text-white {
    margin-top: 4px;
  }

  small.fades {
    font-size: 14px;
    color: #797878;
  }

  .datepicker-inline {
    border: none !important;
  }

  .datepicker--cell.-current- {
    color: #644699 !important;
    background: none;
    border-color: #644699;
  }

  .datepicker--cell.-selected- {
    background: #644699 !important;
  }

  .datepicker--nav-action[data-action="next"],
  .datepicker--nav-action[data-action="prev"] {

    background-color: #644699;
    color: #ffffff !important;
  }

  .datepicker--nav-action[data-action="next"]:after,
  .datepicker--nav-action[data-action="prev"]:after {
    color: #fff !important;
  }

  .not-available {
    background-color: #2f89d4;
    background-image: linear-gradient(to right, #f98b2c, #fbc03a);
    font-size: 12px;
  }

  .on-hove:hover {
    color: #000 !important;
  }

  .on-hove {
    color: #167fd2;
  }

  .fc-content {
    position: absolute;
    bottom: 9px;
    width: 85%;
    left: 0;
    text-align: center;
    height: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    right: 0;
    margin: auto;
    color: #ffffff;
  }
  .w-100.text-center.col-6 {
    padding-top: 10px;
    width: 50%; 
    margin-right: auto;
    margin-left: auto;
}
</style>
@endsection
@section('content')
@php
/* $iacs = \App\Models\instituteAssignedClassSubject::findOrFail(request()->iacs_id);
$iac = $iacs->institute_assigned_class; */ 
$iacs = \App\Models\instituteAssignedClassSubject::findOrFail(request()->iacs_id);
use App\Http\Controllers\Web\Student\StudentController;
$iac = $iacs->institute_assigned_class;
 
  $institute_d = \App\Models\Institute::find($iac->institute_id); 

$mode = StudentController::getmodeofClass(); 
// Declare and define two dates
$trial_end_date = strtotime($mode->end_date);
$today_date = strtotime(date('Y-m-d'));
$avalable_date = abs($today_date - $trial_end_date);
$years = floor($avalable_date / (365*60*60*24));
$months = floor(($avalable_date - $years * 365*60*60*24)
/ (30*60*60*24));
$today_date_show = floor(($avalable_date - $years * 365*60*60*24 -
$months*30*60*60*24)/ (60*60*24));
 
@endphp

<div class="modal fade" id='changeTimeModal' tabindex="-1" role="dialog" aria-hidden="true" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Edit Class Time</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        @php $slots = \DB::table('time_slots')->get(); @endphp
        <form method='post' action="{{url('student/editClassTime')}}">
          @csrf()
          <div class='form-group'>
            <label>New Class Time</label>
            <!-- <input name='newtime' type='time' class='form-control old_time'> -->
            <select name='newTime' class='form-control old_time'>
              <option value=''>--Select--</option>
              @if($slots)
              @foreach($slots as $lots)
              <option value='{{$lots->id}}'>{{$lots->slot}}</option>
              @endforeach
              @endif
            </select>
          </div>
          <button type="submit" class="btn btn-success">Save</button>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<div class="container-fluid">
  <div>{{ Breadcrumbs::render('subject_detail', request()->iacs_id) }}</div>
  <div class="row">
    <div class="col-xl-12 col-md-12 col-sm-12">

      @if(session('success'))
      <div class="alert alert-success alert-dismissible">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        {{ session('success') }}
      </div>
      @endif
      @if (\Session::has('error'))
      <div class="alert alert-danger alert-dismissible">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        {!! \Session::get('error') !!}
      </div>
      @endif

      <div class="card-box position-relative">
        <h3 class="heading-title mt-0 mb-0 text-center heading">
          {{ucFirst(\App\Models\InstituteAssignedClassSubject::findOrFail(request()->iacs_id)->subject->name)}}</h3>
          @if($institute_d->description  && $institute_d->videoApproval == 1) 
          <div class='w-70 text-center col-12 pt-3 px-5  px-sm-1 discription'>{{$institute_d->description ?? ''}}</div> 
          @endif
        <div class="card-box d-flex align-items-center justify-content-center">
          {{-- <div class="widget-detail-1  orange-gradient btn-style position-relative pl-2 pr-4 py-2 mr-2">
            <h3 class="font-weight-normal m-0 text-white text-left pl-0 pr-2 font-14">Your class is live</h3>
            <div>
              <a id="play-video" data-fancybox="" class="video-play-button fancybox-gallery" rel="video-gallery" href=""
                data-id="2">
                <span></span>
              </a>
              <div id="video-overlay" class="video-overlay">
                <a class="video-overlay-close">×</a>
              </div>
            </div>
            <!-- </div> -->
          </div> --}}
          @php
          // try {
          // $lecture = $iacs->lectures->where('lecture_date', date('Y-m-d 00:00:00'))->first();
          // $lecture_url = $lecture->lecture_video;
          // $lecture_date = $lecture->lecture_date->format('Y-m-d');
          // $lecture_day = date('l', strtotime($lecture->lecture_date));
          // $time = \App\Models\SubjectsInfo::where('institute_assigned_class_subject_id',
          // request()->iacs_id)->where('day',
          // strtolower($lecture_day))->first()->student_subjects_info->time_slot->slot;
          // $lecture_time_in_unix_timestamp = strtotime($lecture->lecture_date) + (strtotime($time) -
          // strtotime('00:00:00'));
          // } catch (\Throwable $th) {
          // $lecture_url = '';
          // $lecture_date = '';
          // $time = '';
          // $lecture_time_in_unix_timestamp = strtotime('23:59:59');
          // }
          try {
          $lecture = $iacs->lectures->where('lecture_date', date('Y-m-d 00:00:00'))->first();
          if(empty($lecture)){
          $lecture = $iacs->lectures->where('lecture_date', '>' ,date('Y-m-d 00:00:00'))->first();
          }
          $lecture_url = $lecture->lecture_video;
          $lecture_id = $lecture->id;
          $lecture_date = date('Y-m-d', strtotime($lecture->lecture_date));
          $lecture_day = date('l', strtotime($lecture->lecture_date));
          $time = \App\Models\SubjectsInfo::where('institute_assigned_class_subject_id',
          request()->iacs_id)->where('day',
          strtolower($lecture_day))->first()->student_subjects_infos->where('student_id',
          auth()->user()->student_id)->first()->time_slot->slot;
          // $lecture_time_in_unix_timestamp = strtotime($lecture->lecture_date) + (strtotime($time) -
          // strtotime('00:00:00'));
          $lecture_time_in_unix_timestamp = strtotime(date('Y-m-d', strtotime($lecture->lecture_date)).' '. $time);
          } catch (\Throwable $th) {
          $lecture_url = '';
          $lecture_id = '';
          $lecture_date = '';
          $time = '';
          $lecture_time_in_unix_timestamp = strtotime('23:59:59');
          }
          $period = new DatePeriod(
          new DateTime($iac->start_date->format('Y-m-d')),
          new DateInterval('P1D'),
          new DateTime($iac->end_date->modify('+1 day')->format('Y-m-d'))
          );
          $lecture_dates = [];
          foreach ($period as $key => $value) {
          foreach($iacs->subjects_infos->pluck('day')->toArray() as $key1 => $day){
          if($day === strtolower($value->format('l'))){
          $lecture_dates[] = $value->format('m/d/Y');
          }
          }
          }
          @endphp
          {{-- 300 for 5 mins before --}}
          @if (time() > ($lecture_time_in_unix_timestamp - 300) && time() < ($lecture_time_in_unix_timestamp + 3000))
            <div class="widget-detail-1  orange-gradient btn-style position-relative pl-2 pr-4 py-2 mr-2">
            <h3 class="font-weight-normal m-0 text-white text-left pl-0 pr-2 font-14">Your class is live</h3>
            <div>
              <a id="play-video" data-fancybox="" class="video-play-button fancybox-gallery" rel="video-gallery"
                href="{{$lecture_url}}" data-id="{{$lecture_id}}">
                <span></span>
              </a>
              <div id="video-overlay" class="video-overlay">
                <a class="video-overlay-close">×</a>
              </div>
            </div>
            <!-- </div> -->
        </div>
        @else
        @if ($lecture_date && time() < ($lecture_time_in_unix_timestamp + 3000)) <div
          class="widget-detail-1  orange-gradient btn-style position-relative pl-2 py-2 mr-2">
          <h3 class="font-weight-normal m-0 text-white text-left pl-0 pr-2 font-14">Next class on
            {{date('m/d/Y', strtotime($lecture_date)) . ' ' . $time}}</h3>
      </div>
      @else
      @foreach ($lecture_dates as $item)
      @if (strtotime(explode('/', $item)[2].'-'.explode('/', $item)[0].'-'.explode('/', $item)[1]) >
      strtotime(date('Y-m-d')))
      <div class="widget-detail-1  orange-gradient btn-style position-relative pl-2 py-2 mr-2">
        <h3 class="font-weight-normal m-0 text-white text-left pl-0 pr-2 font-14">Next class on
          {{$item}}</h3>
      </div>
      @break
      @endif
      @endforeach
      @endif
      @endif
      @php
      // $syllabus_url = \App\Models\InstituteAssignedClassSubject::findOrFail(request()->iacs_id)->syllabus;
      $syllabus_url = $iacs->syllabus;
	  $url_ = '';
		if(!empty($syllabus_url) && @unserialize($syllabus_url) == true){
			$url_ = unserialize($syllabus_url);
		}
      @endphp
     
      {{--@if ($syllabus_url)
      <a href="{{$syllabus_url ? ('https://aaradhanaclasses.s3.ap-south-1.amazonaws.com/'.$syllabus_url): '#'}}"
        {{$syllabus_url ? '' :"onclick=showAlert()"}} class="green-gradient text-center btn-style text-white mr-2"
        {{$syllabus_url ? 'target="_blank"' : ''}}>View
        Syllabus</a>
      @endif--}}
	  @if(!empty($url_))
		  <a href="{{$url_[0] ? $url_[0]: '#'}}"
        {{$url_[0] ? '' :"onclick=showAlert()"}} class="green-gradient text-center btn-style text-white mr-2"
        {{$url_[0] ? 'target="_blank"' : ''}}>View
        Syllabus</a>
	  @endif

    <div  class="widget-detail-1  orange-gradient btn-style position-relative pl-2 pr-4 py-2 mr-2 d-flex">
          <h4 class="font-weight-normal font-14 my-0 mr-1 text-white text-left ">View Demo</h4>
      <div> 
          @php 
          $video = $iacs->video ?? '';
          if($video && $iacs->videoApproval == 1){
            $video_to = $video && @unserialize($video) == true ? unserialize($video)[0] :'';
          } 
          @endphp
          <a target='{{ !empty($video_to) ? "_blank":""}}' data-fan cybox class="video-play-button fancyb ox-gallery"
              rel="video-gallery" href="{{ $video_to ?? '' }}">
              <span></span>
          </a>
          <div id="video-overlay" class="video-overlay">
              <a class="video-overlay-close">×</a>
          </div>
      </div>
    </div>

      
    </div>

  </div>
</div>
</div>

@php
$data = StudentController::meetingList();
$segment = Request::segment(3);
if(!empty($data)){
foreach ($data as $list) {
if ($list != '') {
$join_link = get_browser_join_links_student($list->meeting_id, $list->password, $segment);
}
@endphp
@if (!empty($join_link))
<a href="{{ $join_link ? $join_link : '' }}" class="button">
  <div class="row card-box mx-0 justify-content-center time_table">
    <div class="col-md-12">
      <h4 class=" mt-0 mb-3 text-center fw-100">Live Class</h4>
    </div>
    @php

    $colors = ['orange-gradient', 'pink-gradient', 'blue-gradient', 'green-gradient', 'sea-gradient',
    'purple-gradient'];
    @endphp
    @php
    $show_ribbon = false;
    $counter = 1;
    @endphp
    <div class="col-xl-2 col-md-6 mw-220">
      <div class="card-box {{ $colors[$key % 6] }} mx-0 mt-0 mb-md-3">
        <div class="ribbon" style="display: block;' : 'display:none' }}">
          <span>Live
            Class</span>
        </div>
        <h4 class="header-title mt-0 mb-2 text-center text-white">Today</h4>
        <div class="widget-detail-1 text-center">
          <h3 class="font-weight-normal m-0 text-white h4">
            {{ $list->time }}
          </h3>
        </div>
      </div>
    </div><!-- end col -->
  </div>
</a>
@endif
@php
}
}
@endphp
<!--end row-->


<!-- tabs end -->
<div class="row card-box mx-0 justify-content-center time_table">
  <div class="col-md-12">
    <h4 class=" mt-0 mb-3 text-center fw-100">Time Table</h4>
  </div>
  @php
  $colors = [
  'orange-gradient',
  'pink-gradient',
  'blue-gradient',
  'green-gradient',
  'sea-gradient',
  'purple-gradient',
  ];
  @endphp
  @php
  $show_ribbon = false;
  $counter = 1;
  @endphp
  @foreach ($iacs->subjects_infos as $key => $item)
  @if($key == 0)
  @php
  $subj_ids = [];
  foreach ($iacs->subjects_infos as $subj){
  $subj_ids[] =
  
        !empty( $subj->student_subjects_infos->where('student_id',auth()->user()->student_id)->first()->subjects_info_id)

           ? $subj->student_subjects_infos->where('student_id',auth()->user()->student_id)->first()->subjects_info_id  :'';
  }
  $implodes = implode(',',$subj_ids);
  @endphp
  <!--     $item->student_subjects_infos->where('student_id', auth()->user()->student_id)->first()->id -->
  <div class="col-md-12">
    <a href='#' data-toggle="modal" data-target="#changeTimeModal" data-cl="{{$implodes}}"
      data-student='{{auth()->user()->student_id}}'
      data-time="{{!empty($item->student_subjects_infos->where('student_id', auth()->user()->student_id)->first()->time_slot->id) ? $item->student_subjects_infos->where('student_id', auth()->user()->student_id)->first()->time_slot->id : ''}}"
      class='changeClassTime'>
      <div class='on-hove  '> <i class='fa fa-edit'> Change Class Timings</i> </div>
    </a>
    <p><small class='fades'>Note: Changing class timings will be effected from next day.</small></p>
  </div>
  @endif
  <div class="col-xl-2 col-md-6 mw-220">
    <div class="card-box {{$colors[$key%6]}} mx-0 mt-0 mb-md-3">
      @php
      if (strtotime("this week $item->day") > strtotime(date('Y-m-d'))) {
      $show_ribbon = true;
      $counter -= 1;
      }
      @endphp
      @php
      $dataitem =
      !empty($item->student_subjects_infos->where('student_id', auth()->user()->student_id)->first()->time_slot->slot) ?
      date('h:i A', strtotime($item->student_subjects_infos->where('student_id',
      auth()->user()->student_id)->first()->time_slot->slot)) : '';
      $date = date('h:i A');
      $curTdate = date('h:i A',strtotime('-5 minutes',strtotime($date)));
      // dd($curTdate);
      $day = date("l");
      @endphp
      @if($dataitem == $curTdate && $item->day == $day)
      <div class="ribbon"><span>Next
          Class</span></div>
      @endif
      {{--  <div class="ribbon" style="{{$counter == 0 && $show_ribbon ? 'display: block;' : 'display:none'}}"><span>Next
        Class</span></div> --}}
    <h4 class="header-title mt-0 mb-2 text-center text-white">{{ucFirst($item->day)}}</h4>
    <div class="widget-detail-1 text-center">
      <h3 class="font-weight-normal m-0 text-white h4">
        {{!empty($item->student_subjects_infos->where('student_id', auth()->user()->student_id)->first()->time_slot->slot) ? date('h:i A', strtotime($item->student_subjects_infos->where('student_id', auth()->user()->student_id)->first()->time_slot->slot)) : ''}}
      </h3>
    </div>

  </div>
</div><!-- end col -->
@endforeach
@if (!$show_ribbon)
<script>
  document.getElementsByClassName('ribbon')[0].style.display= 'block';
</script>
@endif
{{-- <div class="col-xl-3 col-md-6 mw-220">
                                <div class="card-box purple-gradient m-0">
                                    <h4 class="header-title mt-0 mb-2 text-center text-white">Wednesday</h4>
                                    <div class="widget-box-2">
                                        <div class="widget-detail-1 text-center">
                                            <h3 class="font-weight-normal m-0 text-white"> 7:30 PM </h3>
                                        </div>
                                    </div>
                                </div>

                            </div><!-- end col --> --}}

{{-- <div class="col-xl-3 col-md-6 mw-220">
                                <div class="card-box green-gradient m-0 position-relative">
                                    <div class="ribbon"><span>Next Class</span></div>

                                    <h4 class="header-title mt-0 mb-2 text-center text-white">Friday</h4>
                                    <div class="widget-chart-1">
                                        <div class="widget-detail-1 text-center">
                                            <h3 class="font-weight-normal m-0 text-white"> 10:00 AM </h3>
                                        </div>
                                    </div>
                                </div>
                            </div><!-- end col --> --}}

{{-- <div class="col-xl-3 col-md-6 mw-220">
                                <div class="card-box pink-gradient m-0">
                                    <h4 class="header-title mt-0 mb-2 text-center text-white">Saturday</h4>
                                    <div class="widget-detail-1 text-center">
                                        <h3 class="font-weight-normal m-0 text-white"> 7:00 PM </h3>
                                    </div>
                                </div>
                            </div><!-- end col -->      --}}
</div>
<!-- end row -->

<div  class="card-box class_resources">
  <h4 class=" mt-0 mb-3 text-center fw-100">Class Resources</h4>
  <div class=" d-flex align-items-center justify-content-center flex-wrap">
    <a class="btn  py-2 mx-2  mw-220 text-center text-white getnotification"
      style='background:linear-gradient(45deg,#8a2be2e8, #c8beff);' data-toggle='modal'
      data-target='#notificationModal'>Class Notifications <span
        class='totalNotify'>{{$notifications ? '('.$notifications.')' :'(0)'}}</span></a>

    @if(!empty($mode) && $mode->mode_of_class == 2 )
    <a class="btn green-gradient py-2 mx-2  mw-220 text-center text-white"
      href="{{route('student.revised_lectures', request()->iacs_id)}}">Revise Lectures</a>
    @elseif(!empty($mode) && $mode->mode_of_class == 1 )
    <a class="btn green-gradient py-2 mx-2  mw-220 text-center text-white"
      href="{{ route('student.revised-live-lectures', request()->iacs_id) }}">Revise
      live Lectures</a>
    @elseif(!empty($mode) && $mode->mode_of_class == 0 )
    <a class="btn green-gradient py-2 mx-2  mw-220 text-center text-white"
      href="{{route('student.revised_lectures', request()->iacs_id)}}">Revise Lectures</a>
    @endif
    <a class="btn pink-gradient py-2 mx-2  mw-220 text-center text-white"
      href="{{route('student.assignments', request()->iacs_id)}}">Assignments <span
        class='assignmentnotifications'>{{!empty($assignmentnotifications) ? '('.$assignmentnotifications.')' :'(0)'}}</span></a>
    <a class="btn blue-gradient py-2 mx-2  mw-220 text-center text-white"
      href="{{route('student.doubts', request()->iacs_id)}}">Doubts <span
        class='dnotifications'>{{$dnotifications ? '('.$dnotifications.')' :'(0)'}}</span></a>
    <a class="btn orange-gradient py-2 mx-2  mw-220 text-center text-white"
      href="{{route('student.tests', request()->iacs_id)}}">Tests <span
        class='testsnotification'>{{$testsnotification ? '('.$testsnotification.')' :'(0)'}}</span></a>
    <a class="btn sea-gradient py-2 mx-2  mw-220 text-center text-white"
      href="{{route('student.extra-classes', request()->iacs_id)}}">Extra Classes <span
        class='extranotifications'>{{$extranotifications ? '('.$extranotifications.')' :'(0)'}}</span></a>
  </div>
</div>

<div class="modal fade" id="notificationModal" role="dialog">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        {{-- <button type="button" class="close" data-dismiss="modal">&times;</button> --}}
        <h4 class="modal-title text-left">Notifications</h4>
      </div>
      <div class="modal-body notifications_all">

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-dark" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<!-- end row -->
@php

 if(!empty(request()->iacs_id)){
        $institute_assigned_class_subject = DB::table('institute_assigned_class_subject')->where('id',request()->iacs_id)->first();
        if(!empty($institute_assigned_class_subject)){
          $institute_assigned_class_student = DB::table('institute_assigned_class_student')->where('institute_assigned_class_id',$institute_assigned_class_subject->institute_assigned_class_id)->where('student_id',auth()->user()->student_id)->first();
          if(!empty($institute_assigned_class_student) && !empty($institute_assigned_class_student->end_date)){
            $start_date = $institute_assigned_class_student->start_date;
          } else{
            $institute_assigned_class = DB::table('institute_assigned_class')->where('id',$institute_assigned_class_subject->institute_assigned_class_id)->first();
            $start_date = $institute_assigned_class->start_date;
          }
        }
      }
        $tests = \App\Models\Topic::where('institute_assigned_class_subject_id', request()->iacs_id)->where('type',
        'test')->orderByDesc('id')->take(10)
        ->where('publish_date','>=',$start_date)
        ->where('publish_date', '<=', date('Y-m-d'))
        ->where('status','publish')->get();
        $total_tests = $tests->count();
        $total_attempted = 0;
        $total_unattempted = 0;
        $marks_in_last_test = 0;
        if($total_tests){
        $latest_tests = $tests->sortByDesc('id')->take(10);
        $where_answers = \App\Models\Answer::where('user_id', auth()->user()->student_id)->whereIn('topic_id',
        $tests->pluck('id')->toArray());
        $attempted = $where_answers->get();
        $total_attempted = count(array_unique($attempted->pluck('topic_id')->toArray()));
        $total_unattempted = $total_tests - $total_attempted;
        $latest_given_test = $where_answers->orderByDesc('created_at')->first();

        if(!empty($latest_given_test)){

        $topic = $latest_given_test->topic;
        $answers = \App\Models\Answer::where('topic_id',$topic->id)->where('user_id',Auth::user()->student_id)->get();
        $mark = 0;
        foreach ($answers as $answer){
        if ($answer->answer == $answer->user_answer){
        $mark++;
        }
        }
        $correct = $mark*$topic->per_q_mark;
        $count_questions = $topic->questions->count() ?? 0;
        $total_marks = $topic->per_q_mark*$count_questions;
        } else {
        $correct = 0;
        $total_marks = 0;
        }
        }
@endphp
<div class="row  card-box mx-auto Performance_inner">
  <div class="col-xl-12 col-md-12 ">
    <h4 class=" mt-0 mb-3 text-center fw-100">My Test Performance</h4>
    <div class="row m-0 align-items-center">

      <div class="col-xl-9 ">
        <div class=" h-435">

          <div class="chat_AVESTUD">
            <div id="stacked-bar-chart" class="ct-chart ct-golden-section">
              <div class="chartist-tooltip" style="top: -1px; left: 739px;"></div><svg
                xmlns:ct="http://gionkunz.github.com/chartist-js/ct" width="100%" height="100%" class="ct-chart-bar"
                style="width: 100%; height: 100%;">
                <g class="ct-grids">
                  <line x1="50" x2="50" y1="15" y2="265" class="ct-grid ct-horizontal"></line>
                  <line x1="130" x2="130" y1="15" y2="265" class="ct-grid ct-horizontal"></line>
                  <line x1="210" x2="210" y1="15" y2="265" class="ct-grid ct-horizontal"></line>
                  <line x1="285" x2="285" y1="15" y2="265" class="ct-grid ct-horizontal"></line>
                  <line x1="360" x2="360" y1="15" y2="265" class="ct-grid ct-horizontal"></line>
                  <line x1="435" x2="435" y1="15" y2="265" class="ct-grid ct-horizontal"></line>
                  <line x1="510" x2="510" y1="15" y2="265" class="ct-grid ct-horizontal"></line>
                  <line x1="585" x2="585" y1="15" y2="265" class="ct-grid ct-horizontal"></line>
                  <line x1="655" x2="655" y1="15" y2="265" class="ct-grid ct-horizontal"></line>
                  <line x1="730" x2="730" y1="15" y2="265" class="ct-grid ct-horizontal"></line>
                  <line y1="265" y2="265" x1="50" x2="786" class="ct-grid ct-vertical"></line>
                  <line y1="240" y2="240" x1="50" x2="786" class="ct-grid ct-vertical"></line>
                  <line y1="215" y2="215" x1="50" x2="786" class="ct-grid ct-vertical"></line>
                  <line y1="190" y2="190" x1="50" x2="786" class="ct-grid ct-vertical"></line>
                  <line y1="165" y2="165" x1="50" x2="786" class="ct-grid ct-vertical"></line>
                  <line y1="140" y2="140" x1="50" x2="786" class="ct-grid ct-vertical"></line>
                  <line y1="115" y2="115" x1="50" x2="786" class="ct-grid ct-vertical"></line>
                  <line y1="90" y2="90" x1="50" x2="786" class="ct-grid ct-vertical"></line>
                  <line y1="65" y2="65" x1="50" x2="786" class="ct-grid ct-vertical"></line>
                  <line y1="40" y2="40" x1="50" x2="786" class="ct-grid ct-vertical"></line>
                  <line y1="15" y2="15" x1="50" x2="786" class="ct-grid ct-vertical"></line>
                </g>
                <g>
                  <g class="ct-series ct-series-a">
                    @php

                    if($total_tests){
                    $t = [
                    ['xy' => 90, 'value' => 800000, 'stroke' => '#f9912d'],
                    ['xy' => 172, 'value' => 1200000, 'stroke' => '#88c50d'],
                    ['xy' => 248, 'value' => 1400000, 'stroke' => '#fe5f69'],
                    ['xy' => 322, 'value' => 1300000, 'stroke' => '#1680d2'],
                    ['xy' => 398, 'value' => 1300000, 'stroke' => '#10e0cf'],
                    ['xy' => 472, 'value' => 1300000, 'stroke' => '#a398f1'],
                    ['xy' => 548, 'value' => 1300000, 'stroke' => '#52a9ed'],
                    ['xy' => 622, 'value' => 1300000, 'stroke' => '#dc8186'],
                    ['xy' => 692, 'value' => 1300000, 'stroke' => '#f5b77c'],
                    ['xy' => 762, 'value' => 1300000, 'stroke' => '#5fa611'],
                    ];
                    $marks_in_percentage_array = [];
                    $current_student_tests = $latest_tests->load(['answers' =>
                    function($query){$query->where('user_id',
                    auth()->user()->student_id);}]) ?? [];
                    $keey = $total_tests;
                    foreach ($current_student_tests as $key => $test){
                    $keey = $keey-1;
                    $y2 = 265;
                    if($test->answers->count()){
                    $mark1 = 0;
                    foreach ($test->answers as $answer){
                    if ($answer->answer == $answer->user_answer){
                    $mark1++;
                    }
                    }
                    $correct1 = $mark1*$test->per_q_mark;
                    $count_questions = $test->questions->count() ?? 0;
                    $total_marks1 = $test->per_q_mark*$count_questions;
                    if($total_marks1 == 0)
                    $marks_in_percentage = 0;
                    else
                    $marks_in_percentage = ($correct1/$total_marks1)*100;
                    $y2 = 265-(25*($marks_in_percentage/10));
                    } else {
                    $correct1 = 0;
                    $total_marks1 = 0;
                    if($total_marks1 == 0)
                    $marks_in_percentage = 0;
                    else
                    $marks_in_percentage = ($correct1/$total_marks1)*100;
                    $y2 = 265-(25*($marks_in_percentage/10));
                    }
                    $xy = $t[$keey]['xy'];
                    $value = $t[$keey]['value'];
                    $stroke = $t[$keey]['stroke'];
                    $y2 = $y2 != 265 ? $y2 : 264;
                    $line = "<line x1='$xy' x2='$xy' y1='265' y2='$y2' class='ct-bar' ct:value='$value'";
                      $line .= " style='stroke-width: 30px;stroke:$stroke'></line>";
                    echo $line;
                    }
                    }
                    @endphp
                    {{-- <line x1="90" x2="90" y1="265" y2="{{265-(25*(9/10))}}" class="ct-bar" ct:value="800000"
                    style="stroke-width: 30px;stroke:#f9912d"></line>
                    <line x1="172" x2="172" y1="265" y2="{{265-(25*(19/10))}}" class="ct-bar" ct:value="1200000"
                      style="stroke-width: 30px;stroke:#88c50d;"></line>
                    <line x1="248" x2="248" y1="265" y2="{{265-(25*(29/10))}}" class="ct-bar" ct:value="1400000"
                      style="stroke-width: 30px;stroke:#fe5f69"></line>
                    <line x1="322" x2="322" y1="265" y2="{{265-(25*(39/10))}}" class="ct-bar" ct:value="1300000"
                      style="stroke-width: 30px;stroke:#1680d2"></line>
                    <line x1="398" x2="398" y1="265" y2="{{265-(25*(49/10))}}" class="ct-bar" ct:value="1300000"
                      style="stroke-width: 30px;stroke:#10e0cf"></line>
                    <line x1="472" x2="472" y1="265" y2="{{265-(25*(59/10))}}" class="ct-bar" ct:value="1300000"
                      style="stroke-width: 30px;stroke:#a398f1;"></line>
                    <line x1="548" x2="548" y1="265" y2="{{265-(25*(69/10))}}" class="ct-bar" ct:value="1300000"
                      style="stroke-width: 30px;stroke:#52a9ed;"></line>
                    <line x1="622" x2="622" y1="265" y2="{{265-(25*(79/10))}}" class="ct-bar" ct:value="1300000"
                      style="stroke-width: 30px;stroke:#dc8186;"></line>
                    <line x1="692" x2="692" y1="265" y2="{{265-(25*(89/10))}}" class="ct-bar" ct:value="1300000"
                      style="stroke-width: 30px;stroke:#f5b77c;"></line>
                    <line x1="762" x2="762" y1="265" y2="{{265-(25*(99/10))}}" class="ct-bar" ct:value="1300000"
                      style="stroke-width: 30px;stroke:#5fa611;"></line> --}}
                  </g>
                  <g class="ct-series ct-series-b">
                    <line x1="169.125" x2="169.125" y1="185" y2="165" class="ct-bar" ct:value="200000"
                      style="stroke-width: 30px"></line>
                    <line x1="407.375" x2="407.375" y1="145" y2="105" class="ct-bar" ct:value="400000"
                      style="stroke-width: 30px"></line>
                    <line x1="645.625" x2="645.625" y1="125" y2="75" class="ct-bar" ct:value="500000"
                      style="stroke-width: 30px"></line>
                    <line x1="883.875" x2="883.875" y1="135" y2="105" class="ct-bar" ct:value="300000"
                      style="stroke-width: 30px"></line>
                  </g>
                  <g class="ct-series ct-series-c">
                    <line x1="169.125" x2="169.125" y1="165" y2="149" class="ct-bar" ct:value="160000"
                      style="stroke-width: 30px"></line>
                    <line x1="407.375" x2="407.375" y1="105" y2="76" class="ct-bar" ct:value="290000"
                      style="stroke-width: 30px"></line>
                    <line x1="645.625" x2="645.625" y1="75" y2="34" class="ct-bar" ct:value="410000"
                      style="stroke-width: 30px"></line>
                    <line x1="883.875" x2="883.875" y1="105" y2="45" class="ct-bar" ct:value="600000"
                      style="stroke-width: 30px"></line>
                  </g>
                </g>
                <g class="ct-labels">
                  <foreignObject style="overflow: visible;" x="80" y="270" width="50" height="20"><span
                      class="ct-label ct-horizontal ct-end" xmlns="http://www.w3.org/2000/xmlns/"
                      style="width: 238px; height: 20px;stroke:#fe8c42">T1</span></foreignObject>
                  <foreignObject style="overflow: visible;" x="163" y="270" width="50" height="20"><span
                      class="ct-label ct-horizontal ct-end" xmlns="http://www.w3.org/2000/xmlns/"
                      style="width: 238px; height: 20px;">T2</span></foreignObject>
                  <foreignObject style="overflow: visible;" x="240" y="270" width="50" height="20"><span
                      class="ct-label ct-horizontal ct-end" xmlns="http://www.w3.org/2000/xmlns/"
                      style="width: 238px; height: 20px;stroke:#85c20e">T3</span></foreignObject>
                  <foreignObject style="overflow: visible;" x="314" y="270" width="50" height="20"><span
                      class="ct-label ct-horizontal ct-end" xmlns="http://www.w3.org/2000/xmlns/"
                      style="width: 238px; height: 20px;stroke:#fe5e6a">T4</span></foreignObject>
                  <foreignObject style="overflow: visible;" x="388" y="270" width="50" height="20"><span
                      class="ct-label ct-horizontal ct-end" xmlns="http://www.w3.org/2000/xmlns/"
                      style="width: 238px; height: 20px;stroke:#fe5e6a">T5</span></foreignObject>
                  <foreignObject style="overflow: visible;" x="462" y="270" width="50" height="20"><span
                      class="ct-label ct-horizontal ct-end" xmlns="http://www.w3.org/2000/xmlns/"
                      style="width: 238px; height: 20px;stroke:#fe5e6a">T6</span></foreignObject>
                  <foreignObject style="overflow: visible;" x="541" y="270" width="50" height="20"><span
                      class="ct-label ct-horizontal ct-end" xmlns="http://www.w3.org/2000/xmlns/"
                      style="width: 238px; height: 20px;stroke:#fe5e6a">T7</span></foreignObject>
                  <foreignObject style="overflow: visible;" x="615" y="270" width="50" height="20"><span
                      class="ct-label ct-horizontal ct-end" xmlns="http://www.w3.org/2000/xmlns/"
                      style="width: 238px; height: 20px;stroke:#fe5e6a">T8</span></foreignObject>
                  <foreignObject style="overflow: visible;" x="683" y="270" width="50" height="20"><span
                      class="ct-label ct-horizontal ct-end" xmlns="http://www.w3.org/2000/xmlns/"
                      style="width: 238px; height: 20px;stroke:#fe5e6a">T9</span></foreignObject>
                  <foreignObject style="overflow: visible;" x="746" y="270" width="50" height="20"><span
                      class="ct-label ct-horizontal ct-end" xmlns="http://www.w3.org/2000/xmlns/"
                      style="width: 238px; height: 20px;stroke:#fe5e6a">T10</span></foreignObject>
                  <foreignObject style="overflow: visible;display:flex;justify-content: flex-end;" y="232" x="10"
                    height="25" width="40"><span class="ct-label ct-vertical ct-start"
                      xmlns="http://www.w3.org/2000/xmlns/"
                      style="height: 25px; width: 40px;padding-right: 2px;text-align: right;">10%</span>
                  </foreignObject>
                  <foreignObject style="overflow: visible;display:flex;justify-content: flex-end;" y="205" x="10"
                    height="25" width="40"><span class="ct-label ct-vertical ct-start"
                      xmlns="http://www.w3.org/2000/xmlns/"
                      style="height: 25px;width: 40px;padding-right: 2px;text-align: right;">20%</span>
                  </foreignObject>
                  <foreignObject style="overflow: visible;display:flex;justify-content: flex-end;" y="180" x="10"
                    height="25" width="40"><span class="ct-label ct-vertical ct-start"
                      xmlns="http://www.w3.org/2000/xmlns/"
                      style="height: 25px; width: 40px;padding-right: 2px;text-align: right;">30%</span>
                  </foreignObject>
                  <foreignObject style="overflow: visible;display:flex;justify-content: flex-end;" y="157" x="10"
                    height="25" width="40"><span class="ct-label ct-vertical ct-start"
                      xmlns="http://www.w3.org/2000/xmlns/"
                      style="height: 25px; width: 40px;padding-right: 2px;text-align: right;">40%</span>
                  </foreignObject>
                  <foreignObject style="overflow: visible;display:flex;justify-content: flex-end;" y="133" x="10"
                    height="25" width="40"><span class="ct-label ct-vertical ct-start"
                      xmlns="http://www.w3.org/2000/xmlns/"
                      style="height: 25px; width: 40px;padding-right: 2px;text-align: right;">50%</span>
                  </foreignObject>
                  <foreignObject style="display:flex;justify-content: flex-end;overflow: visible;" y="108" x="10"
                    height="25" width="40"><span class="ct-label ct-vertical ct-start"
                      xmlns="http://www.w3.org/2000/xmlns/"
                      style="height: 25px; width: 40px;padding-right: 2px;text-align: right;">60%</span>
                  </foreignObject>
                  <foreignObject style="overflow: visible;display:flex;justify-content: flex-end;" y="83" x="10"
                    height="25" width="40"><span class="ct-label ct-vertical ct-start"
                      xmlns="http://www.w3.org/2000/xmlns/"
                      style="height: 25px; width: 40px;padding-right: 2px;text-align: right;">70%</span>
                  </foreignObject>
                  <foreignObject
                    style="overflow: visible;display:flex;justify-content: flex-end;display:flex;justify-content: flex-end;"
                    y="58" x="10" height="25" width="40"><span class="ct-label ct-vertical ct-start"
                      xmlns="http://www.w3.org/2000/xmlns/"
                      style="height: 25px; width: 40px;padding-right: 2px;text-align: right;">80%</span>
                  </foreignObject>
                  <foreignObject style="overflow: visible;display:flex;justify-content: flex-end;" y="33" x="10"
                    height="25" width="40"><span class="ct-label ct-vertical ct-start"
                      xmlns="http://www.w3.org/2000/xmlns/"
                      style="height: 25px; width: 40px;padding-right: 2px;text-align: right;">90%</span>
                  </foreignObject>
                  <foreignObject style="overflow: visible;display:flex;justify-content: flex-end;" y="8" x="10"
                    height="25" width="40"><span class="ct-label ct-vertical ct-start"
                      xmlns="http://www.w3.org/2000/xmlns/"
                      style="height: 25px; width: 40px;padding-right: 2px;text-align: right;">100%</span>
                  </foreignObject>
                </g>
              </svg>
            </div>
          </div>

        </div>

      </div>
      <div class="col-xl-3 ml-auto pr-0 ">
        <div class="row">
          <div class="col-xl-12 col-4">
            <div class="card-box green-gradient mx-md-2 performance-box">
              <h4 class="header-title mt-0 mb-2 text-center text-white">Total Attempted Tests&nbsp;</h4>
              <div class="widget-detail-1 text-center">
                <h2 class="font-weight-normal m-0 text-white"> {{$total_attempted}} </h2>
              </div>
            </div>
          </div>
          @php
          // dd($total_unattempted);
          @endphp
          <div class="col-xl-12 col-4">
            <div class="card-box blue-gradient mx-md-2 performance-box">
              <h4 class="header-title mt-0 mb-2 text-center text-white">Total Unattempted Tests&nbsp;</h4>
              <div class="widget-detail-1 text-center">
                <h2 class="font-weight-normal m-0 text-white"> {{$total_unattempted}} </h2>
              </div>
            </div>
          </div>
          <div class="col-xl-12 col-4">
            <div class="card-box sea-gradient mx-md-2 performance-box">
              <h4 class="header-title mt-0 mb-2 text-center text-white">Marks in Last Test</h4>
              <div class="widget-detail-1 text-center">
                @if($total_marks??0)
                <h2 class="font-weight-normal m-0 text-white">{{$correct.'/'.$total_marks}}</h2>
                @else
                <span class="text-white">No Tests Attempted</span>;
                @endif
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div><!-- end col -->
</div>
<div class="row card-box mx-auto your_attendance">
  <div class="col-xl-12 col-md-12">
    <h4 class=" mt-0 mb-3 text-center fw-100">My Attendance</h4>
    <div class="row m-0 ">
      <div class="col-xl-8">
        <!-- <div id="calendar" class="fc fc-unthemed fc-ltr"><div class="fc-toolbar"><div class="fc-left"><div class="fc-button-group"><button type="button" class="fc-prev-button fc-button fc-state-default fc-corner-left"><span class="fc-icon fc-icon-left-single-arrow"></span></button><button type="button" class="fc-next-button fc-button fc-state-default fc-corner-right"><span class="fc-icon fc-icon-right-single-arrow"></span></button></div><button type="button" class="fc-today-button fc-button fc-state-default fc-corner-left fc-corner-right fc-state-disabled" disabled="">today</button></div><div class="fc-right"><div class="fc-button-group"><button type="button" class="fc-month-button fc-button fc-state-default fc-corner-left fc-state-active">month</button><button type="button" class="fc-basicWeek-button fc-button fc-state-default">week</button><button type="button" class="fc-basicDay-button fc-button fc-state-default fc-corner-right">day</button></div></div><div class="fc-center"><h2>June 2020</h2></div><div class="fc-clear"></div></div><div class="fc-view-container" style=""><div class="fc-view fc-month-view fc-basic-view" style=""><table><thead class="fc-head"><tr><td class="fc-head-container fc-widget-header"><div class="fc-row fc-widget-header"><table><thead><tr><th class="fc-day-header fc-widget-header fc-sun">Sun</th><th class="fc-day-header fc-widget-header fc-mon">Mon</th><th class="fc-day-header fc-widget-header fc-tue">Tue</th><th class="fc-day-header fc-widget-header fc-wed">Wed</th><th class="fc-day-header fc-widget-header fc-thu">Thu</th><th class="fc-day-header fc-widget-header fc-fri">Fri</th><th class="fc-day-header fc-widget-header fc-sat">Sat</th></tr></thead></table></div></td></tr></thead><tbody class="fc-body"><tr><td class="fc-widget-content"><div class="fc-scroller fc-day-grid-container" style="overflow: hidden; height: auto;"><div class="fc-day-grid fc-unselectable"><div class="fc-row fc-week fc-widget-content fc-rigid" style="    height: 76px;"><div class="fc-bg"><table><tbody><tr><td class="fc-day fc-widget-content fc-sun fc-other-month fc-past" data-date="2020-05-31"></td><td class="fc-day fc-widget-content fc-mon fc-past" data-date="2020-06-01"></td><td class="fc-day fc-widget-content fc-tue fc-past" data-date="2020-06-02"></td><td class="fc-day fc-widget-content fc-wed fc-past" data-date="2020-06-03"></td><td class="fc-day fc-widget-content fc-thu fc-past" data-date="2020-06-04"></td><td class="fc-day fc-widget-content fc-fri fc-past" data-date="2020-06-05"></td><td class="fc-day fc-widget-content fc-sat fc-past" data-date="2020-06-06"></td></tr></tbody></table></div><div class="fc-content-skeleton"><table><thead><tr><td class="fc-day-number fc-sun fc-other-month fc-past" data-date="2020-05-31">31</td><td class="fc-day-number fc-mon fc-past" data-date="2020-06-01">1</td><td class="fc-day-number fc-tue fc-past" data-date="2020-06-02">2</td><td class="fc-day-number fc-wed fc-past" data-date="2020-06-03">3</td><td class="fc-day-number fc-thu fc-past" data-date="2020-06-04">4</td><td class="fc-day-number fc-fri fc-past" data-date="2020-06-05">5</td><td class="fc-day-number fc-sat fc-past" data-date="2020-06-06">6</td></tr></thead><tbody><tr><td></td><td class="fc-event-container"><a class="fc-day-grid-event fc-h-event fc-event fc-start fc-end fc-draggable"><div class="fc-content"><span class="fc-time">12a</span> <span class="fc-title">All Day Event</span></div></a></td><td></td><td></td><td></td><td></td><td></td></tr></tbody></table></div></div><div class="fc-row fc-week fc-widget-content fc-rigid" style="    height: 76px;"><div class="fc-bg"><table><tbody><tr><td class="fc-day fc-widget-content fc-sun fc-past" data-date="2020-06-14"></td><td class="fc-day fc-widget-content fc-mon fc-past" data-date="2020-06-15"></td><td class="fc-day fc-widget-content fc-tue fc-past" data-date="2020-06-16"></td><td class="fc-day fc-widget-content fc-wed fc-past" data-date="2020-06-17"></td><td class="fc-day fc-widget-content fc-thu fc-past" data-date="2020-06-18"></td><td class="fc-day fc-widget-content fc-fri fc-past" data-date="2020-06-19"></td><td class="fc-day fc-widget-content fc-sat fc-past" data-date="2020-06-20"></td></tr></tbody></table></div><div class="fc-content-skeleton"><table><thead><tr><td class="fc-day-number fc-sun fc-past" data-date="2020-06-14">7</td><td class="fc-day-number fc-mon fc-past" data-date="2020-06-15">8</td><td class="fc-day-number fc-tue fc-past" data-date="2020-06-16">9</td><td class="fc-day-number fc-wed fc-past" data-date="2020-06-17">10</td><td class="fc-day-number fc-thu fc-past" data-date="2020-06-18">11</td><td class="fc-day-number fc-fri fc-past" data-date="2020-06-19">12</td><td class="fc-day-number fc-sat fc-past" data-date="2020-06-20">13</td></tr></thead><tbody><tr><td></td><td></td><td></td><td></td><td></td><td class="fc-event-container"><a class="fc-day-grid-event fc-h-event fc-event fc-start fc-not-end fc-draggable"><div class="fc-content"><span class="fc-time">3a</span> <span class="fc-title"></span></div></a></td></tr></tbody></table></div></div><div class="fc-row fc-week fc-widget-content fc-rigid" style="    height: 76px;"><div class="fc-bg"><table><tbody><tr><td class="fc-day fc-widget-content fc-sun fc-past" data-date="2020-06-14"></td><td class="fc-day fc-widget-content fc-mon fc-past" data-date="2020-06-15"></td><td class="fc-day fc-widget-content fc-tue fc-past" data-date="2020-06-16"></td><td class="fc-day fc-widget-content fc-wed fc-past" data-date="2020-06-17"></td><td class="fc-day fc-widget-content fc-thu fc-past" data-date="2020-06-18"></td><td class="fc-day fc-widget-content fc-fri fc-past" data-date="2020-06-19"></td><td class="fc-day fc-widget-content fc-sat fc-past" data-date="2020-06-20"></td></tr></tbody></table></div><div class="fc-content-skeleton"><table><thead><tr><td class="fc-day-number fc-sun fc-past" data-date="2020-06-14">14</td><td class="fc-day-number fc-mon fc-past" data-date="2020-06-15">15</td><td class="fc-day-number fc-tue fc-past" data-date="2020-06-16">16</td><td class="fc-day-number fc-wed fc-past" data-date="2020-06-17">17</td><td class="fc-day-number fc-thu fc-past" data-date="2020-06-18">18</td><td class="fc-day-number fc-fri fc-past" data-date="2020-06-19">19</td><td class="fc-day-number fc-sat fc-past" data-date="2020-06-20">20</td></tr></thead><tbody><tr><td></td><td></td><td></td><td></td><td></td><td class="fc-event-container" colspan="2"><a class="fc-day-grid-event fc-h-event fc-event fc-start fc-not-end fc-draggable"><div class="fc-content"><span class="fc-time">12a</span> <span class="fc-title"></span></div></a></td></tr></tbody></table></div></div><div class="fc-row fc-week fc-widget-content fc-rigid" style="    height: 76px;"><div class="fc-bg"><table><tbody><tr><td class="fc-day fc-widget-content fc-sun fc-past" data-date="2020-06-21"></td><td class="fc-day fc-widget-content fc-mon fc-past" data-date="2020-06-22"></td><td class="fc-day fc-widget-content fc-tue fc-past" data-date="2020-06-23"></td><td class="fc-day fc-widget-content fc-wed fc-today fc-state-highlight" data-date="2020-06-24"></td><td class="fc-day fc-widget-content fc-thu fc-future" data-date="2020-06-25"></td><td class="fc-day fc-widget-content fc-fri fc-future" data-date="2020-06-26"></td><td class="fc-day fc-widget-content fc-sat fc-future" data-date="2020-06-27"></td></tr></tbody></table></div><div class="fc-content-skeleton"><table><thead><tr><td class="fc-day-number fc-sun fc-past" data-date="2020-06-21">21</td><td class="fc-day-number fc-mon fc-past" data-date="2020-06-22">22</td><td class="fc-day-number fc-tue fc-past" data-date="2020-06-23">23</td><td class="fc-day-number fc-wed fc-today fc-state-highlight" data-date="2020-06-24">24</td><td class="fc-day-number fc-thu fc-future" data-date="2020-06-25">25</td><td class="fc-day-number fc-fri fc-future" data-date="2020-06-26">26</td><td class="fc-day-number fc-sat fc-future" data-date="2020-06-27">27</td></tr></thead><tbody><tr><td class="fc-event-container"><a class="fc-day-grid-event fc-h-event fc-event fc-not-start fc-end fc-draggable"><div class="fc-content"> <span class="fc-title"></span></div></a></td><td rowspan="2"></td><td rowspan="2"></td><td class="fc-event-container"><a class="fc-day-grid-event fc-h-event fc-event fc-start fc-end fc-draggable"><div class="fc-content"><span class="fc-time">10:30a</span> <span class="fc-title">Meeting</span></div></a></td><td class="fc-event-container" rowspan="2"><a class="fc-day-grid-event fc-h-event fc-event fc-start fc-end fc-draggable"><div class="fc-content"><span class="fc-time">7p</span> <span class="fc-title"></span></div></a></td><td rowspan="2"></td><td rowspan="2"></td></tr><tr><td class="fc-event-container"><a class="fc-day-grid-event fc-h-event fc-event fc-start fc-end fc-draggable"><div class="fc-content"><span class="fc-time">4p</span> <span class="fc-title"></span></div></a></td><td class="fc-event-container"><a class="fc-day-grid-event fc-h-event fc-event fc-start fc-end fc-draggable"><div class="fc-content"><span class="fc-time">12p</span> <span class="fc-title"></span></div></a></td></tr></tbody></table></div></div><div class="fc-row fc-week fc-widget-content fc-rigid" style="    height: 76px;"><div class="fc-bg"><table><tbody><tr><td class="fc-day fc-widget-content fc-sun fc-future" data-date="2020-06-28"></td><td class="fc-day fc-widget-content fc-mon fc-future" data-date="2020-06-29"></td><td class="fc-day fc-widget-content fc-tue fc-future" data-date="2020-06-30"></td><td class="fc-day fc-widget-content fc-wed fc-other-month fc-future" data-date="2020-07-01"></td><td class="fc-day fc-widget-content fc-thu fc-other-month fc-future" data-date="2020-07-02"></td><td class="fc-day fc-widget-content fc-fri fc-other-month fc-future" data-date="2020-07-03"></td><td class="fc-day fc-widget-content fc-sat fc-other-month fc-future" data-date="2020-07-04"></td></tr></tbody></table></div><div class="fc-content-skeleton"><table><thead><tr><td class="fc-day-number fc-sun fc-future" data-date="2020-06-28">28</td><td class="fc-day-number fc-mon fc-future" data-date="2020-06-29">29</td><td class="fc-day-number fc-tue fc-future" data-date="2020-06-30">30</td><td class="fc-day-number fc-wed fc-other-month fc-future" data-date="2020-07-01">1</td><td class="fc-day-number fc-thu fc-other-month fc-future" data-date="2020-07-02">2</td><td class="fc-day-number fc-fri fc-other-month fc-future" data-date="2020-07-03">3</td><td class="fc-day-number fc-sat fc-other-month fc-future" data-date="2020-07-04">4</td></tr></thead><tbody><tr><td class="fc-event-container"><a class="fc-day-grid-event fc-h-event fc-event fc-start fc-end fc-draggable" href="http://google.com/"><div class="fc-content"><span class="fc-time"></span> </div></a></td><td rowspan="2"></td><td rowspan="2"></td><td rowspan="2"></td><td rowspan="2"></td><td rowspan="2"></td><td rowspan="2"></td></tr><tr><td class="fc-event-container"><a class="fc-day-grid-event fc-h-event fc-event fc-start fc-end fc-draggable"><div class="fc-content"><span class="fc-time">4p</span> <span class="fc-title"></span></div></a></td></tr></tbody></table></div></div><div class="fc-row fc-week fc-widget-content fc-rigid" style="    height: 76px;"><div class="fc-bg"><table><tbody><tr><td class="fc-day fc-widget-content fc-sun fc-other-month fc-future" data-date="2020-07-05"></td><td class="fc-day fc-widget-content fc-mon fc-other-month fc-future" data-date="2020-07-06"></td><td class="fc-day fc-widget-content fc-tue fc-other-month fc-future" data-date="2020-07-07"></td><td class="fc-day fc-widget-content fc-wed fc-other-month fc-future" data-date="2020-07-08"></td><td class="fc-day fc-widget-content fc-thu fc-other-month fc-future" data-date="2020-07-09"></td><td class="fc-day fc-widget-content fc-fri fc-other-month fc-future" data-date="2020-07-10"></td><td class="fc-day fc-widget-content fc-sat fc-other-month fc-future" data-date="2020-07-11"></td></tr></tbody></table></div><div class="fc-content-skeleton"><table><thead><tr><td class="fc-day-number fc-sun fc-other-month fc-future" data-date="2020-07-05">5</td><td class="fc-day-number fc-mon fc-other-month fc-future" data-date="2020-07-06">6</td><td class="fc-day-number fc-tue fc-other-month fc-future" data-date="2020-07-07">7</td><td class="fc-day-number fc-wed fc-other-month fc-future" data-date="2020-07-08">8</td><td class="fc-day-number fc-thu fc-other-month fc-future" data-date="2020-07-09">9</td><td class="fc-day-number fc-fri fc-other-month fc-future" data-date="2020-07-10">10</td><td class="fc-day-number fc-sat fc-other-month fc-future" data-date="2020-07-11">11</td></tr></thead><tbody><tr><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr></tbody></table></div></div></div></div></td></tr></tbody></table></div></div></div> -->
        <div class="calendar float_none">
          {{-- <header>
              <h2>April</h2>
              <a class="btn-prev " href="#"> <i class="ti-angle-left"></i></a>
              <a class="btn-next" href="#"><i class="ti-angle-right"></i></a>
            </header> --}}

          {{-- <table class="w-100">
              <thead>
                <tr>
                  <th>Mo</th>
                  <th>Tu</th>
                  <th>We</th>
                  <th>Th</th>
                  <th>Fr</th>
                  <th>Sa</thtd>
                  <th>Su</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td class="prev-month">29</td>
                  <td class="prev-month">30</td>
                  <td class="prev-month">31</td>
                  <td>1 <div class="fc-content present"><span class="fc-attendance">4P</span> </div>
                  </td>
                  <td>2</td>
                  <td>3</td>
                  <td>4</td>
                </tr>
                <tr>
                  <td>5 <div class="fc-content present"><span class="fc-attendance">9P</span> </div>
                  </td>
                  <td>6</td>
                  <td>7 <div class="fc-content absent"><span class="fc-attendance">4A</span> </div>
                  </td>
                  <td>8</td>
                  <td class="event">9</td>
                  <td class="current-day event">10</td>
                  <td>11</td>
                </tr>
                <tr>
                  <td>12</td>
                  <td>13<div class="fc-content absent"><span class="fc-attendance">12A</span> </div>
                  </td>
                  <td>14</td>
                  <td>15<div class="fc-content absent"><span class="fc-attendance">7A</span> </div>
                  </td>
                  <td>16</td>
                  <td>17</td>
                  <td>18</td>
                </tr>
                <tr>
                  <td>19</td>
                  <td>20</td>
                  <td>21</td>
                  <td class="event">22</td>
                  <td>23</td>
                  <td>24</td>
                  <td>25</td>
                </tr>
                <tr>
                  <td>26</td>
                  <td>27</td>
                  <td>28</td>
                  <td>29</td>
                  <td>30</td>
                  <td class="next-month">1</td>
                  <td class="next-month">2</td>
                </tr>
              </tbody>
            </table> --}}
          <div id="datepicker"></div>
        </div> <!-- end calendar -->
      </div> <!-- end col -->
      <div class="col-xl-3 ml-auto pr-0">
        @php
        $date_ = date('Y-m-d',strtotime($iac->start_date));
        $lectures = \App\Models\Lecture::where('institute_assigned_class_subject_id',
        request()->iacs_id)->where('lecture_date','>=',$date_.' 00:00:00')->get();
        if($lectures->count() > 0){
        $total_past_lectures = $lectures->count();
        $attended_lectures = \App\Models\StudentLecture::whereIn('lecture_id',
        $lectures->pluck('id')->toArray())->where('student_id',
        auth()->user()->student_id)->where('attendence_in_percentage',
        '>=', '90')->get();
        $absent_lectures = $lectures->whereNotIn('id',
        $attended_lectures->load('lecture')->pluck('lecture.id')->toArray());
        $total_attended_lectures = $attended_lectures->count();
        $total_absents_in_lectures = $total_past_lectures - $total_attended_lectures;
        $percentage = ($total_attended_lectures / $total_past_lectures) * 100;
        }else{
        $total_past_lectures = 0;
        $attended_lectures = 0;
        $total_attended_lectures = 0;
        $total_absents_in_lectures = 0;
        $percentage = 0;
        }
        @endphp
        <div class="row">
          <div class="col-xl-12 col-4">
            <div class="card-box orange-gradient mw-220">
              <h4 class="header-title mt-0 mb-2 text-center text-white">Total classes&nbsp;</h4>
              <div class="widget-detail-1 text-center">
                <h2 class="font-weight-normal m-0 text-white"> {{$total_past_lectures}} </h2>
              </div>
            </div>
          </div>
          <div class="col-xl-12 col-4">
            <div class="card-box pink-gradient mw-220">
              <h4 class="header-title mt-0 mb-2 text-center text-white">Total Present</h4>
              <div class="widget-detail-1 text-center">
                <h2 class="font-weight-normal m-0 text-white"> {{$total_attended_lectures}} </h2>
              </div>
            </div>
          </div>
          <div class="col-xl-12 col-4">
            <div class="card-box purple-gradient mw-220">
              <h4 class="header-title mt-0 mb-2 text-center text-white">Total Absent</h4>
              <div class="widget-detail-1 text-center">
                <h2 class="font-weight-normal m-0 text-white">{{$total_absents_in_lectures}}</h2>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div><!-- end col -->
</div>

@if(!empty($mode->end_date))
@if($mode->end_date >= date('Y-m-d'))
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
  $(document).ready(function(){
    var date_end  = '{{ $today_date_show }}';
     var cookieSet = Cookies.get('date');
       if(!cookieSet) {
        Cookies.set('date', date_end, {expires : 1});
        if(date_end == 0){
                swal({
                title: "Note",
                text: "Your trial will expired Today!",
                icon: "warning",
                });

        }else{
            swal({
                title: "Note",
                text: "Your trial will expired in " + '  ' + date_end + ' ' + "days!",
                icon: "warning",
                });
        }
    }
});
</script>
@endif
@endif



</div>

@endsection
@section('js')
<script src="{{URL::to('assets/student/libs/custombox/custombox.min.js')}}"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="{{URL::to('assets/student/js/app.min.js')}}"></script>
<!-- fancybox -->
<script src="/assets/admin/js/jquery.fancybox.js"></script>

<script>
  var minDateGlobal = new Date('{{$iac->start_date}}');

  @php
  $attended_lectures_dates = '';
    if(!empty($attended_lectures)){
      foreach($attended_lectures->load('lecture')->pluck('lecture.lecture_date') as $attended_lecture_date){
        $attended_lectures_dates .= "'".date('m/d/Y', strtotime($attended_lecture_date))."',";
      }
      $attended_lectures_dates = trim($attended_lectures_dates, ',');
    } else{
      $attended_lectures_dates = '';
    }

    $absent_lectures_dates = '';
    if(!empty($absent_lectures)){
    foreach($absent_lectures->pluck('lecture_date') as $absent_lecture_date){
      if (date('m/d/Y', strtotime($absent_lecture_date)) != date('m/d/Y')) {
        $absent_lectures_dates .= "'".date('m/d/Y', strtotime($absent_lecture_date))."',";
      }
    }
    $absent_lectures_dates = trim($absent_lectures_dates, ',');
    } else{
    $absent_lectures_dates = '';
    }
    $not_available = [];

    if(!empty($lecture_dates)){
      foreach($lecture_dates as $date){
        if(!in_array($date, array_merge(explode(',', str_replace("'", '', $attended_lectures_dates))
        , explode(',', str_replace("'", '', $absent_lectures_dates)))) && $date != date('m/d/Y'))
        $not_available[] = $date;
      }
    }
  @endphp

  var attendedLectureDates = [{!!$attended_lectures_dates!!}];
  var absentLectureDates = [{!!$absent_lectures_dates!!}];
  var notAvailable = [{!!"'".implode("','", $not_available)."'"!!}];
</script> 
<script src="{{ asset('js/datepicker.js') }}"></script>
<script src="{{ asset('js/datepicker.en.js') }}"></script>
<script>
  /*    $.ajax({
          url: "{{url('student/markasreadAssignment')}}",
          type: 'post',
          dataType: 'json',
          data: {
            i_a_c_s:request()->iacs_id,
            type: 'assignment',
            _token: "{{csrf_token()}}"
          },
          success:function(response){
            console.log('read assignment')
          }
        }) */



  function getnotifies(){
        var id = "{{request()->iacs_id}}";
        $.ajax({
          url: "{{url('student/getnotification')}}",
          type: 'post',
          dataType: 'json',
          data: {
            iacs_id: id,
            _token: "{{csrf_token()}}"
          },
          success:function(response){
            $('.totalNotify').html('('+response.count+')');
            $('.assignmentnotifications').html('('+response.assignmentnotifications+')');
            $('.testsnotification').html('('+response.testsnotification+')');
            $('.dnotifications').html('('+response.dnotifications+')');
            $('.extranotifications').html('('+response.extranotifications+')');
          }
        })
    }


  $(document).ready(function(){


    $('.getnotification').click(function(){
      var id = "{{request()->iacs_id}}";
        $.ajax({
          url: "{{url('student/getnotification')}}",
          type: 'post',
          dataType: 'json',
          data: {
            iacs_id: id,
            _token: "{{csrf_token()}}"
          },
          success:function(response){
            $('.notifications_all').html(response.view);
          }
        })
    });

     setInterval(getnotifies,5000);



    $('.changeClassTime').click(function(){
      var classS = $(this).data('cl');
      var student = $(this).data('student');
      var time = $(this).data('time');
      var classNN = classS;
      $(".old_time option[value="+time+"]").prop('selected', true);
      $('.old_time').after('<input type="hidden" value='+classNN+' name="student_subjects_info_id">');
      $('.old_time').after('<input type="hidden" value='+student+' name="student_id">');

    });




    let playingInterval;
    $('#play-video').fancybox({
      afterLoad : function(instance, current){
        playingInterval = setInterval(() => {
          console.log('video is playing');
          $.ajax({
            url: "{{route('student.mark_an_attendence')}}",
            type: 'post',
            dataType: 'json',
            data: {
              id: $('#play-video').data('id'),
              iacs_id: {{request()->iacs_id}},
              _token: "{{csrf_token()}}"
            },
            success:function(response){
              console.log(response);
              if(response.lecture_status == 'completed'){
                clearInterval(playingInterval);
              }
            }
          })
        // }, ((45/10)*60)*1000); //45mins
        }, ((20/10)*60)*1000); //playback required - 20 mins and slots - 2 minutes
        // }, ((2/10)*60)*1000); //playback required - 20 mins and slots - 2 minutes
      },
      afterClose: function(){
        clearInterval(playingInterval);
      }
    })
    // $('#play-video').click(function(){
    //   console.log('Video is playing');
    // })
    // $('.fancybox-toolbar').click(function(){
    //   console.log('Video is stopped');
    // })
  })
</script>
<script>
  $( function() {
    $( "#datepicker" ).datepicker();
  } );
  function showAlert(){
    alert('syllabus is not yet uploaed');
  }
</script>
@endsection