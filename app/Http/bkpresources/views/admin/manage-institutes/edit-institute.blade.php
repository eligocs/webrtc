@extends('admin.layouts.app')
@section('page_heading', 'Edit Institute')
@section('content')

<!-- Start Content-->
<div class="container-fluid">
  <div>{{ Breadcrumbs::render('edit-institute', request()->id) }}</div>
  <div class="row">
    <div class="col-md-6">
      @if (count($errors) > 0)
      <div class="alert alert-danger">
        <ul>
          @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
      @endif
      <div class="card-box">
        <form role="form" action="{{route('admin.manage-institutes.updateInstitute', $institute->id)}}" method="post">
          @csrf
          <div class="form-group">
            <label for="institiute_name"> Institute Name*</label>
            <input type="text" name="name" class="form-control" id="institiute_name"
              value="{{ old('name') ?? $institute->name }}">
          </div>
          <div class="form-group">
            <label for="email">Email</label>
            <input type="text" name="email" class="form-control" id="email"
              value="{{ old('email') ?? $institute->email }}" disabled>
          </div>
          <div class="form-group">
            <label for="password">Password</label>
            <input type="password" name="password" class="form-control" id="password">
          </div>
          <div class="form-group">
            <label for="confirm_password">Confirm Password</label>
            <input type="password" name="confirm_password" class="form-control" id="confirm_password">
          </div>
          <div class="form-group">
            <label for="mobile">Mobile Number</label>
            <input type="text" name="phone" class="form-control" id="mobile"
              value="{{ old('phone') ?? $institute->phone }}">
          </div>
          <div class="form-group">
            <label>Address</label>
            <input type="text" name="address" class="form-control" id="address"
              value="{{ old('address') ?? $institute->address }}">
          </div>
          <div class="form-group text-center">
            <button type="submit" class="btn btn-theme">Save Changes</button>
          </div>

        </form>
      </div>
    </div>
  </div>

</div> <!-- container -->
@endsection