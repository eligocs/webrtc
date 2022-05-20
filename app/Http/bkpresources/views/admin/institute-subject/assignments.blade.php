@extends('admin.layouts.app')
@section('page_heading', 'Assignments')
@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
  .quiz-card {
    padding: 5px 20px 20px 20px;
    box-shadow: 0 7px 15px 0 rgba(0, 0, 0, 0.1);
    background-color: #FFF;
    border-top: 3px solid rgb(100, 70, 153);
    margin-bottom: 30px;
  }

  .quiz-name {
    font-size: 20px;
  }

  .quiz-card p {
    font-size: 13px;
  }

  .topic-detail {
    margin: 10px 0 20px;
    list-style-type: none;
    -webkit-padding-start: 0;
  }

  .topic-detail li {
    margin-bottom: 6px;
    position: relative;
    padding-right: 14px;
  }

  .topic-detail li .fa {
    position: absolute;
    right: 0;
    top: 3.5px;
    color: #644699;
  }

  .fa-long-arrow-right:before {
    content: "\f178";
  }

  .btn-danger {
    color: white !important;
    cursor: pointer;
  }

  .btn-danger:hover,
  .btn-danger:active,
  .btn-danger.hover {
    background-color: #d73925;
  }

  .btn-default {
    background-color: #f4f4f4;
    color: #444;
    border-color: #ddd;
  }

  .btn-default:hover,
  .btn-default:active,
  .btn-default.hover {
    background-color: #e7e7e7;
  }
</style>
<!-- Create Modal -->
{{-- <div id="createModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Add Assignment</h4>
      </div>
      {!! Form::open(['method' => 'POST', 'action' => ['Web\Institute\AssignmentController@store', request()->iacs_id]])
      !!}
      <div class="modal-body">
        <div class="row">
          <div class="col-md-6">
            <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
{!! Form::label('title', 'Assignment Title') !!}
<span class="required">*</span>
{!! Form::text('title', null, ['class' => 'form-control', 'placeholder' => 'Please Enter Assignment
Title', 'required' => 'required']) !!}
<small class="text-danger">{{ $errors->first('title') }}</small>
</div>
<div class="form-group{{ $errors->has('per_q_mark') ? ' has-error' : '' }}">
  {!! Form::label('per_q_mark', 'Per Question Mark') !!}
  <span class="required">*</span>
  {!! Form::number('per_q_mark', null, ['class' => 'form-control', 'placeholder' => 'Please Enter Per
  Question Mark', 'required' => 'required']) !!}
  <small class="text-danger">{{ $errors->first('per_q_mark') }}</small>
</div>
<br>






<div class="form-group {{ $errors->has('show_ans') ? ' has-error' : '' }}">
  <label for="">Enable Show Answer: </label>
  <input type="checkbox" class="toggle-input" name="show_ans" id="toggle2">
  <label for="toggle2"></label>
  <br>
</div>

</div>
<div class="col-md-6">
  <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
    {!! Form::label('description', 'Description') !!}
    {!! Form::textarea('description', null, ['class' => 'form-control', 'placeholder' => 'Please Enter
    Assignment
    Description', 'rows' => '8']) !!}
    <small class="text-danger">{{ $errors->first('description') }}</small>
  </div>
</div>
</div>
</div>
<div class="modal-footer justify-content-center">
  <div class="btn-group d-md-flex justify-content-center">
    {!! Form::reset("Reset", ['class' => 'btn btn-danger']) !!}
    {!! Form::submit("Add", ['class' => 'btn btn-theme']) !!}
  </div>
</div>
{!! Form::close() !!}
</div>
</div>
</div> --}}
{{-- <div>{{ Breadcrumbs::render('assignments', request()->iacs_id) }}</div> --}}
<div class="row">
  <div class="col-md-12 d-md-flex justify-content-start mb-3">
    {{-- <button type="button" class="btn-theme btn-style ml-1" data-toggle="modal" data-target="#createModal">Add
      Assignment</button> --}}
  </div>
  @if ($topics)
  @foreach ($topics as $key => $topic)
  <div class="col-md-4">
    <div class="quiz-card">
      <p class="text-right m-0">
        <!-- Edit Button -->
        {{-- <a type="button" class="btn btn-theme btn-xs text-white" data-toggle="modal"
          data-target="#EditModal{{$topic->id}}"><i class="fa fa-edit"></i></a>
        <!-- Delete Button -->
        <a type="button" class="btn btn-xs btn-danger" data-toggle="modal" data-target="#deleteModal{{$topic->id}}"><i
            class="fa fa-close"></i></a> --}}
        <!-- edit model -->
        {{-- <div id="EditModal{{$topic->id}}" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title">Edit Assignment</h4>
            </div>
            {!! Form::model($topic, ['method' => 'PATCH', 'action' =>
            ['Web\Institute\AssignmentController@update',
            request()->iacs_id, $topic->id]]) !!}
            <div class="modal-body">
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                    {!! Form::label('title', 'Topic Title') !!}
                    <span class="required">*</span>
                    {!! Form::text('title', null, ['class' => 'form-control', 'placeholder' => 'Please Enter
                    Assignment Title',
                    'required' => 'required']) !!}
                    <small class="text-danger">{{ $errors->first('title') }}</small>
                  </div>
                  <div class="form-group{{ $errors->has('per_q_mark') ? ' has-error' : '' }}">
                    {!! Form::label('per_q_mark', 'Per Question Mark') !!}
                    <span class="required">*</span>
                    {!! Form::number('per_q_mark', null, ['class' => 'form-control',
                    'placeholder' => 'Please Enter Per Question Mark', 'required' =>
                    'required']) !!}
                    <small class="text-danger">{{ $errors->first('per_q_mark') }}</small>
                  </div>

                  <label for="">Enable Show Answer: </label>
                  <input {{ $topic->show_ans ==1 ? "checked" : "" }} type="checkbox" class="toggle-input"
                    name="show_ans" id="toggle{{ $topic->id }}">
                  <label for="toggle{{ $topic->id }}"></label>
                </div>

                <div class="col-md-6">
                  <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                    {!! Form::label('description', 'Description') !!}
                    {!! Form::textarea('description', null, ['class' => 'form-control',
                    'placeholder' => 'Please Enter Assignment Description']) !!}
                    <small class="text-danger">{{ $errors->first('description') }}</small>
                  </div>
                </div>
              </div>



              <div class="modal-footer justify-content-center">
                <div class="btn-group">
                  {!! Form::submit("Update", ['class' => 'btn btn-theme']) !!}
                </div>
              </div>
              {!! Form::close() !!}
            </div>
          </div>
        </div>
    </div> --}}
    {{-- <div id="deleteModal{{$topic->id}}" class="delete-modal modal fade" role="dialog">
    <!-- Delete Modal -->
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-header no-border">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <div class="delete-icon"></div>
        </div>
        <div class="modal-body text-center">
          <h4 class="modal-heading">Are You Sure ?</h4>
          <p>Do you really want to delete these records? This process cannot be undone.
          </p>
        </div>
        <div class="modal-footer no-border justify-content-center">
          {!! Form::open(['method' => 'DELETE', 'action' =>
          ['Web\Institute\AssignmentController@destroy', request()->iacs_id,
          $topic->id]]) !!}
          {!! Form::reset("No", ['class' => 'btn btn-gray', 'data-dismiss' => 'modal'])
          !!}
          {!! Form::submit("Yes", ['class' => 'btn btn-danger']) !!}
          {!! Form::close() !!}
        </div>
      </div>
    </div>
  </div> --}}
  </p>
  <h3 class="quiz-name">{{$topic->title}}</h3>
  <p title="{{$topic->description}}">
    {{Str::limit($topic->description, 120)}}
  </p>
  <div class="row">
    <div class="col-6 pad-0">
      <ul class="topic-detail">
        <li>Per Question Mark <i class="fa fa-long-arrow-right"></i></li>
        <li>Total Marks <i class="fa fa-long-arrow-right"></i></li>
        <li>Total Questions <i class="fa fa-long-arrow-right"></i></li>
        <li>Total Time <i class="fa fa-long-arrow-right"></i></li>
      </ul>
    </div>
    <div class="col-6">
      <ul class="topic-detail right">
        <li>{{$topic->per_q_mark}}</li>
        <li>
          @php
          $qu_count = 0;
          @endphp
          @foreach($questions as $question)
          @if($question->topic_id == $topic->id)
          @php
          $qu_count++;
          @endphp
          @endif
          @endforeach
          {{$topic->per_q_mark*$qu_count}}
        </li>
        <li>
          {{$qu_count}}
        </li>
        <li>
          {{$topic->timer}} minutes
        </li>
      </ul>
    </div>
  </div>
  <div class="d-flex flex-wrap justify-content-center">
    {{-- <a href="{{route('institute.questions.show', [request()->iacs_id, $topic->id])}}" class="btn btn-theme m-1">Add
    Questions</a> --}}
    <a href="{{route('admin.institute-subject.reports', [request()->iacs_id, $topic->id])}}"
      class="btn btn-theme m-1">Show
      Reports</a>
  </div>
</div>

<div id="deleteans{{ $topic->id }}" class="delete-modal modal fade" role="dialog">
  <!-- Delete Modal -->
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header no-border">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <div class="delete-icon"></div>
      </div>
      <div class="modal-body text-center">
        <h4 class="modal-heading">Are You Sure ?</h4>
        <p>Do you really want to delete these Assignment Answer Sheet? This process cannot be undone.</p>
      </div>
      <div class="modal-footer  no-border justify-content-center">
        {!! Form::open(['method' => 'DELETE', 'action' => ['Web\Institute\AssignmentController@deleteperquizsheet',
        request()->iacs_id, $topic->id]]) !!}
        {!! Form::reset("No", ['class' => 'btn btn-gray', 'data-dismiss' => 'modal']) !!}
        {!! Form::submit("Yes", ['class' => 'btn btn-danger']) !!}
        {!! Form::close() !!}
      </div>
    </div>
  </div>
</div>
</div>
@endforeach
@endif
</div>
@endsection
@push('js')
<script type="text/javascript">
  $(function() {
        $('#fb_check').change(function() {
        $('#fb').val(+ $(this).prop('checked'))
        })
    })             
    $(document).ready(function(){

        $('.quizfp').change(function(){

            if ($('.quizfp').is(':checked')){
                $('#doabox').show('fast');
            }else{
                $('#doabox').hide('fast');
            }

            
        });

    });
                                                          
    $('#priceCheck').change(function(){
        alert('hi');
    });

    function showprice(id)
    {
        if ($('#toggle2'+id).is(':checked')){
        $('#doabox2'+id).show('fast');
        }else{

        $('#doabox2'+id).hide('fast');
        }
    }
</script>
@endpush