@extends('institute.layouts.app')
@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
    .quiz-card {
        padding: 5px 20px 20px 20px;
        box-shadow: 0 7px 15px 0 rgba(0, 0, 0, 0.1);
        background-color: #FFF;
        border-top: 3px solid #644699;
        margin-bottom: 30px;
    }

    .quiz-name {
        font-size: 22px;
    }

    .quiz-card p {
        font-size: 13px;
    }

    .topic-detail {
        margin: 10px 0 20px;
        list-style-type: none;
        -webkit-padding-start: 0;
    }

    .topic-detail li {
        margin-bottom: 6px;
        position: relative;
    }

    .topic-detail li .fa {
        position: absolute;
        right: 0;
        top: 3.5px;
        color: #26a69a;
    }

    .fa-long-arrow-right:before {
        content: "\f178";
    }

    /* .btn-wave,
    button.btn-wave {
        position: relative;
        cursor: pointer;
        display: inline-block;
        overflow: hidden;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
        -webkit-tap-highlight-color: transparent;
        vertical-align: middle;
        z-index: 1;
        -webkit-transition: .3s ease-out;
        transition: .3s ease-out;
        border: none;
        text-decoration: none;
        color: #fff;
        background-color: #26a69a;
        text-align: center;
        letter-spacing: .5px;
        -webkit-transition: .2s ease-out;
        transition: .2s ease-out;
        cursor: pointer;
    } */

    .btn-danger {
        color: white !important;
        cursor: pointer;
    }

    .btn-danger:hover,
    .btn-danger:active,
    .btn-danger.hover {
        background-color: #d73925;
    }

    .btn-default {
        background-color: #f4f4f4;
        color: #444;
        border-color: #ddd;
    }

    .btn-default:hover,
    .btn-default:active,
    .btn-default.hover {
        background-color: #e7e7e7;
    }
</style>
<div>{{ Breadcrumbs::render('reports', request()->iacsId, request()->all_report) }}</div>
<div class="content-block card-box">
    <div class="box-body table-responsive">
        <table id="topTable" class="table table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Student Name</th>
                    <th>Mobile No.</th>
                    <th>Topic</th>
                    <th>Marks Got</th>
                    <th>Total Marks</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @if ($answers)
                @foreach ($filtStudents as $key => $student)
                <tr>
                    <td>
                        {{$key+1}}
                    </td>
                    <td>{{$student->name}}</td>
                    <td>{{$student->phone}}</td>
                    <td>{{$topic->title}}</td>
                    <td>
                        @php
                        $mark = 0;
                        $correct = collect();
                        @endphp
                        @foreach ($answers as $answer)
                        @if ($answer->user_id == $student->id && $answer->answer == $answer->user_answer)
                        @php
                        $mark++;
                        @endphp
                        @endif
                        @endforeach
                        @php
                        $correct = $mark*$topic->per_q_mark;
                        @endphp
                        {{$correct}}
                    </td>
                    <td>
                        {{$c_que*$topic->per_q_mark}}
                    </td>
                    <td>
                        <a data-toggle="modal" data-target="#delete{{ $topic->id }}"
                            title="It will delete the answer sheet of this student" href="#"
                            class="btn btn-sm btn-theme">
                            Reset Response
                        </a>

                        <div id="delete{{ $topic->id }}" class="delete-modal modal fade" role="dialog">
                            <!-- Delete Modal -->
                            <div class="modal-dialog modal-sm">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        <div class="delete-icon"></div>
                                    </div>
                                    <div class="modal-body text-center">
                                        <h4 class="modal-heading">Are You Sure ?</h4>
                                        <p>Do you really want to delete these record? This process cannot be undone.</p>
                                    </div>
                                    <div class="modal-footer justify-content-center">
                                        {{-- {!! Form::open(['method' => 'DELETE', 'action' => ['AllReportController@delete',
                                        'topicid' => $topic->id, 'userid' => $student->id] ]) !!} --}}
                                        {!! Form::open(['method' => 'DELETE', 'action' => ['Web\Institute\AllReportController@destroy',
                                        'iacsId' => request()->iacsId, 'all_report' => $answer->id, 'topicid' => $topic->id, 'userid' => $student->id] ]) !!}
                                        {!! Form::reset("No", ['class' => 'btn btn-theme', 'data-dismiss' => 'modal'])
                                        !!}
                                        {!! Form::submit("Yes", ['class' => 'btn btn-danger']) !!}
                                        {!! Form::close() !!}
                                    </div>
                                </div>
                            </div>
                        </div>

                    </td>
                </tr>
                @endforeach
                @endif
            </tbody>
        </table>
    </div>
</div>
@endsection
@push('js')
@endpush