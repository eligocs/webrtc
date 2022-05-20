@extends('student.layouts.app')
@section('css')
<link href="{{URL::to('assets/student/libs/custombox/custombox.min.css')}}" rel="stylesheet">
@endsection
@section('content')
<div class="container-fluid">
  <div class="row mx-0 align-items-center justify-content-end"></div>
</div>
@endsection
@section('js')
<script src="{{URL::to('assets/student/libs/custombox/custombox.min.js')}}"></script>
<script src="{{URL::to('assets/student/js/app.min.js')}}"></script>
@endsection