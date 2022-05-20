@extends('student.layouts.app')
@section('css')
    <link href="{{ URL::to('assets/student/libs/custombox/custombox.min.css') }}" rel="stylesheet">
    <link href="{{ URL::to('/assets/student/libs/chartist/chartist.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="/css/app.css">
    <style>
        #sidebar-menu>ul>li>a {
            font-size: inherit;
        }

        .chart_category {
            position: unset;
        }

        .main-block-heading {
            font-size: 40px;
        }
 
        .col-md-12.hem {
            padding-right: 5% !important;
        }
        div#showAnswerDetails {
            padding-right: 5% !important;
        }
    </style>
    <script>
        window.Laravel = <?php echo json_encode([
    'csrfToken' => csrf_token(),
]); ?>
    </script>
@endsection
@section('content')
    <div>{{ Breadcrumbs::render('student_finish_quiz', request()->iacs_id, request()->id) }}</div>
    <div id="app">
        <div class="container ">
            <div class="row">
                <div class="col-md-12">
                    <div class="home-main-block mx-0">
                        <div class="question-block  row">
                            <div class="col-md-12">
                                <h2 class="text-center main-block-heading" style="font-size:20px;">{{ $topic->title }}
                                    Result
                                </h2>
                            </div>

                            <div class="finish_chart col-md-12" style="
                                                        position: relative;
                                                    ">
                                <div id="pie-chart" class="ct-chart1 ct-golden-section text-center"
                                    style="height: 256px;display: flex;justify-content: flex-end;"></div>
                                <div class="chart_category d-flex justify-content-center">
                                    <h4 class="d-flex align-items-center"><span class="right_block mr-1"></span>right</h4>
                                    &nbsp;
                                    <h4 class="d-flex align-items-center"><span class="wrong_block mr-1"></span>wrong</h4>

                                </div>
                            </div>
                            <div class="col-md-12 hem">
                                <table class="table table-bordered result-table">
                                    <thead>
                                        <tr>
                                            <th>Total Questions</th>
                                            <th>My Marks</th>
                                            <th>Per Question Mark</th>
                                            <th>Total Marks</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>{{ $count_questions }}</td>
                                            <td>
                                                @php
                                                    $mark = 0;
                                                    $correct = collect();
                                                @endphp
                                                @foreach ($answers as $answer)
                                                    @if ($answer->answer == $answer->user_answer)
                                                        @php
                                                            $mark++;
                                                        @endphp
                                                    @endif
                                                @endforeach
                                                @php
                                                    $correct = $mark * $topic->per_q_mark;
                                                @endphp
                                                {{ $correct }}
                                            </td>
                                            <td>{{ $topic->per_q_mark }}</td>
                                            <td>{{ $topic->per_q_mark * $count_questions }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-md-12 text-center">
                                <h2 class="text-center">Thank You!</h2>
                            </div>
                        </div>
                        @if ($topic->show_ans == 1)
                            <div class="text-center">
                                <button class="btn btn-success"
                                    onclick="document.getElementById('showAnswerDetails').classList.toggle('d-block')">See
                                    the answers with
                                    explanation</button>
                            </div>
                            <div id="showAnswerDetails" class="question-block col-md-12 d-none">
                                <h2 class="text-center main-block-heading" style="font-size: 20px;">ANSWER REPORT</h2>
                                <table class="table table-bordered result-table">
                                    <thead>
                                        <tr>
                                            <th>Question</th>

                                            <th style="color: #644699  ;">Correct Answer</th>
                                            <th style="color: red;">Your Answer</th>
                                            <th>Answer Explnation</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $answers = \App\Models\Answer::where('topic_id', $topic->id)
                                                ->where('user_id', Auth::user()->student_id)
                                                ->get();
                                        @endphp

                                        @php
                                            $x = $count_questions;
                                            $y = 1;
                                        @endphp
                                        @foreach ($answers as $key => $a)

                                            @if ($a->user_answer != '0' && $topic->id == $a->topic_id)
                                                <tr>
                                                    <td>{{ $a->question->question }}</td>
                                                    <td>{{ $a->answer }}</td>
                                                    <td>{{ $a->user_answer }}</td>
                                                    <td>{{ $a->question->answer_exp }}</td>
                                                </tr>
                                                @php
                                                    $y++;
                                                    if ($y > $x) {
                                                        break;
                                                    }
                                                @endphp
                                            @endif
                                        @endforeach

                                    </tbody>
                                </table>

                            </div>

                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script src="{{ URL::to('assets/student/libs/custombox/custombox.min.js') }}"></script>
    <script src="{{ URL::to('assets/student/js/app.min.js') }}"></script>
    <script src="/js/app.js"></script>
    <script src="/assets/student/libs/chartist/chartist.min.js"></script>
    <script>
        $(document).ready(function() {
            history.pushState(null, null, document.URL);
            window.addEventListener('popstate', function() {
                history.pushState(null, null, document.URL);
            });
            var data = {
                series: [parseInt({{ $mark }}), parseInt({{ $count_questions - $mark }})]
            };
            var sum = function(a, b) {
                return a + b
            };
            new Chartist.Pie('.ct-chart1', data, {
                labelInterpolationFnc: function(value) {
                    return Math.round(value / data.series.reduce(sum) * 100) + '%';
                }
            });
        });
    </script>
@endsection
