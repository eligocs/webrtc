@extends('student.layouts.app')
@section('css')
    <link href="{{ URL::to('assets/student/libs/custombox/custombox.min.css') }}" rel="stylesheet">
    <style>
        .card {
            position: relative;
            margin: .5rem 0 1rem 0;
            background-color: rgba(50, 50, 50, 0.8);
            -webkit-transition: -webkit-box-shadow .25s;
            transition: -webkit-box-shadow .25s;
            -webkit-transition: all 0.5s ease;
            -moz-transition: all 0.5s ease;
            -ms-transition: all 0.5s ease;
            -o-transition: all 0.5s ease;
            border-radius: 2px;
            -webkit-box-shadow: 0 2px 2px 0 rgba(0, 0, 0, 0.14), 0 1px 5px 0 rgba(0, 0, 0, 0.12), 0 3px 1px -2px rgba(0, 0, 0, 0.2);
            box-shadow: 0 2px 2px 0 rgba(0, 0, 0, 0.14), 0 1px 5px 0 rgba(0, 0, 0, 0.12), 0 3px 1px -2px rgba(0, 0, 0, 0.2);
            min-height: 391px;
        }

        .card-title {
            max-height: 96px;
            overflow: hidden;
        }

        .card .card-content {
            padding: 24px;
            /* border-radius: 0 0 2px 2px; */
        }

        .white-text {
            color: #fff !important;
        }

        .card .card-content .card-title {
            display: block;
            line-height: 32px;
            margin-bottom: 8px;
            font-size: 22px;
        }

        .card .card-content p {
            margin: 0;
            color: rgba(255, 255, 255, 0.8);
            font-size: 14px;
        }

        .ribbon {
            top: 3px !important;
        }

        .paddingx {
            padding: 1.5rem !important;
        }

    </style>
@endsection
@section('content')
    <div class="container-fluid">
        <div>{{ Breadcrumbs::render('student_tests', request()->iacs_id) }}</div>
        <div class="quiz-main-block">
            <div class="row">
                @php
                    $total2 = 0;
                    $items2 = [];
                    $assignmentnotifications = DB::table('class_notifications')
                        ->where('i_a_c_s_id', request()->iacs_id)
                        ->where('isread', 1)
                        ->where('type', 'test')
                        ->get();
                    if (!empty($assignmentnotifications)) {
                        foreach ($assignmentnotifications as $noti) {
                            if ($noti->readUsers) {
                                $hiddenProducts = explode(',', $noti->readUsers);
                                if (in_array(auth()->user()->student_id, $hiddenProducts)) {
                                    $total2 = $total2 + 0;
                                } else {
                                    $total2 = $total2 + 1;
                                    $items2[] = $noti->assigment_id;
                                }
                            } else {
                                $total2 = $total2 + 1;
                                $items2[] = $noti->assigment_id;
                            }
                        }
                    }
                    $assignmentnotifications = $total2;
                    $assignNotificationData = $items2;
                    //dd($items2);
                    $old_data = DB::table('class_notifications')
                        ->where('type', 'test')
                        ->where('i_a_c_s_id', request()->iacs_id)
                        ->get();
                    if ($old_data) {
                        foreach ($old_data as $dat) {
                            $old_data_arr = !empty($dat->readUsers) ? explode(',', $dat->readUsers) : [];
                            if (!in_array(auth()->user()->student_id, $old_data_arr)) {
                                $old_data_arr[] = auth()->user()->student_id;
                                $query = DB::table('class_notifications')
                                    ->where('id', $dat->id)
                                    ->where('notify_date', '<=', date('Y-m-d'))
                                    ->update([
                                        'readUsers' => implode(',', $old_data_arr),
                                    ]);
                            }
                        }
                    }
                    
                    if (!empty(request()->iacs_id)) {
                        $institute_assigned_class_subject = DB::table('institute_assigned_class_subject')
                            ->where('id', request()->iacs_id)
                            ->first();
                        if (!empty($institute_assigned_class_subject)) {
                            $institute_assigned_class_student = DB::table('institute_assigned_class_student')
                                ->where('institute_assigned_class_id', $institute_assigned_class_subject->institute_assigned_class_id)
                                ->where('student_id', auth()->user()->student_id)
                                ->first();
                            if (!empty($institute_assigned_class_student) && !empty($institute_assigned_class_student->end_date)) {
                                $start_date = $institute_assigned_class_student->start_date;
                            } else {
                                $institute_assigned_class = DB::table('institute_assigned_class')
                                    ->where('id', $institute_assigned_class_subject->institute_assigned_class_id)
                                    ->first();
                                $start_date = $institute_assigned_class->start_date;
                            }
                        }
                    }
                    
                    $curentdate = date('Y-m-d');
                    $curentTime = date('H:i');
                    
                    $unitName = [];
                    $topics = [];
                    if (!empty($allUnits)) {
                        foreach ($allUnits as $value) {
                            // dd($value);
                            $topicsGet = \App\Models\Topic::where('institute_assigned_class_subject_id', request()->iacs_id)
                                ->where('publish_date', '>=', $start_date)
                                ->where('type', 'test')
                                ->where('status', 'publish')
                                ->where('publish_date', '<=', date('Y-m-d'))
                                ->orderBy('publish_date', 'desc')
                                ->where('unit', $value->id)
                                ->get();
                            $unitName['id'] = $value->id;
                            $unitName['topics'] = $topicsGet;
                            $unitName['name'] = $value->unit;
                            $topics[] = $unitName;
                        }
                    }
                    
                    $topics_old_unit = \App\Models\Topic::where('institute_assigned_class_subject_id', request()->iacs_id)
                        ->where('type', 'test')
                        ->where('publish_date', '>=', $start_date)
                        ->where('unit', null)
                        ->where('status', 'publish')
                        ->where('testType', null)
                        ->where('publish_date', '<=', date('Y-m-d'))
                        ->orderBy('publish_date', 'desc')
                        ->get();
                @endphp
                @if (!empty($topics))
                    @forelse ($topics as $key => $unit)
                        @if ($unit['topics']->count() > 0)
                            <div class="card-box col-12 paddingx">
                                <div class="col-12">
                                    <h3 class=" mt-0 mb-3 text-center fw-100">{{ ucfirst($unit['name']) }}</h3>
                                </div>
                            </div>
                            <div class="card-box col-12 paddingx">
                                <div class="row">
                                    @foreach ($unit['topics'] as $key => $topic)
                                        <div class="col-md-3">
                                            @if (in_array($topic->id, $items2))
                                                <div class="ribbon" style=""><span>New</span></div>
                                            @endif
                                            <div class="topic-block">
                                                <div class="card {{ $colors[$key % 6] }}">
                                                    <div class="card-content white-text">
                                                        @if ($topic->testType == 2)
                                                            <h4 class='text-white'> Theory Test </h4>
                                                        @else
                                                            <h4 class='text-white'> Mcq Test </h4>
                                                        @endif
                                                        <h4 class='text-white'> Test {{ $key + 1 }}</h4>
                                                        <span class="card-title white-text twoLines" data-toggle="tooltip"
                                                            title="{{ $topic->title }}">{{ $topic->title }}</span>
                                                        <p class="white-text" title="{{ $topic->description }}">
                                                            {{ Str::limit($topic->description, 120) }}</p>
                                                        <div class="row">
                                                            <div class="col-md-12 pad-0">
                                                                <ul class="topic-detail px-0">
                                                                    <li class="white-text"><span
                                                                            class="left_side">Per Question Mark <i
                                                                                class="fa fa-long-arrow-right"></i></span><span
                                                                            class="right_side">{{ $topic->per_q_mark }}</span>
                                                                    </li>
                                                                    <li class="white-text"><span
                                                                            class="left_side">Total Marks <i
                                                                                class="fa fa-long-arrow-right"></i></span><span
                                                                            class="right_side"> @php
                                                                                $qu_count = 0;
                                                                            @endphp
                                                                            @foreach ($topic->questions as $question)
                                                                                @if ($question->topic_id == $topic->id)
                                                                                    @php
                                                                                        $qu_count++;
                                                                                    @endphp
                                                                                @endif
                                                                            @endforeach
                                                                            {{ $topic->per_q_mark * $qu_count }}
                                                                        </span></li>
                                                                    <li class="white-text"><span
                                                                            class="left_side">Total Questions <i
                                                                                class="fa fa-long-arrow-right"></i></span><span
                                                                            class="right_side">
                                                                            {{ $qu_count }}</span></li>
                                                                    <li class="white-text"><span
                                                                            class="left_side">Total Time <i
                                                                                class="fa fa-long-arrow-right"></i></span><span
                                                                            class="right_side"> {{ $topic->timer }}
                                                                            minutes</span></li>
                                                                    @if (!empty($topic->publishing_startTime))
                                                                        <li class="white-text"><span
                                                                                class="left_side">Start Time <i
                                                                                    class="fa fa-long-arrow-right"></i></span><span
                                                                                class="right_side">
                                                                                {{ $topic->publishing_startTime }}
                                                                            </span></li>

                                                                    @endif

                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>


                                                    <div class="card-action text-center">

                                                        @if (Session::has('added'))
                                                            <div class="alert alert-success sessionmodal">
                                                                {{ session('added') }}
                                                            </div>
                                                        @elseif (Session::has('updated'))
                                                            <div class="alert alert-info sessionmodal">
                                                                {{ session('updated') }}
                                                            </div>
                                                        @elseif (Session::has('deleted'))z
                                                            <div class="alert alert-danger sessionmodal">
                                                                {{ session('deleted') }}
                                                            </div>
                                                        @endif

                                                        {{-- @if (!empty($topic->publishing_startTime) && $topic->publishing_startTime <= $curentTime && !empty($topic->publishing_endTime) && $topic->publishing_endTime >= $curentTime) --}}
                                                        @if ($topic->testType == 1)
                                                            @if (!empty($topic->publishing_startTime) && $topic->publishing_startTime <= $curentTime)
                                                                <a href="{{ route('student.tests.start_test', [request()->iacs_id, $topic->id]) }}"
                                                                    class="btn btn-theme mb-3" title="Start Quiz">Start
                                                                    Quiz </a>
                                                                {{-- @elseif(empty($topic->publishing_startTime) && empty($topic->publishing_endTime) && !empty($topic->publish_date)) --}}
                                                            @elseif(empty($topic->publishing_startTime) &&
                                                                !empty($topic->publish_date))
                                                                <a href="{{ route('student.tests.start_test', [request()->iacs_id, $topic->id]) }}"
                                                                    class="btn btn-theme mb-3" title="Start Quiz">Start
                                                                    Quiz </a>
                                                            @else
                                                                <a href="#" disabled class="btn btn-theme mb-3 notYet"
                                                                    title="Start Quiz">Start
                                                                    Quiz </a>
                                                            @endif
                                                        @else
                                                            @if (!empty($topic->publishing_startTime) && $topic->publishing_startTime <= $curentTime)
                                                                <a href="{{ route('student.tests.start_testtheory', [request()->iacs_id, $topic->id]) }}"
                                                                    class="btn btn-theme mb-3" title="Start Quiz">Start
                                                                    Quiz </a>
                                                                {{-- @elseif(empty($topic->publishing_startTime) && empty($topic->publishing_endTime) && !empty($topic->publish_date)) --}}
                                                            @elseif(empty($topic->publishing_startTime) &&
                                                                !empty($topic->publish_date))
                                                                <a href="{{ route('student.tests.start_testtheory', [request()->iacs_id, $topic->id]) }}"
                                                                    class="btn btn-theme mb-3" title="Start Quiz">Start
                                                                    Quiz </a>
                                                                @php
                                                                    $total_th_marks = 'Not checked';
                                                                @endphp
                                                                @if (count($getmarks) > 0)
                                                                    @foreach ($getmarks as $getmark)
                                                                        @if ($topic->id == $getmark->topicId)
                                                                            @php
                                                                                $total_th_marks = $getmark->marksGot;
                                                                            @endphp
                                                                        @endif
                                                                    @endforeach
                                                                @endif
                                                                @if ($total_th_marks == 'Not checked')
                                                                    <a href="#" disabled="disabled"
                                                                        class="btn btn-theme mb-3" title="Report">Reports
                                                                        ({{ $total_th_marks }})
                                                                    </a>
                                                                @else
                                                                    <a href="{{ route('student.theoryreport', [request()->iacs_id, $topic->id]) }}"
                                                                        class="btn btn-theme mb-3"
                                                                        title="Start Quiz">Reports

                                                                        ({{ $total_th_marks }})

                                                                    </a>
                                                                @endif
                                                            @else
                                                                <a href="#" disabled class="btn btn-theme mb-3 notYet"
                                                                    title="Start Quiz">Start
                                                                    Quiz </a>
                                                            @endif
                                                        @endif
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    @empty
                        {{-- @endif --}}
                        <div class="w-100 text-center">
                            <h1>No tests published yet!!!</h1>
                        </div>

                    @endforelse
                @endif
                @if ($topics_old_unit)
                    @forelse ($topics_old_unit as $key => $topic)
                        <div class="col-md-3">
                            @if (in_array($topic->id, $items2))
                                <div class="ribbon" style=""><span>New</span></div>
                            @endif
                            <div class="topic-block">
                                <div class="card {{ $colors[$key % 6] }}">
                                    <div class="card-content white-text">
                                        <span class="card-title white-text twoLines" data-toggle="tooltip"
                                            title="{{ $topic->title }}">{{ $topic->title }}</span>
                                        <p class="white-text" title="{{ $topic->description }}">
                                            {{ Str::limit($topic->description, 120) }}</p>
                                        <div class="row">
                                            <div class="col-md-12 pad-0">
                                                <ul class="topic-detail px-0">
                                                    <li class="white-text"><span class="left_side">Per Question
                                                            Mark <i class="fa fa-long-arrow-right"></i></span><span
                                                            class="right_side">{{ $topic->per_q_mark }}</span></li>
                                                    <li class="white-text"><span class="left_side">Total Marks <i
                                                                class="fa fa-long-arrow-right"></i></span><span
                                                            class="right_side"> @php
                                                                $qu_count = 0;
                                                            @endphp
                                                            @foreach ($topic->questions as $question)
                                                                @if ($question->topic_id == $topic->id)
                                                                    @php
                                                                        $qu_count++;
                                                                    @endphp
                                                                @endif
                                                            @endforeach
                                                            {{ $topic->per_q_mark * $qu_count }}
                                                        </span></li>
                                                    <li class="white-text"><span class="left_side">Total Questions
                                                            <i class="fa fa-long-arrow-right"></i></span><span
                                                            class="right_side"> {{ $qu_count }}</span></li>
                                                    <li class="white-text"><span class="left_side">Total Time <i
                                                                class="fa fa-long-arrow-right"></i></span><span
                                                            class="right_side"> {{ $topic->timer }}
                                                            minutes</span></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-action text-center">

                                        @if (Session::has('added'))
                                            <div class="alert alert-success sessionmodal">
                                                {{ session('added') }}
                                            </div>
                                        @elseif (Session::has('updated'))
                                            <div class="alert alert-info sessionmodal">
                                                {{ session('updated') }}
                                            </div>
                                        @elseif (Session::has('deleted'))
                                            <div class="alert alert-danger sessionmodal">
                                                {{ session('deleted') }}
                                            </div>
                                        @endif
                                        <a href="{{ route('student.tests.start_test', [request()->iacs_id, $topic->id]) }}"
                                            class="btn btn-theme mb-3" title="Start Quiz">Start
                                            Quiz </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                    @endforelse
                @endif
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script src="{{ URL::to('assets/student/libs/custombox/custombox.min.js') }}"></script>
    <script src="{{ URL::to('assets/student/js/app.min.js') }}"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.sessionmodal').addClass("active");
            setTimeout(function() {
                $('.sessionmodal').removeClass("active");
            }, 4500);
            /* sweet alert for not yet class */
            $(".notYet").click(function() {
                swal({
                    title: "Opps!",
                    text: "Test time is not apropriate ",
                    icon: "error",
                    button: "Ok!",
                })
            });

        })
    </script>
@endsection
