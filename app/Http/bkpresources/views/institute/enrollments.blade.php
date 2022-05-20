@extends('institute.layouts.app') 
  
@push('css') 
@endpush
<style>
.mybtns {
    margin-top: -10px !important;
}
.overflow_y {
    height: 500px;
    overflow-y: scroll;
}
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
.purple{
  background:#644699;
}
.red{
  background:#b61414bd;
}
.yellow{
  background:#ffe113;
}
.green{
  background:#14b619bd;
}
.foo { 
  width: 15px;
  height: 15px;
  margin: 3px;
  border: 1px solid rgba(0, 0, 0, .2);
}
</style>
@section('content')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<div class="content">
  <div>{{ Breadcrumbs::render('enrollments')}}</div>
  <div class="container">
    <div class="page-header-title">
      <h4 class="page-title">Total Enrollments</h4> 
    </div>
    <div class="page-header-title d-flex">
      <p><strong>Attendance Indicators : </strong></p>&nbsp;&nbsp; 
      <p>Red &nbsp;<div class="foo red"></div> : 0 - 60%</p>&nbsp;,&nbsp; 
      <p>Yellow &nbsp;<div class="foo yellow"></div> : 61 - 80%</p>&nbsp;,&nbsp; 
      <p>Green &nbsp;<div class="foo green"></div> : 81 - 100%</p>{{-- &nbsp;,&nbsp;
      <p>Purpe &nbsp;<div class="foo purple"></div> : No Lecture Found</p> --}}
    </div>
  </div>

  <div class="page-content-wrapper ">
    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-12 overflow_y">
           
          <div class="card">
            <div class="card-body">
              @if (session()->has('message'))
              <div class="alert alert-success">{{session()->get('message')}}</div>
              @endif
              {{-- <ul class="list-inline menu-left mb-0 d-md-flex justify-content-start manage-search">
                <li class="app-search float-left mr-md-3 mb-2 mb-md-0">
                  <form role="search" class="manage_search position-relative">
                    <input type="text" placeholder="Search by name" class="form-control search-bar">
                    <a href=""><i class="fa fa-search"></i></a>
                  </form>
                </li>
                <li class=" app-search float-left mr-md-3 mb-2 mb-md-0">
                  <form role="search" class="manage_search  position-relative">
                    <input type="text" placeholder="Search by phone number" class="form-control search-bar">
                    <a href=""><i class="fa fa-search"></i></a>
                  </form>
                </li>
              </ul> --}}
              <div class="table-responsive">
                <table class="table table-bordered mb-0 package-table" id="dataTables">
                  <thead>
                    <tr>
                      <th>
                        <h4 class="header-title m-0 heading">Sr. No.</h4>
                      </th>
                      <th>
                        <h4 class="header-title m-0 heading">Student Name</h4>
                        <!-- <span class="text-muted">Phone Number</span> -->
                      </th>
                      <th>
                        <h4 class="header-title m-0 heading">Date of Admission</h4>
                        <!-- <span class="text-muted">Phone Number</span> -->
                      </th>
                      <th>
                        <h4 class="header-title m-0 heading">Fee Paid</h4> 
                      </th>
                      <th>
                        <h4 class="header-title m-0 heading">Phone Number</h4>
                      </th>
                      <th>
                        <h4 class="header-title m-0 heading">Attendance</h4>
                      </th>
                      <th>
                        <h4 class="header-title m-0 heading">Receipt</h4>
                      </th>
                     <!--  <th>
                        <h4 class="header-title m-0 heading">Action</h4>
                      </th> -->
                    </tr>
                  </thead>
                  <tbody>  
                    @if (!empty($students) && count($students[0]) >  0)
                    @foreach ($students as $key => $student)
                    @foreach ($student as $key => $single_student)
                    @php      
                 
                      $studentid = $single_student->student_id; 
                      $st = \App\Models\Student::with('lectures')->where('id',$studentid)->first(); 
                      
                    
                   /*  if( $st->institute->institute_assigned_classes->count() > 0 ) {
                      foreach (auth()->user()->institute->institute_assigned_classes as $institute_assigned_class) {
                          if($institute_assigned_class->institute_assigned_class_subject->count() > 0 ){
                            foreach( $institute_assigned_class->institute_assigned_class_subject as $subject ){ 
                              $subjectname = DB::table('subjects')->where('id',$subject->subject_id)->first();
                                echo  "<option value='".$subject->subject_id."'>".$subjectname->name."</option>";
                            }
                          }
                      }   
                    } */ 
                    @endphp
                    <tr>
                      <th>{{$key+1}}</th> 
                      <td>
                        <div class="media"> 
                          <div class="media-body">
                            <h5 class="m-0">{{$st->name ? $st->name : ''}}</h5> 
                          </div>
                        </div>
                      </td>
                      <td>
                        <h5>
                           {{$single_student->created_at ? date('d F Y D h:i a',(strtotime($single_student->created_at))) : ''}}
                        </h5>
                      </td>
                      <td>
                        @php
                             $istried = \App\Models\StudentTrialPeriod::where('student_id',$single_student->student_id)->where('class_id',$single_student->institute_assigned_class_id)->first(); 

                        @endphp
                       @if($single_student->razorpay_payment_id == "manual_enrollment")
                       <h5 class="m-0">Scholarship</h5>
                       @else
                        @if($single_student->price == 0)
                        <h5 class="m-0">Free Trial</h5>
                        @else
                          <h5 class="m-0">{{!empty($single_student->price) ? $single_student->price : '0'}} <i class="fa fa-inr" aria-hidden="true"></i></h5> 
                        @endif
                        @endif
                      </td>
                      <td>
                        <h5 class="m-0">{{$st->phone ? $st->phone : ''}}</h5>
                      </td>
                      <td>
                        @php
                            if( auth()->user()->institute->institute_assigned_classes->count() > 0 ){ 
                              foreach (auth()->user()->institute->institute_assigned_classes as $institute_assigned_class){
                                if($institute_assigned_class->institute_assigned_class_subject->count() > 0 )   { 
                                  if($institute_assigned_class->id == Request::segment(4) )   {
                                    $options = [];
                                    $showPercent = false;     
                                    foreach( $institute_assigned_class->institute_assigned_class_subject as $subject ){
                                      
                                            $iacs = \App\Models\instituteAssignedClassSubject::where('id',Request::segment(4))->first(); 
                                            if(!empty($iacs)){ 
                                              $iac = \App\Models\InstituteAssignedClass::where('id',Request::segment(4))->first();  
                                              $date_ = !empty($iac->start_date) ? date('Y-m-d',strtotime($iac->start_date)) : '';  
                                              $lectures = \App\Models\Lecture::where('institute_assigned_class_subject_id',
                                              $subject->id)->where('lecture_date','>=',$date_.' 00:00:00')->get();
                                             /*  $lectures = \App\Models\Lecture::where('institute_assigned_class_subject_id',
                                              $subject->id)->get(); */
                                              if($lectures->count() > 0){
                                                  $showPercent = true;
                                                  $total_past_lectures = $lectures->count();
                                                  $attended_lectures = \App\Models\StudentLecture::whereIn('lecture_id',
                                                  $lectures->pluck('id')->toArray())->where('student_id',
                                                  $studentid)->where('attendence_in_percentage',
                                                  '>=', '90')->get();
                                                  $absent_lectures = $lectures->whereNotIn('id',
                                                  $attended_lectures->load('lecture')->pluck('lecture.id')->toArray());
                                                  $total_attended_lectures = $attended_lectures->count();
                                                  $total_absents_in_lectures = $total_past_lectures - $total_attended_lectures;
                                                  $percentage = ($total_attended_lectures / $total_past_lectures) * 100;
                                              }elseif($lectures->count() == 0){
                                                $showPercent = false;
                                                $total_past_lectures = 0;
                                                $attended_lectures = 0;
                                                $total_attended_lectures = 0;
                                                $total_absents_in_lectures = 0;
                                                $percentage = 0;
                                              }else{
                                                //$showPercent = true;
                                                $total_past_lectures = 0;
                                                $attended_lectures = 0;
                                                $total_attended_lectures = 0;
                                                $total_absents_in_lectures = 0;
                                                $percentage = 0;
                                              }  
                                            } 
                                            $newpercent = !empty($percentage) ? round($percentage,2) : 0;
                                            if($newpercent > 0){
                                              $options[] = $newpercent; 
                                            }
                                          }  
                                          if($showPercent == true && count($options)>0){
                                            $percentageNew = min($options); 
                                            if($percentageNew <= 60){
                                              $color = '#b61414bd';
                                              $textcolor = 'white';
                                            }elseif($percentageNew > 60 && $percentageNew <= 80){
                                              $color = '#ffe113';
                                              $textcolor = 'black';
                                            }elseif($percentageNew > 80){
                                              $color ='#14b619bd';
                                              $textcolor ='white';
                                            }
                                          }else{
                                            $color ='#644699';
                                            $textcolor ='white';
                                          } 
                                    }
                                  }
                                }
                              }
                        
                        @endphp
                        <button data-iacs='{{$single_student->institute_assigned_class_id}}' data-student='{{$studentid}}' type="button" style='background:{{$color}};color:{{$textcolor}}' class="btn mybtns get_classes" data-toggle="modal" data-target="#studentAttendance"><i class='fa fa-eye'></i></button>
                      </td>
                      <td>
                        <a href="{{url('institute/generate-receipt/'.$single_student->institute_assigned_class_id.'/'.$studentid)}}"
                          class="btn-theme btn-style" target="_blank">Download</a>
                      </td>
                     {{--  <td class="py-2"><a
                          href="{{route('admin.manage-students.enrolled_classes', $student->student_id)}}"
                          class="btn-theme btn-style">View</a>&nbsp;<a
                          href="{{route('admin.search-classes', ['student_id' => $student->student_id])}}"
                          class="btn-theme btn-style">Manual
                          Enroll</a></td> --}}
                    </tr>
                    @endforeach 
                    @endforeach 
                    @else 
                    <tr>
                        <td colspan='7' class='text-center'> No Enrollments Yet !!!!
                          </td>
                    </tr>
                    @endif
                  </tbody>
                </table> 
            </div>
          </div>
        </div>
      </div>
    </div>
    <!---row end-->
  </div> <!-- container-fluid -->
</div> <!-- Page content Wrapper -->
</div><!-- content -->

<div id="studentAttendance" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Attendance</h4>
      </div>
      <div class="modal-body">
        <input type="hidden" class='student_id'>
        <input type="hidden" class='iacs'>

       {{--  <div class='form-group'>
          <label>Seletc Class</label>
          <select class='class_options form-control'>
          </select>
        </div>
 --}} 
 

        <div class='form-group'>
          <label>Subject</label>
          <select class='form-control subject_options'> 
           
          </select>
        </div>

        <div class='attendanceCal'>

        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>

@endsection
@push('js') 
<script> 
 

</script>
@endpush