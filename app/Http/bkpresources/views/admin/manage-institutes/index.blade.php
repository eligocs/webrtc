@extends('admin.layouts.app')
@section('page_heading', 'Manage Institutes')
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

        .switch {
            position: relative;
            display: inline-block;
            width: 60px;
            height: 34px;
        }

        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            -webkit-transition: .4s;
            transition: .4s;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 26px;
            width: 26px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            -webkit-transition: .4s;
            transition: .4s;
        }

        input:checked+.slider {
            background-color: #2196F3;
        }

        input:focus+.slider {
            box-shadow: 0 0 1px #2196F3;
        }

        input:checked+.slider:before {
            -webkit-transform: translateX(26px);
        }

    </style>
@endpush
@section('content')

    <!-- Start Content-->
    <div class="container-fluid">
        <div>{{ Breadcrumbs::render('manage-institutes') }}</div>
        <div class="row mx-0 card-box">
            <div class="col-md-12">
                @if (session()->has('message'))
                    <div class="alert alert-success success_message">
                        {{ session()->get('message') }}
                    </div>
                @endif
                {{-- <form class="app-search align-items-center" action="{{route('admin.manage-institutes.search.institute_id')}}">
      <div class="app-search-box">
        <div class="input-group">
          <input type="text" class="form-control" placeholder="Search by Institute Name" name="name">
          <div class="input-group-append">
            <button class="btn" type="submit">
              <i class="fe-search"></i>
            </button>
          </div>
        </div>
      </div>
      <div class="app-search-box">
        <div class="input-group">
          <input type="text" class="form-control" placeholder="Search by Institute Id" name="id">
          <div class="input-group-append">
            <button class="btn" type="submit">
              <i class="fe-search"></i>
            </button>
          </div>
        </div>
      </div>
      <button class="btn btn-theme">Search</button>
      </form> --}}
                <div class="table-responsive">
                    <table class="table table-bordered mb-0 package-table" id="dataTables">
                        <thead>
                            <tr>
                                <th>
                                    <h4 class="header-title m-0 text-center heading">Sr. No.</h4>
                                </th>
                                <th>
                                    <h4 class="header-title m-0 text-center heading">Institute Name</h4>
                                </th>
                                <th>
                                    <h4 class="header-title m-0 text-center heading">Description</h4>
                                </th>
                                <th>
                                    <h4 class="header-title m-0 text-center heading">Video</h4>
                                </th>
                                <th>
                                    <h4 class="header-title m-0 text-center heading"> Approve</h4>
                                </th>
                                <th>
                                    <h4 class="header-title m-0 text-center heading">Total Enrollment</h4>
                                </th>
                                {{-- <th>
                <h4 class="header-title m-0 text-center heading">Class Name</h4>
              </th> --}}
                                <th>
                                    <h4 class="header-title m-0 text-center heading">Action</h4>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (isset($institutes))
                                @php
                                    $institute_counter = 1;
                                @endphp
                                @foreach ($institutes as $institute)
                                    <tr>
                                        <td>{{ $institute_counter }}.</td>
                                        <td>{{ $institute->name }}</td>
                                        <td><a data-toggle="tooltip" data-placement='top' class='text-blue'
                                                title='{{ $institute->description }}'>{{ strlen($institute->description) > 20 ? substr($institute->description, 0, 20) . '...' : $institute->description }}</a>
                                        </td>
                                        <td>
                                            @if (!empty($institute->video) && @unserialize($institute->video))
                                                @php $videoLink = unserialize($institute->video)[0]; @endphp
                                                <a class="btn-primary text-white btn-style justify-content-center text-center "
                                                    rel="video-gallery" href="{{ $videoLink ? $videoLink : '' }}"
                                                    target="_blank"> <span
                                                        class="text-video mr-1 text-capitalize text-white">Play</span>
                                                    <i class="mdi mdi-play-circle"></i></a>
                                            @endif
                                        </td>
                                        <td>
                                            @if (!empty($institute->video) && @unserialize($institute->video))
                                                <label class="switch">
                                                    <input type="checkbox" class='approveVideo'
                                                        data-id="{{ $institute->id }}"
                                                        value='@if ($institute->videoApproval == 1) {{ 0 }}@else{{ 1 }} @endif'
                                                        <?php if ($institute->videoApproval == 1) {
                                                            echo 'checked';
                                                        } ?>>
                                                    <span class="slider round"></span>
                                                </label>
                                            @endif
                                        </td>
                                        <td>{{ count($institute->students ? $institute->students->toArray() : []) }}</td>
                                        {{-- <td>Classes-2</td> --}} 
                                        <?php  $notiflies = 0; ?>
                                        @if($institute->institute_assigned_classes->count() > 0) 
                                                @foreach ($institute->institute_assigned_classes as $institute_assigned_class)
                                                    @if($institute_assigned_class->institute_assigned_class_subject->count() > 0 ) 
                                                    @if($institute_assigned_class->videoApproval == 0 && !empty($institute_assigned_class->video) ) 
                                                        <?php  $notiflies += 1; ?>
                                                    @endif 
                                                        @foreach( $institute_assigned_class->institute_assigned_class_subject as $subject ) 
                                                            @if(!empty($subject->video) && empty($subject->videoApproval))
                                                                <?php  $notiflies += 1; ?>
                                                            @endif
                                                        @endforeach
                                                    @endif
                                                @endforeach
                                        @endif 
                                        <td class='p-2'><a href="{{ route('admin.manage-institutes.view-institute', $institute->id) }}"
                                                class="btn-theme btn-style">View {{!empty($notiflies) ? '('.$notiflies.')' : ''}}</a>&nbsp;<a
                                                href="{{ route('admin.manage-institutes.edit', $institute->id) }}"
                                                class="btn-theme btn-style">Edit</a>
                                        </td>
                                    </tr>
                                    @php
                                        $institute_counter++;
                                    @endphp
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                    {{-- <div class="mt-4 d-flex justify-content-center">
          {{$institutes->links()}}
      </div> --}}
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
    <input type="hidden" id="add_new_institute_form_url" value="{{ route('admin.manage-institutes.store') }}" />
@endsection
@section('js')
    <script src="{{ URL::to('assets/admin/js/jquery-validate.js') }}"></script>
    <script src="{{ URL::to('assets/admin/js/add-institute.js') }}"></script>
@endsection
@push('js')
    <script src="//cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#dataTables').DataTable();
            $('.approveVideo').click(function() {
                var val = $(this).val();
                var id = $(this).data('id');
                window.location.href = "{{ url('admin/approveVideo') }}" + '/' + id + '/' + val;
            });
        })
    </script>
@endpush
