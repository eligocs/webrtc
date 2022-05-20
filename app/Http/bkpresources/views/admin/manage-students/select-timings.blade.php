@extends('admin.layouts.app')
@section('content')
<link href="{{url('assets/admin/css/style.css')}}" rel="stylesheet" type="text/css" />
<style>
    .checkboxes input[type=radio] {
        display: none;
    }

    .checkboxes label {
        font-weight: 500;
        color: #482782;
        border: 1px solid;
        padding: 4px 9px;
        margin: 2px;
        border: 1px solid transparent;
        border-radius: 3px;
        line-height: 1.4;
    }

    input[type=radio]:checked+label {
        color: white;
        background: #482782;
        padding: 4px 9px;
        border-radius: 3px;
        margin: 3px;
    }
</style>
<!-- Start content -->
@php
// dd($m_o_c);
@endphp
@if($m_o_c == 2)
<div class="content">
    <div class="">
        <div class="page-header-title">
            <h4 class="page-title">Select Timing</h4>
        </div>
    </div>

    <div class="page-content-wrapper ">
        <div class="container-fluid">
            @error("same_day_same_time_error")
            <div class="alert alert-danger text-center">{{ $message }}</div>
            @enderror
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12">
                            @if(isset($data['iacss']) && count($data['iacss'])>0)
                            <form action="{{route('admin.checkout')}}" method="post">
                                @csrf
                                @foreach ($data['iacss'] as $iacs)
                                <div class="select-days">
                                    <h3 class="d-block w-100 text-center" style="color: #482782;">
                                        {{ucFirst($iacs->subject->name)}}</h3>
                                    <input type="hidden" name="student_id" value="{{Request::segment(5)}}">
                                    <input type="hidden" name="mode_of_class" value="{{Request::segment(4)}}">
                                    <input type="hidden" name="class_id"
                                        value="{{old('class_id')??$iacs->institute_assigned_class_id}}">
                                    @foreach ($iacs->subjects_infos as $day)
                                    <div class="row"
                                        style="display: flex; flex-wrap: wrap; align-items: baseline; margin: 20px 0; width:100%;">
                                        <div class="col-lg-2">
                                            <label class="subject m-0">{{ucFirst($day->day)}}</label>
                                        </div>
                                        <div class="col-lg-10">
                                            <div class="checkboxes d-flex justify-content-start flex-wrap">
                                                @foreach (\App\Models\TimeSlot::all() as $item)
                                                {{-- {{dd(old("row"), $item->id) }} --}}
                                                <input type="radio" name="row[{{$day->id}}][slot]"
                                                    id="{{strtolower($day->day)}}_{{$day->id}}_slot_{{$item->id}}"
                                                    value="{{$item->id}}"
                                                    {{!empty(old('row')[$day->id]['slot']) ? ((old("row")[$day->id]['slot'] == $item->id) ? 'checked': '') : '' }}>
                                                <label for="{{strtolower($day->day)}}_{{$day->id}}_slot_{{$item->id}}"
                                                    class="highlight">{{$item->slot}}</label>
                                                <input type="hidden" name="row[{{$day->id}}][day]"
                                                    id="{{strtolower($day->day)}}_{{$day->id}}_day_{{$item->id}}"
                                                    value="{{strtolower($day->day)}}"
                                                    {{!empty(old('row')[$day->id]['day']) ? ((old("row")[$day->id]['day'] == $item->id) ? 'checked': '') : '' }}>
                                                <br>
                                                @endforeach
                                            </div>
                                            <div class="response_{{$day->id}}">
                                                @error("row.$day->id.slot")
                                                <div class="error text-red text-center">This field is required!!!</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                                @endforeach
                                <div class="text-center"><button class=" btn btn-theme" id="createClass">Enroll
                                        Now</button></div>
                                @endif
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div> <!-- container-fluid -->
    </div> <!-- Page content Wrapper -->
</div><!-- content -->
<input type="hidden" id="create_class_post_url" value="{{route('admin.manage-institutes.create-class')}}" />
@else
<div class="content">
    <div class="">
        <div class="page-header-title">
            <h4 class="page-title">Select Timing</h4>
        </div>
    </div>

    <div class="page-content-wrapper ">
        <div class="container-fluid">
            @error("same_day_same_time_error")
            <div class="alert alert-danger text-center">{{ $message }}</div>
            @enderror
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12">
                            @if(isset($data['iacss']) && count($data['iacss'])>0)
                            <form action="{{route('admin.checkout')}}" method="post" name="myForm">
                                @csrf
                                @foreach ($data['iacss'] as $iacs)
                                <div class="select-days">
                                    <h3 class="d-block w-100 text-center" style="color: #482782;">
                                        {{ucFirst($iacs->subject->name)}}</h3>
                                    <input type="hidden" name="student_id" value="{{Request::segment(5)}}">
                                    <input type="hidden" name="mode_of_class" value="{{Request::segment(4)}}">
                                    <input type="hidden" name="class_id"
                                        value="{{old('class_id')??$iacs->institute_assigned_class_id}}">
                                    @foreach ($iacs->subjects_infos as $day)
                                    <div class="row"
                                        style="display: flex; flex-wrap: wrap; align-items: baseline; margin: 20px 0; width:100%;">
                                        <div class="col-lg-2">
                                            <label class="subject m-0">{{ucFirst($day->day)}}</label>
                                        </div>
                                        <div class="col-lg-10">
                                            <div class="checkboxes d-flex justify-content-start flex-wrap">
                                                @foreach (\App\Models\TimeSlot::all() as $item)
                                                {{-- {{dd(old("row"), $item->id) }} --}}
                                                <input type="radio" name="row[{{$day->id}}][slot]"
                                                    id="{{strtolower($day->day)}}_{{$day->id}}_slot_{{$item->id}}"
                                                    value="{{$item->id}}"
                                                    {{!empty(old('row')[$day->id]['slot']) ? ((old("row")[$day->id]['slot'] == $item->id) ? 'checked': '') : '' }}>
                                                <label for="{{strtolower($day->day)}}_{{$day->id}}_slot_{{$item->id}}"
                                                    class="highlight">{{$item->slot}}</label>
                                                <input type="hidden" name="row[{{$day->id}}][day]"
                                                    id="{{strtolower($day->day)}}_{{$day->id}}_day_{{$item->id}}"
                                                    value="{{strtolower($day->day)}}"
                                                    {{!empty(old('row')[$day->id]['day']) ? ((old("row")[$day->id]['day'] == $item->id) ? 'checked': '') : '' }}>
                                                <br>
                                                @endforeach
                                            </div>
                                            <div class="response_{{$day->id}}">
                                                @error("row.$day->id.slot")
                                                <div class="error text-red text-center">This field is required!!!</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                                @endforeach
                                <div class="text-center"><button class=" btn btn-theme" id="createClass">Enroll
                                        Now</button></div>
                                @endif
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    window.onload=function(){
          document.forms["myForm"].submit();
    }
</script>
@endif
@endsection
@section('js')
<script>
    $(document).ready(function(){
    $('.highlight').click(function(){
      $(this).class
    })
  })
</script>
@endsection
