@extends('student.layouts.app')
@section('page_heading', 'Extra Classes')
@section('content')
<style>
.ribbon {
    top: 0px !important;
    left: 3px !important;
}
</style>
<!-- Start Content-->
<div class="container-fluid">
    <div>{{ Breadcrumbs::render('student_extra_classes', request()->iacs_id) }}</div>
    <div class="card-box position-relative">
        <h3 class="heading-title m-0 text-center heading">Extra Classes</h3>
        <form class="app-search align-items-center justify-content-center mt-3">
            <div class="app-search-box">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Search by Unit Name" id="unit_input"
                        name="unit" value="{{$_GET['unit']??''}}">
                    <div class="input-group-append">
                        <button class="btn" type="submit">
                            <i class="fe-search"></i>
                        </button>
                    </div>
                </div>
            </div>
            <div class="app-search-box">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Search by Lecture" id="lecture_input"
                        name="lecture" value="{{$_GET['lecture']??''}}">
                    <div class="input-group-append">
                        <button class="btn" type="submit">
                            <i class="fe-search"></i>
                        </button>
                    </div>
                </div>
            </div>
            <button class="btn btn-theme">Search</button>&nbsp;
            <button type="button" class="btn btn-theme"
                onclick="document.getElementById('unit_input').value='';document.getElementById('lecture_input').value='';this.form.submit();">Reset</button>
        </form>
    </div>

    @php

    $old_data =
    DB::table('class_notifications')->where('type','extraClass')->where('i_a_c_s_id',request()->iacs_id)->where('notify_date','
    <=',date('Y-m-d'))->get(); 
        if ($old_data) {
        $items2 = [];
        foreach($old_data as $dat){
        $old_data_arr = !empty($dat->readUsers) ? explode(',',$dat->readUsers) :[];
        if(!in_array(auth()->user()->student_id , $old_data_arr)) {
        $items2[] = $dat->class_id ? $dat->class_id : '';
        $old_data_arr[] = auth()->user()->student_id;
        $query =
        DB::table('class_notifications')->where('type','extraClass')->where('i_a_c_s_id',request()->iacs_id)->where('notify_date','
        <=',date('Y-m-d'))->update([
            'readUsers'=> implode(',',$old_data_arr),
            ]);
            }
            }
            }
            @endphp

            <div class="card-box">
                <div class="table-responsive">
                    @foreach ($extra_classesGroupedByUnits as $key => $unit)

                    @if ($unit->extra_classes->count())
                    <h4 class=" mt-0 mb-3 text-center fw-100">{{$unit->name}}</h4>
                    <div class="row revised mx-0">
                        @foreach ($unit->extra_classes as $key1 => $extra_class)
                        @if($extra_class->extra_class_date <= date('Y-m-d 23:59:59')) @if(!empty($extra_class->
                            extra_class_video))
                            <?php 
            $video = '';
            if(!empty($extra_class->extra_class_video)){
                $filename = unserialize($extra_class->extra_class_video);
                $video = $filename[0];
            }
            $notes = '';
            if(!empty($extra_class->notes)){
                $notesname = unserialize($extra_class->notes);
                $notes = $notesname[0];
            }
                    ?>
                            <div class="col-md-3 p-1 col-sm-6 col-6">
                                @if(in_array($extra_class->id, $items2))
                                <div class="ribbon" style=""><span>New</span></div>
                                @endif
                                <div class="{{$colors[$key1%6]}} br-6 px-2 py-3">
                                    <h4 class=" text-center fw-100 text-white mt-0 mb-1  font-16"><b>Lecture
                                            {{$extra_class->extra_class_number}}</b>
                                    </h4>
                                    <h4 class=" text-center fw-100 text-white mt-0 mb-1  font-16 oneLine"
                                        title="{{$extra_class->extra_class_name}}" data-toggle="tooltip">
                                        {{$extra_class->extra_class_name}}</h4>
                                    <h4 class=" text-center fw-100 text-white mt-0 mb-1 font-16">
                                        {{date('d/m/Y', strtotime($extra_class->extra_class_date))}}</h4>
                                    <div class="d-flex align-items-start">
                                        {{-- <h4
                class="watch_video font-15 text-white mb-0 mt-1 fw-100 d-flex justify-content-center text-center flex-column w-50">
                <a data-fancybox class=" text-white justify-content-center text-center fancybox-gallery"
                  rel="video-gallery" href="{{$extra_class->extra_class_video}}">
                                        <i class="mdi mdi-play-circle"></i></a>Watch Video
                                        </h4> --}}

                                        <h4
                                            class=" font-15 text-white mb-0 mt-1 fw-100 d-flex justify-content-center text-center flex-column w-50">
                                            <a target='_blank' rel="video-gallery" href="{{$video ?? ''}}">
                                                <i class="mdi mdi-play-circle"></i><br><span class="text-white">Watch
                                                    Video</span></a>
                                        </h4>
                                        <h4
                                            class=" font-15 text-white mb-0 mt-1 fw-100 d-flex justify-content-center  text-center flex-column w-50">
                                            <a class=" text-white justify-content-center text-center"
                                                href="{{$notes ?? ''}}" target="_blank"> <i
                                                    class="mdi mdi-download"></i><br><span class="text-white">View
                                                    Notes</span></a>
                                        </h4>
                                    </div>
                                </div>
                            </div>
                            @endif

                            @endif

                            @endforeach
                    </div>
                    @endif
                    @endforeach
                </div>
            </div>
            {{-- <div class="card-box">
    <div class="table-responsive">
      <h4 class=" mt-0 mb-3 text-center fw-100">Unit 2: Kinematics</h4>
      <table class="table table-bordered mb-0 package-table">
        <thead>
          <tr>
            <th>
              <h4 class="header-title m-0 text-center heading">Extra Class Number</h4>
            </th>
            <th>
              <h4 class="header-title m-0 text-center heading">Extra Class Name</h4>
            </th>
            <th>
              <h4 class="header-title m-0 text-center heading">Extra Class Date</h4>
            </th>
            <th>
              <h4 class="header-title m-0 text-center heading">Action</h4>
            </th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td scope="row">Extra Class 1</td>
            <td>Basics Of kinematics</td>
            <td>28/03/2020</td>
            <td><a data-fancybox=""
                class="btn-theme text-white btn-style justify-content-center text-center fancybox-gallery"
                rel="video-gallery"
                href="https://www.youtube.com/watch?v=iuimHfnP5aU&amp;list=PLWx-A6wseQ6n-i692JSWuNvZcNTV-ULZu">
                <span class="text-video mr-1 text-capitalize text-white">View extra_class</span> <i
                  class="mdi mdi-play-circle"></i></a></td>
          </tr>
          <tr>
            <td scope="row">Extra Class 2</td>
            <td>Basics Of kinematics</td>
            <td>29/03/2020</td>
            <td><a data-fancybox=""
                class="btn-theme text-white btn-style justify-content-center text-center fancybox-gallery"
                rel="video-gallery"
                href="https://www.youtube.com/watch?v=iuimHfnP5aU&amp;list=PLWx-A6wseQ6n-i692JSWuNvZcNTV-ULZu">
                <span class="text-video mr-1 text-capitalize text-white">View extra_class</span> <i
                  class="mdi mdi-play-circle"></i></a></td>
          </tr>
          <tr>
            <td scope="row">Extra Class 3</td>
            <td>Basics Of kinematics</td>
            <td>31/03/2020</td>
            <td><a data-fancybox=""
                class="btn-theme text-white btn-style justify-content-center text-center fancybox-gallery"
                rel="video-gallery"
                href="https://www.youtube.com/watch?v=iuimHfnP5aU&amp;list=PLWx-A6wseQ6n-i692JSWuNvZcNTV-ULZu">
                <span class="text-video mr-1 text-capitalize text-white">View extra_class</span> <i
                  class="mdi mdi-play-circle"></i></a></td>
          </tr>
        </tbody>
      </table>
    </div>
  </div> --}}
</div> <!-- container -->
{{-- <input type="hidden" id="add_new_institute_form_url" value="{{route('institute.extra_classes.store')}}" /> --}}
@endsection
@push('js')
{{-- <script src="{{ URL::to('assets/admin/js/jquery-validate.js')}}"></script>
<script src="{{ URL::to('assets/admin/js/add-institute.js')}}"></script> --}}
{{-- <script>
$(function() {
    $('.popup-youtube, .popup-vimeo').magnificPopup({
        disableOn: 700,
        type: 'iframe',
        mainClass: 'mfp-fade',
        removalDelay: 160,
        preloader: false,
        fixedContentPos: false
    });
});
</script> --}}
@endpush