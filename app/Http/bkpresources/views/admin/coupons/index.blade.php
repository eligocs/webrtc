@extends('admin.layouts.app')
@section('page_heading', 'Teachers')
@section('content')
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<!-- Start Content-->
<div class="container-fluid">
  <div class="card-box position-relative">
    <h3 class="heading-title m-0 text-center heading">Coupons</h3>
    <a href="" class="btn-theme btn-style add_lecture-btn" data-toggle="modal" data-target="#exampleModal">Add
      Coupons</a>
    @if (session()->has('message'))
    <div class="alert alert-success">{{session()->get('message')}}</div>
    @endif
  </div>
  <div class="card-box">
    <div class="table-responsive">
      <h4 class=" mt-0 mb-3 text-center fw-100">{{ '' }}</h4>
      <table class="table table-bordered mb-0 package-table">
        <thead>
          <tr>
            <th>
              <h4 class="header-title m-0 text-center heading">Applicable ON</h4>
            </th>
            <th>
              <h4 class="header-title m-0 text-center heading">Discount Code</h4>
            </th>
            <th>
              <h4 class="header-title m-0 text-center heading">Discount Amount</h4>
            </th>
            <th>
              <h4 class="header-title m-0 text-center heading">Interval</h4>
            </th>
            <th>
              <h4 class="header-title m-0 text-center heading">Status</h4>
            </th>
            <th>
              <h4 class="header-title m-0 text-center heading">Created On</h4>
            </th>
            <th>
              <h4 class="header-title m-0 text-center heading">Action</h4>
            </th>
          </tr>
        </thead>
        <tbody>
          @foreach ($coupons as $coupon)
          <tr>
            <td scope="row">
              {{ $coupon->applicable_type == 'App\Models\InstituteAssignedClass' ? $coupon->applicable->name.'(Class)' : $coupon->applicable->name.'(Institute)' }}
            </td>
            <td>{{ $coupon->code }}</td>
            <td>{{ $coupon->discount_in_rs }}</td>
            <td>{{date('d/m/Y', strtotime($coupon->start_date)) . ' - ' . date('d/m/Y', strtotime($coupon->end_date))}}
            </td>
            <td>
              <form action="{{route('admin.coupons.update-coupon-status', $coupon->id)}}" method="POST">
                @csrf
                <select name="status" id="" onchange="this.form.submit()">
                  <option value="0" {{$coupon->status == '0' ? 'selected' : ''}}>Inactive</option>
                  <option value="1" {{$coupon->status == '1' ? 'selected' : ''}}>Active</option>
                </select>
              </form>
            </td>
            <td>{{$coupon->created_at->format('d/m/Y')}}</td>
            <td>
              <form action="{{route('admin.coupons.destroy', $coupon)}}" method="POST">@csrf @method('DELETE')<input
                  type="submit" class="btn btn-danger" value="Delete"></form>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div> <!-- container -->
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
  aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Create Coupon</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="card-box">
          <form role="form" action="{{ route('admin.coupons.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
              <label for="">Applicable on*</label><br>
              <label for="applicable_type_institute"><input type="radio" name="applicable_type" class=""
                  id="applicable_type_institute" value="institute" required> Institute</label>
              <label for="applicable_type_class"><input type="radio" name="applicable_type" class=""
                  id="applicable_type_class" value="class" required> Class</label>
              @error('applicable_type')
              <div class="alert alert-danger">{{$message}}</div>
              @enderror
            </div>
            <div id="institute_type" class="form-group" style="display: none;">
              <label for=""> Select Institute</label>
              {{-- <select name="institute_id" id="select2_id" class="select2 form-control"> --}}
              <select name="institute_ids[]" id="select2_id_institute" class="select2 select2-institute form-control"
                multiple>
                <option value="">Select Institute</option>
                @foreach (\App\Models\Institute::all() as $item)
                <option value="{{ $item->id }}">{{ $item->name }}</option>
                @endforeach
              </select>
              @error('institute_ids')
              <div class="alert alert-danger">{{$message}}</div>
              @enderror
            </div>
            <div id="class_type" class="form-group" style="display: none;">
              <label for=""> Select Class</label>
              {{-- <select name="class_id" id="select2_id" class="select2 form-control"> --}}
              <select name="class_ids[]" id="select2_id_class" class="select2 select2-class form-control" multiple>
                <option value="">Select Class</option>
                @foreach (\App\Models\InstituteAssignedClass::with('institute')->get() as $item)
                <option value="{{ $item->id }}">{{ $item->name }}
                  ({{$item->institute->name}})</option>
                @endforeach
              </select>
              {{-- @error('class_id') --}}
              @error('class_ids')
              <div class="alert alert-danger">{{$message}}</div>
              @enderror
            </div>
            <div class="form-group">
              <label for="date_interval">Date Interval*</label>
              <input type="text" name="date_interval" class="form-control" id="date_interval" required>
              @error('date_interval')
              <div class="alert alert-danger">{{$message}}</div>
              @enderror
            </div>
            <div class="form-group">
              <label for="code">Code*</label>
              <input type="text" name="code" class="form-control" id="code" required>
              @error('code')
              <div class="alert alert-danger">{{$message}}</div>
              @enderror
            </div>
            <div class="form-group">
              <label for="discount_in_rs">Discount Amount*</label>
              <input type="number" name="discount_in_rs" class="form-control" id="discount_in_rs" required>
              @error('discount_in_rs')
              <div class="alert alert-danger">{{$message}}</div>
              @enderror
            </div>
            <div class="form-group text-center">
              <button type="submit" class="btn btn-theme">Create</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
@section('js')
<script src="{{ URL::to('assets/admin/js/jquery-validate.js')}}"></script>
<script src="{{ URL::to('assets/admin/js/add-institute.js')}}"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script src="{{URL::to('assets/institute/libs/select2/select2.min.js')}}"></script>
<script>
  $(document).ready(function(){
    $('input[name="date_interval"]').daterangepicker({
      opens: 'center',
      locale: {
        format: 'DD/MM/YYYY HH:mm:ss'
      }
    });
    $('[name="applicable_type"]').change(function(){
      let checked = $('[name="applicable_type"]:checked').val();
      if(checked=='institute'){
        $('#institute_type').css('display', 'block');
        $('#class_type').css('display', 'none');
      } else {
        $('#institute_type').css('display', 'none');
        $('#class_type').css('display', 'block');
      }
    })
    $('.select2-class').select2();
    $('.select2-institute').select2();
  });
</script>
@endsection