<script>function handleActivityAttend(activity_attend_id,action,member_id) {    $.getJSON('{"activity/handle_activity_attend"|site_url}',{activity_attend_id:activity_attend_id,action:action},function(data) {      if( data.status ) { //success        if( action ) {          message = '已通过 ID='+member_id+' 的申请';          $("#row-"+activity_attend_id+" .tool").html('已通过申请');        /*        handle 群发        member_img = $("#activity_attend_"+activity_attend_id+ "> .image > a > img").attr('src');        member_url = $("#activity_attend_"+activity_attend_id+ "> .image > a").attr('href');        member_name = $("#activity_attend_"+activity_attend_id+ "> .content > .name > a").html().substring(0,7);                member_message = '<li id="member_message_'+member_id+'">'+                  '<div class="image"><a href=\"'+member_url+'"><img src="'+member_img+'" height="100" width="100" /></a></div>'+                  '<div class="content">'+                    '<span class="name"><a href=\"'+member_url+'\">'+member_name+'</a></span>'+                    '<input type="checkbox" name="member_list[]" value="'+member_id+'" checked="checked" />'+                  '</div>'+                '</li>';        $("ul.activity_attend_member_list").append(member_message);*/        } else {          message = '已拒绝 ID='+member_id+' 的申请';          $("#row-"+activity_attend_id).fadeOut("slow",function(){            $("#row-"+activity_attend_id).remove();          });        }      } else {        message = 'Operation failed.';      }      alert( message );    });}  </script>