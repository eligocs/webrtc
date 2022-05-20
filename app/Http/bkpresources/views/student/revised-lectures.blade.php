@extends('student.layouts.app')
@section('page_heading', 'Lectures')
@section('content')

<!-- Start Content-->
<div class="container-fluid">
    {{ Breadcrumbs::render('student_revised_lectures', request()->iacs_id) }}
    <div class="card-box position-relative">
        <h3 class="heading-title m-0 text-center heading">Revise Lectures</h3>
        <form class="app-search align-items-center justify-content-center mt-3">
            <div class="app-search-box">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Search by Unit Name" id="unit_input"
                        name="unit" value="{{ $_GET['unit'] ?? '' }}">
                    <div class="input-group-append">
                        <button class="btn" type="submit">
                            <i class="fe-search"></i>
                        </button>
                    </div>
                </div>
            </div>
            <div class="app-search-box">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Search by Lecture Name" id="lecture_input"
                        name="lecture" value="{{ $_GET['lecture'] ?? '' }}">
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
    <div class="card-box">
        <div class="table-responsive">
            @foreach ($lecturesGroupedByUnits as $key => $unit)
            @if ($unit->lectures->count())
            <h4 class=" mt-0 mb-3 text-center fw-100">{{ $unit->name }}</h4>
            <div class="row revised mx-0 mb-md-4 mb-1">
                @foreach ($unit->lectures as $key1 => $lecture)
                @if (!empty($lecture->lecture_video))
                <?php 
                    $video = '';
                    if(!empty($lecture->lecture_video) && @unserialize($lecture->lecture_video) == true){
                        $filename = unserialize($lecture->lecture_video);
                        $video = $filename[0];
                    }
                    $notes = '';
                    if(!empty($lecture->notes) && @unserialize($lecture->notes) == true){
                        $notesname = unserialize($lecture->notes);
                        $notes = $notesname[0];
                    }
                                ?>
                <div class="col-md-3 p-1 col-sm-6 col-6">
                    <div class="{{ $colors[$key1 % 6] }} br-6 px-2 py-3">
                        <h4 class=" text-center fw-100 text-white mt-0 mb-1  font-16"><b>Lecture
                                {{ $lecture->lecture_number }}</b>
                        </h4>
                        <h4 class=" text-center fw-100 text-white mt-0 mb-1  font-16 oneLine" data-toggle="tooltip"
                            title="{{ $lecture->lecture_name }}">
                            {{ $lecture->lecture_name }}</h4>
                        <h4 class=" text-center fw-100 text-white mt-0 mb-1 font-16">
                            {{ date('d/m/Y', strtotime($lecture->lecture_date)) }}
                        </h4>
                        <div class="d-flex align-items-start">
                            <h4
                                class=" font-15 text-white mb-0 mt-1 fw-100 d-flex justify-content-center text-center flex-column w-50">
                                <a target='_blank' class=" text-whitejustify-content-center text-center "
                                    rel="video-gallery" href="{{ $video ?? '' }}">
                                    <i class="mdi mdi-play-circle"></i></a>Watch Video
                            </h4>
                            <h4
                                class=" font-15 text-white mb-0 mt-1 fw-100 d-flex justify-content-center  text-center flex-column w-50">
                                <a class=" text-white justify-content-center text-center" href="{{ $notes ?? '' }}"
                                    target="_blank"> <i class="mdi mdi-download"></i></a>View Notes
                            </h4>
                        </div>
                    </div>
                </div>
                @endif
                @endforeach
            </div>
            @endif
            @endforeach
        </div>
    </div>
</div> <!-- container -->
@endsection
@push('js')
{{-- <script src="{{ URL::to('assets/admin/js/jquery-validate.js')}}"></script>
<script src="{{ URL::to('assets/admin/js/add-institute.js')}}"></script> --}}
{{-- <script>
  $(document).ready(function() {
    var select2 = $('#select2_id').select2({
      tags: true,
      insertTag: function(data, tag){
      tag.text = tag.text + "(new)";
      data.push(tag);
      },
      }).on('select2:select', function(){
      if($(this).find("option:selected").data("select2-tag")==true) {
        $.ajax({
          url: "{{route('institute.lectures.addUnit', request()->i_assigned_class_subject_id)}}",
method: "post",
dataType: "json",
data: {
name: $(this).find("option:selected").val(),
_token: "{{csrf_token()}}"
},
success: function(response){
// alert(response.status);
if(response.status){
$(this).find("option:selected").val(response.data.id);
$(this).find("option:selected").text(response.data.name);
}
}
})
}
// language: {
// noResults: function(text) {
// return 'No Result Found<a href="javascript:void(0)" onclick="noResultsButtonClicked()" style="float: right;">Create
    Unit '+text+' <i class="fa fa-plus-circle"></i></a>';
// },
// },
// escapeMarkup: function(markup) {
// return markup;
// },
});

$('#select0_id').on('change', function(){
$.ajax({
url: "{{route('institute.lectures.getSubjectsByClassId', request()->i_assigned_class_subject_id)}}",
method: 'get',
dataType: 'json',
data: { id: $(this).val()},
success: function(response){
if(response.status){
let html = '';
for(x in response.data){
html+= `<option value="${response.data[x].id}">${response.data[x].name}</option>`;
}
$('#select1_id').html(html);
}
}
});
});
$('#select0_id, #select1_id').on('change', function(){
$.ajax({
url: "{{route('institute.lectures.getUnits', request()->i_assigned_class_subject_id)}}",
method: 'get',
dataType: 'json',
data: {
class_id: $('#select0_id').val(),
subject_id: $(this).val()
},
success: function(response){
if(response.status){
let html = '';
for(x in response.data){
html+= `<option value="${response.data[x].id}">${response.data[x].name}</option>`;
}
$('#select2_id').html(html);
}
}
})
})
});
</script> --}}
@endpush