@extends('student.layouts.app')
@section('css')
<link href="{{URL::to('assets/student/libs/custombox/custombox.min.css')}}" rel="stylesheet">
@endsection
@section('content')
<div>{{ Breadcrumbs::render('search_classes') }}</div>
<div class="container-fluid">
  <form role="form" action="{{route('student.inner_category')}}">
    {{-- @csrf --}}
    <div class="row card-box align-items-center">
      <div class="col-md-12">
        <h3 class="heading-title mt-0 mb-0 text-center heading"> Select Appropriate Category</h3>

      </div>
      <div class="col-md-3">
        <img src="{{URL::to('assets/student/images/student3.png')}}" class="img-fluid w-77">
      </div>
      <div class="col-md-9"> 
        <div class="form-group">
          <label class="font-18 mb-2">Select Category</label>
          <select class="form-control font-16 px-2 bg-light  text-black no-border  p-0" name="category_id" required>
            @foreach (\App\Models\Category::all() as $item)
            <option value="{{$item->id}}">{{$item->name}}</option>
            @endforeach
            {{-- <option value="categry1">School / College Coaching</option>
              <option value="categry2">Entrance Exams Coaching</option>
              <option value="categry3">Competitive Exams Coachin</option>
              <option value="categry4">Diploma, Degree and Master Coaching</option> --}}
          </select>
        </div>
      </div>
      <div class="col-md-12 text-center">
        <button type="submit" class="btn btn-theme m-0 btn-style" href="">Next</button>
      </div>
  </form>
</div>
</div>
@endsection
@section('js')
<script src="{{URL::to('assets/student/libs/custombox/custombox.min.js')}}"></script>
<script src="{{URL::to('assets/student/js/app.min.js')}}"></script>
@endsection