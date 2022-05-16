@extends('admin.layouts.app')
@section('page_heading', 'View Application')
@section('content')


<!-- Start Content-->
<div class="container-fluid">
  <div>{{ Breadcrumbs::render('view-resolved-applications', request()->id) }}</div>
  <div class="row">
    <div class="card-box col-md-6">


      <form role="form" class="row">
        <div class="form-group col-md-12">
          <label for="institiute_name">Name of Institute*</label>
          <input type="text" class="form-control" id="institiute_name" value="{{$institute_application->name ?? ''}}"
            readonly>
        </div>
        <div class="form-group col-md-12">
          <label for="institiute_name">Name of Applicant*</label>
          <input type="text" class="form-control" id="institiute_name"
            value="{{$institute_application->firstname . ' '. $institute_application->lastname ?? ''}}" readonly>
        </div>
        <div class="form-group col-md-12">
          <label for="email">Email Id</label>
          <input type="text" class="form-control" id="email" value="{{$institute_application->email ?? ''}}"
            class="form-control" readonly>
        </div>
        <div class="form-group col-md-12">
          <label for="address">Address Line1*</label>
          <input type="text" class="form-control" id="address" value="{{$institute_application->address ?? ''}}"
            readonly>
        </div>
        <div class="form-group col-md-12">
          <label for="address2">Address Line2*</label>
          <input type="text" class="form-control" id="address2" value="{{$institute_application->address2 ?? ''}}"
            readonly>
        </div>
        <div class="form-group col-md-6">
          <label for="state">State</label>
          <input type="text" class="form-control" id="state" value="{{$institute_application->state ?? ''}}" readonly>
        </div>
        <div class="form-group col-md-6">
          <label for="city">City</label>
          <input type="text" class="form-control" id="city" value="{{$institute_application->city ?? ''}}" readonly>
        </div>
        <div class="form-group col-md-6">
          <label for="code">Zip Code</label>
          <input type="text" class="form-control" id="code" value="{{$institute_application->zipcode ?? ''}}" readonly>
        </div>
        <div class="form-group col-md-12">
          <label for="mobile">Mobile No.</label>
          <input type="text" class="form-control" id="mobile" value="{{$institute_application->mobile_no ?? ''}}"
            readonly>
        </div>
        <div class="form-group col-md-12">
          <label for="phone_no">Phone No.</label>
          <input type="text" class="form-control" id="phone_no" value="{{$institute_application->phone_no ?? ''}}"
            readonly>
        </div>
        <div class="form-group col-md-12">
          <label>Type of Class*</label>
          <input type="text" class="form-control" id="productqunatity"
            value="{{$institute_application->type_of_class ?? ''}}" readonly>
        </div>
        <div class="form-group col-md-12">
          <label for="description">Description*</label>
          <textarea rows="3" type="text" class="form-control" id="description"
            readonly>{{$institute_application->description ?? ''}}</textarea>
        </div>
        <div class="col-md-12">
          <button type="submit" class="btn btn-theme">Save</button>
        </div>
      </form>
    </div>
  </div>

</div> <!-- container -->
@endsection