<script>function attendActivity(activity_id) {    $.getJSON("__('activity/attendActivity'|site_url)__?id="+activity_id,function(data){      if( data ) {      	if( data==1 )      		alert('成功报名活动！');      	else if( data==2 )      		alert('成功取消报名！');      }      window.location.reload();    });}function followActivity(activity_id) {    $.getJSON("__('activity/followActivity'|site_url)__?id="+activity_id,function(data){      if( data ) {      	if( data==1 )      		alert('成功关注活动！');      	else if( data==2 )      		alert('成功取消关注！');      }      window.location.reload();    });}//ctrl+enter 提交回复$("#comment-content").keydown(function (e) {  if (e.ctrlKey && e.keyCode == 13) {    $("#reply-form").submit();  }});var prev_page = __($page_information.current_page)__;function addReplyTo(name) {  var t = '回复'+name+': '+$("#comment-content").val();  $("#comment-content").focus().val(t);}function loadPage(page){    activity_id = __($activity_information.activity_id)__;    limit = __($page_information.limit)__;    page_offset = (page-1) * __($page_information.limit)__;        $.getJSON("__('activity/ajaxGetActivityCommentInformation'|site_url)__?activity_id="+activity_id+"&limit="+limit+"&page_offset="+page_offset,function(data){      $("#comment-tbody").empty();      for( i in data ) {        var item = '<tr id="m-'+data[i].member_message_id+'">'                  +'<td style="width: 120px">'                  +'<img src="'+data[i].member_image+'" alt="'+data[i].member_name+'" class="avatar-medium"><a href="__("profile"|site_url)__"?id='+data[i].member_id+'>'+data[i].member_name+'</a>'                  +'</td>'                  +'<td>'+data[i].content+'</td>'                  +'<td class="pull-right">'+data[i].created_time+'</td>'                  +'<td style="width: 50px">';        if( data[i].member_id == __($current_member_information.member_id)__ ) {          item +='<a href="#reply-box" class="act" onclick="addReplyTo(\''+data[i].member_name+'\')">回复</a>';        }        item += '</td></tr>';        $("#comment-tbody").append( item );      }      $("#p-"+prev_page).removeClass("active");      $("#p-"+page).addClass("active");      prev_page = page;    });}</script>