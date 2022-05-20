<html>

<head>
    <meta charset="utf-8" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>AVESTUD - Institute</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="AVESTUD - Institute" name="description" />
    <meta content="Coderthemes" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ URL::to('assets/institute/images/favicon.png') }}">
    <link type="text/css" href="https://uicdn.toast.com/tui-color-picker/v2.2.6/tui-color-picker.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('tuieditorjs/tui.css') }}">
    <style>
        @import url(http://fonts.googleapis.com/css?family=Noto+Sans);

        html,
        body {
            height: 100%;
            margin: 0;
        }

        ul.tui-image-editor-menu {
            background-color: white;
        }

        svg.svg_ic-menu {
            background-color: black;
            padding: 6px;
        }
    </style>
</head>

<body>
    @php

    @endphp
    <div id="tui-image-editor-container"></div>
    @if(!empty($getanswers))


    <input type="hidden" name="currnet_id" value="{{ Crypt::encrypt($getanswers->id)}}">
    <input type="hidden" class="storeimgee" data-userId="{{ Crypt::encrypt($getanswers->userid) }}"
        data-value="https://solveanswerbucket.s3.ap-south-1.amazonaws.com/{{$getanswers->answer}} "
        data-quid="{{ Crypt::encrypt($getanswers->questionId) }}">
    @else
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script>
        swal("Finish!", "Answer sheet completed!", "success");
                   
                    setTimeout(() => {
                             window.location.href ="{{ url('institute/get_reports', [request()->iacsId, $topic->id]) }}";
                     }, 4000);
    </script>
    @endif

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/fabric.js/3.6.0/fabric.js"></script>
    <script type="text/javascript" src="https://uicdn.toast.com/tui.code-snippet/v1.5.0/tui-code-snippet.min.js">
    </script>
    <script type="text/javascript" src="https://uicdn.toast.com/tui-color-picker/v2.2.6/tui-color-picker.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/1.3.3/FileSaver.min.js">
    </script>
    <script src="{{ asset('tuieditorjs/tui.js')  }}"> </script>
    <!-- <script src="https://uicdn.toast.com/tui-image-editor/latest/tui-image-editor.js"></script> -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <script>
        // JQUERY
  $(document).ready(function() {
    // LAUNCH TUI EDITOR

    const customTheme = {  
  //  menu - Normal state  -  green   
  "menu.normalIcon.color": "green",  
  //  menu - Selected state  -  Blue   
  "menu.activeIcon.color": "blue",  
  //  menu - Disabled state  -  gray   
  "menu.disabledIcon.color": "grey",  
  //  menu - Mouse hover  -  yellow   
  "menu.hoverIcon.color": "yellow",  
  //  Overall background color   
  "common.backgroundColor": "#eaeaea",  
  //  The background color of the head   
  "header.backgroundColor": "#556677",  
  //  Download button background color   
  "downloadButton.backgroundColor": "lightgreen",  
  //  Download button text color   
  "downloadButton.color": "#fff",  
  //  Download button border style   
  "downloadButton.border": "none",  
};
const myTheme = {
    "tui-image-editor-header-logo.display": "none"
};
    var hemimgedit = $('.storeimgee').attr("data-value");
    var imageEditor = new tui.ImageEditor('#tui-image-editor-container', {
        
        includeUI: {
            theme: myTheme,
            loadImage: {
                path: hemimgedit,
                name: 'SampleImage'
                
            },
            theme: customTheme, 
            menu: ['crop', 'flip', 'rotate', 'draw', 'shape', 'text'],
            initMenu: 'filter',
            menuBarPosition: 'left'
        },
        cssMaxWidth: 5000,
        cssMaxHeight: 5000,
        usageStatistics: false
    });

    // MAKE THE EDITOR RESPONSIVE
    window.onresize = function() {
        imageEditor.ui.resizeEditor();
    }


    // FUNCTION TO CONVERT DATA-URL to BLOB
    function dataURLtoBlob(dataurl) {
        var arr = dataurl.split(','),
            mime = arr[0].match(/:(.*?);/)[1],
            bstr = atob(arr[1]),
            n = bstr.length,
            u8arr = new Uint8Array(n);
        while (n--) {
            u8arr[n] = bstr.charCodeAt(n);
        }
        return new Blob([u8arr], {
            type: mime
        });
    }

    $('.tui-image-editor-header-buttons .tui-image-editor-download-btn').
    replaceWith('<button class="tui-image-editor-save-btn doSaveFile" >Next</button>'),
    $('.tui-image-editor-header-buttons .tui-image-editor-next-btn').
    replaceWith('<button class="tui-image-editor-save-btn prev" >Prev</button>')
        // LISTEN TO THE CLICK AND SEND VIA AJAX TO THE SERVER
        $('.doSaveFile').on('click', function(e) {
            e.preventDefault();
            var question_id = $('.storeimgee').attr("data-quid");
            var user_id = $('.storeimgee').attr("data-userId")
            var date = new Date();
            var time = date.getTime();
            var valuedata = time + 'image.jpg';
            var topic_id = '{{Crypt::encrypt($topic->id)}}';
            var answer_id = $("currnet_id").val();
            var iacsId = '{{request()->iacsId}}';
            var status =  '1';
            var topicIdurl = '{{$topic->id}}';


            // GET TUI IMAGE AS A BLOB
            var blob = dataURLtoBlob(imageEditor.toDataURL());

            // PREPARE FORM DATA TO SEND VIA POST
            var formData = new FormData();
            formData.append('croppedImage', blob, valuedata);
            formData.append('question_id', question_id);
            formData.append('user_id', user_id);
            formData.append('topic_id', topic_id);
            formData.append('user_id', user_id);
            formData.append('answer_id', answer_id);
            formData.append('iacsId', iacsId);
            formData.append('status', status);
         // SEND TO SERVER
            $.ajax({
                headers: { 
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') 
                },
                url: '/institute/get_quest/'+ iacsId + '/' + topic_id,
                type: 'post',
                data: formData,
                contentType: false, // The content type used when sending data to the server.
                cache: false, // To unable request pages to be cached
                processData: false,
                cache: false,

                datatype:'json',
                //cahche:false,
                success: function(data) {                   
                   if(data.status == 200)   {
                    console.log(data.status);             
                   window.location.href = data.url; 
                    }else{
                        $("button.doSaveFile").css("display", "none");
                        swal('Done!', 'All File Are Checked', 'success');
                        setTimeout(() => {

                                window.location.href = ('/institute/get_reports/' + iacsId +'/' + topicIdurl);
                            
                        }, 3000);
                    }
                },

            });

         
        });
        $('.prev').on('click', function(e) {

           e.preventDefault();
            var question_id = $('.storeimgee').attr("data-quid");
            var user_id = $('.storeimgee').attr("data-userId")
            var date = new Date();
            var time = date.getTime();
            var valuedata = time + 'image.jpg';
            var topic_id = '{{ Crypt::encrypt($topic->id) }}';
            var answer_id = $("currnet_id").val();
            var iacsId = '{{ request()->iacsId}}';
            var prev = '1';

            // GET TUI IMAGE AS A BLOB
            var blob = dataURLtoBlob(imageEditor.toDataURL());

            // PREPARE FORM DATA TO SEND VIA POST
            var formData = new FormData();
            formData.append('prev', 1);
            formData.append('question_id', question_id);
            formData.append('user_id', user_id);
            formData.append('topic_id', topic_id);
            formData.append('user_id', user_id);
            formData.append('answer_id', answer_id);
            formData.append('iacsId', iacsId);
         // SEND TO SERVER
            $.ajax({
                headers: { 
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') 
                },
                url: '/institute/get_quest/'+ iacsId + '/' + topic_id,
                type: 'post',
                data: formData,
                contentType: false, // The content type used when sending data to the server.
                cache: false, // To unable request pages to be cached
                processData: false,
                cache: false,

                datatype:'json',
                //cahche:false,
                success: function(data) {  
                    if(data.status == 200)   {
                    console.log(data.status);             
                   window.location.href = data.url; 
                    }else{
                        $("button.prev").css("display", "none");
                    }
                },

            });


        });
    });
  
    </script>

</body>

</html>