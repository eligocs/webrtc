@extends('institute.layouts.app')
@section('page_heading', 'Detail Page')
@section('content')
<style>
i.fa.fa-paperclip {
    font-size: 20px;
    margin-top: 14px;
}
.upload_file {position: relative;}

.upload_file i {font-size: 20px !important;}

.upload_file input[type="file"] {height: 20px;width: 20px;position: absolute;top: 15px;left: 68px;opacity: 0;}
.w-100.text-center.col-6 {
    padding-top: 10px;
    width: 50%; 
    margin-right: auto;
    margin-left: auto;
}
i.fa.fa-edit { 
    margin-left: -26px;
    margin-top: 60px;
    color: #369ec7;
}
.text-center.text-orange {
    color: #ef9f28;
}
</style>
<div class="container-fluid">
    <div>{{ Breadcrumbs::render('detail', request()->i_a_c_s_id, request()->subject_id) }}</div>
    <div class="row">
        
        <div class="col-xl-12 col-md-12 col-sm-12">
            <div class="card-box position-relative">
                <h3 class="heading-title mt-0 mb-0 text-center heading">{{ $subject->name }}</h3>
                <h4 class=" mt-0 mb-0 text-center fw-100">
                    @php
                    $iacs = \App\Models\InstituteAssignedClassSubject::findOrFail(request()->i_a_c_s_id);
                    $iac = $iacs->institute_assigned_class;  
                    
                    $period = new DatePeriod(new DateTime($iac->start_date->format('Y-m-d')), new DateInterval('P1D'),
                    new DateTime($iac->end_date->modify('+1 day')->format('Y-m-d')));
                    $lecture_dates = [];
                    foreach ($period as $key => $value) {
                    foreach ($iacs->subjects_infos->pluck('day')->toArray() as $key1 => $day) {
                    if ($day === strtolower($value->format('l'))) {
                    $lecture_dates[] = $value->format('Y-m-d');
                    }
                    }
                    }
                    @endphp
                    {{ $iac->name }}
                </h4>


                @if ($errors->any())
                <div class="alert alert-danger  alert-dismissible">
                    <a type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </a>
                    @foreach ($errors->all() as $error)
                    {{ $error }}
                    @endforeach
                </div>
                @endif 
               <!--  <div class='w-70 text-center col-12 pt-3 px-5  px-sm-1 discription'>{{auth()->user()->institute->description ?? ''}}</div> -->
                <div class="card-box d-flex align-items-center justify-content-center">
                    <div id="live-btn">
                        @php
                        $segment1 = Request::segment(3);
                        $segment2 = Request::segment(4);
                        // dd($segment2);
                        @endphp
                        <a href="{{ url('/institute/listMeeting') . '/' . $segment1 . '/' . $segment2 }}" id="btn-2"
                            class="popup-button">Live Class</a>

                    </div>
                    <div
                    class="widget-detail-1  orange-gradient btn-style position-relative pl-2 pr-4 py-2 mr-2 d-flex">
                    <h4 class="font-weight-normal font-14 my-0 mr-1 text-white text-left ">View Demo</h4>
                    <div>
                        {{-- <a data-fancybox class="video-play-button fancybox-gallery" rel="video-gallery" href="https://www.youtube.com/watch?v=iuimHfnP5aU&list=PLWx-A6wseQ6n-i692JSWuNvZcNTV-ULZu"> --}}
                            @php
                            $video = $iacs->video ?? '';
                            if($video){
                            $video = $video && @unserialize($video) == true ? unserialize($video)[0] :'';
                            } 
                            @endphp
                            <a target='_blank' data-fan cybox class="video-play-button fancyb ox-gallery"
                                rel="video-gallery" href="{{ $video ?? '' }}">
                                <span></span>
                            </a>
                            <div id="video-overlay" class="video-overlay">
                                <a class="video-overlay-close">×</a>
                            </div>
                        </div>
                        {{-- <i class="fa fa-edit pull-right" onclick="$('#subject_video').trigger('click');"></i> --}}
                        {{-- <form action="{{route('admin.manage-institutes.uploadSubjectVideo')}}" method="post"
                        enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="institute_assigned_class_subject_id"
                        value="{{request()->i_a_c_s_id}}">
                        <input type="file" name="subject_video" id="subject_video" style="display: none;"
                        onchange="this.form.submit()">
                    </form> --}}
                </div>
                <i class="fa fa-edit   " data-id='{{$iacs->institute_assigned_class->id}}' data-toggle='modal' data-target='#addDemovideo'></i>
                &nbsp;&nbsp;
                @php
                    $Msyllabus = \App\Models\InstituteAssignedClassSubject::findOrFail(request()->i_a_c_s_id)->syllabus; 
                    $syllabus = $Msyllabus && @unserialize($Msyllabus) == true ? unserialize($Msyllabus) :'';

                    @endphp
                    @if ($syllabus && @unserialize($Msyllabus) == true)
                        <a href="{{$syllabus[0] ?? ''}}" class="green-gradient text-center btn-style text-white mr-1"
                        target="_blank">View
                        Syllabus</a> 
                    @else
                    <a href="#" class="green-gradient text-center btn-style text-white mr-1"
                        >No
                        Syllabus</a>
                    @endif
                    <form class=' syllabusform' action="{{ route('institute.addSyllabus', request()->i_a_c_s_id) }}"
                        method="post" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="institute_assigned_class" value='{{$iac->id ?? ""}}'>
                        <input type="hidden" name="institute_assigned_class_subject_id"
                            value="{{ request()->i_a_c_s_id }}">
                        <input type="file" name="syllabus" id="syllabus" style="display: none;" class='inputChange'
                            accept="application/pdf">
                        </form>
                        <i class="fa fa-edit   "    onclick="$('#syllabus').trigger('click');"></i>
                    {{-- <a href="" class=" green-gradient w-30 text-center btn-style text-white mr-1">Add Demo</a> --}}
                    {{-- <a href="" class=" blue-gradient w-30 text-center btn-style text-white">Switch Institute</a> --}}
                </div>   
                <div class='text-center text-orange'>{{!empty($iacs->video) && $iacs->videoApproval == 0 ? 'Content Under Approval': ''}}</div>
            </div>
        </div>
    </div>

    <div class="modal" id="addDemovideo">
        <div class="modal-dialog">
            <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Subject Demo Video</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">

                <form action="{{url('institute/subjectvideo')}}" method='post' enctype='multipart/form-data'>
                    @csrf()
                    <div class="form-group">
                        <label for="email">Video:</label>
                        <input type="file" name='video' class="form-control" required >
                        <input type="hidden" name='iacs_id' class="form-control"   value='{{$iacs->id}}'  accept="video/*">
                        <input type="hidden" name='institute_assigned_class' class="form-control"  value='{{$iac->id ?? ""}}'>
                    </div>
                  <!--   <div class="form-group">
                        <label for="desc">Description:</label>
                        <textarea type="text" class="form-control" placeholder="Enter description" value='' name='description' id="desc">{{$iacs->description ?? ""}}</textarea>
                    </div> --> 
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            
            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>

            </div>
        </div>
    </div>
    <!--end row-->
    <!-- tabs end -->
    <div class="row mx-0">
        <div class="col-md-9 pl-md-0">
            <div class="row mx-0  card-box schedule_inner">
                <div class="col-md-12">
                    <h4 class=" mt-0 mb-3 text-center fw-100">Class Schedule</h4>
                </div>
                @if ($getSubjectsInfo->count() > 0)

                @foreach (['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'] as
                $day)

                <div class="col-md-2 px-1 mb-1">
                    <div
                        class="{{ in_array($day, $getSubjectsInfo->pluck('day')->toArray()) ? 'theme-bg' : 'theme-outline-bg' }} m-0">
                        <h4
                            class="btn-style header-title font-13 m-0 text-center text-white {{ in_array($day, $getSubjectsInfo->pluck('day')->toArray()) ? '' : 'theme-clr' }}">
                            {{ $day ?? '' }}</h4>
                    </div>
                </div>

                @endforeach

                @else

                Not available days !!

                @endif


                {{-- <!-- end col -->
            <div class="col-md-2 px-1">
               <div class="theme-bg m-0">
                  <h4 class="btn-style header-title font-13 m-0 text-center text-white">Tuesday</h4>
               </div>
            </div>
            <!-- end col -->
            <div class="col-md-2 px-1">
               <div class="theme-bg m-0">
                  <h4 class="btn-style header-title font-13 m-0 text-center text-white">Wednesday</h4>
               </div>
            </div>
            <!-- end col -->
            <div class="col-md-2 px-1">
               <div class=" theme-outline-bg m-0">
                  <h4 class="btn-style header-title font-13 m-0 text-center theme-clr">Thursday</h4>
               </div>
            </div>
            <!-- end col -->
            <div class="col-md-2 px-1">
               <div class="theme-outline-bg m-0">
                  <h4 class="btn-style header-title font-13 m-0 text-center theme-clr">Friday</h4>
               </div>
            </div>
            <!-- end col -->
            <div class="col-md-2 px-1">
               <div class="theme-outline-bg m-0">
                  <h4 class="header-title font-13 m-0 text-center theme-clr btn-style">Saturday</h4>
               </div>
            </div> --}}
                <!-- end col -->
                <div class="col-md-12 px-1">
                    @foreach ($lecture_dates as $item)
                    @if (strtotime($item) >= time())
                    <h4 class=" mt-3 mb-0 text-center fw-100"><b>Next class on:</b>
                        <span class="theme-clr mx-1">{{ date('d/m/Y', strtotime($item)) }}</span><span
                            class="theme-clr mr-1">{{ date('l', strtotime($item)) }}</span>
                        {{-- <span class="theme-clr mr-1">11:00 am</span> --}}
                        @break
                        @endif
                        @endforeach
                    </h4>
                </div>
            </div>
            <div class="card-box class_resources">
                <h4 class=" mt-0 mb-3 text-center fw-100">Class Resources</h4>
                <div class=" d-md-flex align-items-center">
                    <a class="btn orange-gradient py-2 mx-1 font-13 w-25 text-center text-white"
                        href="{{ route('institute.lectures.index', request()->i_a_c_s_id) }}">Lectures</a>
                    <a class="bbtn green-gradient py-2 mx-1 font-13 w-25 text-center text-white"
                        href="{{ route('institute.assignments.index', request()->i_a_c_s_id) }}">Assignments</a>
                    <a class="btn pink-gradient py-2 mx-1 font-13 w-20 text-center text-white"
                        href="{{ route('institute.doubts.index', request()->i_a_c_s_id) }}">Doubts <span
                            class='totalNotify'>{{ $doubtsnotify ? '(' . $doubtsnotify . ')' : '(0)' }}</span></a>
                    <a class="bbtn purple-gradient py-2 mx-1 font-13 w-25 text-center text-white"
                        href="{{ route('institute.topics.index', request()->i_a_c_s_id) }}">Tests</a>
                    <a class="btn sea-gradient py-2 mx-1 font-13 w-25 text-center text-white"
                        href="{{ route('institute.extra_classes.index', request()->i_a_c_s_id) }}">Extra
                        Classes</a>
                    {{-- <a class="btn purple-gradient py-2 mx-1 font-13 w-20 text-center text-white" href="view-extraclasses.html"></a> --}}
                </div>
            </div>

            <div class="card-box class_resources">
                <h4 class=" mt-0 mb-3 text-center fw-100">Class Notifications</h4>
                <div class=" ">
                    <form method='post'  action='{{ url("institute/create_notification") }}'>
						@csrf()
						<div  class='row' style='display:flex;' >
							<button class="btn orange-gradient font-13 w-25 text-center text-white col-3">Create</button>
							<input type='hidden' name='i_a_c_s' value='{{ request()->i_a_c_s_id }}'>
							<input type='hidden' name='type' value='text'>
							<textarea rows='3' name='message' class='form-control col-9' placeholder='Notification'
								type='text' required></textarea>
						</div>
						<div  class='row' style='display:flex;' >
							<div class='col-3'></div>
							<div class='col-9'>
								<div class="upload_file">
									<label>Pdf/Image</label>
									<i class='fa fa-paperclip'></i> 
									<input type='file' data-id='{{request()->i_a_c_s_id}}' data-class='{{$iacs->subject_id}}' class='attach_file'  name='file' value=''>
								</div>
							</div>
						</div>
                    </form>
                </div>
            </div>


        </div>
        <div class="col-md-3 card-box">
            <div>
                @php
                $institute_assigned_class_subject_teacher =
                \App\Models\InstituteAssignedClassSubjectTeacher::where(['institute_assigned_class_subject_id'
                =>
                request()->i_a_c_s_id])->first();
                $teacher_id = $institute_assigned_class_subject_teacher ?
                $institute_assigned_class_subject_teacher->teacher_id : '';
                if ($teacher_id) {
                $teacher = \App\Models\Teacher::find($teacher_id);
                }
                @endphp
                @if (!empty($teacher))
                <div class="client-img rounded-circle mx-auto avatar-xl overflow-hidden mb-2">
                    <img src="{{ URL::to('storage/' . $teacher->avatar) }}" class="img-thumbnail w-100"
                        alt="profile-image">
                </div>
                @endif
                {{-- {{dd($teacher_id)}} --}}
                {{-- {{dd($teacher)}} --}}
                @if (!empty($teacher))

                <h3 class=" mt-3 mb-0 text-center fw-100"><b>{{ $teacher->name }}</b></h3>
                <p class="text-center font-14 mt-1 mb-0"> {{ $teacher->qualifications }}</p>
                <p class="text-center font-14 mt-0"><b>Experience:</b><span
                        class="ml-1">{{ $teacher->experience }}</span></p>
                @endif
                {{-- <div class="mt-3 text-center">
                <a href="" class="btn-theme btn-style add_lecture-btn" data-toggle="modal" data-target="#exampleModal">Assign Teacher</a>
            </div> --}}
            </div>
        </div>
    </div>
    <!-- end row -->
    <!-- end row -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Create Lecture</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="card-box">
                        <form role="form" action="{{ route('admin.institute-subject.assignTeacher') }}" method="post"
                            enctype="multipart/form-data">
                            @csrf
                            {{-- <div class="form-group">
              <label for="class_id"> Select Class*</label>
              <select name="class_id" id="select0_id" class="select2" required>
                <option value="">Select Class</option>
                @foreach (\App\Models\InstituteClass::all() as $item)
                <option value="{{$item->id}}">{{$item->name}}</option>
                            @endforeach
                            </select>
                    </div> --}}
                    {{-- <div class="form-group">
              <label for="subject_id"> Select Subject*</label>
              <select name="subject_id" id="select1_id" class="select2" required>
                <option value="">Select Subject</option>
              </select>
            </div> --}}
                    <div class="form-group">
                        @php
                        $institute_assigned_class_id =
                        \App\Models\InstituteAssignedClassSubject::find(request()->i_a_c_s_id)->institute_assigned_class_id;
                        $institute_id =
                        \App\Models\InstituteAssignedClass::find($institute_assigned_class_id)->institute_id;
                        @endphp
                        <label for="unit_name"> Select to Assign Teacher*</label>
                        <input type="hidden" name="institute_assigned_class_subject_id"
                            value="{{ request()->i_a_c_s_id }}">
                        <select name="teacher_id" id="select2_id" class="select2" required>
                            <option value="">Select Teacher</option>
                            @foreach (\App\Models\Teacher::where('institute_id', $institute_id)->get() as
                            $elements)
                            <option value="{{ $elements->id }}">{{ $elements->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group text-center">
                        <button type="submit" class="btn btn-theme">Assign</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<!-- container -->
<script>

$(document).ready(function(){
	$(document).on('change','.attach_file',function(){
        console.log('tes')
		var formData = new FormData();
		formData.append('message', $(this)[0].files[0]);
		formData.append('type', 'pdf');
		formData.append('i_a_c_s', $(this).data('id'));
		formData.append('class', $(this).data('class'));
		formData.append('_token', '{{ csrf_token() }}');
		swal({
		  title: "Are you sure?",
		  text: "You want to share this file !!!",
		  icon: "warning",
		  buttons: true,
		  dangerMode: true,
		})
		.then((yes) => {
		  if (yes) {
			$.ajax({
				url: "{{ url('institute/create_notify') }}",
				type: 'post',
				dataType: 'json',
				data: formData,
				  async: false,
				  cache: false,
				  contentType: false,
				  enctype: 'multipart/form-data',
				  processData: false,
				success: function(response) { 
                    if(response){
						swal(response.message, {
						  icon: "success",
						});						
					}   
                    location.reload();
					 
				}
			})
		  } 
		}); 
	});
});
setInterval(getnotifies, 3000);

function getnotifies() {
    var id = "{{ request()->i_a_c_s_id }}";
    $.ajax({
        url: "{{ url('institute/getdoubts') }}",
        type: 'post',
        dataType: 'json',
        data: {
            iacs_id: id,
            segment: '{{ request()->segment(4) }}',
            _token: "{{ csrf_token() }}"
        },
        success: function(response) {
            $('.totalNotify').html('(' + response.count + ')');
        }
    })
}



function mobileCheck() {
    let check = false;
    (function(a) {
        if (/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino/i
            .test(a) ||
            /1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i
            .test(a.substr(0, 4))) check = true;
    })(navigator.userAgent || navigator.vendor || window.opera);
    return check;
};

function changeViewport() {
    console.log(mobileCheck());
    if (mobileCheck()) {
        document.querySelector('[name="viewport"]').setAttribute('content', 'width=device-width, initial-scale=0.3')
    } else {
        document.querySelector('[name="viewport"]').setAttribute('content', 'width=device-width, initial-scale=1.0')
    }
}

window.addEventListener('DOMContentLoaded', changeViewport);
window.addEventListener('resize', changeViewport);
</script>
@endsection