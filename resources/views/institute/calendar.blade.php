<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link href="{{url('/assets/admin/css/jquery.fancybox.css')}}" rel="stylesheet" type="text/css" />
<link href="{{url('/css/datepicker.css')}}" rel="stylesheet" type="text/css" /> 
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
    .on-hove:hover{ 
        color: #000!important; 
    }
    .on-hove {
      color: #167fd2;
  }
  .datepicker-inline {
    width: 100%;
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
.bgth {
    color: white;
    padding: 6px;
    border-radius: 6px;
}
.fc-content.present {
    background: #644699;
}
.fc-content.absent {
    background: #c95050;
}
.fc-content.not-available {
    background: linear-gradient(to right, #f98b2c, #fbc03a);
}
  </style>
 
 
 <div class="row card-box mx-auto openerr" style='display:none;'>
    <div class="col-xl-12 col-md-12">
      <h4 class=" mt-0 mb-3 text-center fw-100">No data found</h4>
    </div>
</div>
<div class="row card-box mx-auto your_attendance">
    <div class="col-xl-12 col-md-12">
      <h4 class=" mt-0 mb-3 text-center fw-100">Student Attendance</h4>
        <div class="row m-0 ">
            <div class="col-12">
            <div class="calendar float_none"> 
              @php    
              $iacs = DB::table('institute_assigned_class_subject')->where('id',$iacs_data)->first(); 
              if(!empty($iacs)){ 
                $iac = \App\Models\InstituteAssignedClass::where('id',$iacs_data)->first(); 
                $date_ = date('Y-m-d',strtotime($iac->start_date));  
                $lectures = \App\Models\Lecture::where('institute_assigned_class_subject_id',
                $subject_id)->where('lecture_date','>=',$date_.' 00:00:00')->get();    
                /* $lectures = \App\Models\Lecture::where('institute_assigned_class_subject_id',
                $subject_id)->get();    */ 
                if($lectures->count() > 0){
                    $total_past_lectures = $lectures->count();
                    $attended_lectures = \App\Models\StudentLecture::whereIn('lecture_id',
                    $lectures->pluck('id')->toArray())->where('student_id',
                    $student)->where('attendence_in_percentage',
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
                $period = new DatePeriod(
                  new DateTime($iac->start_date->format('Y-m-d')),
                  new DateInterval('P1D'),
                  new DateTime($iac->end_date->modify('+1 day')->format('Y-m-d'))
                );
                $lecture_dates = [];
                foreach ($period as $key => $value) {
                    if(!empty($iacs->subjects_infos)){
                      foreach($iacs->subjects_infos->pluck('day')->toArray() as $key1 => $day){
                        if($day === strtolower($value->format('l'))){
                        $lecture_dates[] = $value->format('m/d/Y');
                        }
                      }
                    }
                  }
                }else{
                    $total_past_lectures = 0;
                    $attended_lectures = 0;
                    $total_attended_lectures = 0;
                    $total_absents_in_lectures = 0;
                    $percentage = 0;
                } 
                 
                if($percentage <= 60){
                  $color = '#b61414bd';
                  $textcolor = 'white';
                }elseif($percentage > 60 && $percentage <= 80){
                  $color = '#ffe113';
                  $textcolor = 'black';
                }elseif($percentage > 80){
                  $color ='#14b619bd';
                  $textcolor ='white';
                } 
            @endphp
            
                  <div class='text-center bgth' style='background:{{$color}};color:{{$textcolor}}'>
                    Total Lectures : {{$total_past_lectures}}
                    Total Present : {{$total_attended_lectures}}
                    Total Absent : {{$total_absents_in_lectures}}
                    Percentage : {{round($percentage,2)}} %
                  </div>
                <div id="datepicker"></div>
                </div> 
            </div>
        </div>
    </div>
</div>
    
<!-- fancybox --> 
 <script>
    var minDateGlobal = new Date('{{!empty($iac->start_date) ? $iac->start_date : ''}}'); 
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
  $(document).ready(function() {
    setTimeout(() => { 
    $( "#datepicker" ).datepicker();
    }, 1000);
  });
  function showAlert(){
    alert('syllabus is not yet uploaded');
  }
</script> 
 