@extends('admin.layouts.app')
@section('page_number', 'Create Teacher')
@section('content')
<!-- Start Content-->
<div class="container-fluid">
  <div>{{ Breadcrumbs::render('create-teacher', request()->institute_id) }}</div>
  <div class="row">
    <div class="col-md-6">
      <div class="card-box">
        <form role="form" action="{{route('admin.teachers.store', request()->institute_id)}}" method="post"
          enctype="multipart/form-data">
          @csrf
          {{-- <div class="form-group">
                        <label>Select Institute</label>
                        <select class="form-control" id="institute_id" name="institute_id" required>
                            <option value="">select</option>
                            @foreach (\App\Models\Institute::all() as $institute)
                            <option value="{{$institute->id}}">{{$institute->name}}</option>
          @endforeach
          </select>
      </div> --}}
      <div class="form-group">
        <label for="name">Name</label>
        <input type="hidden" name="institute_id" value="{{request()->institute_id}}">
        <input type="text" class="form-control" id="name" name="name" required>
      </div>
      <div class="form-group">
        <label for="qualifications">Qualifications</label>
        <input type="text" class="form-control" id="qualifications" name="qualifications" required>
      </div>
      <div class="form-group">
        <label for="experience">Experience</label>
        <input type="text" class="form-control" id="experience" name="experience" required>
      </div>
      <div class="form-group">
        <label for="avatar">Profile Photo</label>
        <input type="file" class="form-control" id="avatar" name="avatar" required>
      </div>
      <div class="form-group">
        <label for="head_teacher"><input type="checkbox" id="head_teacher" name="head_teacher"
            value="1">&nbsp;&nbsp;Make Head Teacher</label>
      </div>
      <div class=" text-center">
        {{-- <button type="submit" class="btn btn-theme"><a href="select-days.html">Save</a></button> --}}
        <button type="submit" class="btn btn-theme waves-effect waves-light m-l-10">
          Submit
        </button>
      </div>
      </form>
    </div>
  </div>
</div>
</div>
<!-- container -->
@endsection