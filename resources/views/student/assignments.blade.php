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

ul.topic-detail li {
    color: #000000;
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
    color: #000000;
    font-size: 14px;
}

.ribbon {
    top: 3px !important;
}
</style>
@endsection
@section('content')
@php
// dd("sdkj");
@endphp
<div class="container-fluid assignments-page">
    <div>{{ Breadcrumbs::render('student_assignments', request()->iacs_id) }}</div>
    <div class="quiz-main-block">
        <div class="row">
            @php

            $total2 = 0;
            $items2 = [];
            $assignmentnotifications = DB::table('class_notifications')
            ->where('i_a_c_s_id', request()->iacs_id)
            ->where('isread', 1)
            ->where('type', 'assignment')
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

            // dd($assig_all_Units);

            $unitName = [];
            $topics = [];
            if (!empty($assig_all_Units)) {
            foreach ($assig_all_Units as $value) {
            // dd($value);
            $topicsGet = \App\Models\Topic::where('institute_assigned_class_subject_id', request()->iacs_id)
            ->where('type', 'assignment')
            ->where('status', 'publish')
            ->where('publish_date', '<=', date('Y-m-d')) ->where('publish_date', '>=', $start_date)
                ->orderBy('publish_date', 'desc')
                ->where('unit', $value->id)
                ->get();

                $unitName['id'] = $value->id;
                $unitName['topics'] = $topicsGet;
                $unitName['name'] = $value->unitName;
                $topics[] = $unitName;
                }

                // dd($topics);
                }

                $assignment_old_unit = \App\Models\Topic::where('institute_assigned_class_subject_id',
                request()->iacs_id)
                ->where('type', 'assignment')
                ->where('status', 'publish')
                ->where('publish_date', '<=', date('Y-m-d')) ->where('publish_date', '>=', $start_date)
                    ->orderBy('publish_date', 'desc')
                    ->where('unit', null)
                    ->where('testType', null)
                    ->get();
                    $old_data = DB::table('class_notifications')
                    ->where('type', 'assignment')
                    ->where('i_a_c_s_id', request()->iacs_id)
                    ->get();
                    if ($old_data) {
                    foreach ($old_data as $dat) {
                    $old_data_arr = !empty($dat->readUsers) ? explode(',', $dat->readUsers) : [];
                    if (!in_array(auth()->user()->student_id, $old_data_arr)) {
                    $old_data_arr[] = auth()->user()->student_id;
                    $query = DB::table('class_notifications')
                    ->where('id', $dat->id)
                    ->where('notify_date', '<=', date('Y-m-d')) ->update([
                        'readUsers' => implode(',', $old_data_arr),
                        ]);
                        }
                        }
                        }
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
                                            <div class="card-content">
                                                <span class="card-title white-text twoLines" data-toggle="tooltip"
                                                    title="{{ $topic->title }}">{{ ucfirst($topic->title) }}</span>
                                                    <?php
                                                    $test_type = '';
                                                    if(!empty($topic->testType) && $topic->testType == 1){
                                                        $test_type = 'MCQ';
                                                    }elseif(!empty($topic->testType) && $topic->testType == 2){
                                                        $test_type = 'Theory';
                                                    }
                                                    ?>
                                                    <span class="card-title white-text twoLines" data-toggle="tooltip" title="{{ $test_type ?? '' }}">{{ $test_type ?? '' }}</span>
                                                <p class="white-text" title="{{ ucfirst($topic->description) }}">
                                                    {{ Str::limit($topic->description, 120) }}
                                                </p>
                                                <div class="row">
                                                    <div class="col-md-12 pad-0">
                                                        <ul class="topic-detail">
                                                            <h5 class="white-text"> Assignment
                                                                {{ $key + 1 }} </h5>
                                                            <li class="white-text"><span class="left_side">Per Question
                                                                    Mark <i
                                                                        class="fa fa-long-arrow-right"></i></span><span
                                                                    class="right_side">{{ $topic->per_q_mark }}</span>
                                                            </li>
                                                            <li class="white-text"><span class="left_side">Total Marks
                                                                    <i class="fa fa-long-arrow-right"></i></span><span
                                                                    class="right_side">
                                                                    @php
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
                                                            <li class="white-text"><span class="left_side">Total
                                                                    Questions <i
                                                                        class="fa fa-long-arrow-right"></i></span><span
                                                                    class="right_side">
                                                                    {{ $qu_count }}</span>
                                                            </li>
                                                            {{-- <li class="white-text">Total Time <i class="fa fa-long-arrow-right"></i></li> --}}
                                                            {{-- <li class="white-text">Quiz Price <i class="fa fa-long-arrow-right"></i></li> --}}
                                                        </ul>
                                                    </div>
                                                    <div class="col-xs-6 col-md-4">
                                                        <ul class="topic-detail right">

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
                                                <a href="{{ route('student.assignments.start_assignment', [request()->iacs_id, $topic->id]) }}"
                                                    class="btn btn-theme mb-2" title="Start Quiz">Start
                                                    Quiz </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>

                        @endif
                        @empty
                      {{--   <div class="w-100 text-center">
                            <h1>No assignments published yet!!!</h1>
                        </div> --}}
                        @endforelse
                        @endif
                        @if (empty($topics))
                            <div class="w-100 text-center">
                                <h1>No assignments published yet!!!</h1>
                            </div>
                        @endif
                        @if ($assignment_old_unit)
                        @forelse ($assignment_old_unit as $key => $topic)
                        <div class="col-md-3">
                            @if (in_array($topic->id, $items2))
                            <div class="ribbon" style=""><span>New</span></div>
                            @endif
                            <div class="topic-block">
                                <div class="card {{ $colors[$key % 6] }}">
                                    <div class="card-content">
                                        <span class="card-title white-text twoLines" data-toggle="tooltip"
                                            title="{{ $topic->title }}">{{ $topic->title }}</span>
                                         
                                        <p class="white-text" title="{{ $topic->description }}">
                                            {{ Str::limit($topic->description, 120) }}</p>
                                        <div class="row">
                                            <div class="col-md-12 pad-0">
                                                <ul class="topic-detail">
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
                                                    {{-- <li class="white-text">Total Time <i class="fa fa-long-arrow-right"></i></li> --}}
                                                    {{-- <li class="white-text">Quiz Price <i class="fa fa-long-arrow-right"></i></li> --}}
                                                </ul>
                                            </div>
                                            <div class="col-xs-6 col-md-4">
                                                <ul class="topic-detail right">
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
                                        <a href="{{ route('student.assignments.start_assignment', [request()->iacs_id, $topic->id]) }}"
                                            class="btn btn-theme mb-2" title="Start Quiz">Start
                                            Quiz </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @empty
                      {{--   <div class="w-100 text-center">
                            <h1>No assignments published yet!!!</h1>
                        </div> --}}
                        @endforelse
                        @endif
        </div>
    </div>
</div>
@endsection
@section('js')
<script src="{{ URL::to('assets/student/libs/custombox/custombox.min.js') }}"></script>
<script src="{{ URL::to('assets/student/js/app.min.js') }}"></script>
<script>
$(document).ready(function() {
    $('.sessionmodal').addClass("active");
    setTimeout(function() {
        $('.sessionmodal').removeClass("active");
    }, 4500);
});
</script>
@endsection