@extends('student.layouts.app')
@section('css')
<link href="{{URL::to('assets/student/libs/custombox/custombox.min.css')}}" rel="stylesheet">
<link href="{{ asset('theory/assets/css/gsdk-bootstrap-wizard.css') }}" rel="stylesheet" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.7.0/dropzone.css" />
<style>
    div#wizard {
        background: whitesmoke;
    }

    #showQuestion {
        color: black;
        font-size: 13px;
    }

    #skipButton {
        background: #5e57d1;
    }



    /* navbar   ntn */

    .nav-pills {
        background: #d3d9e0 !important;
        height: 39px !important;
    }

    ul.nav.nav-pills {
        align-items: center !important;
        justify-content: center;
    }

    #question228 row {
        border: 3px solid black;
        padding: 20px;
    }

    #wizard .wizard-card .tab-content {
        min-height: 340px;
        padding: 66px;
    }

    #wizard .btn-fill.btn-success {
        background-image: linear-gradient(to right, #fe5b6c, #fe8f40) !important;
        border: none !important;
    }

    button#btnSubmit {
        background-image: linear-gradient(to right, #fe5b6c, #fe8f40) !important;
        border: none !important;
        border-radius: 5px;
        font-size: 18px;
    }

    small#notekip {
        color: #c74040;
        /* text-shadow: 1px -1px #dc1aff; */
    }

    .submitAnswerBtn {
        display: flex;
        flex-direction: row;
        flex-wrap: wrap;
        justify-content: space-evenly;
    }

    .form-group.col-md-12 {
        padding: 50px 90px 0 90px;
    }

    div#wizard {
        padding-bottom: 40px;
    }

    /* navbar ends ntn  */
</style>
@endsection
@section('content')
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
             $ques =  \App\Models\Question::where('topic_id',$topic->id)->get();
             $count =   $ques->count();
            //  dd($count);
         
            
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
                    @if(empty($ques))
                    <div class="alert alert-danger">
                        No Questions in this quiz
                    </div>
                    @endif
                </div>
            </div>
    </div>
</div>
<div class="container-fluid">
    <div class="col-sm-12 col-sm-offset-2">
        <!--      Wizard container        -->
        <div class="wizard-container">
            <div class="card wizard-card" data-color="green" id="wizard">
                <form enctype="multipart/form-data">
                    @csrf
                    <div class="wizard-header">
                        <h3>
                            <b>Upload</b> All Answer <br>
                            <small id="notekip">Upload All Questions Answer in one file only!</small>
                        </h3>
                    </div>
                    <div class="form-group col-md-12">
                        <label class="control-label">Upload Answer *</label>
                        <div id="ans" class="dropzone classquestionid" name="answerimage" required>
                        </div>
                    </div>
                    <br>
                </form>
                <div class="submitAnswerBtn">
                    <button type="submit" id="btnSubmit">Submit</button>
                </div>
            </div>
        </div> <!-- wizard container -->
    </div>

</div> <!--  big container -->

@endsection
@section('js')
<!--   Core JS Files   -->
<script src="{{ asset('theory/assets/js/jquery-2.2.4.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('theory/assets/js/bootstrap.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('theory/assets/js/jquery.bootstrap.wizard.js') }}" type="text/javascript"></script>

<!--  Plugin for the Wizard -->
<script src="{{ asset('theory/assets/js/gsdk-bootstrap-wizard.js') }}"></script>

<!--  More information about jquery.validate here: http://jqueryvalidation.org/	 -->
<script src="{{ asset('theory/assets/js/jquery.validate.min.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.7.0/dropzone.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script>
    $(document).ready(function(){    
        $('.classquestionid').click(function(){
            $('.ans_id').val($(this).data('id'));
        });
        $('#btnSubmit').click(function(e) {
                    //     e.preventDefault();    
                    //     $("#btnSubmit").attr("disabled", true);  
                swal("Good job!", "You test has been end!", "success");
                    setTimeout(() => {
                     window.location.href= "{{route('student.tests', request()->iacs_id)}}";
                    }, 5000);
            
        });
    // var totallength = '{{ $count }}';
    // // console.log(totallength);
    // for(var i=1;i<=totallength;i++){  
       /*  var id = $('#ans'+i).data('id'); */
    Dropzone.autoDiscover = false;
        var uploadedDocumentMap = {};
        // window.onload = function() {
       
        
        var dropzoneOptions = {
        items: '.dz-preview',
        cursor: 'move',
        opacity: 0.5,
        containment: "parent",
        distance: 20,
        tolerance: 'pointer',
        update: function(e, ui) {
        // do what you want
        },
        dictDefaultMessage: 'Images And file size  Not More Than 5 MB',
        paramName: "file",
        maxFilesize: 5, // MB
        addRemoveLinks: true,
        acceptedFiles: ".jpeg,.jpg,.pdf",
        
        
        
        thumbnail: function(file, dataUrl) {
        if (file.previewElement) { 
        file.previewElement.classList.remove("dz-file-preview");
        var images = file.previewElement.querySelectorAll("[data-dz-thumbnail]");
        for (var i = 0; i < images.length; i++){ 
            var thumbnailElement=images[i]; 
            thumbnailElement.alt=file.name;
            thumbnailElement.src=dataUrl;
        }
        setTimeout(function() {
             file.previewElement.classList.add("dz-image-preview"); 
             },1);
         }
        },


         
        headers: { 'X-CSRF-TOKEN' : $('meta[name="csrf-token" ]').attr('content') }, 
        url: "{{route('student.tests.storeimage', [request()->iacs_id, $topic->id])}}" ,
        maxFiles:1,
        init: function() { this.on("success", function(file, res){ 
            console.log(res);
            this.hiddenFileInput.removeAttribute('multiple');
            var userid = "{{ auth()->user()->id }}";
            var topicid = "{{$topic->id}}"
            // console.log(userid);           
            // $('#btnSubmit').click(function(e) {
            //     e.preventDefault();    
            //     $("#btnSubmit").attr("disabled", true);     
                // if(file !== 'undefined'){
                     $.ajax({
                        headers: { 'X-CSRF-TOKEN' : $('meta[name="csrf-token" ]').attr('content') },
                        type:'post',
                        url: "{{route('student.tests.storetheory', [request()->iacs_id, $topic->id])}}" ,
                        data: {
                            answer: res,
                            userid :userid,
                            topicId : topicid

                        },
                        cache:false,
                    success: function(response) {
                        // swal("Good job!", "You test has been end!", "success");
                        // setTimeout(() => {
                        // window.location.href= "{{route('student.tests', request()->iacs_id)}}";
                        // }, 5000);

                        //    console.log(response);
                            
                        }
                    }); 
                // }else{
                //     swal("Opps!", "Uplode the Answer!", "success");

                // }
            //  });
            // $('#recipe_img').append('<input type="hidden" name="images" value="' + file.name + '">');
            // uploadedDocumentMap[file.name] = file.name        
        
            // $(file.previewTemplate).find('.des').attr('data-id', res.id);
            });
            this.on("error", function(file, data) {
            /* this.removeFile(file);
            swal(data, " ", "error"); */
            });
        
            }
            };
        
            var dropzone = new Dropzone('#ans', dropzoneOptions);
        
            dropzone.removeAllFiles();
            //dropzone.handleFiles(files);
            dropzone.processQueue();
            // }

            
        })
</script>
@endsection