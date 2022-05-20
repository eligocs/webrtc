@extends('admin.layouts.app')
@section('content')
<!-- Start Content-->
<div class="container-fluid">
  {{ Breadcrumbs::render('enrollable_class', request()->category_id) }}
  <div class="row mx-0 card-box">
    <div class="col-md-12 mb-4">
      <h3 class="heading-title mt-0 mb-0 text-center heading">All Classes</h3>
      <form action="{{route('admin.inner_category')}}" style="float: right;">
        <input type="text" class="form-control" id="class_input" name="class" style="width: 200px;display: inline;"
          placeholder="Search for classes" value="{{$_GET['class']??''}}">
        <input type="hidden" name="category_id" value="{{request()->category_id}}">
        <button class="text-right btn btn-theme">Search</button>
        <button type="button" class="text-right btn btn-theme"
          onclick="document.getElementById('class_input').value='';this.form.submit()">Reset</button>
      </form>
    </div>
    @if( $classes->count() > 0 )

    @foreach ($classes as $institute_assigned_class)
    <div class="col-lg-4 col-6">
      <div class="card box-shadow">
        <div class="card-body">
          <div class="profile-statistics">
            <div class="text-center mt-2 border-bottom">
              <div class="my-4">
                <div class="btn-theme pl-2 pr-2 py-2 mr-0 mb-4">{{$institute_assigned_class->name}}
                  ({{$institute_assigned_class->institute->name}})</div>
              </div>
            </div>
          </div>
          <div class="profile-blog pt-1 border-bottom pb-1 ">
            <h5 class="theme-clr justify-content-between  d-flex align-items-center">
              {{$institute_assigned_class->language_table->name ?? '' }}<a href="javascript:void()"
                class="theme-clr pull-right f-s-16">{{$institute_assigned_class->board ?? '' }}</a> </h5>
          </div>
          <div class="profile-blog pt-1 border-bottom pb-1 ">
            <h5 class="theme-clr justify-content-between  d-flex align-items-center text-capitalize">
              {{$institute_assigned_class->state ?? '' }}
              <span class="pull-right f-s-16">{{$institute_assigned_class->city ?? '' }}</span>
            </h5>
          </div>
          <div class="profile-interest mt-2 pb-2 border-bottom">
            <div class="row mt-0">
              @if($institute_assigned_class->institute_assigned_class_subject->count() > 0 )

              @foreach( $institute_assigned_class->institute_assigned_class_subject as $subject )

              <div class="col-lg-6 col-xl-6 col-sm-6 col-6 int-col">
                <a href="{{route('student.detail',[$subject->id])}}"
                  class="btn btn-theme my-1 w-100 waves-effect waves-light cursor-default text-white">{{$subject->subject->name ?? ''}}</a>
              </div>

              @endforeach

              @endif
            </div>
          </div>
          <div class="profile-videobox border-bottom position-relative">
            <div class="image-element1 border-bt-e6f3ff py-2">
              <h5 class="text-center theme-clr pl-1">View Class Demo</h5>
              <div class="view_demo">
                {{-- <a data-fancybox class="video-play-button fancybox-gallery" rel="video-gallery" href="https://www.youtube.com/watch?v=iuimHfnP5aU&list=PLWx-A6wseQ6n-i692JSWuNvZcNTV-ULZu"> --}}
                <a data-fancybox class="video-play-button fancybox-gallery" rel="video-gallery"
                  href="{{$institute_assigned_class->video}}">
                  <span></span>
                </a>
                <div id="video-overlay" class="video-overlay">
                  <a class="video-overlay-close">×</a>
                </div>
              </div>
            </div>
          </div>
          <div class="batch_date d-flex justify-content-between my-2 pb-2 border-bottom">
            <p class="font-small text-dark mb-0 d-flex flex-column"><b>Batch
                Start</b>{{date('d/m/Y', strtotime($institute_assigned_class->start_date))}}</p>
            <p class="font-small text-dark  d-flex flex-column mb-0"><b>Batch
                End</b>{{date('d/m/Y', strtotime($institute_assigned_class->end_date))}}</p>
          </div>
          <div class="total text-center mt-lg-2 my-md-2 border-bottom">
            <p class="mt-0 mb-2">Enrollment Fee - {{number_format($institute_assigned_class->price)}} INR</p>
          </div>
          <div class="total text-center mt-lg-3 my-md-3">
            @if (!(\App\Models\InstituteAssignedClassStudent::where(['institute_assigned_class_id' =>
            $institute_assigned_class->id,
            'student_id' => request()->student_id])->exists()))
            <input type hidden ="student_id" id ="student_id" class= "student_id" value ="{{ request()->student_id }}">
            {{-- <form action="{{route('student.select_timings', $institute_assigned_class->id)}}"> --}}
            {{-- @csrf --}}
            {{-- <input type="hidden" name="class_id" value="{{$institute_assigned_class->id}}"> --}}
            {{-- <button type="submit" class="btn-theme btn-style">Enroll Now</button> --}}
            {{-- </form> --}}
            {{-- <a href="{{route('admin.select_timings', ['class_id' => $institute_assigned_class->id, 'student_id' => request()->student_id])}}"
              class="btn-theme btn-style">Enroll Now</a> --}}
              <button type="submit" id="enroll" class=" btn-theme btn-style enroll" data-id="{{$institute_assigned_class->id}}">Enroll Now</button>
            @else
            <h5 class="theme-clr justify-content-center  d-flex align-items-center">
              Enrolled</h5>
            @endif
          </div>
        </div>
      </div>
    </div>
    @endforeach
    @endif
  </div>
  <!-- end row -->

</div> <!-- container -->



<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
  $(document).ready(function() {
    $('.enroll').click(function(e) {
      e.preventDefault();
      var id = $(this).data('id');
      var student_id = $("#student_id").val();
      console.log(student_id);
      (async () => {

        const {
          value: Class
        } = await Swal.fire({
          title: 'Select Class Mode',
          input: 'select',
          inputOptions: {
            // 'Mode of Class ': {
            1: 'Live ',
            2: 'Recoded',
            // },
          },
          inputPlaceholder: 'Select Class Mode',
          showCancelButton: true,
        })
        // console.log(Class);

        if (Class) {
          Swal.fire(`You selected: ${Class}`)
          window.location.href = "{{url('admin/select-timings')}}/" + id + '/' + Class + '/' + student_id;
          // window.location = "{{ url('select-timings') }}/" + id;
        }

      })()

    })

    // $(".freeTrial").click(function(e){
    //   e.preventDefault();
    //   var id = $(this).data('id');
    //   var free = 'true';
    //   // console.log(free);

    //   (async () => {

    //       const {
    //         value: Class
    //       } = await Swal.fire({
    //         title: 'Select Class Mode',
    //         input: 'select',
    //         inputOptions: {
    //           // 'Mode of Class ': {
    //           1: 'Live ',
    //           2: 'Recoded',
    //           // },
    //         },
    //         inputPlaceholder: 'Select Class Mode',
    //         showCancelButton: true,
    //       })
    //       // console.log(Class);

    //       if (Class) {
    //         Swal.fire(`You selected: ${Class}`)
    //         // window.location.href = "{{url('student/select/timingsfree')}}/" + id + '/' + Class + '/' + free ;
    //         window.location.href = "{{url('student/select/timingsfree')}}/" + id + '/' + Class + '/' + free ;

    //         // window.location = "{{ url('select-timings') }}/" + id;
    //       }

    //       })()
    //   console.log("sdlajfk");
    // })

  })
</script>
@endsection