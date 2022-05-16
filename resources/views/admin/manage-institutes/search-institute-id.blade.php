@extends('admin.layouts.app')
@section('content')
<!-- Start content -->
<div class="content">
    <div class="">
        <div class="page-header-title">
            <h4 class="page-title">Manage Institutes  </h4>

        </div>
    </div> 
    <div class="page-content-wrapper ">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">                              
                    <ul class="nav nav-tabs d-md-flex justify-content-center manage-nav" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="new-application-tab" data-toggle="tab" href="#new-application" role="tab" aria-controls="new-application" aria-selected="false">
                                <span class=" d-sm-block">Existing Institute</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="resolved-tab" data-toggle="tab" href="#resolved" role="tab" aria-controls="resolved" aria-selected="true">
                             <span class=" d-sm-block">Add New Institute</span>
                            </a>
                        </li>
                         
                    </ul>
                    <div class="tab-content bg-light mt-4">
                        <div class="tab-pane fade active show" id="new-application" role="tabpanel" aria-labelledby="new-application-tab">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        
                                        <div class="col-12">
                                            <ul class="list-inline menu-left mb-md-5 d-md-flex justify-content-start manage-search">
                                                <li class=" app-search float-left mr-md-3 mb-2">
                                                    <form role="search" action="{{route('admin.manage-institutes.search.institute_name')}}" class="position-relative">
                                                        <input type="text" placeholder="Search by Institute Name" class="form-control search-bar" name="name"> 
                                                        <button type="submit" class="search_btn"><i class="fa fa-search"></i></button>
                                                    </form>
                                                </li>
                                                <li class="app-search float-left mr-md-3  mb-2">
                                                    <form role="search" class="position-relative" action="{{route('admin.manage-institutes.search.institute_id')}}">
                                                        <input type="text" placeholder="Search by Institute Id" class="form-control search-bar" name="id">
                                                        <button type="submit" class="search_btn"><i class="fa fa-search"></i></button>
                                                    </form>
                                                </li>
                                            </ul>
                                            <div class="table-responsive">
                                                <table class="table table-hover mb-0 manage-table">
                                                    <tbody> 
                                                        @if(isset($institute))
                                                        <tr>
                                                            <th>1.</th>
                                                            <td> 
                                                                <span class="text-pale-sky text-capitalize">{{$institute->name ?? ''}}</span><p>Id : {{$institute->id ?? ''}}</p>
                                                            </td>
                                                            <td>Total Enrollments 300</td>
                                                            <td> Classes - 2</td>
                                                            <td>
                                                                <a href="{{route('admin.manage-institutes.view-institute',$institute->id ?? '')}}" class="text-theme">View</a>
                                                            </td>
                                                        </tr>  
                                                        @else
                                                            <h4>Sorry, No institute found</h4> 
                                                        @endif
                                                    </tbody>
                                                </table>
                                                
                                                <nav class="mt-md-4">
                                                    <ul class="pagination pagination-rounded pagination-md justify-content-end">
                                                        <li class="page-item active"><a class="page-link" href="javascript:void()">1</a></li>
                                                        <li class="page-item"><a class="page-link" href="javascript:void()">2</a></li>
                                                        <li class="page-item"><a class="page-link" href="javascript:void()">3</a></li>
                                                        <li class="page-item"><a class="page-link" href="javascript:void()">4</a></li>
                                                        <li class="page-item"><a class="page-link" href="javascript:void()">5</a></li>
                                                    </ul>
                                                </nav>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @include('admin.manage-institutes.add-new-institute-tab')
                    </div>
                </div>
            </div><!---row end-->
        </div>  <!-- container-fluid -->
    </div> <!-- Page content Wrapper -->
</div><!-- content --> 
<input type="hidden" id="add_new_institute_form_url" value="{{route('admin.manage-institutes.store')}}" />
@endsection
@section('js')
    <script src="{{ URL::to('assets/admin/js/jquery-validate.js')}}"></script>
    <script src="{{ URL::to('assets/admin/js/add-institute.js')}}"></script>
@endsection
