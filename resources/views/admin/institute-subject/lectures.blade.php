@extends('admin.layouts.app')
@section('page_heading', 'Lectures')
@section('content')

<!-- Start Content-->
<style>
form {
    display: block;
    margin: 20px auto;
    background: #eee;
    border-radius: 10px;
    padding: 15px
}

.progress {
    height: 20px;
    position: relative;
    width: 400px;
    border: 1px solid #ddd;
    padding: 1px;
    border-radius: 3px;
}

.bar {
    background-color: #B4F5B4;
    width: 0%;
    height: 20px;
    border-radius: 3px;
}

.percent {
    position: absolute;
    display: inline-block;
    top: 3px;
    left: 48%;
}

i.fa.fa-pencil {
    color: #644699;
    font-size: 20px;
}

i.fa.fa-trash {
    color: #bd1f1f;
    font-size: 20px;
}

i.fa.fa-arrow-left,
i.fa.fa-arrow-right {
    color: white;
    background: #644699;
    padding: 18px;
    border-radius: 28px;
}

.custom-arrows {
    display: flex;
    justify-content: center;
}

.custom-arrows1 {
    display: flex;
}
</style>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<!-- Modal -->
<div class="modal fade" id="lectureModal" tabindex="-1" role="dialog" aria-labelledby="lectureModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="lectureModalLabel">Lecture</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card-box">
                    <form role="form" id='lectureForm'>
                        @csrf
                        {{-- <div class="form-group">
                <label for="class_id"> Select Class*</label>
                <select name="class_id" id="select0_id" class="select2" required>
                  <option value="">Select Class</option>
                  @foreach (\App\Models\InstituteClass::all() as $item)
                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                        @endforeach
                        </select>
                </div> --}}
                <input name='i_assigned_class_subject_id' class='i_assigned_class_subject_id'
                    value='{{request()->iacs_id}}' type='hidden'>
                <input name='last_id' class='last_id' value='' type='hidden'>
                {{-- <div class="form-group">
                <label for="subject_id"> Select Subject*</label>
                <select name="subject_id" id="select1_id" class="select2" required>
                  <option value="">Select Subject</option>
                </select>
              </div> --}}
                <div class='inputFields'>
                    <div class="form-group">
                        <label for="unit_name"> Select Unit*</label>
                        <select name="unit_name" id="select2_id" class="select2 unit_name" required>
                            <option value="">Select Unit</option>
                            @foreach (\App\Models\Unit::where('institute_assigned_class_subject_id',
                            request()->iacs_id)->get() as $item)
                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="lecture_number">Lecture number*</label>
                        <input type="text" name="lecture_number" class="form-control" id="lecture_number" required>
                    </div>
                    <div class="form-group">
                        <label for="lecture_name">Lecture Name*</label>
                        <input type="text" name="lecture_name" class="form-control" id="lecture_name" required>
                    </div>
                    <div class="form-group">
                        <label for="lecture_date">Lecture Date*</label>
                        <input type="date" name="lecture_date" class="form-control" id="lecture_date" required
                            min="{{date('Y-m-d')}}">
                    </div>
                    <div class="form-group text-center">
                        <label for="notes">Lecture Notes* (Note : PDF File Only)</label>
                        <input type="file" name="notes" class="form-control" id="notes" required
                            accept="application/pdf">
                    </div>
                    <div class='oldPdf'>
                    </div>


                    <div class="form-group custom-arrows">
                        <!--  <i class='fa fa-arrow-left'></i>&nbsp;&nbsp; --> <i
                            class='showVideoInput fa fa-arrow-right'></i>
                    </div>
                </div>

                <div class="form-group videoInput" style='display:none;'>
                    <label for="lecture_video">Lecture Video (Can Upload Later)</label>
                    <input type="file" name="lecture_video" class="form-control dropzone" id="lecture_video"
                        accept="video/*">
                    <small><strong>(Note : .mp4, .mov, .ogg, .mpeg, .avi File Types Only)</strong></small>
                    <!--   <div class="progress">
            <div class="progress-bar" role="progressbar" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100" style="width:10%"></div>
          </div> -->
                    <div class='oldVideo'>
                    </div>
                </div>


            </div>


            <div class="form-group text-center create_Div" style='display:none;'>
                <div class="form-group custom-arrows">
                    <i class='goback fa fa-arrow-left'></i>
                </div>

                <!--  <button type="submit" class="btn btn-warning " id='cancleButton' style='display:none;' data-skip='true'>Cancel Upload</button> -->
                <!-- <div class="progress"  style='display: non e;'>
            <div class="bar"></div >
            <div id="uploadpercent">0%</div >
        </div> -->
                <button type="submit" class="btn btn-warning " id='cancleButton' style='display:none;'
                    data-skip='true'>Cancel Upload</button>
                <button type="submit" class="btn btn-warning createClicked" data-skip='true'>Skip Video</button>
                <button type="submit" class="btn btn-theme createClicked">Create</button><br>
                <div class="spinner-border text-primary loading" role="status" style='display:none;'>
                    <span class="sr-only">Loading...</span>
                </div>
            </div>
            </form>
        </div>
    </div>
</div>
</div>
</div>

<div class="container-fluid">
    @php
    $iacs = \App\Models\InstituteAssignedClassSubject::find(request()->iacs_id);
    $iac = $iacs->institute_assigned_class;
    @endphp
    <div class="card-box position-relative">
        <h3 class="heading-title m-0 text-center heading">Lectures</h3>
        <a href="" class="btn-theme btn-style add_lecture-btn" data-toggle="modal" data-target="#lectureModal">Add
            Lectures</a>
    </div>
    @foreach ($lecturesGroupedByUnits as $key => $unit)
    @if ($unit->lectures->count())
    <div class="card-box">
        <div class="table-responsive">
            <h4 class=" mt-0 mb-3 text-center fw-100">{{$unit->name}}</h4>
            <table class="table table-bordered mb-0 package-table">
                <thead>
                    <tr>
                        <th>
                            <h4 class="header-title m-0 text-center heading">Lecture Number</h4>
                        </th>
                        <th>
                            <h4 class="header-title m-0 text-center heading">Lecture Name</h4>
                        </th>
                        <th>
                            <h4 class="header-title m-0 text-center heading">Lecture Date</h4>
                        </th>
                        <th>
                            <h4 class="header-title m-0 text-center heading">Lecture Video</h4>
                        </th>
                        <th>
                            <h4 class="header-title m-0 text-center heading">Notes</h4>
                        </th>
                        <th style="width: 15%;">
                            <h4 class="header-title m-0 text-center heading">Actions</h4>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($unit->lectures as $lecture)
                    <tr>
                        <td scope="row" style="width: 10%;">{{ $lecture->lecture_number }}</td>
                        <td style="width: 45%;overflow-wrap: anywhere;">{{ $lecture->lecture_name }}</td>
                        <td>{{ date('d/m/Y', strtotime($lecture->lecture_date))}}</td>
                        <td style="width: 15%;">
                            @if(!empty($lecture->lecture_video) && @unserialize($lecture->lecture_video) ==true )
                            <?php $videodata = $lecture->lecture_video && @unserialize($lecture->lecture_video) ==true ? unserialize($lecture->lecture_video) :'';  ?>

                            <a class="btn-theme text-white btn-style justify-content-center text-center "
                                href="{{ $videodata ? $videodata[0] : '' }}" target="_blank">
                                <span class="text-video mr-1 text-capitalize text-white">Play</span> <i
                                    class="mdi mdi-play-circle"></i></a>
                            <!--  <a data-fancybox="" class="btn-theme text-white btn-style justify-content-center text-center fancybox-gallery"
                rel="video-gallery" href="{{ $lecture->lecture_video }}" target="_blank">
                <span class="text-video mr-1 text-capitalize text-white">Play</span> <i
                  class="mdi mdi-play-circle"></i></a>  -->
                            @else
                            <div class='videosDiv'>
                                <input type="file" name="videoFile" class="form-control videoFile"
                                    data-id='{{$lecture->id}}' id="" accept="video/*">
                                <div class='percent' style='display:none;'>10</div>
                                <div class="progress" style='display:none;'>
                                    <div class="progress-bar progress-bar-striped active" role="progressbar"
                                        aria-valuenow="10" aria-valuemin="0" aria-valuemax="100" style="width:10%">
                                    </div>
                                </div>
                                <button class="btn btn-danger cancleUpload" style='display:none;'><i
                                        class='fa fa-times'></i></button>
                            </div>
                            @endif
                        </td>
                        <td style="width: 15%;">
                            @if (!empty($lecture->notes) && @unserialize($lecture->notes)==true)
                            <?php $notesData = !empty($lecture->notes) && @unserialize($lecture->notes)==true ? unserialize($lecture->notes):''; ?>
                            <a class="btn-theme text-white btn-style justify-content-center text-center"
                                href="{{ !empty($notesData) ? $notesData[0] : '' }}" target="_blank">View</a>
                            @else
                            -
                            @endif
                        </td>
                        <td style="width: 15%;">
                            <a class="editLecture" data-id='{{$lecture->id}}'><i class="fa fa-pencil"
                                    aria-hidden="true"></i></a>&nbsp;&nbsp;&nbsp;
                            <a class="text-reds deleteLecture" data-id='{{$lecture->id}}'><i
                                    class='fa fa-trash'></i></a>
                        </td>
                        <!-- <td scope="row">{{$lecture->lecture_number}}</td>
            <td>{{$lecture->lecture_name}}</td>
            <td>{{date('d/m/Y', strtotime($lecture->lecture_date))}}</td>
            <td><a data-fancybox=""
                class="btn-theme text-white btn-style justify-content-center text-center fancybox-gallery"
                rel="video-gallery" href="{{url($lecture->lecture_video)}}" target="_blank">
                <span class="text-video mr-1 text-capitalize text-white">Play</span> <i
                  class="mdi mdi-play-circle"></i></a></td>
            <td><a class="btn-theme text-white btn-style justify-content-center text-center"
                href="{{url($lecture->notes??'')}}" target="_blank">Download</a></td> -->
                    </tr>
                    @endforeach
                    {{-- <tr>
            <td scope="row">Lecture 2</td>
            <td>Basics Of Kinetic</td>
            <td>26/03/2020</td>
            <td><a data-fancybox=""
                class="btn-theme text-white btn-style justify-content-center text-center fancybox-gallery"
                rel="video-gallery"
                href="https://www.youtube.com/watch?v=iuimHfnP5aU&amp;list=PLWx-A6wseQ6n-i692JSWuNvZcNTV-ULZu">
                <span class="text-video mr-1 text-capitalize text-white">View lecture</span> <i
                  class="mdi mdi-play-circle"></i></a></td>
          </tr> --}}
                    {{-- <tr>
            <td scope="row">Lecture 3</td>
            <td>Basics Of Kinetic</td>
            <td>27/03/2020</td>
            <td><a data-fancybox=""
                class="btn-theme text-white btn-style justify-content-center text-center fancybox-gallery"
                rel="video-gallery"
                href="https://www.youtube.com/watch?v=iuimHfnP5aU&amp;list=PLWx-A6wseQ6n-i692JSWuNvZcNTV-ULZu">
                <span class="text-video mr-1 text-capitalize text-white">View lecture</span> <i
                  class="mdi mdi-play-circle"></i></a></td>
          </tr> --}}
                </tbody>
            </table>
        </div>
    </div>
    @endif
    @endforeach
    {{-- <div class="card-box">
    <div class="table-responsive">
      <h4 class=" mt-0 mb-3 text-center fw-100">Unit 2: Kinematics</h4>
      <table class="table table-bordered mb-0 package-table">
        <thead>
          <tr>
            <th>
              <h4 class="header-title m-0 text-center heading">Lecture Number</h4>
            </th>
            <th>
              <h4 class="header-title m-0 text-center heading">Lecture Name</h4>
            </th>
            <th>
              <h4 class="header-title m-0 text-center heading">Lecture Date</h4>
            </th>
            <th>
              <h4 class="header-title m-0 text-center heading">Action</h4>
            </th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td scope="row">Lecture 1</td>
            <td>Basics Of kinematics</td>
            <td>28/03/2020</td>
            <td><a data-fancybox=""
                class="btn-theme text-white btn-style justify-content-center text-center fancybox-gallery"
                rel="video-gallery"
                href="https://www.youtube.com/watch?v=iuimHfnP5aU&amp;list=PLWx-A6wseQ6n-i692JSWuNvZcNTV-ULZu">
                <span class="text-video mr-1 text-capitalize text-white">View lecture</span> <i
                  class="mdi mdi-play-circle"></i></a></td>
          </tr>
          <tr>
            <td scope="row">Lecture 2</td>
            <td>Basics Of kinematics</td>
            <td>29/03/2020</td>
            <td><a data-fancybox=""
                class="btn-theme text-white btn-style justify-content-center text-center fancybox-gallery"
                rel="video-gallery"
                href="https://www.youtube.com/watch?v=iuimHfnP5aU&amp;list=PLWx-A6wseQ6n-i692JSWuNvZcNTV-ULZu">
                <span class="text-video mr-1 text-capitalize text-white">View lecture</span> <i
                  class="mdi mdi-play-circle"></i></a></td>
          </tr>
          <tr>
            <td scope="row">Lecture 3</td>
            <td>Basics Of kinematics</td>
            <td>31/03/2020</td>
            <td><a data-fancybox=""
                class="btn-theme text-white btn-style justify-content-center text-center fancybox-gallery"
                rel="video-gallery"
                href="https://www.youtube.com/watch?v=iuimHfnP5aU&amp;list=PLWx-A6wseQ6n-i692JSWuNvZcNTV-ULZu">
                <span class="text-video mr-1 text-capitalize text-white">View lecture</span> <i
                  class="mdi mdi-play-circle"></i></a></td>
          </tr>
        </tbody>
      </table>
    </div>
  </div> --}}
</div> <!-- container -->
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Create Lecture</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card-box">
                    <form role="form" action="{{url('/admin/lectures/store')}}" method="post"
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
                    <label for="unit_name"> Select Unit*</label>
                    <select name="unit_name" id="select2_id" class="select2" required>
                        <option value="">Select Unit</option>
                        @foreach (\App\Models\Unit::where('institute_assigned_class_subject_id',
                        request()->iacs_id)->get() as $item)
                        <option value="{{$item->name}}">{{$item->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="lecture_number">Lecture number*</label>
                    <input type="text" name="lecture_number" class="form-control" id="lecture_number" required>
                </div>
                <div class="form-group">
                    <label for="lecture_name">Lecture Name*</label>
                    <input type="text" name="lecture_name" class="form-control" id="lecture_name" required>
                </div>
                <div class="form-group">
                    <label for="lecture_video">Lecture Video*</label>
                    <input type="file" name="lecture_video" class="form-control" id="lecture_video" required>
                </div>
                <div class="form-group">
                    <label for="notes">Lecture Notes*</label>
                    <input type="file" name="notes" class="form-control" id="notes" required>
                </div>
                <div class="form-group text-center">
                    <button type="submit" class="btn btn-theme">Create</button>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>
</div>
@endsection
@push('js')
{{-- <script src="{{ URL::to('assets/admin/js/jquery-validate.js')}}"></script>
<script src="{{ URL::to('assets/admin/js/add-institute.js')}}"></script> --}}
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script>
$(document).ready(function() {

    var jqXHR;
    $('.createClicked').click(function(e) {
        e.preventDefault();
        var $this = $(this);
        var skip = $(this).data('skip');
        if (skip == true) {
            $("#cancleButton").hide();
        } else {
            $("#cancleButton").show();
            $this.after(
                '<div class="progress"><div class="bar"></div><div id="uploadpercent">0%</div> </div>'
            );
        }
        $(".loading").show();
        $(".progress").show();
        $('.createClicked').attr('disabled', true);
        $(".close").hide();
        var data = new FormData();
        data.append('notes', $('#notes').get(0).files.length > 0 ? $('#notes').get(0).files[0] : '');
        data.append('lecture_video', $('#lecture_video').get(0).files.length > 0 ? $('#lecture_video')
            .get(0).files[0] : '');
        data.append('unit_name', $('.unit_name').val());
        data.append('last_id', $('.last_id').val());
        data.append('lecture_name', $('#lecture_name').val());
        data.append('lecture_number', $('#lecture_number').val());
        data.append('lecture_date', $('#lecture_date').val());
        data.append('i_assigned_class_subject_id', $('.i_assigned_class_subject_id').val());
        jqXHR = $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'POST',
            url: '{{ url("admin/lectures/store") }}',
            data: data,
            xhr: function() {
                var myXhr = $.ajaxSettings.xhr();
                if (myXhr.upload) {
                    myXhr.upload.addEventListener('progress', function(event) {
                        if (event.lengthComputable) {
                            var percent = event.loaded / event.total;
                            $('#uploadpercent').html(Math.round(percent * 100) +
                                "%");
                        }
                    }, false);
                }
                return myXhr;
            },
            success: function(response) {
                $('#uploadpercent').html("100%");
                setTimeout(() => {
                    $('.progress').hide();
                    $(".loading").hide();
                    $(".close").show();
                    $('.createClicked').hide();
                    $("#cancleButton").hide();
                    if ($('.last_id').val()) {
                        $this.after(
                            '<br><span class="alert alert-success text-green">Lecture Updated Successfully</span>'
                        );
                    } else {
                        $this.after(
                            '<br><span class="alert alert-success text-green">Lecture Created Successfully</span>'
                        );
                    }
                    setTimeout(() => {
                        window.location.reload();
                    }, 1000);
                }, 1000);
            },
            error: function(_jqXHR, textStatus) {
                $('.progress').remove();
                $(".loading").hide();
                $(".close").show();
                $('.createClicked').show();
                $('.createClicked').attr('disabled', false);
                $("#cancleButton").hide();

                var errors = _jqXHR.responseJSON ? _jqXHR.responseJSON : '';
                console.log(errors.errors)
                if (errors.errors.notes) {
                    $this.before(
                        '<br><div class="alert alert-danger"><a type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></a>Notes file error : Please select only PDF file for notes</div>'
                    );
                }
                if (errors.errors.lecture_video) {
                    $this.before(
                        '<div class="alert alert-danger"><a type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></a>Video file error : Please select only .mp4, .mov, .ogg, .mpeg, .avi file types for video</div>'
                    );
                }
            },
            cache: false,
            contentType: false,
            processData: false
        });
    });

    $('#cancleButton').click(function() {
        if (jqXHR) {
            jqXHR.abort();
        }
        $(".loading").hide();
        $("form")[0].reset()
        $(".progress").hide();
    });



    $('.deleteLecture').click(function(e) {
        e.preventDefault();
        var id = $(this).data('id');

        swal({
                title: "Are you sure?",
                text: "Once deleted, you will not be able to recover!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        url: "{{ url('admin/lectures/delete') }}",
                        method: "post",
                        data: {
                            id: id
                        },
                        success: function(response) {
                            if (response.status = true) {
                                swal("Lecture deleted successfully", {
                                    icon: "success",
                                });
                                setTimeout(() => {
                                    window.location.reload();
                                }, 2000);
                            } else {
                                swal("Something wend wrong,try again later !!!");
                            }
                        }
                    });
                }
            });


    });


    var jqXHR1;
    $('.videoFile').change(function(e) {
        e.preventDefault();
        $this = $(this);
        $this.parent('.videosDiv').find('.cancleUpload').show();
        $this.after(
            '<div class="progress"><div class="bar"></div><div id="uploadpercent">0%</div> </div>');
        var id = $(this).data('id');
        let video = $(this)[0].files[0];
        var data = new FormData();
        data.append("lecture_video", video);
        data.append("id", id);

        jqXHR1 = $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "POST",
            url: "{{ url('admin/lectures/addvideo') }}",
            data: data,
            xhr: function() {
                var myXhr = $.ajaxSettings.xhr();
                if (myXhr.upload) {
                    myXhr.upload.addEventListener('progress', function(event) {
                        if (event.lengthComputable) {
                            var percent = event.loaded / event.total;
                            $('#uploadpercent').html(Math.round(percent * 100) +
                                "%");
                        }
                    }, false);
                }
                return myXhr;
            },
            success: function(response) {
                $('#uploadpercent').html("100%");
                if (response.status == true) {
                    $this.after(
                        '<span class="text-green">Video Uploaded Successfully</span>');
                } else {
                    $this.after(
                        '<span class="text-red">Failes to upload video, Try again</span>'
                    );
                }
                setTimeout(() => {
                    $('.videosDiv').hide();
                    window.location.reload();
                }, 500);
            },
            error: function(_jqXHR, textStatus) {
                var errors = _jqXHR.responseJSON ? _jqXHR.responseJSON : '';
                if (errors.errors.lecture_video) {
                    $this.before(
                        '<br><div class="alert alert-danger"><a type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></a>Video file error : Please select only .mp4, .mov, .ogg, .mpeg, .avi file types for video</div>'
                    );
                }
                $this.parent('.videosDiv').find('.cancleUpload').hide();
                $('.progress').remove();
            },
            cache: false,
            contentType: false,
            processData: false
        });
    });

    $('.cancleUpload').click(function() {
        if (jqXHR1) {
            jqXHR1.abort();
        }
        $(this).hide();
        $(".videoFile").val('');
        $(".progress").hide();
        window.location.reload();

    });


    $('.add_lecture-btn').click(function(e) {
        $('.text-red').remove();
        $('.last_id').val('');
        $('#select2_id').val('').trigger('change');
        $('#lecture_number').val('');
        $('#lecture_name').val('');
        $('#lecture_date').val('');
        $('.oldPdf').html('');
        $('.oldVideo').html('');
    });


    $('.editLecture').click(function(e) {
        e.preventDefault();
        var id = $(this).data('id');
        $('.text-red').remove();
        $('.last_id').val('');
        $('#select2_id').val('').trigger('change');
        $('#lecture_number').val('');
        $('#lecture_name').val('');
        $('#lecture_date').val('');
        $('.oldPdf').html('');
        $('.oldVideo').html('');
        $('#notes').val('');
        $('#lecture_video').val('');
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "{{ url('admin/lectures/getLecture') }}",
            method: "post",
            data: {
                id: id
            },
            success: function(response) {
                console.log(response.lecture_date);
                if (response.status) {
                    $("#lectureModal").modal('show');
                    $('#select2_id').val(response.data.unit_id).trigger('change');
                    $('.last_id').val(response.data.id);
                    $('#lecture_number').val(response.data.lecture_number);
                    $('#lecture_name').val(response.data.lecture_name);
                    $('#lecture_date').val(response.lecture_date);
                    if (response.notes) {
                        $('.oldPdf').append('<a href="' + response.notes +
                            '" target="__blank"><i class="fa fa-eye"></i> Old File</a>');
                    }
                    if (response.video) {
                        $('.oldVideo').append('<a href="' + response.video +
                            '" target="__blank"><i class="fa fa-eye"></i> Old Video</a>'
                        );
                    }
                    /*  $('.oldPdf').append('<a href="' + response.data.notes +
                         '" target="__blank"><i class="fa fa-eye"></i> Old File</a>');
                     $('.oldVideo').append('<a href="' + response.data.lecture_video +
                         '" target="__blank"><i class="fa fa-eye"></i> Old Video</a>'); */
                }
            }
        })
    });




    $('input').change(function() {
        $('.text-red').remove();
    });

    $('.showVideoInput').click(function() {
        $('.text-red').remove();
        var err = 0;
        var last_id = $('.last_id').val();
        if (last_id == '') {
            if ($('#lecture_number').val() == '') {
                $('#lecture_number').after('<span class="text-red">Required</span>');
                err = 1;
            }
            if ($('#select2_id').val() == '') {
                $('#select2_id').after('<span class="text-red">Required</span>');
                err = 1;
            }
            if ($('#lecture_name').val() == '') {
                $('#lecture_name').after('<span class="text-red">Required</span>');
                err = 1;
            }
            if ($('#lecture_date').val() == '') {
                $('#lecture_date').after('<span class="text-red">Required</span>');
                err = 1;
            }
            if ($('#notes').val() == '') {
                $('#notes').after('<span class="text-red">Required</span>');
                err = 1;
            }
        }
        if (err == 0) {
            $(this).hide();
            $('.create_Div').show(400);
            $('.videoInput').show(400);
            $('.showVideoInput').show(400);
            $('.inputFields').hide(300);
        }
    });
    $('.goback').click(function() {
        $('.text-red').remove();
        $('.create_Div').hide(300);
        $('.videoInput').hide(300);
        $('.inputFields').show(400);
    });


    var select2 = $('#select2_id').select2({
        tags: true,
        insertTag: function(data, tag) {
            tag.text = tag.text + "(new)";
            data.push(tag);
        },
    }).on('select2:select', function() {
        if ($(this).find("option:selected").data("select2-tag") == true) {
            $.ajax({
                url: "{{url('admin/lectures/addUnit')}}",
                method: "post",
                dataType: "json",
                data: {
                    i_assigned_class_subject_id: "{{request()->iacs_id}}",
                    name: $(this).find("option:selected").val(),
                    _token: "{{csrf_token()}}"
                },
                success: function(response) {
                    // alert(response.status);
                    if (response.status) {
                        $(this).find("option:selected").val(response.data.id);
                        $(this).find("option:selected").text(response.data.name);
                    }
                }
            })
        }
        // language: {
        //   noResults: function(text) {
        //   return 'No Result Found<a href="javascript:void(0)" onclick="noResultsButtonClicked()" style="float: right;">Create Unit '+text+' <i class="fa fa-plus-circle"></i></a>';
        //   },
        // },
        // escapeMarkup: function(markup) {
        //   return markup;
        // },
    });

    $('#select0_id').on('change', function() {
        $.ajax({
            url: "{{route('institute.lectures.getSubjectsByClassId', request()->iacs_id)}}",
            method: 'get',
            dataType: 'json',
            data: {
                id: $(this).val()
            },
            success: function(response) {
                if (response.status) {
                    let html = '';
                    for (x in response.data) {
                        html +=
                            `<option value="${response.data[x].id}">${response.data[x].name}</option>`;
                    }
                    $('#select1_id').html(html);
                }
            }
        });
    });
    $('#select0_id, #select1_id').on('change', function() {
        $.ajax({
            url: "{{route('institute.lectures.getUnits', request()->iacs_id)}}",
            method: 'get',
            dataType: 'json',
            data: {
                class_id: $('#select0_id').val(),
                subject_id: $(this).val()
            },
            success: function(response) {
                if (response.status) {
                    let html = '';
                    for (x in response.data) {
                        html +=
                            `<option value="${response.data[x].id}">${response.data[x].name}</option>`;
                    }
                    $('#select2_id').html(html);
                }
            }
        })
    })
});
</script>
@endpush