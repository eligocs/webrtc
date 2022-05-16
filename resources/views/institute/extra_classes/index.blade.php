@extends('institute.layouts.app')
@section('page_heading', 'Extra Classes')
@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
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
<!-- Start Content-->
<div class="container-fluid">
    {{ Breadcrumbs::render('extra_classes', request()->i_assigned_class_subject_id) }}
    <div class="card-box position-relative">
        <h3 class="heading-title m-0 text-center heading">Extra Classes</h3>
        <a href="" class="btn-theme btn-style add_extra_class-btn" data-toggle="modal" data-target="#lectureModal">Add
            Extra Classes</a>
    </div>
    @foreach ($extra_classesGroupedByUnits as $key => $unit)
    @if ($unit->extra_classes->count())
    <div class="card-box">
        <div class="table-responsive">
            <h4 class=" mt-0 mb-3 text-center fw-100">{{ $unit->name }}</h4>
            <table class="table table-bordered mb-0 package-table w-800">
                <thead>
                    <tr>
                        <th>
                            <h4 class="header-title m-0 text-center heading">Extra Class Number</h4>
                        </th>
                        <th>
                            <h4 class="header-title m-0 text-center heading">Extra Class Name</h4>
                        </th>
                        <th>
                            <h4 class="header-title m-0 text-center heading">Extra Class Date</h4>
                        </th>
                        <th>
                            <h4 class="header-title m-0 text-center heading">Extra Class Video</h4>
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
                    @foreach ($unit->extra_classes as $extra_class)
                    <tr>
                        <td scope="row">{{ $extra_class->extra_class_number }}</td>
                        <td>{{ $extra_class->extra_class_name }}</td>
                        <td>{{ date('m/d/Y', strtotime($extra_class->extra_class_date)) }}</td>
                        <td style="width: 15%;">
                            @if (!empty($extra_class->extra_class_video) &&
                            @unserialize($extra_class->extra_class_video) == true)
                            <?php $videodata = $extra_class->extra_class_video && @unserialize($extra_class->extra_class_video) ? unserialize($extra_class->extra_class_video) :'';  ?>
                            <a class="btn-theme text-white btn-style justify-content-center text-center "
                                rel="video-gallery" href="{{ $videodata ? $videodata[0] : '' }}" target="_blank">
                                <span class="text-video mr-1 text-capitalize text-white">Play</span> <i
                                    class="mdi mdi-play-circle"></i></a>
                            @else
                            <div class='videosDiv'>
                                <input type="file" name="videoFile" class="form-control videoFile"
                                    data-id='{{$extra_class->id}}' id="" accept="video/*">
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
                        <td>
                            @if (!empty($extra_class->notes) && @unserialize($extra_class->notes) == true)
                            <?php $notesData = unserialize($extra_class->notes); ?>
                            <a class="btn-theme text-white btn-style justify-content-center text-center"
                                href="{{ $notesData[0] ? $notesData[0] : '' }}" target="_blank">View</a>
                            @else
                            -
                            @endif
                        </td>
                        <td style="width: 15%;">
                            <a class="editLecture" data-id='{{$extra_class->id}}'><i class="fa fa-pencil"
                                    aria-hidden="true"></i></a>&nbsp;&nbsp;&nbsp;
                            <a class="text-reds deleteLecture" data-id='{{$extra_class->id}}'><i
                                    class='fa fa-trash'></i></a>
                        </td>
                    </tr>
                    @endforeach
                    {{-- <tr>
                  <td scope="row">Extra Class 2</td>
                  <td>Basics Of Kinetic</td>
                  <td>26/03/2020</td>
                  <td><a data-fancybox=""
                      class="btn-theme text-white btn-style justify-content-center text-center fancybox-gallery"
                      rel="video-gallery"
                      href="https://www.youtube.com/watch?v=iuimHfnP5aU&amp;list=PLWx-A6wseQ6n-i692JSWuNvZcNTV-ULZu">
                      <span class="text-video mr-1 text-capitalize text-white">View extra_class</span> <i
                        class="mdi mdi-play-circle"></i></a></td>
                </tr> --}}
                    {{-- <tr>
                  <td scope="row">Extra Class 3</td>
                  <td>Basics Of Kinetic</td>
                  <td>27/03/2020</td>
                  <td><a data-fancybox=""
                      class="btn-theme text-white btn-style justify-content-center text-center fancybox-gallery"
                      rel="video-gallery"
                      href="https://www.youtube.com/watch?v=iuimHfnP5aU&amp;list=PLWx-A6wseQ6n-i692JSWuNvZcNTV-ULZu">
                      <span class="text-video mr-1 text-capitalize text-white">View extra_class</span> <i
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
                <h4 class="header-title m-0 text-center heading">Extra Class Number</h4>
              </th>
              <th>
                <h4 class="header-title m-0 text-center heading">Extra Class Name</h4>
              </th>
              <th>
                <h4 class="header-title m-0 text-center heading">Extra Class Date</h4>
              </th>
              <th>
                <h4 class="header-title m-0 text-center heading">Action</h4>
              </th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td scope="row">Extra Class 1</td>
              <td>Basics Of kinematics</td>
              <td>28/03/2020</td>
              <td><a data-fancybox=""
                  class="btn-theme text-white btn-style justify-content-center text-center fancybox-gallery"
                  rel="video-gallery"
                  href="https://www.youtube.com/watch?v=iuimHfnP5aU&amp;list=PLWx-A6wseQ6n-i692JSWuNvZcNTV-ULZu">
                  <span class="text-video mr-1 text-capitalize text-white">View extra_class</span> <i
                    class="mdi mdi-play-circle"></i></a></td>
            </tr>
            <tr>
              <td scope="row">Extra Class 2</td>
              <td>Basics Of kinematics</td>
              <td>29/03/2020</td>
              <td><a data-fancybox=""
                  class="btn-theme text-white btn-style justify-content-center text-center fancybox-gallery"
                  rel="video-gallery"
                  href="https://www.youtube.com/watch?v=iuimHfnP5aU&amp;list=PLWx-A6wseQ6n-i692JSWuNvZcNTV-ULZu">
                  <span class="text-video mr-1 text-capitalize text-white">View extra_class</span> <i
                    class="mdi mdi-play-circle"></i></a></td>
            </tr>
            <tr>
              <td scope="row">Extra Class 3</td>
              <td>Basics Of kinematics</td>
              <td>31/03/2020</td>
              <td><a data-fancybox=""
                  class="btn-theme text-white btn-style justify-content-center text-center fancybox-gallery"
                  rel="video-gallery"
                  href="https://www.youtube.com/watch?v=iuimHfnP5aU&amp;list=PLWx-A6wseQ6n-i692JSWuNvZcNTV-ULZu">
                  <span class="text-video mr-1 text-capitalize text-white">View extra_class</span> <i
                    class="mdi mdi-play-circle"></i></a></td>
            </tr>
          </tbody>
        </table>
      </div>
    </div> --}}
</div> <!-- container -->
<!-- Modal -->
<div class="modal fade" id="lectureModal" tabindex="-1" role="dialog" aria-labelledby="lectureModallLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="lectureModallLabel">Extra Class</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card-box">
                    <form role="form"
                        action="{{ route('institute.extra_classes.store', request()->i_assigned_class_subject_id) }}"
                        method="post" enctype="multipart/form-data">
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
                {{-- <div class="form-group">
                <label for="subject_id"> Select Subject*</label>
                <select name="subject_id" id="select1_id" class="select2" required>
                  <option value="">Select Subject</option>
                </select>
              </div> --}}
                <input name='last_id' class='last_id' value='' type='hidden'>
                <div class='inputFields'>
                    <div class="form-group">
                        <label for="unit_name"> Select Unit*</label>
                        <select name="unit_name" id="select2_id" class="select2 unit_name" required>
                            <option value="">Select Unit</option>
                            @foreach (\App\Models\Unit::where('institute_assigned_class_subject_id',
                            request()->i_assigned_class_subject_id)->get() as $item)
                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="extra_class_number">Lecture number*</label>
                        <input type="text" name="extra_class_number" class="form-control" id="extra_class_number"
                            required>
                    </div>
                    <div class="form-group">
                        <label for="extra_class_name">Lecture Name*</label>
                        <input type="text" name="extra_class_name" class="form-control" id="extra_class_name" required>
                    </div>
                    <div class="form-group">
                        <label for="lecture_date">Lecture Date*</label>
                        <input type="date" name="lecture_date" class="form-control" id="lecture_date" required
                            min="{{date('Y-m-d')}}">
                    </div>
                    <div class="form-group t ext-center">
                        <label for="notes">Lecture Notes* (Note : PDF File Only) </label>
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
                    <label for="lecture_video">Lecture Video (Can Upload Later) </label>
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

                <button type="submit" class="btn btn-warning" id='cancleButton' style='display:none;'
                    data-skip='true'>Cancel Upload</button>
                <button type="submit" class="btn btn-warning createClicked" data-skip='true'>Skip Video</button>
                <button type="submit" class="btn btn-theme createClicked">Create</button><br>
                <div class="spinner-border text-primary loading" role="status" style='display:none;'>
                    <span class="sr-only">Loading...</span>
                </div>
            </div> 
            <!--  <div class="form-group">
          <label for="unit_name"> Select Unit*</label>
          <select name="unit_name" id="select2_id" class="select2" required>
            <option value="">Select Unit</option>
            @foreach (\App\Models\Unit::where('institute_assigned_class_subject_id',
            request()->i_assigned_class_subject_id)->get() as $item)
            <option value="{{ $item->name }}">{{ $item->name }}</option>
            @endforeach
          </select>
        </div>
        <div class="form-group">
          <label for="extra_class_number">Extra Class number*</label>
          <input type="text" name="extra_class_number" class="form-control" id="extra_class_number" required>
        </div>
        <div class="form-group">
          <label for="extra_class_name">Extra Class Name*</label>
          <input type="text" name="extra_class_name" class="form-control" id="extra_class_name" required>
        </div>
        <div class="form-group">
          <label for="extra_class_video">Extra Class Video*</label>
          <input type="file" name="extra_class_video" class="form-control" id="extra_class_video" required>
        </div>
        <div class="form-group">
          <label for="lecture_date">Lecture Date*</label>
          <input type="date" name="lecture_date" class="form-control" id="lecture_date" required>
        </div>
        <div class="form-group">
          <label for="notes">Extra Class Notes*</label>
          <input type="file" name="notes" class="form-control" id="notes" required>
        </div>
        <div class="form-group text-center">
          <button type="submit" class="btn btn-theme">Create</button>
        </div> -->
            </form>
        </div>
    </div>
</div>
</div>
</div>
{{-- <input type="hidden" id="add_new_institute_form_url"
    value="{{ route('institute.extra_classes.store') }}" /> --}}
@endsection
@push('js')
{{-- <script src="{{ URL::to('assets/admin/js/jquery-validate.js') }}"></script>
<script src="{{ URL::to('assets/admin/js/add-institute.js') }}"></script> --}}
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script>
$(document).ready(function() {

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
                        url: "{{ url('institute/extra_classes/delete') }}",
                        method: "post",
                        data: {
                            id: id
                        },
                        success: function(response) {
                            if (response.status = true) {
                                swal("Extra Class deleted successfully", {
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

    $('.editLecture').click(function(e) {
        e.preventDefault();
        var id = $(this).data('id');
        $('.text-red').remove();
        $('.last_id').val('');
        $('#select2_id').val('').trigger('change');
        $('#extra_class_number').val('');
        $('#extra_class_name').val('');
        $('#lecture_date').val('');
        $('.oldPdf').html('');
        $('.oldVideo').html('');
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "{{ url('institute/extra_classes/getLecture') }}",
            method: "post",
            data: {
                id: id
            },
            success: function(response) {
                if (response.status) {
                    $("#lectureModal").modal('show');
                    $('#select2_id').val(response.data.unit_id).trigger('change');
                    $('.last_id').val(response.data.id);
                    $('#extra_class_number').val(response.data.extra_class_number);
                    $('#extra_class_name').val(response.data.extra_class_name);
                    var classDate = response.data.extra_class_date.split(' ');
                    $('#lecture_date').val(classDate[0]);
                    if (response.notes) {
                        $('.oldPdf').append('<a href="' + response.notes +
                            '" target="__blank"><i class="fa fa-eye"></i> Old File</a>');
                    }
                    if (response.video) {
                        $('.oldVideo').append('<a href="' + response.video +
                            '" target="__blank"><i class="fa fa-eye"></i> Old Video</a>'
                        );
                    }
                    /* var notes = response.data.notes ? response.data.notes : '';
                    if (notes) {
                        $('.oldPdf').append('<a href="' + notes +
                            '" target="__blank"><i class="fa fa-eye"></i> Old File</a>');
                    }
                    var video = response.data.lecture_video ? response.data.lecture_video :
                        '';
                    if (video) {
                        $('.oldVideo').append('<a href="' + video +
                            '" target="__blank"><i class="fa fa-eye"></i> Old Video</a>'
                        );
                    } */
                }
            }
        })
    });

    $('input').change(function() {
        $('.text-red').remove();
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
        data.append("extra_class_video", video);
        data.append("id", id);

        jqXHR1 = $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "POST",
            url: "{{ route('institute.extra_classes.updvideo',request()->i_assigned_class_subject_id) }}",
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
                    setTimeout(() => {
                        $('.videosDiv').hide();
                        window.location.reload();
                    }, 500);
                } else {
                    $this.after(
                        '<span class="text-red">Failed to upload video, Try again</span>'
                    );
                }
            },
            error: function(_jqXHR, textStatus) {
                var errors = _jqXHR.responseJSON ? _jqXHR.responseJSON : '';
                if (errors.errors.extra_class_video) {
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
        data.append('notes', $('#notes').get(0).files[0] ? $('#notes').get(0).files[0] : '');
        data.append('extra_class_video', $('#lecture_video').get(0).files.length > 0 ? $(
            '#lecture_video').get(0).files[0] : '');
        //data.append('unit_name',$('#select2_id').val());
        data.append('unit_name', $('.unit_name').val());
        data.append('last_id', $('.last_id').val());
        data.append('extra_class_name', $('#extra_class_name').val());
        data.append('extra_class_number', $('#extra_class_number').val());
        data.append('lecture_date', $('#lecture_date').val());
        jqXHR = $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'POST',
            url: '{{ route("institute.extra_classes.store", request()->i_assigned_class_subject_id) }}',
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
                    $('.progress').hide().remove();
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
                /* if($('.last_id').val()){ */
                var errors = _jqXHR.responseJSON ? _jqXHR.responseJSON : '';
                if (errors.errors && errors.errors.notes) {
                    $this.before(
                        '<br><div class="alert alert-danger">Notes file error : Please select only PDF file for notes</div>'
                    );
                }
                if (errors.errors && errors.errors.extra_class_video) {
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


    $('.showVideoInput').click(function() {
        $('.text-red').remove();
        var err = 0;
        var last_id = $('.last_id').val();
        if (last_id == '') {
            if ($('#extra_class_number').val() == '') {
                $('#extra_class_number').after('<span class="text-red">Required</span>');
                err = 1;
            }
            if ($('#select2_id').val() == '') {
                $('#select2_id').after('<span class="text-red">Required</span>');
                err = 1;
            }
            if ($('#extra_class_name').val() == '') {
                $('#extra_class_name').after('<span class="text-red">Required</span>');
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

    $('.add_extra_class-btn').click(function(e) {
        $('.text-red').remove();
        $('.last_id').val('');
        $('#select2_id').val('').trigger('change');
        $('#extra_class_number').val('');
        $('#extra_class_name').val('');
        $('#lecture_date').val('');
        $('.oldPdf').html('');
        $('.oldVideo').html('');
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
                url: "{{ route('institute.extra_classes.addUnit', request()->i_assigned_class_subject_id) }}",
                method: "post",
                dataType: "json",
                data: {
                    name: $(this).find("option:selected").val(),
                    _token: "{{ csrf_token() }}"
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
            url: "{{ route('institute.extra_classes.getSubjectsByClassId', request()->i_assigned_class_subject_id) }}",
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
            url: "{{ route('institute.extra_classes.getUnits', request()->i_assigned_class_subject_id) }}",
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