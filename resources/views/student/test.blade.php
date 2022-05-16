@extends('student.layouts.app')
@section('css')
<link href="{{URL::to('assets/student/libs/custombox/custombox.min.css')}}" rel="stylesheet">
<link rel="stylesheet" href="/css/test.css">
<link rel="stylesheet" href="/css/app.css">
<style>
#clock>span {
    color: black;
}

#sidebar-menu>ul>li>a {
    font-size: inherit;
}

.border-gradient {
    border: 10px solid;
    border-image-slice: 1;
    border-width: 5px;
    border-radius: 10px;
    background-image: none !important;
    color: black !important;
}

/* .border-gradient>input {
    visibility: hidden;
  } */

.border-gradient-orange {
    border-image-source: linear-gradient(to right, #f98b2c, #fbc03a);
    background-image: none;
}

.border-gradient-pink {
    border-image-source: linear-gradient(to right, #fe5b6c, #fe8f40);
}

.border-gradient-blue {
    border-image-source: linear-gradient(to right, #167cd1, #0eb5e1);
}

.border-gradient-green {
    border-image-source: linear-gradient(to right, #5ba312, #89c50d);
}

.qustn-slct {
    font-size: 17.5px !important;
    font-weight: normal;
    padding: 0 10px;
}

.qustn-slct>input {
    margin: 10px 5px;
}
</style>
<script>
window.Laravel = <?php echo json_encode([
        'csrfToken' => csrf_token(),
    ]); ?>
</script>
@endsection
@section('content')
<div>{{ Breadcrumbs::render('student_start_quiz', request()->iacs_id, request()->id) }}</div>
<div id="app">
    <div class="container-fluid">
        @php
        $topic = \App\Models\Topic::findOrFail(request()->id);
        $answers = \App\Models\Answer::where('topic_id','=',$topic->id)->first();
        $old_data = DB::table('class_notifications')->where('assigment_id',$topic->id)->first();
        if ($old_data) {
        $old_data_arr = !empty($old_data->readUsers) ? explode(',',$old_data->readUsers) :[];
        if(!in_array(auth()->user()->student_id , $old_data_arr)) {
        $old_data_arr[] = auth()->user()->student_id;
        $query = DB::table('class_notifications')->where('notify_date','<=',date('Y-m-d'))->
            where('assigment_id',$topic->id)->update([
            'readUsers'=> implode(',',$old_data_arr)
            ]);
            }
            }
            @endphp
            <div class="row">
                <div class="col-md-6 col-sm-8">
                    <div class="navbar-header">
                        <!-- Branding Image -->

                        @if($topic)
                        <h4 class="heading" style="color: black;">{{$topic->title}}</h4>

                        @endif
                    </div>
                </div>
                <div class="col-md-3 ml-auto text-right col-sm-4">
                    <div class="collapse navbar-collapse d-flex justify-content-end align-items-center"
                        id="app-navbar-collapse">
                        <!-- Right Side Of Navbar -->
                        {{--<button class="btn theme-clr font-16">Submit</button>--}}
                        @if (request()->segment(3) == 'tests')
                        <h5 class="font-14 black text-right"
                            style="font-size: 22px !important;color: black !important; font-weight: bold;">Time left:
                            <ul class="nav navbar-nav navbar-right my-0 mx-1 p-0">
                                <!-- Authentication Links -->
                                <li id="clock" style="color: black;"></li>
                            </ul>
                        </h5>
                        @endif
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="home-main-block">
                    <?php $users =  \App\Models\Answer::where('topic_id',$topic->id)->where('user_id', auth()->user()->student_id)->first();
             $que =  \App\Models\Question::where('topic_id',$topic->id)->first();
            ?>
                    @if(!empty($users))
                    <div class="alert alert-danger">
                        You have already Given the test ! Try to give other Quizes
                    </div>
                    @else
                    <div id="question_block" class="question-block container" style="padding: 1rem 10rem;">
                        <question :topic_id="{{$topic->id}}"></question>
                    </div>
                    @endif
                    @if(empty($que))
                    <div class="alert alert-danger">
                        No Questions in this quiz
                    </div>
                    @endif
                </div>
            </div>
    </div>
</div>
@endsection
@section('js')
<script src="/js/app.js"></script>
<script src="{{URL::to('assets/student/libs/custombox/custombox.min.js')}}"></script>
<script src="{{URL::to('assets/student/js/app.min.js')}}"></script>

<!-- jQuery 3 -->
{{-- <script src="{{asset('js/jquery.min.js')}}"></script> --}}
<!-- Bootstrap 3.3.7 -->
{{-- <script src="{{asset('js/bootstrap.min.js')}}"></script> --}}
<script src="{{asset('/js/jquery.cookie.js')}}"></script>
<script src="{{asset('/js/jquery.countdown.js')}}"></script>

@if(empty($users) && !empty($que))
<script>
    var topic_id = {{$topic->id}};
@if(!in_array('assignments', request()->segments()))
var timer = {{$topic->timer}};
@endif
$(document).ready(function() {
    function e(e) {
        (116 == (e.which || e.keyCode) || 82 == (e.which || e.keyCode)) && e.preventDefault()
    }
    setTimeout(function() {
        $(".myQuestion:first-child").addClass("active");
        $(".prebtn").attr("disabled", true);
    }, 2500), history.pushState(null, null, document.URL), window.addEventListener("popstate", function() {
        history.pushState(null, null, document.URL)
    }), $(document).on("keydown", e), setTimeout(function() {
        $(".nextbtn").click(function() {
                var e = $(".myQuestion.active");
                $(e).removeClass("active"), 0 == $(e).next().length ? (Cookies.remove("time"),
                    Cookies.set("done", "Your Quiz is Over...!", {
                        expires: 1
                    }), location.href =
                    "{{route('student.finish_test', [request()->iacs_id,request()->id])}}") : (
                    $(e).next().addClass("active"), $(".myForm")[0].reset(),
                    $(".prebtn").attr("disabled", false))
            }),
            $(".prebtn").click(function() {
                var e = $(".myQuestion.active");
                $(e).removeClass("active"),
                    $(e).prev().addClass("active"), $(".myForm")[0].reset()
                $(".myQuestion:first-child").hasClass("active") ? $(".prebtn").attr("disabled",
                    true) : $(".prebtn").attr("disabled", false);
            })
    }, 700);
    @if(!in_array('assignments', request()->segments()))
    var i, o = (new Date).getTime() + 6e4 * timer;
    if (Cookies.get("time") && Cookies.get("topic_id") == topic_id) {
        i = Cookies.get("time");
        var t = o - i,
            n = o - t;
        $("#clock").countdown(n, {
            elapse: !0
        }).on("update.countdown", function(e) {
            var i = $(this);
            e.elapsed ? (Cookies.set("done", "Your Quiz is Over...!", {
                    expires: 1
                }), Cookies.remove("time"), location.href =
                "{{route('student.finish_test', [request()->iacs_id,request()->id])}}") : i.html(e
                .strftime("<span>%H:%M:%S</span>"))
        })
    } else Cookies.set("time", o, {
        expires: 1
    }), Cookies.set("topic_id", topic_id, {
        expires: 1
    }), $("#clock").countdown(o, {
        elapse: !0
    }).on("update.countdown", function(e) {
        var i = $(this);
        e.elapsed ? (Cookies.set("done", "Your Quiz is Over...!", {
                expires: 1
            }), Cookies.remove("time"), location.href =
            "{{route('student.finish_test', [request()->iacs_id,request()->id])}}") : i.html(e
            .strftime("<span>%H:%M:%S</span>"))
    })
    @endif
});
</script>
@endif
@endsection