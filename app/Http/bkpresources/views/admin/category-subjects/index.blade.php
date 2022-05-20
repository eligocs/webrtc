@extends('admin.layouts.app')
@section('content')
<!-- Start content -->
<div class="content">
    <div class="">
        <div class="page-header-title">
            <h4 class="page-title">Category Subjects</h4>
        </div>
    </div>
    <div class="page-content-wrapper ">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <ul class="nav nav-tabs d-md-flex justify-content-center" role="tablist">                        
                        <li class="nav-item"> 
                            <a class="nav-link active" data-toggle="modal" data-target="#custom-width-modal" href="#">
                                <span class="d-none d-sm-block">Add Subjects In Category</span>
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
                                                    <thead>
                                                        <tr>
                                                            <th>S.No.</th>
                                                            <th>Category</th>
                                                            <th>Subject</th>
                                                            <th>Created At</th>
                                                            <th>Action</th>
                                                        </tr>
                                                      </thead>
                                                    <tbody>
                                                        @if(isset($category_subjects))
                                                            @php 
                                                                $counter = 1;
                                                            @endphp
                                                            @foreach($category_subjects as $category_subject)
                                                                
                                                                <tr>
                                                                    <th>{{$counter}}.</th>
                                                                    <td>
                                                                        <span class="text-pale-sky text-capitalize">
                                                                           {{getCategoryById($category_subject->category_id )->name ?? ''}} 
                                                                        </span> 
                                                                    </td>
                                                                    <td>
                                                                        <span class="text-pale-sky text-capitalize">
                                                                           {{getSubjectById($category_subject->subject_id )->name ?? ''}} 
                                                                        </span> 
                                                                    </td>
                                                                    <td>  {{date('d/m/Y', strtotime($category_subject->created_at))}}
                                                                    </td>
                                                                    <td>
                                                                        <a href="{{route('admin.category-subjects.edit',$category_subject->id)}}" class="text-theme">View</a>
                                                                        
                                                                        <a href="{{route('admin.category-subjects.edit',$category_subject->id)}}" class="text-theme open_delete_confirm_modal" data-toggle="modal" data-target="#deleteModal" data-id="{{$category_subject->id}}" >Delete</a>
                                                                    </td> 
                                                                </tr> 
                                                                @php
                                                                    $counter++;
                                                                @endphp
                                                            @endforeach
                                                        @else
                                                            <h2>No Subjects in Categories !!</h2>
                                                        @endif
                                                    </tbody>
                                                </table>
                                                @if(isset($category_subjects))
                                                <nav class="mt-md-4">
                                                    {!! $category_subjects->render() !!}
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
                <form id="add_category_form" method="POST" action="{{ route('admin.category-subjects.store') }}">
                    @csrf
                    <div class="form-group row"> 
                        <div class="col-sm-10"> 
                            <select id="category" name="category" class="form-control">
                                <option value="">Select Category</option>
                                @if(isset($categories) && count($categories)>0)
                                    @foreach ($categories as $category)
                                        <option value="{{$category->id}}">{{$category->name}}</option>
                                    @endforeach
                                @endif
                            </select><br>
                            <select id="subjects" name="subjects[]" class="form-control" multiple>
                                <option value="">Select Subject</option>
                                @if(isset($subjects) && count($subjects)>0)
                                    @foreach ($subjects as $subject)
                                        <option value="{{$subject->id}}">{{$subject->name}}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>                    
                    <button class="btn btn-pink mt-md-2 confirm_btn" type="button" id="add_category_btn">Save</button>
                </form>                                
            </div>
            <div class="response"></div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<!-- delete modal content -->
<div id="deleteModal" class="modal fade" tabindex="-1" role="dialog"
aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header no-border">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <input type="hidden" id="set_category_subject_id" value=""/> 
            </div>
            <div class="modal-body">
                <h4 class="mt-0">Do you want to delete ?</h4>
                <button class="btn btn-pink mt-md-2 delete_confirm_btn" type="button">Confirm</button>
                <div class="response"></div>
            </div>
        </div>
    </div>
</div>

<!--- /delete modal content -->

<input type="hidden" id="add_category_subjects_url" value="{{ route('admin.category-subjects.store') }}" />
<input type="hidden" id="category_subjects_index_url" value="{{ route('admin.category-subjects.index') }}" />
<input type="hidden" id="delete_category_subjects_url" value="{{route('admin.category-subjects.delete')}}" /> 
@endsection
@section('js')
    <script>
        $(document).ready(function(){ 
            $('#add_category_btn').click(function(){
                
                let add_category_subjects_url = $('#add_category_subjects_url').val();
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
                    url:add_category_subjects_url,
                    data:{
                        "_token": "{{ csrf_token() }}",
                        category:category,
                        subjects:subjects,
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

            $('.open_delete_confirm_modal').click(function(){
                let set_id = $(this).data('id'); 
                $('#set_category_subject_id').val(set_id); 
            });

            $('.delete_confirm_btn').click(function(){
                let delete_category_subjects_url = $('#delete_category_subjects_url').val();
                let get_id = $('#set_category_subject_id').val();  
                let redirect_url = $('#category_subjects_index_url').val(); 
                $('.response').html('');
                $.ajax({            
                    type:'POST',
                    url:delete_category_subjects_url,
                    data:{
                        "_token": "{{ csrf_token() }}",
                        id:get_id, 
                    },
                    success:function(return_data) { 
                        if(return_data.status == 'Success'){
                            $('.response').html('<p class="js_response_success text-center">Category has been deleted successfully.</p>');
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