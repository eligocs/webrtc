@extends('institute.layouts.app')
@section('page_heading', 'Assignments')
@section('content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        .quiz-card {
            padding: 5px 20px 20px 20px;
            box-shadow: 0 7px 15px 0 rgba(0, 0, 0, 0.1);
            background-color: #FFF;
            border-top: 3px solid rgb(100, 70, 153);
            min-height: 376px;
            height: 100%;
        }

        .quiz-name {
            font-size: 17px;
            max-height: 69px;
            overflow: hidden;
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
                                                                                                            background-color: #644699;
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

        small.olDate {
            float: right;
        }

        small.olDate {
            background: beige;
            padding: 5px;
            font-weight: 700;
            border-radius: 20px;
        }

    </style>
    <!-- Create Modal -->


    <div id="createModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Add Assignment</h4>
                </div>
                {!! Form::open(['method' => 'POST', 'action' => ['Web\Institute\AssignmentController@store', request()->iacsId]]) !!}
                <div class="modal-body">
                    <div class="row">
                        <div class=col-md-12>
                            <div class="form-group{{ $errors->has('answer') ? ' has-error' : '' }}">
                                <div id="selecte_mode">
                                    {!! Form::label('answer', 'Select paper mode') !!}
                                    <span class="required">*</span><br>
                                </div>
                                <div id="lableOfCalss">
                                    <label for="mcqradio">Mcq
                                    <input type="radio" name="testType" id="mcqradio" value="1" /></label>
                                    <label for="theoryradio">Theory
                                    <input type="radio" name="testType" id="theoryradio" value="2" /></label>
                                </div>
                            </div>
                        </div> 
                        <div class="col-md-6">
                            <div class="form-group">
                                <input type="hidden" id="iacsId" value="{{ request()->iacsId }}">
                                <label for="unit_name">Select Unit*</label>
                                <select name="unit" id="unit" class="select2 unit_name" required>
                                    <option value="">Select Unit</option>
                                    @foreach (\App\Models\Assignments_unit::where('institute_assigned_class_subject_id', request()->iacsId)->get() as $item)
                                        <option value="{{ $item->id }}">{{ $item->unitName }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                                {!! Form::label('title', 'Assignment Title') !!}
                                <span class="required">*</span>
                                {!! Form::text('title', null, ['class' => 'form-control', 'placeholder' => 'Please Enter Assignment Title', 'required' => 'required']) !!}
                                <small class="text-danger">{{ $errors->first('title') }}</small>
                            </div>
                            <div class="form-group{{ $errors->has('per_q_mark') ? ' has-error' : '' }}">
                                {!! Form::label('per_q_mark', 'Per Question Mark') !!}
                                <span class="required">*</span>
                                {!! Form::number('per_q_mark', null, ['class' => 'form-control', 'placeholder' => 'Please Enter Per Question Mark', 'required' => 'required']) !!}
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
                                {!! Form::textarea('description', null, ['class' => 'form-control', 'placeholder' => 'Please Enter Assignment Description', 'rows' => '8']) !!}
                                <small class="text-danger">{{ $errors->first('description') }}</small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-center">
                    <div class="btn-group d-md-flex justify-content-center">
                        {!! Form::reset('Reset', ['class' => 'btn btn-danger']) !!}
                        {!! Form::submit('Add', ['class' => 'btn btn-theme']) !!}
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
    <div>{{ Breadcrumbs::render('assignments', request()->iacsId) }}</div>
    <div class="row">
        <div class="col-md-12 d-md-flex justify-content-start mb-3">
            <button type="button" class="btn-theme btn-style ml-1" data-toggle="modal" data-target="#createModal">Add
                Assignment</button>
        </div>
        @if (!empty($topics))
            @foreach ($topics as $key => $unitname)
                @if ($unitname['topics']->count() > 0)
                    <div class="card-box col-12 paddingx">
                        <div class="col-12">
                            <h3 class=" mt-0 mb-3 text-center fw-100">{{ ucfirst($unitname['name']) }}</h3>
                        </div>
                    </div>
                    <div class="card-box col-12 paddingx">
                        <div class="row">
                            @foreach ($unitname['topics'] as $key => $topic)
                                <div class="col-md-4 mb-4">
                                    <div class="quiz-card">
                                        <div class="d-flex justify-content-between m-0 mb-3">
                                            {{-- publish button --}}
                                            @if ($topic->status == 'publish')
                                                <button data-toggle="modal" data-target="#publishModal"
                                                    class="btn btn-sm btn-success getOldAssingment"
                                                    data-id="{{ $topic->id ? $topic->id : '' }}"
                                                    data-date='{{ $topic->publish_date ? $topic->publish_date : '' }}'>Re-Publish</button>
                                            @else
                                                <!--   <form class='publishForm' action="{{ route('institute.topics.publish', [request()->iacsId, $topic->id]) }}" method="POST">
                                                                                                              @csrf -->
                                                <button data-toggle="modal" data-target="#publishModal"
                                                    data-id="{{ $topic->id ? $topic->id : '' }}"
                                                    class="btn btn-sm btn-danger publishThis" value="">Not yet
                                                    publish</button>
                                                <!-- </form> -->
                                            @endif
                                            @if ($topic->testType == '1')
                                            MCQ
                                            @endif
                                            @if($topic->testType == '2') 
                                                Theory
                                            @endif
                                            <div>
                                                <!-- Edit Button -->
                                                <a type="button" class="btn btn-theme btn-xs text-white" data-toggle="modal"
                                                    data-target="#EditModal{{ $topic->id }}"><i
                                                        class="fa fa-edit"></i></a>
                                                <!-- Delete Button -->
                                                <a type="button" class="btn btn-xs btn-danger" data-toggle="modal"
                                                    data-target="#deleteModal{{ $topic->id }}"><i
                                                        class="fa fa-close"></i></a>
                                            </div>
                                            <!-- edit model -->
                                            <div id="EditModal{{ $topic->id }}" class="modal fade" role="dialog">
                                                <div class="modal-dialog modal-lg">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <button type="button" class="close"
                                                                data-dismiss="modal">&times;</button>
                                                            <h4 class="modal-title">Edit Assignment</h4>
                                                        </div>
                                                        {!! Form::model($topic, ['method' => 'PATCH', 'action' => ['Web\Institute\AssignmentController@update', request()->iacsId, $topic->id]]) !!}
                                                        <div class="modal-body">
                                                            <div class="row">
                                                                <div class=col-md-12>
                                                                    <div class="form-group{{ $errors->has('answer') ? ' has-error' : '' }}">
                                                                        <div id="selecte_mode">
                                                                            {!! Form::label('answer', 'Select paper mode') !!}
                                                                            <span class="required">*</span><br>
                                                                        </div>
                                                                        <div id="lableOfCalss">
                                                                            <label for="mcqradio">Mcq
                                                                            <input type="radio" @if(!empty($topic->testType) && $topic->testType == 1) checked @endif name="testType" id="mcqradio" value="1" /></label>
                                                                            <label for="theoryradio">Theory
                                                                            <input  @if(!empty($topic->testType) && $topic->testType == 2) checked @endif type="radio" name="testType" id="theoryradio" value="2" /></label>
                                                                        </div>
                                                                    </div>
                                                                </div> 
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <input type="hidden" id="iacsId"
                                                                            value="{{ request()->iacsId }}">
                                                                        <label for="unit_name">Select Unit*</label>
                                                                        <select name="unit" id="editunit"
                                                                            class="select2 unit_name form-control" required>
                                                                            <option value="{{ $topic->unit }}">
                                                                                {{ $unitname['name'] }}</option>
                                                                            @foreach (\App\Models\Assignments_unit::where('institute_assigned_class_subject_id', request()->iacsId)->get() as $item)
                                                                                <option value="{{ $item->id }}">
                                                                                    {{ $item->unitName }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                    <div
                                                                        class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                                                                        {!! Form::label('title', 'Topic Title') !!}
                                                                        <span class="required">*</span>
                                                                        {!! Form::text('title', null, ['class' => 'form-control', 'placeholder' => 'Please Enter                          Assignment Title', 'required' => 'required']) !!}
                                                                        <small
                                                                            class="text-danger">{{ $errors->first('title') }}</small>
                                                                    </div>
                                                                    <div
                                                                        class="form-group{{ $errors->has('per_q_mark') ? ' has-error' : '' }}">
                                                                        {!! Form::label('per_q_mark', 'Per Question Mark') !!}
                                                                        <span class="required">*</span>
                                                                        {!! Form::number('per_q_mark', null, ['class' => 'form-control', 'placeholder' => 'Please Enter Per Question Mark', 'required' => 'required']) !!}
                                                                        <small
                                                                            class="text-danger">{{ $errors->first('per_q_mark') }}</small>
                                                                    </div>
                                                                    {{-- <div class="form-group{{ $errors->has('timer') ? ' has-error' : '' }}">
                        {!! Form::label('timer', 'Assignment Time (in minutes)') !!}
                        {!! Form::number('timer', null, ['class' => 'form-control', 'placeholder' => 'Please Enter
                        Assignment Total Time
                        (In Minutes)']) !!}
                        <small class="text-danger">{{ $errors->first('timer') }}</small>
                      </div> --}}


                                                                    <label for="">Enable Show Answer: </label>
                                                                    <input {{ $topic->show_ans == 1 ? 'checked' : '' }}
                                                                        type="checkbox" class="toggle-input"
                                                                        name="show_ans" id="toggle{{ $topic->id }}">
                                                                    <label for="toggle{{ $topic->id }}"></label>

                                                                    {{-- <label for="">Assignment Price:</label>
                                                    <input onchange="showprice('{{ $topic->id }}')"
                      {{ $topic->amount !=NULL  ? "checked" : ""}} type="checkbox"
                      class="toggle-input " name="pricechk" id="toggle2{{ $topic->id }}"> --}}
                                                                    {{-- <label for="toggle2{{ $topic->id }}"></label> --}}

                                                                    {{-- <div style="{{ $topic->amount == NULL ? "display: none" : "" }}"
                      id="doabox2{{ $topic->id }}">

                      <label for="doba">Choose Assignment Price: </label>
                      <div class="form-group{{ $errors->has('amount') ? ' has-error' : '' }}">
                        <input value="{{ $topic->amount }}" name="amount" id="doa" type="text" class="form-control"
                          placeholder="Please Enter Assignment Price">
                        <small class="text-danger">{{ $errors->first('amount') }}</small>
                      </div>
                    </div> --}}


                                                                </div>

                                                                <div class="col-md-6">
                                                                    <div
                                                                        class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                                                                        {!! Form::label('description', 'Description') !!}
                                                                        {!! Form::textarea('description', null, ['class' => 'form-control', 'placeholder' => 'Please Enter Assignment Description']) !!}
                                                                        <small
                                                                            class="text-danger">{{ $errors->first('description') }}</small>
                                                                    </div>
                                                                </div>
                                                            </div>



                                                            <div class="modal-footer justify-content-center">
                                                                <div class="btn-group">
                                                                    {!! Form::submit('Update', ['class' => 'btn btn-theme']) !!}
                                                                </div>
                                                            </div>
                                                            {!! Form::close() !!}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div id="deleteModal{{ $topic->id }}" class="delete-modal modal fade"
                                                role="dialog">
                                                <!-- Delete Modal -->
                                                <div class="modal-dialog modal-sm">
                                                    <div class="modal-content">
                                                        <div class="modal-header no-border">
                                                            <button type="button" class="close"
                                                                data-dismiss="modal">&times;</button>
                                                            <div class="delete-icon"></div>
                                                        </div>
                                                        <div class="modal-body text-center">
                                                            <h4 class="modal-heading">Are You Sure ?</h4>
                                                            <p>Do you really want to delete these records? This process
                                                                cannot be undone.
                                                            </p>
                                                        </div>
                                                        <div class="modal-footer no-border justify-content-center">
                                                            {!! Form::open(['method' => 'DELETE', 'action' => ['Web\Institute\AssignmentController@destroy', request()->iacsId, $topic->id]]) !!}
                                                            {!! Form::reset('No', ['class' => 'btn btn-gray', 'data-dismiss' => 'modal']) !!}
                                                            {!! Form::submit('Yes', ['class' => 'btn btn-danger']) !!}
                                                            {!! Form::close() !!}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                        <h4> Assignments {{ $key + 1 }} </h4>
                                        @if (!empty($topic->publish_date))<small
                                                class='olDate'>{{ $topic->publish_date ? 'Published on ' . date('m-d-Y', strtotime($topic->publish_date)) : '' }}</small>
                                        @endif
                                        <h2 class="quiz-name twoLines" data-toggle="tooltip" title="{{ $topic->title }}">
                                            {{ $topic->title }}</h2>
                                        <p data-toggle="tooltip" title="{{ $topic->description }}"
                                            class="twoLines">
                                            {{ Str::limit($topic->description, 120) }}
                                        </p>
                                        <div class="row">

                                            <div class="col-6 pad-0">
                                                <ul class="topic-detail">
                                                    <li>Per Question Mark <i class="fa fa-long-arrow-right"></i></li>
                                                    <li>Total Marks <i class="fa fa-long-arrow-right"></i></li>
                                                    <li>Total Questions <i class="fa fa-long-arrow-right"></i></li>
                                                    {{-- <li>Total Time <i class="fa fa-long-arrow-right"></i></li> --}}
                                                </ul>
                                            </div>
                                            <div class="col-6">
                                                <ul class="topic-detail right">
                                                    <li>{{ $topic->per_q_mark }}</li>
                                                    <li>
                                                        @php
                                                            $qu_count = 0;
                                                        @endphp
                                                        @foreach ($questions as $question)
                                                            @if ($question->topic_id == $topic->id)
                                                                @php
                                                                    $qu_count++;
                                                                @endphp
                                                            @endif
                                                        @endforeach
                                                        {{ $topic->per_q_mark * $qu_count }}
                                                    </li>
                                                    <li>
                                                        {{ $qu_count }}
                                                    </li>
                                                    {{-- <li>
              {{$topic->timer}} minutes
            </li> --}}
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="d-flex flex-wrap justify-content-center">
                                            <a href="{{ route('institute.questions.show', [request()->iacsId, $topic->id]) }}"
                                                class="btn btn-theme  m-1">Add
                                                Questions</a>
                                            <a href="{{ route('institute.all_reports.show', [request()->iacsId, $topic->id]) }}"
                                                class="btn btn-theme m-1">Show
                                                Reports</a>
                                            {{-- <a data-target="#deleteans{{ $topic->id }}" data-toggle="modal" class="btn btn-danger">Delete Answer
        Sheet</a> --}}
                                        </div>
                                    </div>

                                    <div class="modal fade" id="publishModal" tabindex="-1" role="dialog"
                                        aria-labelledby="publishModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="publishModalLabel">Assigment</h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <form class='publishForm'
                                                        action="{{ route('institute.topics.publish', [request()->iacsId, $topic->id]) }}"
                                                        method="POST">
                                                        @csrf
                                                        <div class='form-group'>
                                                            <label>Select Publishing date</label>
                                                            <input type='hidden' name='type' class='form-control '
                                                                value='assignment'>
                                                            <input type='date' name='publishingDate' class='form-control '
                                                                id='publishingDate' placeholder='Assignment Publishing Date'
                                                                required>
                                                        </div>
                                                        <button type='submit' class='btn btn-success'>Publish</button>
                                                    </form>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-dismiss="modal">Close</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    <div id="deleteans{{ $topic->id }}" class="delete-modal modal fade" role="dialog">
                                        <!-- Delete Modal -->
                                        <div class="modal-dialog modal-sm">
                                            <div class="modal-content">
                                                <div class="modal-header no-border">
                                                    <button type="button" class="close"
                                                        data-dismiss="modal">&times;</button>
                                                    <div class="delete-icon"></div>
                                                </div>
                                                <div class="modal-body text-center">
                                                    <h4 class="modal-heading">Are You Sure ?</h4>
                                                    <p>Do you really want to delete these Assignment Answer Sheet? This
                                                        process cannot be undone.</p>
                                                </div>
                                                <div class="modal-footer  no-border justify-content-center">
                                                    {!! Form::open(['method' => 'DELETE', 'action' => ['Web\Institute\AssignmentController@deleteperquizsheet', request()->iacsId, $topic->id]]) !!}
                                                    {!! Form::reset('No', ['class' => 'btn btn-gray', 'data-dismiss' => 'modal']) !!}
                                                    {!! Form::submit('Yes', ['class' => 'btn btn-danger']) !!}
                                                    {!! Form::close() !!}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            @endforeach
        @endif



        @if ($assignmet_w_n_t)
            @foreach ($assignmet_w_n_t as $key => $topic)
                <div class="col-md-4 mb-4">
                    <div class="quiz-card">
                        <div class="d-flex justify-content-between m-0 mb-3">
                            {{-- publish button --}}
                            @if ($topic->status == 'publish')
                                <button data-toggle="modal" data-target="#publishModal"
                                    class="btn btn-sm btn-success getOldAssingment"
                                    data-id="{{ $topic->id ? $topic->id : '' }}"
                                    data-date='{{ $topic->publish_date ? $topic->publish_date : '' }}'>Re-Publish</button>
                            @else
                                <!--   <form class='publishForm' action="{{ route('institute.topics.publish', [request()->iacsId, $topic->id]) }}" method="POST">
                                              @csrf -->
                                <button data-toggle="modal" data-target="#publishModal"
                                    data-id="{{ $topic->id ? $topic->id : '' }}"
                                    class="btn btn-sm btn-danger publishThis" value="">Not yet publish</button>
                                <!-- </form> -->
                            @endif
                            
                            <div>
                                <!-- Edit Button -->
                                <a type="button" class="btn btn-theme btn-xs text-white" data-toggle="modal"
                                    data-target="#EditModal{{ $topic->id }}"><i class="fa fa-edit"></i></a>
                                <!-- Delete Button -->
                                <a type="button" class="btn btn-xs btn-danger" data-toggle="modal"
                                    data-target="#deleteModal{{ $topic->id }}"><i class="fa fa-close"></i></a>
                            </div>
                            <!-- edit model -->
                            <div id="EditModal{{ $topic->id }}" class="modal fade" role="dialog">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close"
                                                data-dismiss="modal">&times;</button>
                                            <h4 class="modal-title">Edit Assignment</h4>
                                        </div>
                                        {!! Form::model($topic, ['method' => 'PATCH', 'action' => ['Web\Institute\AssignmentController@update', request()->iacsId, $topic->id]]) !!}
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div
                                                        class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                                                        {!! Form::label('title', 'Topic Title') !!}
                                                        <span class="required">*</span>
                                                        {!! Form::text('title', null, ['class' => 'form-control', 'placeholder' => 'Please Enter  Assignment Title', 'required' => 'required']) !!}
                                                        <small
                                                            class="text-danger">{{ $errors->first('title') }}</small>
                                                    </div>
                                                    <div
                                                        class="form-group{{ $errors->has('per_q_mark') ? ' has-error' : '' }}">
                                                        {!! Form::label('per_q_mark', 'Per Question Mark') !!}
                                                        <span class="required">*</span>
                                                        {!! Form::number('per_q_mark', null, ['class' => 'form-control', 'placeholder' => 'Please Enter Per Question Mark', 'required' => 'required']) !!}
                                                        <small
                                                            class="text-danger">{{ $errors->first('per_q_mark') }}</small>
                                                    </div>
                                                    {{-- <div class="form-group{{ $errors->has('timer') ? ' has-error' : '' }}">
                    {!! Form::label('timer', 'Assignment Time (in minutes)') !!}
                    {!! Form::number('timer', null, ['class' => 'form-control', 'placeholder' => 'Please Enter
                    Assignment Total Time
                    (In Minutes)']) !!}
                    <small class="text-danger">{{ $errors->first('timer') }}</small>
                  </div> --}}


                                                    <label for="">Enable Show Answer: </label>
                                                    <input {{ $topic->show_ans == 1 ? 'checked' : '' }} type="checkbox"
                                                        class="toggle-input" name="show_ans"
                                                        id="toggle{{ $topic->id }}">
                                                    <label for="toggle{{ $topic->id }}"></label>

                                                    {{-- <label for="">Assignment Price:</label>
                                                    <input onchange="showprice('{{ $topic->id }}')"
                  {{ $topic->amount !=NULL  ? "checked" : ""}} type="checkbox"
                  class="toggle-input " name="pricechk" id="toggle2{{ $topic->id }}"> --}}
                                                    {{-- <label for="toggle2{{ $topic->id }}"></label> --}}

                                                    {{-- <div style="{{ $topic->amount == NULL ? "display: none" : "" }}"
                  id="doabox2{{ $topic->id }}">

                  <label for="doba">Choose Assignment Price: </label>
                  <div class="form-group{{ $errors->has('amount') ? ' has-error' : '' }}">
                    <input value="{{ $topic->amount }}" name="amount" id="doa" type="text" class="form-control"
                      placeholder="Please Enter Assignment Price">
                    <small class="text-danger">{{ $errors->first('amount') }}</small>
                  </div>
                </div> --}}


                                                </div>

                                                <div class="col-md-6">
                                                    <div
                                                        class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                                                        {!! Form::label('description', 'Description') !!}
                                                        {!! Form::textarea('description', null, ['class' => 'form-control', 'placeholder' => 'Please Enter Assignment Description']) !!}
                                                        <small
                                                            class="text-danger">{{ $errors->first('description') }}</small>
                                                    </div>
                                                </div>
                                            </div>



                                            <div class="modal-footer justify-content-center">
                                                <div class="btn-group">
                                                    {!! Form::submit('Update', ['class' => 'btn btn-theme']) !!}
                                                </div>
                                            </div>
                                            {!! Form::close() !!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="deleteModal{{ $topic->id }}" class="delete-modal modal fade" role="dialog">
                                <!-- Delete Modal -->
                                <div class="modal-dialog modal-sm">
                                    <div class="modal-content">
                                        <div class="modal-header no-border">
                                            <button type="button" class="close"
                                                data-dismiss="modal">&times;</button>
                                            <div class="delete-icon"></div>
                                        </div>
                                        <div class="modal-body text-center">
                                            <h4 class="modal-heading">Are You Sure ?</h4>
                                            <p>Do you really want to delete these records? This process cannot be undone.
                                            </p>
                                        </div>
                                        <div class="modal-footer no-border justify-content-center">
                                            {!! Form::open(['method' => 'DELETE', 'action' => ['Web\Institute\AssignmentController@destroy', request()->iacsId, $topic->id]]) !!}
                                            {!! Form::reset('No', ['class' => 'btn btn-gray', 'data-dismiss' => 'modal']) !!}
                                            {!! Form::submit('Yes', ['class' => 'btn btn-danger']) !!}
                                            {!! Form::close() !!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @if (!empty($topic->publish_date))<small class='olDate'>{{ $topic->publish_date ? 'Published on ' . date('m-d-Y', strtotime($topic->publish_date)) : '' }}</small>@endif
                        <h3 class="quiz-name twoLines" data-toggle="tooltip" title="{{ $topic->title }}">
                            {{ $topic->title }}</h3>
                        <p data-toggle="tooltip" title="{{ $topic->description }}" class="twoLines">
                            {{ Str::limit($topic->description, 120) }}
                        </p>
                        <div class="row">
                            <div class="col-6 pad-0">
                                <ul class="topic-detail">
                                    <li>Per Question Mark <i class="fa fa-long-arrow-right"></i></li>
                                    <li>Total Marks <i class="fa fa-long-arrow-right"></i></li>
                                    <li>Total Questions <i class="fa fa-long-arrow-right"></i></li>
                                    {{-- <li>Total Time <i class="fa fa-long-arrow-right"></i></li> --}}
                                </ul>
                            </div>
                            <div class="col-6">
                                <ul class="topic-detail right">
                                    <li>{{ $topic->per_q_mark }}</li>
                                    <li>
                                        @php
                                            $qu_count = 0;
                                        @endphp
                                        @foreach ($questions as $question)
                                            @if ($question->topic_id == $topic->id)
                                                @php
                                                    $qu_count++;
                                                @endphp
                                            @endif
                                        @endforeach
                                        {{ $topic->per_q_mark * $qu_count }}
                                    </li>
                                    <li>
                                        {{ $qu_count }}
                                    </li>
                                    {{-- <li>
              {{$topic->timer}} minutes
        </li> --}}
                                </ul>
                            </div>
                        </div>
                        <div class="d-flex flex-wrap justify-content-center">
                            <a href="{{ route('institute.questions.show', [request()->iacsId, $topic->id]) }}"
                                class="btn btn-theme  m-1">Add
                                Questions</a>
                            <a href="{{ route('institute.all_reports.show', [request()->iacsId, $topic->id]) }}"
                                class="btn btn-theme m-1">Show
                                Reports</a>
                            {{-- <a data-target="#deleteans{{ $topic->id }}" data-toggle="modal" class="btn btn-danger">Delete Answer
    Sheet</a> --}}
                        </div>
                    </div>

                    <div class="modal fade" id="publishModal" tabindex="-1" role="dialog"
                        aria-labelledby="publishModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="publishModalLabel">Assigment</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form class='publishForm'
                                        action="{{ route('institute.topics.publish', [request()->iacsId, $topic->id]) }}"
                                        method="POST">
                                        @csrf
                                        <div class='form-group'>
                                            <label>Select Publishing date</label>
                                            <input type='hidden' name='type' class='form-control ' value='assignment'>
                                            <input type='date' name='publishingDate' class='form-control '
                                                id='publishingDate' placeholder='Assignment Publishing Date' required>
                                        </div>
                                        <button type='submit' class='btn btn-success'>Publish</button>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                </div>
                            </div>
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
                                    <p>Do you really want to delete these Assignment Answer Sheet? This process cannot be
                                        undone.</p>
                                </div>
                                <div class="modal-footer  no-border justify-content-center">
                                    {!! Form::open(['method' => 'DELETE', 'action' => ['Web\Institute\AssignmentController@deleteperquizsheet', request()->iacsId, $topic->id]]) !!}
                                    {!! Form::reset('No', ['class' => 'btn btn-gray', 'data-dismiss' => 'modal']) !!}
                                    {!! Form::submit('Yes', ['class' => 'btn btn-danger']) !!}
                                    {!! Form::close() !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
        {{-- @php
            dd($assignmet_w_n_t);
        @endphp --}}
    </div>
@endsection
@push('js')
    <script type="text/javascript">
        $(function() {
            $('#fb_check').change(function() {
                $('#fb').val(+$(this).prop('checked'))
            })
        })
        $(document).ready(function() {

            $('.quizfp').change(function() {

                if ($('.quizfp').is(':checked')) {
                    $('#doabox').show('fast');
                } else {
                    $('#doabox').hide('fast');
                }


            });


            var select2 = $('#unit').select2({
                tags: true,
                insertTag: function(data, tag) {
                    tag.text = tag.text + "(new)";
                    data.push(tag);
                },
            }).on('select2:select', function() {
                var mainthis = $(this);
                var iacsId = $('#iacsId').val();
                // console.log(iacsId);die;

                console.log($(this).find("option:selected").data("select2-tag") == true);
                if ($(this).find("option:selected").data("select2-tag") == true) {
                    $.ajax({
                        url: "{{ route('institute.lectures.assignmentUnit', request()->iacsId) }}",
                        method: "post",
                        dataType: "json",
                        data: {
                            iacsId: iacsId,
                            unitName: $(this).find("option:selected").val(),
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(response) {
                            // alert(response.status);
                            if (response.status) {
                                mainthis.find("option:selected").val(response.data.id);
                                mainthis.find("option:selected").text(response.data.name);
                            }
                        }
                    })
                }
            });


            var select2 = $('#editunit').select2({
                tags: true,
                insertTag: function(data, tag) {
                    tag.text = tag.text + "(new)";
                    data.push(tag);
                },
            }).on('select2:select', function() {
                var mainthis = $(this);
                var iacsId = $('#iacsId').val();
                // console.log(iacsId);die;

                console.log($(this).find("option:selected").data("select2-tag") == true);
                if ($(this).find("option:selected").data("select2-tag") == true) {
                    $.ajax({
                        url: "{{ route('institute.lectures.assignmentUnit', request()->iacsId) }}",
                        method: "post",
                        dataType: "json",
                        data: {
                            iacsId: iacsId,
                            unitName: $(this).find("option:selected").val(),
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(response) {
                            // alert(response.status);
                            if (response.status) {
                                mainthis.find("option:selected").val(response.data.id);
                                mainthis.find("option:selected").text(response.data.name);
                            }
                        }
                    })
                }
            });

        });

        $('.getOldAssingment').click(function() {
            var date = $(this).data('date');
            var id = $(this).data('id');
            $('#publishingDate').val(date);
            $('#publishingDate').after('<input name="lastId" value=' + id + ' type="hidden">');
        });
        $('.publishThis').click(function() {
            var id = $(this).data('id');
            $('#publishingDate').after('<input name="lastId" value=' + id + ' type="hidden">');
        });

        $('#priceCheck').change(function() {
            alert('hi');
        });

        function showprice(id) {
            if ($('#toggle2' + id).is(':checked')) {
                $('#doabox2' + id).show('fast');
            } else {

                $('#doabox2' + id).hide('fast');
            }
        }
    </script>
@endpush
