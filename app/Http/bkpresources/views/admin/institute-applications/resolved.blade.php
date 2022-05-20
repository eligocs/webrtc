@extends('admin.layouts.app')
@section('page_heading', 'Resolved Applications')
@section('content')


<!-- Start Content-->
<div class="container-fluid">
  <div>{{ Breadcrumbs::render('resolved-applications') }}</div>
  <div class="row mx-0 card-box">
    <div class="col-md-12">
      @if( Request::get('s') )
      <div class="card-box text-capitalize text-center  success_message">
        <div class="close-icn"><a href="#"><i class="mdi mdi-close"></a></i></div>
        Application by "{{Request::get('s')}} institute" have been added to resolved applications successfully.
      </div>
      @endif
      <div class="table-responsive">
        <table class="table table-bordered mb-0 package-table">
          <thead>
            <tr>
              <th>
                <h4 class="header-title m-0 text-center heading">Sr. No.</h4>
              </th>
              <th>
                <h4 class="header-title m-0 text-center heading">Application By</h4>
              </th>
              <th>
                <h4 class="header-title m-0 text-center heading">Application Date</h4>
              </th>
              <th>
                <h4 class="header-title m-0 text-center heading">View Application</h4>
              </th>
            </tr>
          </thead>
          <tbody>
            @if(isset($resolved_institute_applications))
            @php
            $resolved_counter = 1;
            @endphp
            @foreach($resolved_institute_applications as
            $resolved_institute_application)
            @if($resolved_institute_application->status == '1')
            <tr>
              <td>{{$resolved_counter}}.</td>
              <td>{{$resolved_institute_application->name}}</td>
              <td>{{date('d/m/Y', strtotime($resolved_institute_application->created_at))}}</td>
              <td><a href="{{route('admin.institute-applications.view',$resolved_institute_application->id)}}"
                  class="btn-theme btn-style">View</a>
              </td>
            </tr>
            @endif
            @php
            $resolved_counter++;
            @endphp
            @endforeach
            @endif
          </tbody>
        </table>
        <div class="mt-4 d-flex justify-content-center">{{$resolved_institute_applications->links() }}</div>
        <!-- <nav class="mt-4">
                            <ul class="pagination pagination-rounded pagination-md justify-content-end">
                                <li class="page-item active"><a class="page-link" href="javascript:void()">1</a></li>
                                <li class="page-item"><a class="page-link" href="javascript:void()">2</a></li>
                                <li class="page-item"><a class="page-link" href="javascript:void()">3</a></li>
                                <li class="page-item"><a class="page-link" href="javascript:void()">4</a></li>
                                <li class="page-item"><a class="page-link" href="javascript:void()">5</a></li>
                            </ul>
                        </nav> -->
      </div>

    </div><!-- end col -->
  </div>
  <!-- end row -->

</div> <!-- container -->
@endsection