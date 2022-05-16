@extends('admin.layouts.app') 
  
@push('css') 
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>

</style>
@endpush
@section('content')
<div class="content">
  <div class="">
    <div class="page-header-title">
      <h4 class="page-title">Total Enrollments</h4>

    </div>
  </div>

  <div class="page-content-wrapper ">
    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-12">
           
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
                      $st = \DB::table('students')->where('id',$studentid)->select('name','phone')->first();   
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
                          $istried = \App\Models\StudentTrialPeriod::where('student_id',$single_student->student_id)->where('class_id',Request::segment('5'))->first();  
                        @endphp
                        @if($single_student->price == 0)
                          <h5 class="m-0">Free Trial</h5>
                        @else
                          <h5 class="m-0">{{$single_student->price ? $single_student->price : '-'}} <i class="fa fa-inr" aria-hidden="true"></i></h5>
                        @endif
                      </td>
                      <td>
                        <h5 class="m-0">{{$st->phone ? $st->phone : ''}}</h5>
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
                        <td colspan='5' class='text-center'> No Enrollments Yet !!!!
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

@endsection
@push('js') 
<script> 
</script>
@endpush