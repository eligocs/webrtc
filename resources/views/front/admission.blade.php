@extends('front.layouts.static-pages-app')
@section('title', '')

@section('content')
<div class="content-wrap blog-single-page mt-100">
  <div class="container">
    <div class="row  align-items-center">
      <div class="col-md-12">
        <h4 class=" text-center"> Select Appropriate Category</h4>
        <p class="text-center pt-3">Select the category in which you want to continue studies</p>
      </div>
      <div class="col-md-3 mt-3rem mb-3rem ">
        <a href="inner-category.html">
          <div class="border-1p paddng-10rem">
            <h4 class="text-white text-center inner-box-clss">School/college Coaching</h4>
          </div>
        </a>
      </div>
      <div class="col-md-3 mt-3rem mb-3rem ">
        <a href="inner-category.html">
          <div class="border-1p paddng-10rem">
            <h4 class="text-white text-center inner-box-clss">Entrance Exams Coaching</h4>
          </div>
        </a>
      </div>
      <div class="col-md-3 mt-3rem mb-3rem ">
        <a href="inner-category.html">
          <div class="border-1p paddng-10rem">
            <h4 class="text-white text-center inner-box-clss">Competitive Exams Coaching</h4>
          </div>
        </a>
      </div>
      <div class="col-md-3 mt-3rem mb-3rem ">
        <a href="inner-category.html">
          <div class="border-1p paddng-10rem">
            <h4 class="text-white text-center inner-box-clss">Diploma, Degree &amp; Master Coaching</h4>
          </div>
        </a>
      </div>
    </div>

  </div>
</div>
@endsection
@push('js')
@endpush