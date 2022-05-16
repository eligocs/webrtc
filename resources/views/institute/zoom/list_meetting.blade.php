@extends('institute.layouts.app')
@section('page_heading', 'Live Lecture')
@section('content')
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

    /* button#submit_meeting {
    border: none;

    /*Hidden class for adding and removing*/
    .lds-dual-ring.hidden {
        display: none;
    }

    /*Add an overlay to the entire page blocking any further presses to buttons or other elements.*/
    .overlay {
        position: absolute;
        /* child */
        top: 50%;
        left: 50%;
        margin-left: -39px;
        /* half of width*/
        margin-top: -39px;
        /* half of height */
        width: 100%;
        height: 100vh;
        background: #ececec;
        z-index: 999;
        opacity: 1;
        transition: all 0.5s;
    }

    /*Spinner Styles*/
    .lds-dual-ring {
        display: inline-block;
        width: 80px;
        height: 80px;
    }

    .lds-dual-ring:after {
        content: " ";
        display: block;
        width: 64px;
        height: 64px;
        margin: 5% auto;
        border-radius: 50%;
        border: 6px solid #fff;
        border-color: #63c22d #286e2e00 #b2d7e1 transparent;
        animation: lds-dual-ring 1.2s linear infinite;
    }

    @keyframes lds-dual-ring {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
    }
</style>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<div class="container-fluid">
    <div>{{ Breadcrumbs::render('liveclass', $i_class_id_segment , $i_subject_id_segment) }}</div>
    <div class="card-box position-relative">
        <h3 class="heading-title m-0 text-center heading">Live Lecture</h3>
        <a href="{{ url('institute/create') }}" class="btn-theme btn-style add_lecture-btn" data-toggle="modal"
            data-target="#lectureModal">Create
            Lecture</a>
    </div>
    @foreach ($groupByunitMeeting as $key => $unit)

    @if ($unit['meeting']->count() > 0)
    <div class="card-box">
        <div class="table-responsive">
            <h4 class=" mt-0 mb-3 text-center fw-100">{{$unit['unitName']}}</h4>
            <table class="table table-bordered mb-0 package-table">
                <thead>
                    <tr>
                        <th style="width: 10%;">
                            <h4 class="header-title m-0 text-center heading">Lecture Number</h4>
                        </th>
                        <th style="width: 30%;">
                            <h4 class="header-title m-0 text-center heading">Lecture Name</h4>
                        </th>
                        <th style="width: 15%;">
                            <h4 class="header-title m-0 text-center heading">Meeting Date</h4>
                        </th>
                        <th style="width: 5%;">
                            <h4 class="header-title m-0 text-center heading">Duration</h4>
                        </th>
                        <th style="width: 5%;">
                            <h4 class="header-title m-0 text-center heading">Join Meeting</h4>
                        </th>
                        <td style="width: 20%">
                            Action
                        </td>
                    </tr>
                </thead>

                @foreach ($unit['meeting'] as $key => $unitMeeting)
                <tbody>
                    <td style="width: 15%;">{{ $unitMeeting->lecture_number }}</td>
                    <td style="width: 15%;">{{ $unitMeeting->lecture_name }}</td>
                    <td>{{ $unitMeeting->date }}</td>
                    <td style="width: 15%;">
                        {{ $unitMeeting->duration }}
                    </td>
                    <td style="width: 5%;overflow-wrap: anywhere;">
                        @php
                        $join_link = get_browser_join_links($unitMeeting->meeting_id, $unitMeeting->password,
                        $i_class_id_segment, $i_subject_id_segment);
                        @endphp
                        <a target='__blank' title='Join Now' href="{{ $join_link ? $join_link : '' }}"><i
                                class="fa fa-video-camera" aria-hidden="true"></i></a>
                    </td>
                    <td style="width: 20%;">
                        <a class="edit_meet" data-id='{{ $unitMeeting->meeting_id }}'><i class="fa fa-pencil"
                                aria-hidden="true"></i></a>&nbsp;&nbsp;&nbsp;
                        <a href="" class="text-reds deleteLecture" data-id='{{ $unitMeeting->meeting_id }}'><i
                                class='fa fa-trash' id="delete_meeting"></i></a>
                    </td>
                    </tr>
                </tbody>
                @endforeach
            </table>
        </div>
    </div>
    {{-- @else
    <tr>
        <td colspan="8">No upcoming meeting</td>
    </tr> --}}
    @endif
    @endforeach
</div>

<!-- Create Modal -->
<div class="modal fade" id="lectureModal" tabindex="-1" role="dialog" aria-labelledby="lectureModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="lectureModalLabel"> Create Meetings</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="loader" class="lds-dual-ring hidden  overlay"></div>
            <div class="modal-body">
                <div class="card-box">
                    <form role="form" id='lectureForm'>
                        {{-- @if ($errors->has('date'))
                                <div class="error">{{ $errors->first('date') }}
                </div>
                @endif --}}
                @csrf
                <input name='last_id' class='last_id' id="i_a_c_s_id" value='{{ $i_class_id_segment }}' type='hidden'>
                <input name='last_id' class='last_id' id="subject_id" value='{{ $i_subject_id_segment }}' type='hidden'>
                <input name='last_id' class='last_id' id="id" value='' type='hidden'>

                {{-- <div class="form-group">
                    <label for="lecture_name">Unit*</label>
                    <input type="text" class="form-control" id="topic_name" name=" topic_name"
                        value="{{ old('topic_name') }}" required>
            </div> --}}
            <div class="form-group">
                <input type="hidden" id="iacsId" value="{{ $i_class_id_segment }}">
                <label for="unit_name">Select Unit*</label>
                <select name="topic_name" id="topic_name" class="select2 unit_name" required>
                    <option value="">Select Unit</option>
                    @foreach (\App\Models\Live_unit::where('institute_assigned_class_subject_id',
                    $i_class_id_segment)->get() as $item)
                    <option value="{{ $item->id }}">{{ $item->unitName }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="lecture_number">Lecture number*</label>
                <input type="number" name="lecture_number" class="form-control" id="lecture_number" required>
            </div>
            <div class="form-group">
                <label for="lecture_name">Lecture Name*</label>
                <input type="text" name="lecture_name" class="form-control" id="lecture_name" required>
            </div>
            <div class="form-group">
                <label for="lecture_date">Lecture Date*</label>
                {{-- <input type="text" value='{{ isset($meeting->start_time) ? $meeting->start_time : '' }}'
                class="form-control" required id="datetimepicker" name="start_time"> --}}
                <input type="date" name="start_time" class="form-control" min="{{ date('Y-m-d') }}" id="datetimepicker"
                    required>
            </div>
            <div class="form-group">
                <label for="lecture_date">Lecture Time*</label>
                {{-- <input type="text" value='{{ isset($meeting->start_time) ? $meeting->start_time : '' }}'
                class="form-control" required id="datetimepicker" name="start_time"> --}}
                <input class="form-control" type="time" name="start-time" id="start-time" required>
            </div>
            <div class="form-group">
                <label for="duration">Duration* (Minutes)</label>
                <input type="number" class="form-control" id="duration" aria-label="file example" name="duration"
                    value="{{ old('duration') }}" required>

            </div>
            {{-- <div class="form-group">
                                    <label for="duration">Schedule*</label>
                                    <input type="number" class="form-control" aria-label="file example" id="schedule"
                                        name="schedule" autocomplete="off" value="{{ old('schedule') }}" required>
        </div> --}}
        {{-- <div class="form-group">
            <label for="duration">Password* <span style="color :red">Enter max 3 digit</span></label>
            <input type="hidden" class="form-control" aria-label="file example" id="password" name="password"
                autocomplete="off" min="1" max="3" value="123" required>
        </div> --}}
        <div class="form-group custom-arrows">
            <button type="submit" name="singlebutton" id="create_meeting" class="btn btn-primary">
                Create</button>
        </div>
    </div>
    </form>
</div>
</div>
</div>
</div>
</div>


<!----Edit form model --------->
<!-- Modal -->
<div class="modal fade" id="EditModel" tabindex="-1" role=" dialog" aria-labelledby="lectureModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="lectureModalLabel"> Edit Meetings</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="edit_loader" class="lds-dual-ring hidden  overlay"></div>
            <div class="modal-body">
                <div class="card-box">
                    <form role="form" id='lectureForm'>
                        @csrf
                        <input name='last_id' id="hiddenId" class='last_id' value='' type='hidden'>
                        <input name='last_id' class='last_id' id="i_a_c_s" value='' type='hidden'>
                        <input name='last_id' class='last_id' id="subject" value='' type='hidden'>
                        <div class='inputFields'>
                            {{-- <div class="form-group">
                                <label for="lecture_name">Unit*</label>
                                <input type="text" class="form-control" id="topic" name=" topic_name" value="" required>
                            </div> --}}
                            <div class="form-group">
                                <input type="hidden" id="iacsId" value="{{ $i_class_id_segment }}">
                                <label for="unit_name">Select Unit*</label>
                                <select name="topic_name" id="topic" class="select2 unit_name" required>
                                    <option value="">Select Unit</option>
                                    @foreach (\App\Models\Live_unit::where('institute_assigned_class_subject_id',
                                    $i_class_id_segment)->get() as $item)
                                    <option value="{{ $item->id }}">{{ $item->unitName }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="lecture_number">Lecture number*</label>
                                <input type="text" name="lecture_number" class="form-control" id="lecture_numbe"
                                    required>
                            </div>
                            <div class="form-group">
                                <label for="lecture_name">Lecture Name*</label>
                                <input type="text" name="lecture_name" class="form-control" id="lecture_nam" required>
                            </div>
                            <div class="form-group">
                                <label for="lecture_date">Lecture Date*</label>
                                <input type="date" name="start_time" class="form-control" min="{{ date('Y-m-d') }}"
                                    id="datetimepic" value="" required>
                            </div>
                            <div class="form-group">
                                <label for="lecture_date">Lecture Time*</label>
                                <input class="form-control" type="time" name="time_edit" id="time_edit" value=""
                                    required>
                            </div>
                            <div class=" form-group">
                                <label for="duration">Duration* (Minutes)</label>
                                <input type="number" class="form-control" id="durati" aria-label="file example"
                                    name="duration" value="" required>
                            </div>
                            {{-- <div class="form-group">
                                <label for="duration">Password* <span style="color :red">Enter max 3
                                        digit</span></label>
                                <input type="password" class="form-control" aria-label="file example" id="pass"
                                    name="password" autocomplete="off" value="" min="1" max="3" required>
                            </div> --}}
                            <div class="form-group custom-arrows">
                                <button type="submit" name="singlebutton" id="edit_meeting_button"
                                    class="btn btn-primary">
                                    Edit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('js')
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script>
    $(document).ready(function() {
            $("#create_meeting").on('click', function(e) {
                e.preventDefault();
                var i_a_c_s_id = $("#i_a_c_s_id").val();
                var subject_id = $("#subject_id").val();
                var lecture_number = $("#lecture_number").val();
                var lecture_name =$("#lecture_name").val();
                var time = $('#start-time').val();
                var topic_name = $("#topic_name").val();
                var date = $("#datetimepicker").val();
                var duration = $("#duration").val();
                // var schedule = $("#schedule").val();
                var password = $("#password").val();
                if (topic_name != '' && date != '' && duration != '' && password != '' && time != '' && lecture_number != '' && lecture_name != '') {
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

                        },
                        url: "/institute/meeting",
                        type: "POST",
                        data: {
                            i_a_c_s_id: i_a_c_s_id,
                            lecture_number:lecture_number,
                            lecture_name:lecture_name,
                            subject_id: subject_id,
                            topic_name: topic_name,
                            date: date,
                            time: time,
                            duration: duration,
                            password: password,
                        },
                        caches: false,
                        beforeSend: function() { // Before we send the request, remove the .hidden class from the spinner and default to
                        $('#loader').removeClass('hidden')
                        },
                        success: function(dataResult) {
                            var dataResult = JSON.parse(dataResult);
                            if (dataResult.statusCode == 201) {
                                Swal.fire(
                                    'success!',
                                    'Done, Meeting Created!',
                                    'success'
                                )
                                setTimeout(() => {
                                    window.location.reload();
                                }, 5000);

                            } else {
                                if (dataResult.statusCode == 300) {
                                    Swal.fire(
                                        'Error!',
                                        'A maximum of {rateLimitNumber} meetings can be created/updated for a single user in one day.',
                                        'error'
                                    )
                                } else {
                                    if (dataResult.statusCode == 400) {
                                        Swal.fire(
                                            'Error!',
                                            'Pless Enter correct date!',
                                            'error'
                                        )
                                    } else {
                                        if (dataResult.statusCode == 101) {
                                            Swal.fire(
                                                'Error!',
                                                'This Meeting Date is Already Exists',
                                                'error'
                                            )
                                        } else {
                                            if (dataResult.statusCode == 102) {
                                                Swal.fire(
                                                    'Error!',
                                                    'This Meeting Date  is Already Exists',
                                                    'error'
                                                )
                                            } else {
                                                if (dataResult.statusCode == 1001) {
                                                    Swal.fire(
                                                        'Error!',
                                                        'User does not exist',
                                                        'error'
                                                    )
                                                }
                                            }

                                        }
                                    }

                                }

                            }
                        },
                        complete: function() { // Set our complete callback, adding the .hidden class and hiding the spinner.
                        $('#loader').addClass('hidden')
                        },

                    })

                } else {
                    Swal.fire(
                        'Error!',
                        'All field are Required!',
                        'error'
                    )

                }
            });

            $('.deleteLecture').click(function(e) {
                e.preventDefault();
                var id = $(this).data('id');
                console.log(id);

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
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                                        'content')
                                },
                                url: "/institute/deleteMeeting/" + id,
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
                                        }, 5000);
                                    } else {
                                        swal(
                                            "Something wend wrong,try again later !!!"
                                        );
                                    }
                                }
                            });
                        }
                    });
            });


            $('.edit_meet').click(function() {
                var i_a_c_s_id = $("#i_a_c_s").val('');
                var subject_id = $("#subject").val('');
                var meeting_id = $(this).data('id');
                var getid = $('#hiddenId').val('');
                var topic_name = $("#topic").val('');
                var date = $("#datetimepic").val('');
                var time = $("#time_edit").val('');
                var duration = $("#durati").val('');
                var password = $("#pass").val('');
                var lecture_numbe = $("#lecture_numbe").val('');
                var lecture_nam = $("#lecture_nam").val('');
                var id = $("#id").val('');
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

                    },
                    url: "/institute/getMeeting/" + meeting_id,
                    type: "POST",
                    data: {
                        meeting_id: meeting_id,

                    },
                    caches: false,
                    success: function(dataResult) {
                        console.log(dataResult);
                        // console.log(dataResult);
                        if (dataResult.status) {
                            $("#EditModel").modal('show');
                            var meetingId = $('#hiddenId').val(dataResult.data.meeting_id);
                            var topic_name = $('#topic').val(dataResult.data.topic_name);
                            var date = $('#datetimepic').val(dataResult.data.date);
                            var time = $('#time_edit').val(dataResult.data.time);
                            var duration = $('#durati').val(dataResult.data.duration);
                            var password = $('#pass').val(dataResult.data.password);
                            var i_a_c_s_id = $('#i_a_c_s').val(dataResult.data.i_a_c_s_id);
                            var subject_id = $('#subject').val(dataResult.data.subject_id);
                            var lecture_numbe = $("#lecture_numbe").val(dataResult.data.lecture_number);
                            var lecture_nam = $("#lecture_nam").val(dataResult.data.lecture_name);

                        }

                        // response_return_meeting(meeting_id, topic_name, date, duration, password);
                    }
                })
            });


            $("#edit_meeting_button").on('click', function(e) {
                e.preventDefault();
                var i_a_c_s_id = $("#i_a_c_s").val();
                var subject_id = $("#subject").val();
                var id = $("#hiddenId").val();
                var topic_name = $("#topic").val();
                var date = $("#datetimepic").val();
                var time = $("#time_edit").val();
                var duration = $("#durati").val();
                var password = $("#pass").val();
                var lecture_number = $("#lecture_numbe").val();
                var lecture_name = $("#lecture_nam").val();
                if (topic_name != '' && date != '' && duration != '' && password != '' && time != '' && lecture_number != '' && lecture_name != '') {
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                                'content')

                        },
                        beforeSend: function() { // Before we send the request, remove the .hidden class from the spinner and default to
                        $('#edit_loader').removeClass('hidden')
                        },
                        url: "/institute/editMeeting/" + id,
                        type: "POST",
                        data: {
                            i_a_c_s_id:i_a_c_s_id,
                            lecture_number:lecture_number,
                            lecture_name:lecture_name,
                            subject_id:subject_id,
                            id: id,
                            topic_name: topic_name,
                            date: date,
                            time: time,
                            duration: duration,
                            password: password,
                        },
                        caches: false,
                        success: function(dataResult) {
                            var dataResult = JSON.parse(dataResult);
                            if (dataResult.statusCode == 200) {
                                Swal.fire(
                                    'success!',
                                    'Done, Meeting Updated!',
                                    'success'
                                )
                                setTimeout(() => {
                                    window.location.reload();
                                }, 5000);

                            } else {
                                if (dataResult.statusCode == 400) {
                                    Swal.fire(
                                        'Error!',
                                        'Meeting not updated',
                                        'error'
                                    )
                                } else {
                                    if (dataResult.statusCode == 101) {
                                        Swal.fire(
                                            'Error!',
                                            'This Meeting Date  is Already Exists',
                                            'error'
                                        )
                                    }
                                    else {
                                    if (dataResult.statusCode == 102) {
                                        Swal.fire(
                                            'Error!',
                                            'This Meeting Date  is Already Exists',
                                            'error'
                                        )
                                    }
                                    else {
                                    if (dataResult.statusCode == 1001) {
                                        Swal.fire(
                                            'Error!',
                                            'User not Exists',
                                            'error'
                                        )
                                    }
                                    }
                                }
                            }
                            }
                        },
                        complete: function() { // Set our complete callback, adding the .hidden class and hiding the spinner.
                        $('#edit_loader').addClass('hidden')
                        },

                    })

                } else {
                    Swal.fire(
                        'Error!',
                        'All field are Required!',
                        'error'
                    )

                }
            });

            var select2 = $('#topic_name').select2({
            tags: true,
            insertTag: function(data, tag) {
            tag.text = tag.text + "(new)";
            data.push(tag);
            },
            }).on('select2:select', function() {
            var mainthis = $(this);
            var iacsId = $('#iacsId').val();

            console.log($(this).find("option:selected").data("select2-tag") == true);
            if ($(this).find("option:selected").data("select2-tag") == true) {
            $.ajax({
            url: "{{ route('institute.lectures.liveUnit', $i_class_id_segment) }}",
            method: "post",
            dataType: "json",
            data: {
            iacsId: iacsId,
            unitName: $(this).find("option:selected").val(),
            _token: "{{ csrf_token() }}"
            },
            success: function(response) {
            // alert(response.status);
            if (response.status) {
            mainthis.find("option:selected").val(response.data.id);
            mainthis.find("option:selected").text(response.data.name);
            }
            }
            })
            }
            });

            //edit
            var select2 = $('#topic').select2({
            tags: true,
            insertTag: function(data, tag) {
            tag.text = tag.text + "(new)";
            data.push(tag);
            },
            }).on('select2:select', function() {
            var mainthis = $(this);
            var iacsId = $('#iacsId').val();

            console.log($(this).find("option:selected").data("select2-tag") == true);
            if ($(this).find("option:selected").data("select2-tag") == true) {
            $.ajax({
            url: "{{ route('institute.lectures.liveUnit', $i_class_id_segment) }}",
            method: "post",
            dataType: "json",
            data: {
            iacsId: iacsId,
            unitName: $(this).find("option:selected").val(),
            _token: "{{ csrf_token() }}"
            },
            success: function(response) {
            // alert(response.status);
            if (response.status) {
            mainthis.find("option:selected").val(response.data.id);
            mainthis.find("option:selected").text(response.data.name);
            }
            }
            })
            }
            });
        });
</script>

@endsection