@extends('admin.layouts.app')
@section('content')
<!-- Start content -->
<div class="content">
    <div class="">
        <div class="page-header-title">
            <h4 class="page-title">Edit Category Subjects</h4>
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
                                <a href="{{route('admin.category-subjects.index')}}">
                                    <i class="mdi mdi-arrow-left"></i>
                                </a>
                             </button>
                            <button class="btn btn-pink">Edit</button>
                            </div>
                        @include('admin.layouts.error')
                        @include('admin.layouts.success')
                        <form class="form-horizontal" id="update_category_subjects_form" action="{{route('admin.category-subjects.store' )}}" method="post">
                            @csrf
                                <select id="category" name="category" class="form-control"> 
                                    <option value="{{$category_subjects->category_id}}">{{getCategoryById($category_subjects->category_id)->name}}</option>                                        
                                </select><br>
                                <select id="subjects" name="subjects[]" class="form-control" multiple>
                                    <option value="">Select Subject</option>
                                    @if(isset($subjects) && count($subjects)>0)
                                        @foreach ($subjects as $subject)
                                            <option value="{{$subject->id}}" @if($category_subjects->subject_id == $subject->id ) selected @endif>{{$subject->name}}</option>
                                        @endforeach
                                    @endif
                                </select><br>
                                <div class="form-group text-center">
                                    <button type="button" id="update_category_subjects_btn" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">Update</a>
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
<input type="hidden" id="update_category_subjects_url" value="{{ route('admin.category-subjects.store') }}" />
<input type="hidden" id="category_subjects_index_url" value="{{ route('admin.category-subjects.index') }}" />
@endsection 
@section('js')
    <script>
        $(document).ready(function(){
            $('#update_category_subjects_btn').click(function(){
                let update_category_subjects_url = $('#update_category_subjects_url').val();
                let category = $('#category').val();
                let subjects = $('#subjects').val();
                let redirect_url = $('#category_subjects_index_url').val();
                if(category == ''){
                    $('.response').html('<p class="js_response_error text-center">Category is required.</p>');
                   return false;
                }
                if(subjects == ''){
                    $('.response').html('<p class="js_response_error text-center">Subject is required.</p>');
                   return false;
                }
                $('.response').html('');
                $.ajax({            
                    type:'POST',
                    url:update_category_subjects_url,
                    data:{
                        "_token": "{{ csrf_token() }}",
                        category:category,
                        subjects:subjects,
                    },
                    success:function(return_data) { 
                        if(return_data.status == 'Success'){
                            $('.response').html('<p class="js_response_success text-center">Category has been updated successfully.</p>');
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