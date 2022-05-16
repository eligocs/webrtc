@extends('admin.layouts.app')
@section('content') 
<!-- Start content -->
<div class="content">
    <div class="">
        <div class="page-header-title">
            <h4 class="page-title">Select Days</h4>
        </div>
    </div>

    <div class="page-content-wrapper ">
        <div class="container-fluid">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12">   
                            @if(isset($request['subjects']) && count($request['subjects'])>0)
                                @foreach ($request['subjects'] as $subject)
                                    <form action="{{route('admin.manage-institutes.create-class')}}" method="post" id="form_id_{{$subject}}">
                                        @csrf

                                        <div class="select-days row">
                                            <div class="col-lg-3">
                                                <label class="subject m-0">{{\App\Models\Subject::find($subject)->name}}</label>
                                                <input type="hidden" name="id" value="{{$request['id']}}" />
                                                <input type="hidden" name="category" value="{{$request['category']}}" />
                                                <input type="hidden" name="start_date" value="{{$request['start_date']}}" />
                                                <input type="hidden" name="end_date" value="{{$request['end_date']}}" />
                                                <input type="hidden" name="price" value="{{$request['price']}}" />
                                                <input type="hidden" name="language" value="{{$request['language']}}" />
                                                <input type="hidden" name="subject_id" value="{{$subject}}" />
                                            </div>
                                            <div class="col-lg-9">
                                                <div class="checkboxes d-flex justify-content-center">
                                                    {{-- @if(isset($days))
                                                        @if(count($days)>0)
                                                            @foreach($days as $day)     
                                                                <input type="checkbox" name="" id="1adm" value="selected">
                                                                <label for="1adm" class="highlight">{{$day}}</label><br>
                                                            @endforeach
                                                        @endif
                                                    @endif --}}
                                                    <input type="checkbox" name="day[]" id="monday_{{$subject}}" value="monday" >
                                                    <label for="monday_{{$subject}}" class="highlight">Monday</label>
                                                    <br>
                                                    <input type="checkbox" name="day[]" id="tuesday_{{$subject}}" value="tuesday" >
                                                    <label for="tuesday_{{$subject}}" class="highlight">Tuesday</label>
                                                    <br>
                                                    <input type="checkbox" name="day[]" id="wednesday_{{$subject}}" value="wednesday" >
                                                    <label for="wednesday_{{$subject}}" class="highlight">Wednesday</label>
                                                    <br>
                                                    <input type="checkbox" name="day[]" id="thursday_{{$subject}}" value="thursday" >
                                                    <label for="thursday_{{$subject}}" class="highlight">Thursday</label>
                                                    <br>
                                                    <input type="checkbox" name="day[]" id="friday_{{$subject}}" value="friday" >
                                                    <label for="friday_{{$subject}}" class="highlight">Friday</label>
                                                    <br>
                                                    <input type="checkbox" name="day[]" id="saturday_{{$subject}}" value="saturday" >
                                                    <label for="saturday_{{$subject}}" class="highlight">Saturday</label>
                                                    <br>
                                                    <input type="checkbox" name="day[]" id="sunday_{{$subject}}" value="sunday" >
                                                    <label for="sunday_{{$subject}}" class="highlight">Sunday</label>
                                                    <br>
                                                    <input type="hidden" name="institute_assigned_class_id" value="{{$institute_assigned_class_id ?? '' }}" />
                                                    <button type="button" data-subject_id="{{$subject}}" class="btn btn-theme add_class">Add</button>
                                                   
                                                </div> 
                                                <div class="response_{{$subject}}"></div>
                                            </div>
                                        </div>
                                    </form>
                                @endforeach
                           @endif
                            <div class="text-center"><button class=" btn btn-theme" id="createClass">Create Class</button></div>
                          
                        </div>
                    </div>
                </div>
            </div>
        </div>  <!-- container-fluid -->
    </div> <!-- Page content Wrapper -->
</div><!-- content -->
<input type="hidden" id="create_class_post_url" value="{{route('admin.manage-institutes.create-class')}}" /> 
@endsection
@section('js')
    <script>
      var countAllSubjectsDaysSelected = 0;
        $(document).ready(function(){
            $('.add_class').click(function(){
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    }
                });
                let subject_id = $(this).data('subject_id'); 
                let form_data = $('#form_id_'+subject_id).serialize();
                let create_class_post_url = $('#create_class_post_url').val();
                $('.response_'+subject_id).html(''); 
                $.ajax({            
                    type:'POST',
                    url:create_class_post_url,
                    data:form_data,
                    success:function(return_data) { 
                        if(return_data.status == 'Success'){
                            countAllSubjectsDaysSelected += 1;
                            $('.response_'+subject_id).html('<p class="js_response_success">Added Successfully !!</p>');
                        }
                        else
                        {
                            $('.response_'+subject_id).html('<p class="js_response_error">'+return_data.error+'</p>');
                        }
                    }
                });
            });
            $('#createClass').click(function(){
              // if(countAllSubjectsDaysSelected == parseInt("{{count($request['subjects'])}}")){
              if($('.js_response_success').length == parseInt("{{count($request['subjects'])}}")){
                alert('Class Added Successfully');
                location.href="{{url('admin/manage-institutes/view-institute'.'/'.$request['id'])}}"
              } else{
                alert('Please select days for all subjects and click add button respectively.')
              }
            })
        });
    </script>
@endsection