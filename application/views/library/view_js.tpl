<script>$("#navbar-library").addClass("active");$("#btn-like").click( function() {   $.getJSON("{'library/ajaxLikeBook'|site_url}?id="+{$book_information.book_id},function(data){      if( !data ) {         alert('Operation failed.');      } else if( data == 1 ) {         alert('成功喜欢了日志!');        window.location.reload();      } else if( data == -1 ) {         alert('你已经喜欢过了!');      } else if( data == -2 ) {         alert('你就别自恋了!');      }    });});//ctrl+enter 提交回复$("#comment-content").keydown(function (e) {   if (e.ctrlKey && e.keyCode == 13) {     addComment();  }});$("#reply-form-submit").click(function() {   addComment();});var prev_page = {$page_information.page};function addReplyTo(name) {   var t = '回复'+name+': '+$("#comment-content").val();  $("#comment-content").focus().val(t);}function addComment() {   book_id = {$book_information.book_id};  content = $("#comment-content").val();  if(!content) {     alert("评论提交不能为空！");    return;  }  $.getJSON("{'library/ajaxAddComment'|site_url}", { "book_id":book_id, "content":content }, function(data) {     newComment = wrapComment(data);    $("#comment-tbody").prepend( newComment );  });  $("#comment-content").val('');}function loadPage(page){     book_id = {$book_information.book_id};    limit = {$page_information.limit};    page_offset = (page-1) * {$page_information.limit};        $.getJSON("{'library/ajaxGetBookComment'|site_url}",{ "book_id":book_id, "page_offset":page_offset }, function(data){       $("#comment-tbody").empty();      for( i in data ) {        item = wrapComment( data[i] );        $("#comment-tbody").append( item );      }      $("#p-"+prev_page).removeClass("active");      $("#p-"+page).addClass("active");      prev_page = page;    });}function wrapComment(data) {  var item = '<tr id="m-'+data.member_message_id+'">'            +'<td style="width: 120px">'            +'<img src="'+data.member_image+'" alt="'+data.member_name+'" class="avatar-medium"><a href="{"profile"|site_url}"?id='+data.member_id+'>'+data.member_name+'</a>'            +'</td>'            +'<td class="span7">'+data.content+'</td>'            +'<td class="span2 pull-right">'+data.created_time+'</td>'            +'<td style="width: 50px">';  if( data.member_id != {$current_member_information.member_id} ) {    item +='<a href="#reply-box" class="act" onclick="addReplyTo(\''+data.member_name+'\')">回复</a>';  }  item += '</td></tr>';  return item;}</script>