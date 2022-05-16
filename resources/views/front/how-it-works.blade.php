@extends('front.layouts.static-pages-app')
@section('title', 'How it Works')
@section('content')
<div class="how-work">
  <div class="container mt-6m pt-3m">
    <div class="row ">
      <div class="col-md-12">
        <h4 class=" text-center">Choose any from following</h4>
        <p class="text-center pt-3">Please choose the right option to see how it works for you</p>
      </div>
      <div class="col-md-10 col-md-offset-1 mt-3rem d-md-flex">
      <div class="choose-inner"><a class="text-white" href="{{route('front.inner-work')}}">How it works for a teacher</a>
        </div>
        <div class="choose-inner"><a class="text-white" href="{{route('front.inner-work')}}">How it works for a student</a>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
@push('js')
@endpush