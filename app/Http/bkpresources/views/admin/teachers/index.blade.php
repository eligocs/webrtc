@extends('admin.layouts.app')
@section('page_heading', 'Teachers')
@section('content')

<!-- Start Content-->
<div class="container-fluid">
  <div>{{ Breadcrumbs::render('teachers', request()->institute_id) }}</div>
  <div class="row mx-0 card-box">
    <div class="col-md-12">
      @if(session()->has('message'))
      <div class="alert alert-success success_message">
        {{ session()->get('message') }}
      </div>
      @endif
      <form class="app-search align-items-center" action="{{route('admin.manage-institutes.search.institute_id')}}">
        {{-- <div class="app-search-box">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Search by Institute Name" name="name">
                        <div class="input-group-append">
                            <button class="btn" type="submit">
                                <i class="fe-search"></i>
                            </button>
                        </div>
                    </div>
                </div> --}}
        {{-- <div class="app-search-box">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Search by Institute Id" name="id">
                        <div class="input-group-append">
                            <button class="btn" type="submit">
                                <i class="fe-search"></i>
                            </button>
                        </div>
                    </div>
                </div> --}}
        {{-- <button class="btn btn-theme">Search</button> --}}
      </form>
      <div class="col-md-12 d-md-flex justify-content-end mb-3">
        <a href="{{route('admin.teachers.create', request()->institute_id)}}" class="btn-theme btn-style ml-1">Add New
          Teacher</a>
        <br>
      </div>
      <div class="table-responsive">
        <table class="table table-bordered mb-0 package-table">
          <thead>
            <tr>
              <th>
                <h4 class="header-title m-0 text-center heading">Sr. No.</h4>
              </th>
              <th>
                <h4 class="header-title m-0 text-center heading">Institute Name</h4>
              </th>
              <th>
                <h4 class="header-title m-0 text-center heading">Profile Photo</h4>
              </th>
              <th>
                <h4 class="header-title m-0 text-center heading">Teacher Name</h4>
              </th>
              <th>
                <h4 class="header-title m-0 text-center heading">Qualifications</h4>
              </th>
              <th>
                <h4 class="header-title m-0 text-center heading">Experience</h4>
              </th>
              <th>
                <h4 class="header-title m-0 text-center heading">Action</h4>
              </th>
            </tr>
          </thead>
          <tbody>
            @foreach ($array as $key => $element)
            <tr>
              <td>{{$key+1}}.</td>
              <td>{{$element->institute->name}}</td>
              <td><img src="{{url('/storage/'.$element->avatar)}}" alt="" width="100"></td>
              <td>{{$element->name}}{!!$element->head_teacher == '1' ? '&nbsp;<span
                  class="badge badge-primary">HEAD</span>': ''!!}</td>
              <td>{{$element->qualifications}}</td>
              <td>{{$element->experience}}</td>
              <td>
                {{-- <a href="{{route('admin.manage-institutes.view-institute',$element->id)}}" class="btn-theme
                btn-style">View</a> --}}
                &nbsp;
                <a href="{{route('admin.teachers.edit',[request()->institute_id, $element->id])}}"
                  class="btn-theme btn-style">Edit</a></td>
            </tr>
            @endforeach
          </tbody>
        </table>
        {{-- <nav class="mt-4">
                                    <ul class="pagination pagination-rounded pagination-md justify-content-end">
                                        <li class="page-item active"><a class="page-link" href="javascript:void()">1</a></li>
                                        <li class="page-item"><a class="page-link" href="javascript:void()">2</a></li>
                                        <li class="page-item"><a class="page-link" href="javascript:void()">3</a></li>
                                        <li class="page-item"><a class="page-link" href="javascript:void()">4</a></li>
                                        <li class="page-item"><a class="page-link" href="javascript:void()">5</a></li>
                                    </ul>
                                </nav> --}}
      </div>
    </div><!-- end col -->
  </div>
  <!-- end row -->
</div> <!-- container -->
<input type="hidden" id="add_new_institute_form_url" value="{{route('admin.manage-institutes.store')}}" />
@endsection
@section('js')
<script src="{{ URL::to('assets/admin/js/jquery-validate.js')}}"></script>
<script src="{{ URL::to('assets/admin/js/add-institute.js')}}"></script>
@endsection