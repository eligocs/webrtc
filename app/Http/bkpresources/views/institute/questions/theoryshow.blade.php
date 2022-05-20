@extends('institute.layouts.app')
@section('page_heading', 'Questions')
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

        .btn-xs {
            padding: 5px 5px;
        }

        .quiz-name {
            font-size: 22px;
        }

        .btn-theme {
            color: #ffffff !important;
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
    {{-- <div class="margin-bottom">
    <button type="button" class="btn-theme btn-style ml-1" data-toggle="modal" data-target="#createModal">Add Question</button>
    <button type="button" class="btn btn-theme" data-toggle="modal" data-target="#importQuestions">Import
        Questions</button>
</div> --}}
    <!-- Create Modal -->
    <div id="createModal" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header no-border">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Add Question</h4>
                </div>
                {!! Form::open(['method' => 'POST', 'action' => ['Web\Institute\QuestionController@store', request()->iacsId], 'files' => true]) !!}
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            {!! Form::hidden('testType', 2) !!}
                            {!! Form::hidden('topic_id', $topic->id) !!}
                            <div class="form-group{{ $errors->has('question') ? ' has-error' : '' }}">
                                {!! Form::label('question', 'Question') !!}
                                <span class="required">*</span>
                                {!! Form::textarea('question', null, [
    'class' => 'form-control',
    'placeholder' => 'Please
                            Enter Question',
    'rows' => '12',
    'required' => 'required',
]) !!}
                                <small class="text-danger">{{ $errors->first('question') }}</small>
                            </div>
                        </div>
                        <div class="col-md-12">
                            {{-- <div class="form-group{{ $errors->has('code_snippet') ? ' has-error' : '' }}">
                        {!! Form::label('code_snippet', 'Code Snippets') !!}
                        {!! Form::textarea('code_snippet', null, ['class' => 'form-control', 'placeholder' => 'Please
                        Enter Code
                        Snippets', 'rows' => '5']) !!}
                        <small class="text-danger">{{ $errors->first('code_snippet') }}</small>
                    </div> --}}
                            <div class="form-group{{ $errors->has('answer_ex') ? ' has-error' : '' }}">
                                {!! Form::label('answer_exp', 'Answer Explanation') !!}
                                {!! Form::textarea('answer_exp', null, [
    'class' => 'form-control',
    'placeholder' => 'Please
                        Enter Answer
                        Explanation',
    'rows' => '15',
]) !!}
                                <small class="text-danger">{{ $errors->first('answer_ex') }}</small>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="col-md-6">
                                <div class="form-group{{ $errors->has('question_img') ? ' has-error' : '' }}">
                                    {!! Form::label('question_img', 'Add Image To Question') !!}
                                    {{-- {!! Form::file('question_img') !!} --}}
                                    <input type='file' name='question_img' class='inputch'
                                        accept='image/x-png,image/jpg,image/jpeg'>
                                    <small class="text-danger">{{ $errors->first('question_img') }}</small>
                                    <p class="help">Please Choose Only .JPG, .JPEG and .PNG</p>
                                </div>
                            </div>
                        </div>
                        {{-- <div class="col-md-12">
                        <div class="extras-block">
                            <h4 class="extras-heading">Video And Image For Question</h4>
                            <div class="row">
                                <div class="col-md-6">
                                    <div
                                        class="form-group{{ $errors->has('question_video_link') ? ' has-error' : '' }}">
                {!! Form::label('question_video_link', 'Add Video To Question') !!}
                {!! Form::text('question_video_link', null, ['class' => 'form-control',
                'placeholder'=>'https://myvideolink.com/embed/..']) !!}
                <small class="text-danger">{{ $errors->first('question_video_link') }}</small>
                <p class="help">YouTube And Vimeo Video Support (Only Embed Code Link)</p>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group{{ $errors->has('question_img') ? ' has-error' : '' }}">
                {!! Form::label('question_img', 'Add Image To Question') !!}
                {!! Form::file('question_img') !!}
                <small class="text-danger">{{ $errors->first('question_img') }}</small>
                <p class="help">Please Choose Only .JPG, .JPEG and .PNG</p>
            </div>
        </div>
    </div>
</div>
</div> --}}
                    </div>
                </div>
                <div class="modal-footer justify-content-center no-border">
                    <div class="btn-group d-md-flex justify-content-center">
                        {!! Form::reset('Reset', ['class' => 'btn btn-danger']) !!}
                        {{-- {!! Form::submit("Add", ['class' => 'btn btn-theme']) !!} --}}
                        <button class='submitbutton btn btn-theme' type='submit'>Add</button>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
    <!-- Import Questions Modal -->
    <div id="importQuestions" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Import Questions (Excel File With Exact Header of DataBase Field)</h4>
                </div>
                {!! Form::open(['method' => 'POST', 'action' => ['Web\Institute\QuestionController@importExcelToDB', request()->iacsId], 'files' => true]) !!}
                <div class="modal-body">
                    {!! Form::hidden('topic_id', $topic->id) !!}
                    <div class="form-group{{ $errors->has('question_file') ? ' has-error' : '' }}">
                        {!! Form::label('question_file', 'Import Question Via Excel File', [
    'class' => 'col-sm-3
                    control-label',
]) !!}
                        <span class="required">*</span>
                        <div class="col-sm-9">
                            {!! Form::file('question_file', ['required' => 'required']) !!}
                            <p class="help-block">Only Excel File (.CSV and .XLS)</p>
                            <small class="text-danger">{{ $errors->first('question_file') }}</small>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-center">
                    <div class="btn-group d-md-flex justify-content-center">
                        {!! Form::reset('Reset', ['class' => 'btn btn-danger']) !!}
                        {!! Form::submit('Import', ['class' => 'btn btn-theme']) !!}
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
    <div>{{ Breadcrumbs::render('questions', request()->iacsId, request()->id, 'detail') }}</div>
    <div class="card-box">
        <div class="col-md-12 d-md-flex justify-content-end mb-3">
            <button type="button" class="btn-theme btn-style ml-1" data-toggle="modal" data-target="#createModal">Add
                Question</button>
        </div>
        <div class="box-body table-responsive">
            <table id="questions_table" class="table table-hover table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Questions</th>
                        <th>Answer Explanation</th>
                        <th>Image</th>
                        {{-- <th>Video Link</th> --}}
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($questions)
                        @foreach ($questions as $key => $question)
                            @php
                                $answer = strtolower($question->answer);
                            @endphp
                            <tr>
                                <td>
                                    {{ $key + 1 }}
                                </td>
                                <td>{{ $question->question }}</td>

                                {{-- <td>
                        <pre>
                    {{{$question->code_snippet}}}
                    </pre>
                    </td> --}}
                                <td>
                                    {{ $question->answer_exp }}
                                </td>
                                <td>
                                    @if ($question->question_img)

                                        <a href="{{ 'https://aaradhanaclasses.s3.ap-south-1.amazonaws.com/' . $question->question_img }}"
                                            class="image-popup theme-clr" title="Screenshot-1" target="_blank">
                                            View Image
                                        </a>
                                    @endif
                                    {{-- <img src="{{asset('/storage/'.$question->question_img)}}" class="img-responsive"
                        alt="image"> --}}
                                </td>
                                {{-- <td>
                        {{$question->question_video_link}}
                    </td> --}}
                                <td>
                                    <!-- Edit Button -->
                                    <a type="button" class="btn btn-theme btn-xs mb-1" data-toggle="modal"
                                        data-target="#EditModal{{ $question->id }}"><i class="fa fa-edit"></i> </a>
                                    <!-- Delete Button -->
                                    <a type="button" class="btn btn-xs btn-danger mb-1" data-toggle="modal"
                                        data-target="#deleteModal{{ $question->id }}"><i class="fa fa-close"></i> </a>
                                    <div id="deleteModal{{ $question->id }}" class="delete-modal modal fade"
                                        role="dialog">
                                        <!-- Delete Modal -->
                                        <div class="modal-dialog modal-sm">
                                            <div class="modal-content">
                                                <div class="modal-header  no-border">
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
                                                <div class="modal-footer no-border justify-content-center">
                                                    {!! Form::open(['method' => 'DELETE', 'action' => ['Web\Institute\QuestionController@destroy', request()->iacsId, $question->id]]) !!}
                                                    {!! Form::reset('No', ['class' => 'btn btn-theme', 'data-dismiss' => 'modal']) !!}
                                                    {!! Form::submit('Yes', ['class' => 'btn btn-danger']) !!}
                                                    {!! Form::close() !!}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <!-- edit model -->
                            <div id="EditModal{{ $question->id }}" class="modal fade" role="dialog">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header no-border">
                                            <button type="button" class="close"
                                                data-dismiss="modal">&times;</button>
                                            <h4 class="modal-title">Edit Question</h4>
                                        </div>
                                        {!! Form::model($question, ['method' => 'PATCH', 'action' => ['Web\Institute\QuestionController@update', request()->iacsId, $question->id], 'files' => true]) !!}
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    {!! Form::hidden('testType', 2) !!}
                                                    {!! Form::hidden('topic_id', $topic->id) !!}
                                                    <div
                                                        class="form-group{{ $errors->has('question') ? ' has-error' : '' }}">
                                                        {!! Form::label('question', 'Question') !!}
                                                        <span class="required">*</span>
                                                        {!! Form::textarea('question', null, ['class' => 'form-control', 'placeholder' => 'Please Enter Question', 'rows' => '12', 'required' => 'required']) !!}
                                                        <small
                                                            class="text-danger">{{ $errors->first('question') }}</small>
                                                    </div>
                                                </div>

                                                <div class="col-md-12">

                                                    <div
                                                        class="form-group{{ $errors->has('answer_ex') ? ' has-error' : '' }}">
                                                        {!! Form::label('answer_exp', 'Answer Explanation') !!}
                                                        {!! Form::textarea('answer_exp', null, ['class' => 'form-control', 'placeholder' => 'Please Enter Answer Explanation', 'rows' => '15']) !!}
                                                        <small
                                                            class="text-danger">{{ $errors->first('answer_ex') }}</small>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div
                                                        class="form-group{{ $errors->has('question_img') ? ' has-error' : '' }}">
                                                        {!! Form::label('question_img', 'Add Image In Question') !!}
                                                        {!! Form::file('question_img') !!}
                                                        <small
                                                            class="text-danger">{{ $errors->first('question_img') }}</small>
                                                        <p class="help">Please Choose Only .JPG, .JPEG and .PNG
                                                        </p>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="modal-footer no-border justify-content-center">
                                            <div class="btn-group">
                                                {!! Form::submit('Update', ['class' => 'btn btn-theme']) !!}
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
    <script>
        $('.inputch').change(function(e) {
            e.preventDefault();
            var fileExtension = ['jpeg', 'jpg', 'png'];
            if ($.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) == -1) {
                alert("Only formats are allowed : " + fileExtension.join(', '));
                $('.submitbutton').prop('disabled', true);
            } else {
                $('.submitbutton').prop('disabled', false);
            }
        });
    </script>
@endpush
