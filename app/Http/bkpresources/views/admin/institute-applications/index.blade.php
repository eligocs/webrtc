@extends('admin.layouts.app')
@section('page_heading', 'Institute Applications')
@section('content')
<!-- Start Content-->
<div class="container-fluid">
  <div>{{ Breadcrumbs::render('institute-applications') }}</div>
  <div class="row mx-0 card-box">
    <div class="col-md-12">
      <div class="table-responsive">
        <table class="table table-bordered mb-0 package-table">
          <thead>
            <tr>
              <th>
                <h4 class="header-title m-0 text-center heading">Sr. No.</h4>
              </th>
              <th>
                <h4 class="header-title m-0 text-center heading">Application By</h4>
              </th>
              <th>
                <h4 class="header-title m-0 text-center heading">Application Date</h4>
              </th>
              {{-- <th>
                <h4 class="header-title m-0 text-center heading">Email</h4>
              </th>
              <th>
                <h4 class="header-title m-0 text-center heading">Mobile No.</h4>
              </th>
              <th>
                <h4 class="header-title m-0 text-center heading">Phone</h4>
              </th> --}}
              <th>
                <h4 class="header-title m-0 text-center heading">View Application</h4>
              </th>
              <th>
                <h4 class="header-title m-0 text-center heading">Action</h4>
              </th>
            </tr>
          </thead>
          <tbody>
            @if(isset($unresolved_institute_applications))
            @php
            $counter = 1;
            @endphp
            @foreach($unresolved_institute_applications as $unresolved_institute_application)
            @if($unresolved_institute_application->status == '0')
            <tr>
              <td>{{$counter}}.</td>
              <td>{{$unresolved_institute_application->name}}</td>
              <td>{{date('d/m/Y', strtotime($unresolved_institute_application->created_at))}}</td>
              {{-- <td>{{$unresolved_institute_application->email}}</td>
              <td>{{$unresolved_institute_application->mobile_no}}</td>
              <td>{{$unresolved_institute_application->phone_no}}</td> --}}
              <td><a href="{{route('admin.institute-applications.view',$unresolved_institute_application->id)}}"
                  class="btn-theme btn-style">View</a></td>
              <td><a href="#resolved-modal" class="btn-theme btn-style make_resolve_btn" data-animation="fadein"
                  data-plugin="custommodal" data-overlayColor="#36404a"
                  data-id="{{$unresolved_institute_application->id ?? ''}}"
                  data-application-name="{{$unresolved_institute_application->name ?? ''}}">Mark Resolved</a></td>
            </tr>
            @php $counter++;
            @endphp
            @endif
            @endforeach
            @endif
          </tbody>
        </table>
        <div class="mt-4 d-flex justify-content-center">{{$unresolved_institute_applications->links() }}</div>
        {{-- <nav class="mt-4">
                                    <ul class="pagination pagination-rounded pagination-md justify-content-end">
                                        <li class="page-item active"><a class="page-link" href="javascript:void()">1</a></li>
                                        <li class="page-item"><a class="page-link" href="javascript:void()">2</a></li>
                                        <li class="page-item"><a class="page-link" href="javascript:void()">3</a></li>
                                        <li class="page-item"><a class="page-link" href="javascript:void()">4</a></li>
                                        <li class="page-item"><a class="page-link" href="javascript:void()">5</a></li>
                                    </ul>
                                </nav> --}}
      </div>

    </div><!-- end col -->
  </div>
  <!-- end row -->

</div> <!-- container -->
<!-- block modal -->
<div id="resolved-modal" class="modal-demo">
  <button type="button" class="close black" onclick="Custombox.modal.close();">
    <span>&times;</span><span class="sr-only">Close</span>
  </button>
  <!-- <h4 class="custom-modal-title">Change Password</h4> -->
  <div class="custom-modal-text p-4 text-center">
    <h4 class="text-center">Do you want to mark this application resolved ?</h4>
    <div class="text-center mt-3">
      <button class="btn btn-theme confirm_btn">Confirm</button>
    </div>
  </div>

</div>
<!-- ============================================================== -->
<!-- End Page content -->
<!-- ============================================================== -->
<input type="hidden" id="set_application_id" value="" />
<input type="hidden" id="set_application_name" value="" />
<input type="hidden" id="institute_application_resolve_url"
  value="{{route('admin.institute-applications.make_resolve')}}" />
<input type="hidden" id="redirect_url" value="{{route('admin.institute-applications.resolved')}}" />
@endsection
@section('js')
<script>
  $(document).ready(function () {

            const success = 'Success';
            const redirect_url = $('#redirect_url').val();

            $('.make_resolve_btn').click(function () {
                $('.response').html('');
                $('.confirm_btn').attr("disabled", false);
                let set_application_id = $(this).data('id');
                let set_application_name = $(this).data('application-name');
                $('#set_application_id').val(set_application_id);
                $('#set_application_name').val(set_application_name);
            });

            $('.confirm_btn').click(function () {
                $('.confirm_btn').html('<i class="fa fa-spinner fa-spin" style="font-size:24px"></i>');
                let post_institute_form_url = $('#institute_application_resolve_url').val();
                let id = $('#set_application_id').val();
                let application_name = $('#set_application_name').val();
                $.ajax({
                    type: 'POST',
                    url: post_institute_form_url,
                    data: {
                        "_token": "{{ csrf_token() }}",
                        id: id
                    },
                    success: function (return_data) {
                        $('.confirm_btn').html('Confirm');
                        $('.confirm_btn').attr("disabled", true);
                        if (return_data.status == success) {
                            //$('.response').html('Your Application has been successfully sent.'); 
                            $('.confirm_btn').html('<i class="fa fa-spinner fa-spin" style="font-size:24px"></i>');
                            setTimeout(function () {
                                $("#custom-width-modal").modal('toggle');
                                window.location.replace(redirect_url + '?s=' + application_name);
                            }, 2000);

                        }
                        else {
                            $('.response').html('<p>' + return_data.error + '</p>');
                        }
                    }
                });
            })
        });
</script>
@endsection