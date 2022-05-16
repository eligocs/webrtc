@extends('admin.layouts.app')
@section('content')
<!-- Start content -->
<div class="content">
    <div class="">
        <div class="page-header-title">
            <h4 class="page-title">View Category</h4>
        </div>
    </div>

    <div class="page-content-wrapper ">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                            <button class="btn btn-back">
                                <a href="{{route('admin.category.index')}}">
                                    <i class="mdi mdi-arrow-left"></i>
                                </a>
                             </button>
                            <button class="btn btn-pink">Edit</button>
                            </div>
                        @include('admin.layouts.error')
                        @include('admin.layouts.success')
                        <form class="form-horizontal" id="update_category_form" action="{{route('admin.category.update',$category->id)}}" method="post">
                            @csrf
                                <div class="form-group row">
                                    <label class="col-sm-2 control-label" for="example-text-input">Name of Category</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="name" name="name" value="{{$category->name ?? ''}}" required>
                                    </div>
                                </div> 
                                <input type="hidden" id="id" name="id" value="{{$category->id ?? ''}}" />
                                <div class="form-group text-center">
                                    <button type="button" id="update_category_btn" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">Update</a>
                                    </button>
                                </div>
                            </form>
                            <div class="response"></div>
                        </div>
                    </div>
                </div>
            </div>
            <!---row end-->
        </div> <!-- container-fluid -->
    </div> <!-- Page content Wrapper -->
</div><!-- content -->
<input type="hidden" id="update_category_url" value="{{route('admin.category.update',$category->id)}}" />
@endsection
@section('js')
    <script>
        $(document).ready(function(){
            $('#update_category_btn').click(function(){
                let update_category_url = $('#update_category_url').val();
                let name = $('#name').val();                 
                if(name == ''){
                    $('.response').html('<p class="js_response_error text-center">Name is required.</p>');
                   return false;
                }
                $('#update_category_btn').html('<i class="fa fa-spinner fa-spin" style="font-size:24px"></i>');
                $.ajax({            
                    type:'POST',
                    url:update_category_url,
                    data:{
                        "_token": "{{ csrf_token() }}",
                        name:name
                    },
                    success:function(return_data) { 
                        $('#update_category_btn').html('Update');
                        if(return_data.status == 'Success'){
                            $('.response').html('<p class="js_response_success text-center">Category has been updated successfully.</p>'); 
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