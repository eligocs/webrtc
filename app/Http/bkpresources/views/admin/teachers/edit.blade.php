@extends('admin.layouts.app')
@section('page_heading', 'Edit Teacher')
@section('content')
<!-- Start Content-->
<div class="container-fluid">
  <div>{{ Breadcrumbs::render('edit-teacher', request()->institute_id, request()->teacher) }}</div>
  <div class="row">
    <div class="col-md-6">
      <div class="card-box">
        <form role="form" action="{{route('admin.teachers.update', [request()->institute_id, $element->id])}}"
          method="post" enctype="multipart/form-data">
          @csrf @method('PUT')
          {{-- <div class="form-group">
                        <label>Select Institute</label>
                        <select class="form-control" id="institute_id" name="institute_id" required>
                            <option value="">select</option>
                            @foreach (\App\Models\Institute::all() as $institute)
                            <option value="{{$institute->id}}"
          {{$element->institute_id == $institute->id ? 'selected' : ''}}>{{$institute->name}}</option>
          @endforeach
          </select>
      </div> --}}
      <div class="form-group">
        <label for="name">Name</label>
        <input type="hidden" name="institute_id" value="{{request()->institute_id}}">
        <input type="text" class="form-control" id="name" name="name" value="{{$element->name}}" required>
      </div>
      <div class="form-group">
        <label for="qualifications">Qualifications</label>
        <input type="text" class="form-control" id="qualifications" name="qualifications"
          value="{{$element->qualifications}}" required>
      </div>
      <div class="form-group">
        <label for="experience">Experience</label>
        <input type="text" class="form-control" id="experience" name="experience" value="{{$element->experience}}"
          required>
      </div>
      <div class="form-group">
        <label for="avatar">Profile Photo</label>
        <input type="file" class="form-control" id="avatar" name="avatar">
        <img src="{{url('storage/'.$element->avatar)}}" alt="" width="100">
      </div>
      <div class="form-group">
        <label for="head_teacher"><input type="checkbox" id="head_teacher" name="head_teacher" value="1"
            {{$element->head_teacher == 1 ? 'checked' : ''}}>&nbsp;&nbsp;Make Head
          Teacher</label>
      </div>
      <div class=" text-center">
        {{-- <button type="submit" class="btn btn-theme"><a href="select-days.html">Save</a></button> --}}
        <button type="submit" class="btn btn-theme waves-effect waves-light m-l-10">
          Update
        </button>
      </div>
      </form>
    </div>
  </div>
</div>
</div>
<!-- container -->
@endsection