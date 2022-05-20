 
@if(!empty($notifications) && count($notifications) > 0)
@foreach($notifications as $key => $notify)
<div class="container">  
    @if(!empty($notify) && $notify->type == 'pdf')
       @if($key % 2 == 0)
        <div class="alert alert-success  alert-dismissibl marka sread"  data-id='{{$notify->id ? $notify->id :''}}'>
             <button type="button" class="close markasread" data-iacs="{{$notify->i_a_c_s_id ? $notify->i_a_c_s_id :''}}" data-id='{{$notify->id ? $notify->id :''}}' data-dismiss="alert">&times;</button>
            <strong>
            @if (!empty($notify->message) && @unserialize($notify->message) == true) 
            <a target='_blank'  href="<?php echo $video = unserialize($notify->message)[0]; ?>">View</a>
            @endif
          </strong><br>
            <small>{{$notify->created_at ? date('Y-m-d h:i A',strtotime($notify->created_at)) : ''}}</small>
        </div>
        @else
        <div class="alert alert-primary  alert-dismissibl marka sread" data-id='{{$notify->id ? $notify->id :''}}'>
             <button type="button" class="close markasread" data-iacs="{{$notify->i_a_c_s_id ? $notify->i_a_c_s_id :''}}" data-id='{{$notify->id ? $notify->id :''}}' data-dismiss="alert">&times;</button>
             <strong>
             @if (!empty($notify->message) && @unserialize($notify->message) == true) 
             <a  target='_blank' href="<?php echo $video = unserialize($notify->message)[0]; ?>">View</a>
            @endif
             </strong><br>
             <small>{{$notify->created_at ? date('Y-m-d h:i A',strtotime($notify->created_at)) : ''}}</small>
        </div>
        @endif 
    @else
        @if($key / 2 == 0)
        <div class="alert alert-success  alert-dismissibl marka sread"  data-id='{{$notify->id ? $notify->id :''}}'>
             <button type="button" class="close markasread" data-iacs="{{$notify->i_a_c_s_id ? $notify->i_a_c_s_id :''}}" data-id='{{$notify->id ? $notify->id :''}}' data-dismiss="alert">&times;</button>
            <strong>{{$notify->message ? $notify->message : ''}}</strong><br>
            <small>{{$notify->created_at ? date('Y-m-d h:i A',strtotime($notify->created_at)) : ''}}</small>
        </div>
        @else
        <div class="alert alert-primary  alert-dismissibl marka sread" data-id='{{$notify->id ? $notify->id :''}}'>
             <button type="button" class="close markasread" data-iacs="{{$notify->i_a_c_s_id ? $notify->i_a_c_s_id :''}}" data-id='{{$notify->id ? $notify->id :''}}' data-dismiss="alert">&times;</button>
             <strong>{{$notify->message ? $notify->message : ''}}</strong><br>
             <small>{{$notify->created_at ? date('Y-m-d h:i A',strtotime($notify->created_at)) : ''}}</small>
        </div>
        @endif
    @endif
    </div>
@endforeach

@else
<div class="container">
    No Notifications !!!
</div>
@endif
<script>
 $(document).ready(function(){
    $('.markasread').click(function(){
        var id = $(this).data('id');
        var iacs = $(this).data('iacs');
        $.ajax({
          url: "{{url('student/markasread')}}",
          type: 'post',
          dataType: 'json',
          data: { 
            id: id,
            iacs: iacs,
            _token: "{{csrf_token()}}"
          },
          success:function(response){ 
            $('.notifications_all').html(response.view);
            if(response.count){
            $('.totalNotify').html('('+response.count+')');
            }else{
              $('.totalNotify').html('(0)');
            }
            
          }
        })
    });
 });
</script>