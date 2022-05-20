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

@endsection
@push('js')
@endpush