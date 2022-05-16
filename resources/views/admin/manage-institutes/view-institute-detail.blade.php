@extends('admin.layouts.app')
@section('content')
<!-- Start content -->
<div class="content">
  <div class="">
    <div>{{ Breadcrumbs::render('view-institute-detail', request()->id) }}</div>
    <div class="page-header-title">
      <h4 class="page-title">View Institute Details</h4>
    </div>
  </div>

  <div class="page-content-wrapper ">
    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-body">
              <div class="d-flex justify-content-between align-items-center mb-3">
                <button class="btn btn-back"><a
                    href="{{route('admin.manage-institutes.view-institute',$institute->id)}}"><i
                      class="mdi mdi-arrow-left"></i></a> </button>
                <button class="btn btn-theme">Edit</button>
              </div>
              @include('admin.layouts.error')
              @include('admin.layouts.success')
              <form class="form-horizontal" id="update_institute_form"
                action="{{route('admin.manage-institutes.update',$institute->id)}}" method="post">
                @csrf
                <div class="form-group row">
                  <label class="col-sm-2 control-label" for="example-text-input">Name of
                    Institute</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" name="name" value="{{$institute->name ?? ''}}" required>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-2 control-label">Login Id</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" name="email" value="{{$institute->email ?? ''}}" required>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-2 control-label">Email Id</label>
                  <div class="col-sm-10">
                    <input type="email" class="form-control" name="email" value="{{$institute->email ?? ''}}" required>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-2 control-label" for="example-email">Address</label>
                  <div class="col-sm-10">
                    <input type="text" name="address" value="{{$institute->address ?? ''}}" class="form-control"
                      required>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-2 control-label">Mobile no.</label>
                  <div class="col-sm-10">
                    <input type="text" name="mobile_no" data-parsley-type="digits" class="form-control" minlength="10"
                      maxlength="10" value="{{$institute->phone ?? ''}}" required>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-2 control-label" for="example-text-input">Institute ID</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" value="{{$institute->id ?? ''}}" readonly>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-2 control-label">Institute Added On</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" value="{{date('d/m/Y', strtotime($institute->created_at))}}"
                      readonly>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-2 control-label">Total Enrollments</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" value="400" readonly>
                  </div>
                </div>
                <input type="hidden" id="id" name="id" value="{{$institute->id ?? ''}}" />
                <div class="form-group text-center">
                  <button type="submit" class="btn btn-theme" data-toggle="modal" data-target="#exampleModal">Save</a>
                  </button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
      <!---row end-->
    </div> <!-- container-fluid -->
  </div> <!-- Page content Wrapper -->
</div><!-- content -->
<div class="modal fade show" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header no-border">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <h4 class="mt-0 response"></h4>
      </div>
    </div>
  </div>
</div>
<input type="hidden" id="update_institute_form_url" value="{{route('admin.manage-institutes.update')}}" />
@endsection
@section('js')
<script src="{{ URL::to('assets/admin/js/jquery-validate.js')}}"></script>
<script>
  $(document).ready(function(){ 
    
            const name_err = 'Please enter your name';
            const email_err = 'Please enter a valid email address';
            const mobile_no_err = 'Please enter valid mobile number';
            const address_err = 'Please enter your address';  
            const required = 'required';
            const form_post_url = $('#update_institute_form_url').val();
            const success = 'Success';

            $("#update_institute_form").validate({
                rules: {
                    name: required,
                    email: {
                        required: true,
                        email: true
                    }, 
                    mobile_no: {
                        required: true,
                        digits: true,
                        maxlength: 10,
                        minlength: 10
                    }, 
                    address: required, 
                }, 
                messages: {
                    name: name_err,              
                    email: email_err, 
                    mobile_no: mobile_no_err,
                    address: address_err, 
                },
                submitHandler: function(form) { 
                    submitForm('#update_institute_form'); 
                }                
            });


            function submitForm(form_id){
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    }
                });
                $('.response').html('');
                $('.submit_btn').html('<i class="fa fa-spinner fa-spin" style="font-size:24px"></i>');
                let form_data = $(form_id).serialize(); 
                $.ajax({
                    type:'POST',
                    url:form_post_url,
                    data:form_data,
                    success:function(return_data) {                
                        $('.submit_btn').html('Create Institute'); 
                        if(return_data.status == success)
                        { 
                            $('.response').html('Changes Saved Successfully');                            
                        }
                        else
                        {
                            $('.response').html('<p class="js_response_error">'+return_data.error+'</p>');
                        }
                        setTimeout(function () {
                            $("#exampleModal").modal('toggle');
                            location.reload(true);
                        }, 2000);
                    }
                });
            }
        });
</script>
@endsection