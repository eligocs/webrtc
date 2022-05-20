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
<div class="row">
    @if ($topics)
    @foreach ($topics as $key => $topic)
    <div class="col-md-4">
        <div class="quiz-card">
            <h3 class="quiz-name">{{$topic->title}}</h3>
            <p title="{{$topic->description}}">
                {{Str::limit($topic->description, 120)}}
            </p>
            <div class="row">
                <div class="col-6 pad-0">
                    <ul class="topic-detail">
                        <li>Per Question Mark <i class="fa fa-long-arrow-right"></i></li>
                        <li>Total Marks <i class="fa fa-long-arrow-right"></i></li>
                        <li>Total Questions <i class="fa fa-long-arrow-right"></i></li>
                        <li>Total Time <i class="fa fa-long-arrow-right"></i></li>
                    </ul>
                </div>
                <div class="col-6">
                    <ul class="topic-detail right">
                        <li>{{$topic->per_q_mark}}</li>
                        <li>
                            @php
                            $qu_count = 0;
                            @endphp
                            @foreach($questions as $question)
                            @if($question->topic_id == $topic->id)
                            @php
                            $qu_count++;
                            @endphp
                            @endif
                            @endforeach
                            {{$topic->per_q_mark*$qu_count}}
                        </li>
                        <li>
                            {{$qu_count}}
                        </li>
                        <li>
                            {{$topic->timer}} minutes
                        </li>
                    </ul>
                </div>
            </div>
            <a href="{{route('institute.all_reports.show', [request()->iacsId, $topic->id])}}" class="btn btn-theme">Show Report</a>
        </div>
    </div>
    @endforeach
    @endif
</div>
@endsection
@push('js')
@endpush