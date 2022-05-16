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

    /* $getanswers->id */
</style>

<div>{{ Breadcrumbs::render('reports', request()->iacsId, request()->all_report) }}</div>
<div class="content-block card-box">
    <div class="box-body table-responsive">
        <table id="topTable" class="table table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Student Name</th>
                    <th>Mobile No.</th>
                    <th>Topic</th>
                    <th>Action</th>
                    <th>Insert Marks</th>
                </tr>
            </thead>
            <tbody>
                @if (!empty($getanswers) && $filtStudents)
                @foreach ($filtStudents as $key => $student)
                <tr>
                    <td>
                        {{$key+1}}
                    </td>
                    <td>{{$student->name}}</td>
                    <td>{{$student->phone}}</td>
                    <td>{{$topic->title}}</td>
                    @foreach($getanswers as $getanswer)
                    @if($getanswer->userid == $student->id)
                    @php
                    $status = DB::table('answer_status')
                    ->where('topicId', $getanswer->topicId)
                    ->get();
                    @endphp
                    @if(!empty($status))
                    @foreach($status as $statusData)
                    @if(!empty($statusData) && ($statusData->userid == $student->id))
                    @if($statusData->answer_checked == 2)
                    <td>
                        <button type="button" class="btn btn-danger submitbutton"
                            data-tid="{{Crypt::encrypt($topic->id)}}" data-id="{{ Crypt::encrypt($student->id)}}"
                            data-ansid="{{Crypt::encrypt($getanswer->id)}}">Reports</button>
                    </td>
                    @else
                    <td>
                        <button type="button" class="btn btn-success submitbutton"
                            data-tid="{{Crypt::encrypt($topic->id)}}" data-id="{{ Crypt::encrypt($student->id)}}"
                            data-ansid="{{Crypt::encrypt($getanswer->id)}}">Reports Checked</button>
                    </td>
                    @endif
                    @php
                    $valuedata = 0;
                    @endphp
                    @if(count($gotMarks) > 0)
                    @foreach($gotMarks as $getMark)
                    @if($getMark->userid == $student->id)
                    @php
                    $valuedata = $getMark->marksGot;
                    @endphp
                    @endif
                    @endforeach
                    @endif
                    <td><input type="number" class="marksGot" name="marksGot" data-tid="{{$topic->id}}"
                            data-id="{{$student->id}}" data-ansid="{{$getanswer->id}}" value="{{ $valuedata }}"></td>
                    @endif
                    @endforeach
                    @endif
                    @endif
                    @endforeach
                </tr>
                @endforeach
                @endif
            </tbody>
        </table>
    </div>
</div>
@endsection
@push('js')
<script>
    $(document).ready(function(){
        $(".submitbutton").click(function(e){
            $(this).data('id');
            e.preventDefault();
            var topic_id = $(this).data('tid');
            var student_id = $(this).data('id');
            // var answer_id = $(this).data('ansid');
            var iacsId = '{{request()->iacsId}}';
            $.ajax({
                headers: { 
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') 
                },
                url: '/institute/get_quest/'+ iacsId + '/' + topic_id,
                type: 'POST',
                data: {
                    topic_id:topic_id,
                    student_id:student_id,
                    // answer_id:answer_id 
                },
                datatype:'json',
                //cahche:false,
                success: function(data) {   
                    // console.log(data) ;               
                   window.location.href = data.url; 
                },

            });
        });
    
        $(".marksGot").blur(function(e) {
            $(this).data('id');
            e.preventDefault();
            var marks = $(this).val();
            var topicId = $(this).data('tid');
            var student_id = $(this).data('id');
            var iacsId = '{{request()->iacsId}}';
            $.ajax({
                headers: { 
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') 
                },
                url: '/institute/set_marks/'+ iacsId + '/' + topicId,
                type: 'POST',
                data: {
                    marksGot:marks,
                    topicId:topicId,
                    userid:student_id,
                    iacsId:iacsId

                },
                datatype:'json',
                success: function(data) {  
                    setTimeout(() => {
                        // window.location.reload();
                }, 5000);

                },

            });            
        });       
    });

</script>
@endpush