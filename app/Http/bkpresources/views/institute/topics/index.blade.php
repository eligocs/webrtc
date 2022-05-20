@extends('institute.layouts.app')
@section('page_heading', 'Tests')
@section('content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        small.olDate.text-right {
            float: right;
        }

        .quiz-card-box-quiz-hem,
        .quiz-card {
            padding: 5px 20px 20px 20px;
            box-shadow: 0 7px 15px 0 rgba(0, 0, 0, 0.1);
            background-color: #FFF;
            border-top: 3px solid #644699;
            margin-bottom: 30px;
            min-height: 376px;
            max-height: 376px;
        }

        .quiz-name {
            font-size: 22px;
            max-height: 72px;
            overflow: hidden;
        }

        .quiz-card-box-quiz-hem p,
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
            background: beige;
            padding: 5px;
            font-weight: 700;
            border-radius: 20px;
        }


        .paddingx {
            padding: 1.5rem !important;
        }

        div#lableOfCalss {
            padding-left: 180px;
        }

        div#selecte_mode {
            padding-left: 165px;
        }

    </style>
    <!-- Create Modal -->
    <div id="createModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Add Test</h4>
                </div>
                {!! Form::open(['method' => 'POST', 'action' => ['Web\Institute\TopicController@store', request()->iacsId]]) !!}
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
                                    @foreach (\App\Models\Test_unit::where('institute_assigned_class_subject_id', request()->iacsId)->get() as $item)
                                        <option value="{{ $item->id }}">{{ $item->unit }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                                {!! Form::label('title', 'Test Title') !!}
                                <span class="required">*</span>
                                {!! Form::text('title', null, ['class' => 'form-control', 'id' => 'title', 'placeholder' => 'Please Enter Test Title', 'required' => 'required']) !!}
                                <small class="text-danger">{{ $errors->first('title') }}</small>
                            </div>
                            <div class="form-group{{ $errors->has('per_q_mark') ? ' has-error' : '' }}">
                                {!! Form::label('per_q_mark', 'Per Question Mark') !!}
                                <span class="required">*</span>
                                {!! Form::number('per_q_mark', null, ['class' => 'form-control', 'id' => 'per_q_mark', 'placeholder' => 'Please Enter Per Question Mark', 'required' => 'required']) !!}
                                <small class="text-danger">{{ $errors->first('per_q_mark') }}</small>
                            </div>
                            <div class="form-group{{ $errors->has('timer') ? ' has-error' : '' }}">
                                {!! Form::label('timer', 'Test Duration (in minutes)') !!}
                                {!! Form::number('timer', null, ['class' => 'form-control', 'id' => 'timer', 'placeholder' => 'Please Enter Test Total Time (In Minutes)']) !!}
                                <small class="text-danger">{{ $errors->first('timer') }}</small>
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
                                {!! Form::textarea('description', null, ['class' => 'form-control', 'id' => 'description', 'placeholder' => 'Please Enter Test Description', 'rows' => '8']) !!}
                                <small class="text-danger">{{ $errors->first('description') }}</small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="btn-group pull-right">
                        {!! Form::reset('Reset', ['class' => 'btn btn-danger']) !!}
                        {!! Form::submit('Add', ['class' => 'btn btn-theme addbutton', 'id' => 'addbutton']) !!}
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
    <div>{{ Breadcrumbs::render('tests', request()->iacsId) }}</div>
    @if (session()->has('add'))
        <div class="alert alert-success">
            {{ session()->get('add') }}
        </div>
    @endif
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="container-fluid">
        <div class="col-md-12 d-md-flex justify-content-end mb-3">
            <button type="button" class="btn-theme btn-style ml-1" data-toggle="modal" data-target="#createModal">Add
                Test</button>
        </div>
        @if (!empty($topics))
            @foreach ($topics as $key => $unit)
                @if ($unit['topics']->count() > 0)

                    <div class="card-box col-12 paddingx">
                        <div class="col-12">
                            <h3 class=" mt-0 mb-3 text-center fw-100">{{ ucfirst($unit['name']) }}</h3>
                        </div>
                    </div>
                    <div class="card-box col-12 paddingx">
                        <div class="row">
                            @foreach ($unit['topics'] as $key => $topic)
                                <div class="col-md-4">
                                    <div class="quiz-card">
                                        <div class="d-flex justify-content-between m-0 mb-3">
                                            {{-- publish button --}}
                                            @if ($topic->status == 'publish')
                                                <button data-toggle="modal" data-target="#publishModal" type="submit"
                                                    class="btn btn-sm btn-success getOldAssingment"
                                                    data-id="{{ $topic->id ? $topic->id : '' }}"
                                                    data-date='{{ $topic->publish_date ? $topic->publish_date : '' }}'>Re-Publish</button>
                                            @else
                                                <!--  <form action="{{ route('institute.topics.publish', [request()->iacsId, $topic->id]) }}" method="POST">
                                                                                                                                                                                                                                                                                    @csrf
                                                                                                                                                                                                                                                      <input type="submit" class="btn btn-sm btn-danger" value="Not yet publish">
                                                                                                                                                                                                                                                    </form> -->
                                                <button data-toggle="modal" data-target="#publishModal"
                                                    data-id="{{ $topic->id ? $topic->id : '' }}"
                                                    class="btn btn-sm btn-danger publishThis" value="">Not yet
                                                    publish</button>
                                            @endif
                                            @if ($topic->testType == 2)
                                                <h4> THEORY</h4>
                                            @else
                                                <h4> MCQ </h4>
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
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <button type="button" class="close"
                                                                data-dismiss="modal">&times;</button>
                                                            <h4 class="modal-title">Edit Test</h4>
                                                        </div>
                                                        {!! Form::model($topic, ['method' => 'PATCH', 'action' => ['Web\Institute\TopicController@update', request()->iacsId, $topic->id]]) !!}

                                                        <div class="modal-body">
                                                            <div class="row">
                                                                <div class=col-md-12>
                                                                    <div
                                                                        class="form-group{{ $errors->has('answer') ? ' has-error' : '' }}">
                                                                        <div id="selecte_mode">
                                                                            {!! Form::label('answer', 'Selecte paper mode') !!}
                                                                            <span class="required">*</span><br>
                                                                        </div>
                                                                        <div id="lableOfCalss">
                                                                            <label for="mcq">Mcq</label>
                                                                            <input type="radio" name="testType"
                                                                                id="mcqradio" value="1"
                                                                                <?php echo $topic->testType == '1' ? 'checked="checked"' : ''; ?> />
                                                                            <label for="theory">Theory</label>
                                                                            <input type="radio" name="testType"
                                                                                id="theoryradio" value="2"
                                                                                <?php echo $topic->testType == '2' ? 'checked="checked"' : ''; ?> />
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <input type="hidden" id="iacsId"
                                                                            value="{{ request()->iacsId }}">
                                                                        <label for="unit_name">Select Unit*</label>
                                                                        <select name="unit" id="editTestunit"
                                                                            class="select2 unit_name form-control" required>
                                                                            <option value="{{ $topic->unit }}">
                                                                                {{ $unit['name'] }}
                                                                            </option>
                                                                            @foreach (\App\Models\Test_unit::where('institute_assigned_class_subject_id', request()->iacsId)->get() as $item)
                                                                                <option value="{{ $item->id }}">
                                                                                    {{ $item->unit }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                    <div
                                                                        class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                                                                        {!! Form::label('title', 'Topic Title') !!}
                                                                        <span class="required">*</span>
                                                                        {!! Form::text('title', null, ['class' => 'form-control', 'placeholder' => 'Please Enter Test   Title', 'required' => 'required']) !!}
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
                                                                    <div
                                                                        class="form-group{{ $errors->has('timer') ? ' has-error' : '' }}">
                                                                        {!! Form::label('timer', 'Test Duration (in minutes)') !!}
                                                                        {!! Form::number('timer', null, ['class' => 'form-control', 'placeholder' => 'Please Enter Test Total Time(In Minutes)']) !!}
                                                                        <small
                                                                            class="text-danger">{{ $errors->first('timer') }}</small>
                                                                    </div>


                                                                    <label for="">Enable Show Answer: </label>
                                                                    <input {{ $topic->show_ans == 1 ? 'checked' : '' }}
                                                                        type="checkbox" class="toggle-input"
                                                                        name="show_ans" id="toggle{{ $topic->id }}">
                                                                    <label for="toggle{{ $topic->id }}"></label>
                                                                </div>

                                                                <div class="col-md-6">
                                                                    <div
                                                                        class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                                                                        {!! Form::label('description', 'Description') !!}
                                                                        {!! Form::textarea('description', null, ['class' => 'form-control', 'placeholder' => 'Please Enter Test Description']) !!}
                                                                        <small
                                                                            class="text-danger">{{ $errors->first('description') }}</small>
                                                                    </div>
                                                                </div>
                                                            </div>



                                                            <div class="modal-footer">
                                                                <div class="btn-group pull-right">
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
                                                        <div class="modal-header">
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
                                                        <div class="modal-footer">
                                                            {!! Form::open(['method' => 'DELETE', 'action' => ['Web\Institute\TopicController@destroy', request()->iacsId, $topic->id]]) !!}
                                                            {!! Form::reset('No', ['class' => 'btn btn-gray', 'data-dismiss' => 'modal']) !!}
                                                            {!! Form::submit('Yes', ['class' => 'btn btn-danger']) !!}
                                                            {!! Form::close() !!}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @if (!empty($topic->publish_date))<small
                                                class='olDate text-right'>{{ $topic->publish_date ? 'Published on ' . date('m-d-Y', strtotime($topic->publish_date)) : '' }}</small>
                                        @endif
                                        <h3> Test {{ $key + 1 }} </h3>
                                        <h3 class="quiz-name twoLines" data-toggle="tooltip" title="{{ $topic->title }}">
                                            {{ $topic->title }}</h3>
                                        <p title="{{ $topic->description }}">
                                            {{ Str::limit($topic->description, 120) }}
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
                                                    <li>
                                                        {{ $topic->timer }} minutes
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="d-flex flex-wrap justify-content-center">
                                            @if ($topic->testType == 1)
                                                <a href="{{ route('institute.questions.show', [request()->iacsId, $topic->id]) }}"
                                                    class="btn btn-theme mb-1 mx-1">Add
                                                    Questions</a>
                                            @else
                                                <a href="{{ url('institute/showtheory', [request()->iacsId, $topic->id]) }}"
                                                    class="btn btn-theme mb-1 mx-1">Add
                                                    Questions</a>
                                            @endif
                                            @if ($topic->testType == 1)
                                                <a href="{{ route('institute.all_reports.show', [request()->iacsId, $topic->id]) }}"
                                                    class="btn btn-danger mb-1 mx-1">ShowReports</a>
                                            @else
                                                <a href="{{ url('institute/get_reports', [request()->iacsId, $topic->id]) }}"
                                                    class="btn btn-danger mb-1 mx-1">ShowReports</a>
                                            @endif

                                        </div>

                                    </div>

                                    <div class="modal fade" id="publishModal" tabindex="-1" role="dialog"
                                        aria-labelledby="publishModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="publishModalLabel">Tests</h5>
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
                                                                value='test'>
                                                            <input type='date' name='publishingDate' class='form-control '
                                                                id='publishingDate' placeholder='Assignment Publishing Date'
                                                                required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Select Test Time (optional)</label>
                                                            <input type="time" name='publishing_startTime'
                                                                class='form-control ' id='publishingStartTime'
                                                                placeholder='Assignment Starting Time'>
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
                                                <div class="modal-header">
                                                    <button type="button" class="close"
                                                        data-dismiss="modal">&times;</button>
                                                    <div class="delete-icon"></div>
                                                </div>
                                                <div class="modal-body text-center">
                                                    <h4 class="modal-heading">Are You Sure ?</h4>
                                                    <p>Do you really want to delete these Test Answer Sheet? This process
                                                        cannot be undone.</p>
                                                </div>
                                                <div class="modal-footer">
                                                    {!! Form::open(['method' => 'DELETE', 'action' => ['Web\Institute\TopicController@deleteperquizsheet', request()->iacsId, $topic->id]]) !!}
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
                    {{-- ends here --}}
                @endif
            @endforeach
        @endif

        @if ($topicsw_u)
            <div class="row">
                @foreach ($topicsw_u as $key => $topic)
                    <div class="col-md-4">
                        <div class="quiz-card-box-quiz-hem">
                            <div class="d-flex justify-content-between m-0 mb-3">
                                {{-- publish button --}}
                                @if ($topic->status == 'publish')
                                    <button data-toggle="modal" data-target="#publishModal" type="submit"
                                        class="btn btn-sm btn-success getOldAssingment"
                                        data-id="{{ $topic->id ? $topic->id : '' }}"
                                        data-date='{{ $topic->publish_date ? $topic->publish_date : '' }}'>Re-Publish</button>
                                @else
                                    <!--  <form action="{{ route('institute.topics.publish', [request()->iacsId, $topic->id]) }}" method="POST">
                                                                                                                                                                                                                                                  @csrf
                                                                                                                                                                                                                                                  <input type="submit" class="btn btn-sm btn-danger" value="Not yet publish">
                                                                                                                                                                                                                                                </form> -->
                                    <button data-toggle="modal" data-target="#publishModal"
                                        data-id="{{ $topic->id ? $topic->id : '' }}"
                                        class="btn btn-sm btn-danger publishThis" value="">Not yet publish</button>
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
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close"
                                                    data-dismiss="modal">&times;</button>
                                                <h4 class="modal-title">Edit Test</h4>
                                            </div>
                                            {!! Form::model($topic, ['method' => 'PATCH', 'action' => ['Web\Institute\TopicController@update', request()->iacsId, $topic->id]]) !!}
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div
                                                            class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                                                            {!! Form::label('title', 'Topic Title') !!}
                                                            <span class="required">*</span>
                                                            {!! Form::text('title', null, ['class' => 'form-control', 'placeholder' => 'Please Enter Test Title', 'required' => 'required']) !!}
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
                                                        <div
                                                            class="form-group{{ $errors->has('timer') ? ' has-error' : '' }}">
                                                            {!! Form::label('timer', 'Test Time (in minutes)') !!}
                                                            {!! Form::number('timer', null, ['class' => 'form-control', 'placeholder' => 'Please Enter Test Total Time (In Minutes)']) !!}
                                                            <small
                                                                class="text-danger">{{ $errors->first('timer') }}</small>
                                                        </div>


                                                        <label for="">Enable Show Answer: </label>
                                                        <input {{ $topic->show_ans == 1 ? 'checked' : '' }}
                                                            type="checkbox" class="toggle-input" name="show_ans"
                                                            id="toggle{{ $topic->id }}">
                                                        <label for="toggle{{ $topic->id }}"></label>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div
                                                            class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                                                            {!! Form::label('description', 'Description') !!}
                                                            {!! Form::textarea('description', null, ['class' => 'form-control', 'placeholder' => 'Please Enter Test Description']) !!}
                                                            <small
                                                                class="text-danger">{{ $errors->first('description') }}</small>
                                                        </div>
                                                    </div>
                                                </div>



                                                <div class="modal-footer">
                                                    <div class="btn-group pull-right">
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
                                            <div class="modal-header">
                                                <button type="button" class="close"
                                                    data-dismiss="modal">&times;</button>
                                                <div class="delete-icon"></div>
                                            </div>
                                            <div class="modal-body text-center">
                                                <h4 class="modal-heading">Are You Sure ?</h4>
                                                <p>Do you really want to delete these records? This process cannot be
                                                    undone.
                                                </p>
                                            </div>
                                            <div class="modal-footer">
                                                {!! Form::open(['method' => 'DELETE', 'action' => ['Web\Institute\TopicController@destroy', request()->iacsId, $topic->id]]) !!}
                                                {!! Form::reset('No', ['class' => 'btn btn-gray', 'data-dismiss' => 'modal']) !!}
                                                {!! Form::submit('Yes', ['class' => 'btn btn-danger']) !!}
                                                {!! Form::close() !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @if (!empty($topic->publish_date))<small class='olDate text-right'>{{ $topic->publish_date ? 'Published on ' . date('m-d-Y', strtotime($topic->publish_date)) : '' }}</small>@endif
                            <h3 class="quiz-name twoLines" data-toggle="tooltip" title="{{ $topic->title }}">
                                {{ $topic->title }}</h3>
                            <p title="{{ $topic->description }}">
                                {{ Str::limit($topic->description, 120) }}
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
                                        <li>
                                            {{ $topic->timer }} minutes
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="d-flex flex-wrap justify-content-center">
                                <a href="{{ route('institute.questions.show', [request()->iacsId, $topic->id]) }}"
                                    class="btn btn-theme mb-1 mx-1">Add
                                    Questions</a>
                                <a href="{{ route('institute.all_reports.show', [request()->iacsId, $topic->id]) }}"
                                    class="btn btn-danger mb-1 mx-1">Show Reports</a>

                            </div>

                        </div>

                        <div class="modal fade" id="publishModal" tabindex="-1" role="dialog"
                            aria-labelledby="publishModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="publishModalLabel">Tests</h5>
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
                                                <input type='hidden' name='type' class='form-control ' value='test'>
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
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        <div class="delete-icon"></div>
                                    </div>
                                    <div class="modal-body text-center">
                                        <h4 class="modal-heading">Are You Sure ?</h4>
                                        <p>Do you really want to delete these Test Answer Sheet? This process cannot be
                                            undone.</p>
                                    </div>
                                    <div class="modal-footer">
                                        {!! Form::open(['method' => 'DELETE', 'action' => ['Web\Institute\TopicController@deleteperquizsheet', request()->iacsId, $topic->id]]) !!}
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
        @endif

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

                console.log($(this).find("option:selected").data("select2-tag") == true);
                if ($(this).find("option:selected").data("select2-tag") == true) {
                    $.ajax({
                        url: "{{ route('institute.lectures.testUnit', request()->iacsId) }}",
                        method: "post",
                        dataType: "json",
                        data: {
                            iacsId: iacsId,
                            unit: $(this).find("option:selected").val(),
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


            var select2 = $('#editTestunit').select2({
                tags: true,
                insertTag: function(data, tag) {
                    tag.text = tag.text + "(new)";
                    data.push(tag);
                },
            }).on('select2:select', function() {
                var mainthis = $(this);
                var iacsId = $('#iacsId').val();

                console.log($(this).find("option:selected").data("select2-tag") == true);
                if ($(this).find("option:selected").data("select2-tag") == true) {
                    $.ajax({
                        url: "{{ route('institute.lectures.testUnit', request()->iacsId) }}",
                        method: "post",
                        dataType: "json",
                        data: {
                            iacsId: iacsId,
                            unit: $(this).find("option:selected").val(),
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
