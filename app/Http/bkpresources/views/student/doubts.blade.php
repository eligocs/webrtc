@extends('student.layouts.app')
@section('css')
<link href="{{ URL::to('assets/student/libs/custombox/custombox.min.css') }}" rel="stylesheet">
@endsection
@section('content')
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" type="text/css"
    rel="stylesheet">
<style>
.container {
    max-width: 1170px;
    margin: auto;
}

img {
    max-width: 100%;
}

.inbox_people {
    background: #f8f8f8 none repeat scroll 0 0;
    float: left;
    overflow: hidden;
    width: 40%;
    border-right: 1px solid #c4c4c4;
}

.inbox_msg {
    border: 1px solid #c4c4c4;
    clear: both;
    overflow: hidden;
}

.top_spac {
    margin: 20px 0 0;
}


.recent_heading {
    float: left;
    width: 40%;
}

.srch_bar {
    display: inline-block;
    text-align: right;
    width: 60%;
    padding:
}

.headind_srch {
    padding: 10px 29px 10px 20px;
    overflow: hidden;
    border-bottom: 1px solid #c4c4c4;
}

.recent_heading h4 {
    color: #644699;
    font-size: 21px;
    margin: auto;
}

.srch_bar input {
    border: 1px solid #cdcdcd;
    border-width: 0 0 1px 0;
    width: 80%;
    padding: 2px 0 4px 6px;
    background: none;
}

.srch_bar .input-group-addon button {
    background: rgba(0, 0, 0, 0) none repeat scroll 0 0;
    border: medium none;
    padding: 0;
    color: #707070;
    font-size: 18px;
}

.srch_bar .input-group-addon {
    margin: 0 0 0 -27px;
}

.chat_ib h5 {
    font-size: 15px;
    color: #464646;
    margin: 0 0 8px 0;
}

.chat_ib h5 span {
    font-size: 13px;
    float: right;
}

.chat_ib p {
    font-size: 14px;
    color: #989898;
    margin: auto
}

.chat_img {
    float: left;
    width: 11%;
}

.chat_ib {
    float: left;
    padding: 0 0 0 15px;
    width: 88%;
}

.chat_people {
    overflow: hidden;
    clear: both;
}

.chat_list {
    border-bottom: 1px solid #c4c4c4;
    margin: 0;
    padding: 18px 16px 10px;
}

.inbox_chat {
    height: 550px;
    overflow-y: scroll;
}

.active_chat {
    background: #ebebeb;
}

.incoming_msg_img {
    display: inline-block;
    width: 6%;
    padding-bottom: 10px;
}

.received_msg {
    display: inline-block;
    padding: 0 0 0 10px;
    vertical-align: top;
    width: 92%;
}

.received_withd_msg p {
    background: #ebebeb none repeat scroll 0 0;
    border-radius: 3px;
    color: #646464;
    font-size: 14px;
    margin: 0;
    padding: 5px 10px 5px 12px;
    width: 100%;
}

.time_date {
    color: #747474;
    display: block;
    font-size: 12px;
    margin: 8px 0 0;
}

.received_withd_msg {
    width: 57%;
}

.mesgs {
    float: left;
    padding: 30px 15px 0 25px;
    width: 100%;
    background: white;
}

.sent_msg p {
    background: #644699 none repeat scroll 0 0;
    border-radius: 3px;
    font-size: 14px;
    margin: 0;
    color: #fff;
    padding: 5px 10px 5px 12px;
    width: 100%;
}

.outgoing_msg {
    overflow: hidden;
    margin: 26px 0 26px;
}

.sent_msg {
    float: right;
    width: 46%;
}

.input_msg_write input {
    background: rgba(0, 0, 0, 0) none repeat scroll 0 0;
    border: medium none;
    color: #4c4c4c;
    font-size: 15px;
    min-height: 48px;
    width: 100%;
}

.type_msg {
    border-top: 1px solid #c4c4c4;
    position: relative;
}

.msg_send_btn {
    background: #644699 none repeat scroll 0 0;
    border: medium none;
    border-radius: 50%;
    color: #fff;
    cursor: pointer;
    font-size: 17px;
    height: 33px;
    position: absolute;
    right: 0;
    top: 11px;
    width: 33px;
}

.messaging {
    padding: 0 0 50px 0;
}

.msg_history {
    height: 516px;
    overflow-y: auto;
}
</style>
<div>{{ Breadcrumbs::render('student_doubts', request()->iacs_id) }}</div>
<div class="container">
    <h3 class=" text-center">Doubts Section</h3>
    <div class="messaging">
        <div class="inbox_msg">
            {{-- <div class="inbox_people">
          <div class="headind_srch">
            <div class="recent_heading">
              <h4>Recent</h4>
            </div>
            <div class="srch_bar">
              <div class="stylish-input-group">
                <input type="text" class="search-bar" placeholder="Search">
                <span class="input-group-addon">
                  <button type="button"> <i class="fa fa-search" aria-hidden="true"></i> </button>
                </span> </div>
            </div>
          </div>
          <div class="inbox_chat">
            @php
            $grouped_doubts_messages = \App\Models\DoubtMessage::orderBy('created_at', 'DESC')->get()->unique('doubt_id');
            @endphp
            @foreach ($grouped_doubts_messages as $key => $item)
              <div class="chat_list {{ $item->doubt->id == request()->doubt ? 'active_chat' : '' }}">
            <a href="{{ route('institute.doubts.show', [request()->iacs_id, $item->doubt->id]) }}">
                <div class="chat_people">
                    <div class="chat_img"> <img src="{{auth()->user()->student->avatar}}" alt="sunil"> </div>
                    <div class="chat_ib">
                        @php
                        $doubt_message = \App\Models\DoubtMessage::where('doubt_id',
                        $item->doubt->id)->orderBy('created_at',
                        'desc')->first();
                        if(!empty($doubt_message)){
                        $chat_date = date('H:i | M d, Y', strtotime($doubt_message->created_at));
                        }else{
                        $chat_date='';
                        }
                        @endphp
                        <h5>{{ $item->doubt->student->name }} <span class="chat_date">{{ $chat_date }}</span></h5>
                    </div>
                </div>
            </a>
        </div>
        @endforeach
    </div>
</div> --}}
<div class="mesgs">
    <div class="msg_history">
        @php
        $institute_id = '';
        if($doubt = \App\Models\Doubt::where(['institute_assigned_class_subject_id' => request()->iacs_id,
        'student_id' => auth()->user()->student_id])->first()){
        $institute_assigned_class_subject =
        \App\Models\InstituteAssignedClassSubject::where('id',request()->iacs_id)->first();
        if(!empty($institute_assigned_class_subject)){
        $institute_assigned_class =
        \App\Models\InstituteAssignedClass::where('id',$institute_assigned_class_subject->institute_assigned_class_id)->first();
        $institute_id = $institute_assigned_class->institute_id;
        }
        $doubt_messages = $doubt->doubt_messages;
        if ($dontread){
        }else{
        $old_data =
        DB::table('class_notifications')->where('student_id',auth()->user()->student_id)->where('isread',2)->where('i_a_c_s_id',request()->iacs_id)->get();
        if ($old_data) {
        foreach($old_data as $dat){
        $old_data_arr = !empty($dat->readUsers) ? explode(',',$dat->readUsers) :[];
        if(!in_array(auth()->user()->student_id , $old_data_arr)) {
        $old_data_arr[] = auth()->user()->student_id;
        $query =
        DB::table('class_notifications')->where('i_a_c_s_id',request()->iacs_id)->where('isread',2)->where('student_id',auth()->user()->student_id)->update([
        'readUsers'=> implode(',',$old_data_arr),
        'isread'=> 4
        ]);
        }
        }
        }
        }
        }
        @endphp
        @forelse ($doubt_messages ?? [] as $item)
        @if ($item->sendable_type == '\App\Models\Student')
        <div class="incoming_msg">
            <div class="incoming_msg_img"> <img
                    src="{{!empty(auth()->user()->student->avatar) ? auth()->user()->student->avatar : '/assets/front/images/cost.png'}}"
                    alt="{{auth()->user()->student->name}}" style="border-radius: 50%!important;">
            </div>
            <div class="received_msg">
                <div class="received_withd_msg">
                    @php
                    $filename = '';
                    if($item->type == '' || $item->type == 'file'){
                    $mesg = !empty($item->message) && @unserialize($item->message) ? unserialize($item->message) :'';
                    if(!empty($mesg)){
                    $filename = $mesg[0];
                    }}
                    @endphp
                    <p>
                        @if($item->type == 'file')
                        <a href="{{ $filename ?? '' }}" target="_blank">
                            View
                        </a>
                        @endif
                         @if($item->type == 'text')
                        <?php echo $item->message; ?>
                        @endif  
                        <!--  @if(!empty($exe) && $exe == 'pdf')
                        <a href="{{ $item->message }}" target="_blank">
                            View PDF
                        </a>
                        @else
                        <a href="{{ $item->message }}" target="_blank">
                            <img src="{{ $item->message }}" alt="" style="width:200px;">
                        </a>
                        @endif -->
                    </p>
                    <span class="time_date">{{ date('H:i | M d, Y', strtotime($item->created_at)) }}</span>
                </div>
            </div>
        </div>
        @else
        <div class="outgoing_msg">
            <div class="sent_msg">
                {{--  <p><a href="{{ $item->message }}" target="_blank"><img src="{{ $item->message }}" alt=""
                    style="width:200px;"></a></p> --}}
                @php
                $filename = '';
                if($item->type == '' || $item->type == 'file'){
                $mesg = !empty($item->message) ? unserialize($item->message) :'';
                if(!empty($mesg)){
                $filename = $mesg[0];
                }}
                @endphp
                <p>
                    <a href="{{ $filename ?? '' }}" target="_blank">
                        View
                    </a>
                    {{--  @if($exe == 'pdf')
                    <a href="{{ $item->message }}" target="_blank">
                    View PDF
                    </a>
                    @else
                    <a href="{{ $item->message }}" target="_blank">
                        <img src="{{ $item->message }}" alt="" style="width:200px;">
                    </a>
                    @endif --}}
                </p>
                <span class="time_date">{{ date('H:i | M d, Y', strtotime($item->created_at)) }}</span>
            </div>
        </div>
        @endif
        @empty
        <h2 class="d-flex justify-content-center align-items-center h-75">No Doubts yet</h2>
        @endforelse
    </div>
    @if ($errors->any())
    <div class="alert alert-danger">
        <a type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </a>
        @foreach ($errors->all() as $error)
        {{ $error }}
        @endforeach
    </div>
    @endif
    <div class="type_msg">
        <div class="input_msg_write">
            <form action="{{ route('student.doubts', request()->iacs_id) }}" class='syllabusform' method="POST"
                enctype="multipart/form-data">
                @csrf
                <label for="">Image format - JPG/PNG/PDF</label>
                <input type="file" class="write_msg form-control inputChange" name="message"
                    placeholder="Type a message" accept='application/pdf,image/x-png,image/jpg,image/jpeg' />
                <button class="msg_send_btn" type="submit"><i class="fa fa-paper-plane-o"
                        aria-hidden="true"></i></button>
            </form>
        </div>
    </div>
</div>
</div>


{{-- <p class="text-center top_spac"> Developed by <a target="" href="#">Harat
          Malli</a></p> --}}

</div>
</div>
@endsection
@section('js')
<script src="{{ URL::to('assets/student/libs/custombox/custombox.min.js') }}"></script>
<script src="{{ URL::to('assets/student/js/app.min.js') }}"></script>
<script>
$('.write_msg').change(function() {
    $('.msg_send_btn').focus();
})


$('.inputChange').change(function(e) {
    e.preventDefault();
    var fileExtension = ['pdf', 'jpg', 'png'];
    if ($.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) == -1) {
        alert("Only formats are allowed : " + fileExtension.join(', '));
    } else {}
});
</script>
@endsection