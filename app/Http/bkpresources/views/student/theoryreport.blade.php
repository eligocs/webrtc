@extends('student.layouts.app')
@section('css')
<link href="{{URL::to('assets/student/css/report.css')}}" rel="stylesheet">
<style>
  .ansImg {
    display: none;
  }
</style>
@endsection
@section('content')
<div>{{ Breadcrumbs::render('student_report', request()->iacs_id, request()->id) }}</div>
@if(!empty($reportGet))
<div class="container">
  @foreach($reportGet as $report)
  <img class="ansImg" src="https://solveanswerbucket.s3.ap-south-1.amazonaws.com/{{$report->answer}}"
    style="width:100%">
  @endforeach
  <button class="w3-button w3-black w3-display-left" onclick="plusDivs(-1)">&#10094;</button>
  <button class="w3-button w3-black w3-display-right" onclick="plusDivs(1)">&#10095;</button>
</div>
@else

sdafds
@endif
@endsection
@push('js')
<script>
  var slideIndex = 1;
showDivs(slideIndex);

function plusDivs(n) {
  showDivs(slideIndex += n);
}

function showDivs(n) {
  var i;
  var x = document.getElementsByClassName("ansImg");
  if (n > x.length) {slideIndex = 1}
  if (n < 1) {slideIndex = x.length}
  for (i = 0; i < x.length; i++) {
    x[i].style.display = "none";  
  }
  x[slideIndex-1].style.display = "block";  
}
</script>
@endpush