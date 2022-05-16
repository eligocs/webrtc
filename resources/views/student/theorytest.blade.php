@extends('student.layouts.app')
@section('css')
    <link href="{{ URL::to('assets/student/libs/custombox/custombox.min.css') }}" rel="stylesheet">
    <link href="{{ asset('theory/assets/css/gsdk-bootstrap-wizard.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.7.0/dropzone.css" />
    <style>
        div#wizard {
            background: whitesmoke;
        }

        #showQuestion {
            color: black;
            font-size: 13px;
        }

        #skipButton {
            background: #5e57d1;
        }



        /* navbar   ntn */

        .nav-pills {
            background: #d3d9e0 !important;
            height: 39px !important;
        }

        ul.nav.nav-pills {
            align-items: center !important;
            justify-content: center;
        }

        #question228 row {
            border: 3px solid black;
            padding: 20px;
        }

        #wizard .wizard-card .tab-content {
            min-height: 340px;
            padding: 66px;
        }

        #wizard .btn-fill.btn-success {
            background-image: linear-gradient(to right, #fe5b6c, #fe8f40) !important;
            border: none !important;
        }

        small#notekip {
            color: #c74040;
            /* text-shadow: 1px -1px #dc1aff; */
        }

        .form-group {
            margin-left: 20px !important;
            margin-top: 20px !important;
        }

        div#ans2 {
            margin-left: -15px;
        }

        /* navbar ends ntn  */

    </style>
@endsection
@section('content')
@section('content')
    <div>{{ Breadcrumbs::render('student_start_quiz', request()->iacs_id, request()->id) }}</div>
    <div id="app">
        <div class="container-fluid">
            @php
                $topic = \App\Models\Topic::findOrFail(request()->id);
                $answers = \App\Models\Answer::where('topic_id', '=', $topic->id)->first();
                
                $old_data = DB::table('class_notifications')
                    ->where('assigment_id', $topic->id)
                    ->first();
                if ($old_data) {
                    $old_data_arr = !empty($old_data->readUsers) ? explode(',', $old_data->readUsers) : [];
                    if (!in_array(auth()->user()->student_id, $old_data_arr)) {
                        $old_data_arr[] = auth()->user()->student_id;
                        $query = DB::table('class_notifications')
                            ->where('notify_date', '<=', date('Y-m-d'))
                            ->where('assigment_id', $topic->id)
                            ->update([
                                'readUsers' => implode(',', $old_data_arr),
                            ]);
                    }
                }
            @endphp
            <div class="row">
                <div class="col-md-6 col-sm-8">
                    <div class="navbar-header">
                        <!-- Branding Image -->

                        @if ($topic)
                            <h4 class="heading" style="color: black;">{{ $topic->title }}</h4>

                        @endif
                    </div>
                </div>
                <div class="col-md-3 ml-auto text-right col-sm-4">
                    <div class="collapse navbar-collapse d-flex justify-content-end align-items-center"
                        id="app-navbar-collapse">
                        <!-- Right Side Of Navbar -->
                        @if (request()->segment(3) == 'tests')
                            <h5 class="font-14 black text-right"
                                style="font-size: 22px !important;color: black !important; font-weight: bold;">Time left:
                                <ul class="nav navbar-nav navbar-right my-0 mx-1 p-0">
                                    <!-- Authentication Links -->
                                    <li id="clock" style="color: black;"></li>
                                </ul>
                            </h5>
                        @endif
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="home-main-block">
                    <?php $users = \App\Models\Theoryanswer::where('topicId', $topic->id)
                        ->where('userid', auth()->user()->student_id)
                        ->first();
                    $ques = \App\Models\Question::where('topic_id', $topic->id)->get();
                    $count = $ques->count();
                    //  dd($count);
                    ?>
                </div>
            </div>
        </div>
    </div>
    @if (!empty($users))
        <div class="alert alert-danger">
            You have already Given the test ! Try to give other Quizes
        </div>
    @elseif (count($ques) > 0)
        <div class="container-fluid">
            <div class="col-sm-12 col-sm-offset-2">
                <!--      Wizard container        -->
                <div class="wizard-container">
                    <div class="card wizard-card" data-color="green" id="wizard">
                        <form action="" method="post" enctype="multipart/form-data">
                            @csrf
                            <!--        You can switch ' data-color="green" '  with one of the next bright colors: "blue", "green", "orange", "red"          -->

                            <div class="wizard-header">
                                <h3>
                                    <b>LIST</b> Question <br>
                                    <small id="notekip">Note: If you want to upload all answer in a file click submit
                                        button!</small>
                                </h3>
                            </div>
                            <div class="wizard-navigation">
                                <ul>
                                    @if (count($ques) > 0)
                                        @foreach ($ques as $key => $que)
                                            <li id="questionNavigation"><a href="#question{{ $que->id }}"
                                                    data-toggle="tab">{{ $key + 1 }}</a></li>
                                        @endforeach
                                    @endif
                                </ul>
                            </div>
                            <div class="tab-content">
                                @if (!empty($ques))

                                    @foreach ($ques as $key => $que)

                                        <input type="hidden" class="quidb" value="{{ $que->id }}">
                                        <div class="tab-pane" id="question{{ $que->id }}">
                                            <div class="row">
                                                <h4 class="info-text"> </h4>
                                                <div class="col-sm-6 col-sm-offset-1">
                                                    <br>
                                                    <div class="form-group">
                                                        <label>Questions No . {{ $key + 1 }}</label>
                                                        <h6>Questions No . {{ $key + 1 }} {{ $que->question }}</h6>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 col-sm-offset-1">
                                                    <br>
                                                    <div class="form-group">
                                                        <label>Questions Image</label><br>
                                                        @if (!empty($que->question_img))
                                                            <a
                                                                href="{{ 'https://aaradhanaclasses.s3.ap-south-1.amazonaws.com/' . $que->question_img }}">
                                                                <img src="{{ 'https://aaradhanaclasses.s3.ap-south-1.amazonaws.com/' . $que->question_img }}"
                                                                    width="500px">
                                                            </a>
                                                        @else
                                                            No Image Are Here
                                                        @endif
                                                    </div>
                                                </div>
                                                <input type="hidden" class="quidb" value="{{ $que->id }}">
                                                <div class="col-sm-12">
                                                    <div class="form-group col-md-6">
                                                        <label class="control-label">Upload Answer :</label>
                                                        <div id="ans{{ $key + 1 }}" class="dropzone classquestionid"
                                                            data-id="{{ $que->id }}" name="answerimage">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    @endforeach
                                @endif
                            </div>
                            <input type='hidden' class='ans_id'>
                            <div class="wizard-footer">
                                <div class="pull-right">
                                    <input type='button' class='btn btn-next btn-fill btn-success btn-wd btn-sm' name='next'
                                        value='Next' />
                                    <button id="btnSubmit" class='btn btn-finish btn-fill btn-success btn-wd btn-sm'
                                        name='finish'>Finish
                                    </button>

                                </div>

                                <div class="pull-left">
                                    <input type='button' class='btn btn-previous btn-fill btn-default btn-wd btn-sm'
                                        name='previous' value='Previous' />
                                    <input type='button' id="skipButton"
                                        class='btn btn-next btn-fill btn-default btn-wd btn-sm' name='skip' value='Skip' />
                                </div>
                                <div class="clearfix"></div>
                            </div>

                        </form>
                    </div>
                </div> <!-- wizard container -->
            </div>
        </div> <!--  big container -->
    @else
        <div class="alert alert-danger">
            No Questions in this quiz
        </div>
    @endif
@endsection
@section('js')
    <!--   Core JS Files   -->
    <script src="{{ asset('theory/assets/js/jquery-2.2.4.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('theory/assets/js/bootstrap.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('theory/assets/js/jquery.bootstrap.wizard.js') }}" type="text/javascript"></script>
    <script src="{{ asset('/js/jquery.cookie.js') }}"></script>
    <script src="{{ asset('/js/jquery.countdown.js') }}"></script>
    <!--  Plugin for the Wizard -->
    <script src="{{ asset('theory/assets/js/gsdk-bootstrap-wizard.js') }}"></script>

    <!--  More information about jquery.validate here: http://jqueryvalidation.org/	 -->
    <script src="{{ asset('theory/assets/js/jquery.validate.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.7.0/dropzone.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.classquestionid').click(function() {
                $('.ans_id').val($(this).data('id'));
            });

            $('#btnSubmit').click(function(e) {
                e.preventDefault();
                var userid = "{{ auth()->user()->student_id }}";
                var topicid = "{{ $topic->id }}";
                var answer_status = "2";

                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token" ]').attr('content')
                    },
                    type: 'post',
                    url: "{{ route('student.finish_test_theory', [request()->iacs_id, $topic->id]) }}",
                    data: {
                        userid: userid,
                        topicId: topicid,
                        answer_status: answer_status

                    },
                    cache: false,
                    success: function(response) {
                        //    console.log(response);

                    }
                });
                //     $("#btnSubmit").attr("disabled", true);  
                swal("Good job!", "You test has been end!", "success");
                setTimeout(() => {
                    window.location.href = "{{ route('student.tests', request()->iacs_id) }}";
                }, 5000);

            });

            var totallength = '{{ $count }}';
            // console.log(totallength);
            for (var i = 1; i <= totallength; i++) {
                /*  var id = $('#ans'+i).data('id'); */
                Dropzone.autoDiscover = false;
                var uploadedDocumentMap = {};
                // window.onload = function() {


                var dropzoneOptions = {
                    items: '.dz-preview',
                    cursor: 'move',
                    opacity: 0.5,
                    containment: "parent",
                    distance: 20,
                    tolerance: 'pointer',
                    update: function(e, ui) {
                        // do what you want
                    },
                    dictDefaultMessage: 'Select Mulitple Recipe Images And Not More Than 5 MB',
                    paramName: "file",
                    maxFilesize: 5, // MB
                    addRemoveLinks: true,
                    acceptedFiles: ".jpeg,.jpg,.png,.gif,.pdf",


                    thumbnail: function(file, dataUrl) {
                        if (file.previewElement) {
                            file.previewElement.classList.remove("dz-file-preview");
                            var images = file.previewElement.querySelectorAll("[data-dz-thumbnail]");
                            for (var i = 0; i < images.length; i++) {
                                var thumbnailElement = images[i];
                                thumbnailElement.alt = file.name;
                                thumbnailElement.src = dataUrl;
                            }
                            setTimeout(function() {
                                file.previewElement.classList.add("dz-image-preview");
                            }, 1);
                        }
                    },



                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token" ]').attr('content')
                    },
                    url: "{{ route('student.tests.storeimage', [request()->iacs_id, $topic->id]) }}",
                    // maxFiles:1,
                    init: function()



                    {
                        this.on("success", function(file, res) {
                            var id = $('.ans_id').val();
                            var userid = "{{ auth()->user()->student_id }}";
                            var topicid = "{{ $topic->id }}"
                            var anser_no = '1';
                            // console.log(userid);

                            $.ajax({
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token" ]').attr('content')
                                },
                                type: 'post',
                                url: "{{ route('student.tests.storetheory', [request()->iacs_id, $topic->id]) }}",
                                data: {
                                    answer: res,
                                    questionId: id,
                                    userid: userid,
                                    topicId: topicid,
                                    anser_no: anser_no

                                },
                                cache: false,
                                success: function(response) {
                                    //    console.log(response);

                                }
                            });
                            $('.dz-remove').click(function(e) {
                                e.preventDefault();
                                var id = $('.ans_id').val();
                                var userid = "{{ auth()->user()->student_id }}";
                                var topicid = "{{ $topic->id }}"
                                var anser_no = '1';
                                // console.log(userid);

                                $.ajax({
                                    headers: {
                                        'X-CSRF-TOKEN': $('meta[name="csrf-token" ]').attr(
                                            'content')
                                    },
                                    type: 'post',
                                    url: "{{ route('student.tests.deleteimg', [request()->iacs_id, $topic->id]) }}",
                                    data: {
                                        answer: res,
                                        questionId: id,
                                        userid: userid,
                                        topicId: topicid,
                                        anser_no: anser_no

                                    },
                                    cache: false,
                                    success: function(response) {
                                        //    console.log(response);

                                    }
                                });

                            })
                        });
                        this.on("error", function(file, data) {
                            /* this.removeFile(file);
                            swal(data, " ", "error"); */
                        });

                    }
                };

                var dropzone = new Dropzone('#ans' + i, dropzoneOptions);
                dropzone.removeAllFiles();
                dropzone.processQueue();
            }


        })

        var topic_id = {{ $topic->id }};
        @if (!in_array('assignments', request()->segments()))
            var timer = {{ $topic->timer }};
        @endif
        $(document).ready(function() {
            /*   function e(e) {
                   (116 == (e.which || e.keyCode) || 82 == (e.which || e.keyCode)) && e.preventDefault()
               }
               setTimeout(function() {
                   $(".tab-content:first-child").addClass("active");
                   $(".prebtn").attr("disabled", true);
               }, 2500), history.pushState(null, null, document.URL), window.addEventListener("popstate",
                   function() {
                       history.pushState(null, null, document.URL)
                   }), $(document).on("keydown", e), setTimeout(function() {
                   $(".nextbtn").click(function() {
                           var e = $(".myQuestion.active");
                           $(e).removeClass("active"), 0 == $(e).next().length ? (Cookies.remove("time"),
                               Cookies.set("done", "Your Quiz is Over...!", {
                                   expires: 1
                               }), location.href =
                               "{{ route('student.finish_test', [request()->iacs_id, request()->id]) }}"
                           ) : ($(e).next().addClass("active"), $(".myForm")[0].reset(),
                               $(".prebtn").attr("disabled", false))
                       }),
                       $(".prebtn").click(function() {
                           var e = $(".myQuestion.active");
                           $(e).removeClass("active"),
                               $(e).prev().addClass("active"), $(".myForm")[0].reset()
                           $(".myQuestion:first-child").hasClass("active") ? $(".prebtn").attr("disabled",
                               true) : $(".prebtn").attr("disabled", false);
                       })
               }, 700);*/
            @if (!in_array('assignments', request()->segments()))
                var i, o = (new Date).getTime() + 6e4 * timer;
                if (Cookies.get("time") && Cookies.get("topic_id") == topic_id) {
                i = Cookies.get("time");
                var t = o - i,
                n = o - t;
                $("#clock").countdown(n, {
                elapse: !0
                }).on("update.countdown", function(e) {
                var i = $(this);
                e.elapsed ? (Cookies.set("done", "Your Quiz is Over...!", {
                expires: 1
                }), Cookies.remove("time"), location.href =
                "{{ route('student.finish_test', [request()->iacs_id, request()->id]) }}") :
                i.html(e.strftime("<span>%H:%M:%S</span>"))
                })
                } else Cookies.set("time", o, {
                expires: 1
                }), Cookies.set("topic_id", topic_id, {
                expires: 1
                }), $("#clock").countdown(o, {
                elapse: !0
                }).on("update.countdown", function(e) {
                var i = $(this);
                e.elapsed ? (Cookies.set("done", "Your Quiz is Over...!", {
                expires: 1
                }), Cookies.remove("time"), location.href =
                "{{ route('student.finish_test', [request()->iacs_id, request()->id]) }}") :
                i.html(e.strftime("<span>%H:%M:%S</span>"))
                })
            @endif
        });
    </script>
@endsection
