@extends('institute.layouts.app')
@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
    .quiz-card {
        padding: 5px 20px 20px 20px;
        box-shadow: 0 7px 15px 0 rgba(0, 0, 0, 0.1);
        background-color: #FFF;
        border-top: 3px solid #644699;
        margin-bottom: 30px;
    }

    .quiz-name {
        font-size: 22px;
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
    }

    .topic-detail li .fa {
        position: absolute;
        right: 0;
        top: 3.5px;
        color: #26a69a;
    }

    .fa-long-arrow-right:before {
        content: "\f178";
    }

    /* .btn-wave,
    button.btn-wave {
        position: relative;
        cursor: pointer;
        display: inline-block;
        overflow: hidden;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
        -webkit-tap-highlight-color: transparent;
        vertical-align: middle;
        z-index: 1;
        -webkit-transition: .3s ease-out;
        transition: .3s ease-out;
        border: none;
        text-decoration: none;
        color: #fff;
        background-color: #26a69a;
        text-align: center;
        letter-spacing: .5px;
        -webkit-transition: .2s ease-out;
        transition: .2s ease-out;
        cursor: pointer;
    } */

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
<div id="createModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Add Quiz</h4>
            </div>
            {!! Form::open(['method' => 'POST', 'action' => ['Web\Institute\TopicController@store', request()->iacsId]])
            !!}
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                            {!! Form::label('title', 'Quiz Title') !!}
                            <span class="required">*</span>
                            {!! Form::text('title', null, ['class' => 'form-control', 'placeholder' => 'Please Enter Quiz Title', 'required' => 'required']) !!}
                            <small class="text-danger">{{ $errors->first('title') }}</small>
                        </div>
                        <div class="form-group{{ $errors->has('per_q_mark') ? ' has-error' : '' }}">
                            {!! Form::label('per_q_mark', 'Per Question Mark') !!}
                            <span class="required">*</span>
                            {!! Form::number('per_q_mark', null, ['class' => 'form-control', 'placeholder' => 'Please Enter Per Question Mark', 'required' => 'required']) !!}
                            <small class="text-danger">{{ $errors->first('per_q_mark') }}</small>
                        </div>
                        <div class="form-group{{ $errors->has('timer') ? ' has-error' : '' }}">
                            {!! Form::label('timer', 'Quiz Time (in minutes)') !!}
                            {!! Form::number('timer', null, ['class' => 'form-control', 'placeholder' => 'Please Enter Quiz Total Time (In Minutes)']) !!}
                            <small class="text-danger">{{ $errors->first('timer') }}</small>
                        </div>

                        {{-- <label for="married_status">Quiz Price:</label> --}}
                        {{-- <select name="married_status" id="ms" class="form-control">
                  <option value="no">Free</option>
                  <option value="yes">Paid</option>
                </select> --}}

                        {{-- <input type="checkbox" class="quizfp toggle-input" name="quiz_price" id="toggle">
                        <label for="toggle"></label> --}}

                        {{-- <div style="display: none;" id="doabox">
                            <br>
                            <label for="dob">Choose Quiz Price: </label>
                            <div class="form-group{{ $errors->has('amount') ? ' has-error' : '' }}">
                                <input value="" name="amount" id="doa" type="text" class="form-control"
                                    placeholder="Please Enter Quiz Price">
                                <small class="text-danger">{{ $errors->first('amount') }}</small>
                            </div>
                        </div> --}}
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
                            {!! Form::textarea('description', null, ['class' => 'form-control', 'placeholder' => 'Please Enter Quiz Description', 'rows' => '8']) !!}
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
</div>
<div class="card-box">
    <div class="col-md-12 d-md-flex justify-content-end mb-3">
        <button type="button" class="btn-theme btn-style ml-1" data-toggle="modal" data-target="#createModal">Add
            Quiz</button>
    </div>
    <div class="box-body table-responsive">
        <table id="search" class="table table-hover table-striped package-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Quiz Title</th>
                    <th>Description</th>
                    <th>Per Question Mark</th>
                    <th>Time</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @if ($topics)
                @php($i = 1)
                @foreach ($topics as $topic)
                <tr>
                    <td>
                        {{$i}}
                        @php($i++)
                    </td>
                    <td>{{$topic->title}}</td>
                    <td title="{{$topic->description}}">{{Str::limit($topic->description, 50)}}</td>
                    <td>{{$topic->per_q_mark}}</td>
                    <td>{{$topic->timer}} mins</td>
                    <td>
                        <!-- Edit Button -->
                        <a type="button" class="btn btn-theme btn-xs" data-toggle="modal"
                            data-target="#EditModal{{$topic->id}}"><i class="fa fa-edit"></i> Edit</a>
                        <!-- Delete Button -->
                        <a type="button" class="btn btn-xs btn-danger" data-toggle="modal"
                            data-target="#deleteModal{{$topic->id}}"><i class="fa fa-close"></i> Delete</a>
                        <div id="deleteModal{{$topic->id}}" class="delete-modal modal fade" role="dialog">
                            <!-- Delete Modal -->
                            <div class="modal-dialog modal-sm">
                                <div class="modal-content">
                                    <div class="modal-header">
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
                                        ['Web\Institute\TopicController@destroy', request()->iacsId,
                                        $topic->id]]) !!}
                                        {!! Form::reset("No", ['class' => 'btn btn-theme', 'data-dismiss' => 'modal'])
                                        !!}
                                        {!! Form::submit("Yes", ['class' => 'btn btn-danger']) !!}
                                        {!! Form::close() !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
                <!-- edit model -->
                <div id="EditModal{{$topic->id}}" class="modal fade" role="dialog">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">Edit Quiz</h4>
                            </div>
                            {!! Form::model($topic, ['method' => 'PATCH', 'action' =>
                            ['Web\Institute\TopicController@update',
                            request()->iacsId, $topic->id]]) !!}
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                                            {!! Form::label('title', 'Topic Title') !!}
                                            <span class="required">*</span>
                                            {!! Form::text('title', null, ['class' => 'form-control', 'placeholder' => 'Please Enter Quiz Title', 'required' => 'required']) !!}
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
                                        <div class="form-group{{ $errors->has('timer') ? ' has-error' : '' }}">
                                            {!! Form::label('timer', 'Quiz Time (in minutes)') !!}
                                            {!! Form::number('timer', null, ['class' => 'form-control', 'placeholder' => 'Please Enter Quiz Total Time (In Minutes)']) !!}
                                            <small class="text-danger">{{ $errors->first('timer') }}</small>
                                        </div>


                                        <label for="">Enable Show Answer: </label>
                                        <input {{ $topic->show_ans ==1 ? "checked" : "" }} type="checkbox"
                                            class="toggle-input" name="show_ans" id="toggle{{ $topic->id }}">
                                        <label for="toggle{{ $topic->id }}"></label>

                                        {{-- <label for="">Quiz Price:</label>
                                        <input onchange="showprice('{{ $topic->id }}')"
                                            {{ $topic->amount !=NULL  ? "checked" : ""}} type="checkbox"
                                            class="toggle-input " name="pricechk" id="toggle2{{ $topic->id }}"> --}}
                                        {{-- <label for="toggle2{{ $topic->id }}"></label> --}}

                                        {{-- <div style="{{ $topic->amount == NULL ? "display: none" : "" }}"
                                            id="doabox2{{ $topic->id }}">

                                            <label for="doba">Choose Quiz Price: </label>
                                            <div class="form-group{{ $errors->has('amount') ? ' has-error' : '' }}">
                                                <input value="{{ $topic->amount }}" name="amount" id="doa" type="text"
                                                    class="form-control" placeholder="Please Enter Quiz Price">
                                                <small class="text-danger">{{ $errors->first('amount') }}</small>
                                            </div>
                                        </div> --}}


                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                                            {!! Form::label('description', 'Description') !!}
                                            {!! Form::textarea('description', null, ['class' => 'form-control',
                                            'placeholder' => 'Please Enter Quiz Description']) !!}
                                            <small class="text-danger">{{ $errors->first('description') }}</small>
                                        </div>
                                    </div>
                                </div>



                                <div class="modal-footer">
                                    <div class="btn-group pull-right">
                                        {!! Form::submit("Update", ['class' => 'btn btn-theme']) !!}
                                    </div>
                                </div>
                                {!! Form::close() !!}
                            </div>
                        </div>
                    </div>
                    @endforeach
                    @endif
            </tbody>
        </table>
    </div>
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