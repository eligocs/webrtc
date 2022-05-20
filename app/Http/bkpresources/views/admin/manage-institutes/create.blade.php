@extends('admin.layouts.app')
@section('content')
<!-- Start content -->
<div class="content">
    <div class="">
        <div class="page-header-title">
            <h4 class="page-title">Manage Institutes</h4>

        </div>
    </div> 
   
    <div class="page-content-wrapper ">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">                              
                    <ul class="nav nav-tabs d-md-flex justify-content-center manage-nav" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="new-application-tab" data-toggle="tab" href="#new-application" role="tab" aria-controls="new-application" aria-selected="false">
                                <span class=" d-sm-block">Old Institute</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="resolved-tab" data-toggle="tab" href="#resolved" role="tab" aria-controls="resolved" aria-selected="true">
                             <span class=" d-sm-block">Add Institute</span>
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
                                                    <form role="search" >
                                                        <input type="text" placeholder="Search by Institute Name" class="form-control search-bar">
                                                        <a href=""><i class="fa fa-search"></i></a>
                                                    </form>
                                                </li>
                                                <li class="app-search float-left mr-md-3  mb-2">
                                                    <form role="search">
                                                        <input type="text" placeholder="Search by Institute Id" class="form-control search-bar">
                                                        <a href=""><i class="fa fa-search"></i></a>
                                                    </form>
                                                </li>
                                            </ul>
                                            <div class="table-responsive">
                                                <table class="table table-hover mb-0 manage-table">
                                                    <tbody>
                                                      <tr>
                                                        <th>1.</th>
                                                        <td> <span class="text-pale-sky text-capitalize">Akaash Institute</span><p>Id:0909090</p>
                                                        </td>
                                                        <td>Total Enrollments 300</td>
                                                        <td> Classes - 2</td>
                                                        <td><a href="view-institute.html" class="text-theme">View</a></td>
                                                      </tr>
                                                      <tr>
                                                        <th scope="row">2</th>
                                                        <td> <span class="text-pale-sky text-capitalize">Akaash Institute</span><p>Id:0909090</p>
                                                        </td>
                                                        <td>Total Enrollments 300</td>
                                                        <td> Classes - 2</td>
                                                        <td><a href="view-institute.html" class="text-theme">View</a></td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">3</th>
                                                        <td> <span class="text-pale-sky text-capitalize">Akaash Institute</span><p>Id:0909090</p>
                                                        </td>
                                                        <td>Total Enrollments 300</td>
                                                        <td> Classes - 2</td>
                                                        <td><a href="view-institute.html" class="text-theme">View</a></td>
                                                    </tr>
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
                        <div class="tab-pane fade " id="resolved" role="tabpanel" aria-labelledby="resolved-tab">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-12">
                                            <form class="form-horizontal">
                                                <div class="form-group row">
                                                    <label class="col-sm-2 control-label" for="example-text-input">Institute Name</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" class="form-control" value="" id="example-text-input"  required>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-sm-2 control-label" for="example-email">Email</label>
                                                    <div class="col-sm-10">
                                                        <input type="email" id="example-email" name="example-email" class="form-control" required>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-sm-2 control-label" for="example-email">Mobile Number</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" id="example-number" name="example-number" class="form-control" required>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-sm-2 control-label" for="example-email">Address</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" id="example-address" name="example-address" class="form-control" required>
                                                    </div>
                                                </div>
                               
                                                <div class="form-group text-center">
                                                   <button type="submit" class="btn btn-theme waves-effect waves-light m-l-10">Create Institute</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!---row end-->
        </div>  <!-- container-fluid -->
    </div> <!-- Page content Wrapper -->
</div><!-- content -->
@endsection