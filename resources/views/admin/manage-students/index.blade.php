@extends('admin.layouts.app')
{{-- @section('page_heading', 'Manage Students') --}}
@push('css')
<link rel="stylesheet" href="//cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">
<style>
  [type=search] {
    height: 38px;
    width: 220px;
    padding-left: 20px;
    padding-right: 0;
    color: #323a46;
    background-color: #ffffff;
    box-shadow: none;
    border: 1px solid #644699;
    border-radius: 9px !important;
    outline: none;
  }
</style>
@endpush
@section('content')
<!-- Start content -->
<style>
  .manage_search i {
    position: absolute;
    right: 7px;
    top: 12px;
    color: #000000;
  }

  .manage_search input {
    padding-right: 20px;
  }
</style>
<div class="content">
  <div class="">
    <div class="page-header-title">
      <h4 class="page-title">Manage Students</h4>

    </div>
  </div>

  <div class="page-content-wrapper ">
    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-12">
          {{-- <ul class="nav nav-tabs d-md-flex justify-content-center visibility-hidden" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="new-application-tab" data-toggle="tab" href="#new-application" role="tab" aria-controls="new-application" aria-selected="false">
                                    <span class="d-none d-sm-block">Old Institute</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="resolved-tab" data-toggle="tab" href="#resolved" role="tab" aria-controls="resolved" aria-selected="true">
                                 <span class="d-none d-sm-block">Add Institute</span>
                                </a>
                            </li>
                        </ul> --}}
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
                        <h4 class="header-title m-0 heading">Registration Time</h4>
                        <!-- <span class="text-muted">Phone Number</span> -->
                      </th>
                      <th>
                        <h4 class="header-title m-0 heading">Phone Number</h4>
                      </th>
                      <th>
                        <h4 class="header-title m-0 heading">Action</h4>
                      </th>
                    </tr>
                  </thead>
                  <tbody> 
                    @foreach ($students as $key => $student)
                    <tr>
                      <th>{{$key+1}}</th>
                      {{-- <th>{{$student->id}}</th> --}}
                      <td>
                        <div class="media">
                          <!-- <img src="assets/images/student1.jpg" class="mr-3 rounded-circle" width="70" height="70" alt=""> -->
                          <div class="media-body">
                            <h5 class="m-0">{{$student->name}}</h5>
                            <!-- <span class="text-muted">{{$student->phone}}</span> -->
                          </div>
                        </div>
                      </td>
                      <td>
                        <h5>
                           {{$student->created_at ? date('d F Y D h:i a',(strtotime($student->created_at))) : ''}}
                        </h5>
                      </td>
                      <td>
                        <h5 class="m-0">{{$student->phone}}</h5>
                      </td>
                      <td class="py-2"><a
                          href="{{route('admin.manage-students.enrolled_classes', $student->student_id)}}"
                          class="btn-theme btn-style">View</a>&nbsp;<a
                          href="{{route('admin.search-classes', ['student_id' => $student->student_id])}}"
                          class="btn-theme btn-style">Manual
                          Enroll</a></td>
                    </tr>
                    @endforeach
                    {{-- <tr>
                                            <th>2</th>
                                            <td>
                                                <div class="media">
                                                    <!-- <img src="assets/images/student1.jpg" class="mr-3 rounded-circle" width="70" height="70" alt=""> -->
                                                    <div class="media-body">
                                                        <h5 class="m-0">Shubham</h5>
                                                        <span class="text-muted">9090909090</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td> <span class="text-pale-sky text-capitalize">6th Grade</span>
                                            </td>
                                            <td> <span class="text-pale-sky text-capitalize">Akaash Institute</span>
                                            </td>
                                            <td><a href="view-manage-student.html" class="text-theme">View</a></td>
                                         </tr> --}}
                    {{-- <tr>
                                            <th>3</th>
                                            <td>
                                                <div class="media">
                                                    <!-- <img src="assets/images/student1.jpg" class="mr-3 rounded-circle" width="70" height="70" alt=""> -->
                                                    <div class="media-body">
                                                        <h5 class="m-0">Shubham</h5>
                                                        <span class="text-muted">9090909090</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td> <span class="text-pale-sky text-capitalize">6th Grade</span>
                                            </td>
                                            <td> <span class="text-pale-sky text-capitalize">Akaash Institute</span>
                                            </td>
                                            <td><a href="view-manage-student.html" class="text-theme">View</a></td>
                                         </tr> --}}
                  </tbody>
                </table>
                {{-- <div class="mt-4 d-flex justify-content-center">
                  {{$students->links()}}
              </div> --}}
              {{-- <nav class="mt-md-4">
                                        <ul class="pagination pagination-rounded pagination-md justify-content-end">
                                            <li class="page-item active"><a class="page-link" href="javascript:void()">1</a></li>
                                            <li class="page-item"><a class="page-link" href="javascript:void()">2</a></li>
                                            <li class="page-item"><a class="page-link" href="javascript:void()">3</a></li>
                                            <li class="page-item"><a class="page-link" href="javascript:void()">4</a></li>
                                            <li class="page-item"><a class="page-link" href="javascript:void()">5</a></li>
                                        </ul>
                                    </nav>  --}}
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
<script src="//cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script>
  $(document).ready(function(){
    $('#dataTables').DataTable();
  })
</script>
@endpush