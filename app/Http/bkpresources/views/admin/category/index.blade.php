@extends('admin.layouts.app')
@section('content')
<!-- Start content -->
<div class="content">
    <div class="">
        <div class="page-header-title">
            <h4 class="page-title">Categories</h4>
        </div>
    </div>
    <div class="page-content-wrapper ">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <ul class="nav nav-tabs d-md-flex justify-content-center" role="tablist">                        
                        <li class="nav-item"> 
                            <a class="nav-link active" data-toggle="modal" data-target="#custom-width-modal" href="#">
                                <span class="d-none d-sm-block">Add New Category</span>
                            </a>                            
                        </li>
                    </ul> 
    
                    <div class="tab-content bg-light mt-4">
                        <div class="tab-pane fade active show" id="new-application" role="tabpanel"
                            aria-labelledby="new-application-tab">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="table-responsive">
                                                <table class="table table-hover mb-0">
                                                    <tbody>
                                                        @if(isset($categories))
                                                            @php 
                                                                $counter = 1;
                                                            @endphp
                                                            @foreach($categories as $category)
                                                                
                                                                <tr>
                                                                    <th>{{$counter}}.</th>
                                                                    <td>
                                                                        <span class="text-pale-sky text-capitalize">
                                                                            {{$category->name}}
                                                                        </span> 
                                                                    </td>
                                                                    <td> Category Date - {{date('d/m/Y', strtotime($category->created_at))}}
                                                                    </td>
                                                                    <td>
                                                                        <a href="{{route('admin.category.view',$category->id)}}" class="text-theme">View Category</a>
                                                                    </td> 
                                                                </tr> 
                                                                @php
                                                                    $counter++;
                                                                @endphp
                                                            @endforeach
                                                        @else
                                                            <h2>No Categories !!</h2>
                                                        @endif
                                                    </tbody>
                                                </table>
                                                @if(isset($categories))
                                                <nav class="mt-md-4">
                                                    {!! $categories->render() !!}
                                                </nav>
                                                @endif 
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> 
                    </div>
                </div>
            </div>
            <!---row end-->
        </div> <!-- container-fluid -->
    </div> <!-- Page content Wrapper -->
</div>

<!-- sample modal content -->
<div id="custom-width-modal" class="modal fade" tabindex="-1" role="dialog"
aria-labelledby="custom-width-modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header no-border">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button> 
            </div>
            <div class="modal-body">
                <form id="add_category_form" method="POST" action="{{ route('admin.category.store') }}">
                    @csrf
                    <div class="form-group row"> 
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="name" name="name" placeholder="Name" required >
                        </div>
                    </div>                    
                    <button class="btn btn-pink mt-md-2 confirm_btn" type="button" id="add_category_btn">Confirm</button>
                </form>                                
            </div>
            <div class="response"></div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<input type="hidden" id="add_category_url" value="{{ route('admin.category.store') }}" />
<input type="hidden" id="category_index_url" value="{{ route('admin.category.index') }}" />
@endsection
@section('js')
    <script>
        $(document).ready(function(){
            $('#add_category_btn').click(function(){
                let add_category_url = $('#add_category_url').val();
                let name = $('#name').val();
                let redirect_url = $('#category_index_url').val();
                if(name == ''){
                    $('.response').html('<p class="js_response_error text-center">Name is required.</p>');
                   return false;
                }
                $.ajax({            
                    type:'POST',
                    url:add_category_url,
                    data:{
                        "_token": "{{ csrf_token() }}",
                        name:name
                    },
                    success:function(return_data) { 
                        if(return_data.status == 'Success'){
                            $('.response').html('<p class="js_response_success text-center">Category has been saved successfully.</p>');
                            setTimeout(function () { 
                                window.location.replace(redirect_url);
                            }, 2000);
                        }
                        else
                        {
                            $('.response').html('<p class="js_response_error text-center">'+return_data.error+'</p>');
                        } 
                    }
                });

            });
        });
    </script>
    
@endsection