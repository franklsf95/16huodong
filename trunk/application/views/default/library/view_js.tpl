<script>$("#navbar-library").addClass("active");$("#btn-like").click( function() {  $.getJSON("__('library/ajaxLikeBook'|site_url)__?id="+__($book_information.member_blog_id)__,function(data){      if( !data ) {        alert('Operation failed.');      } else if( data == 1 ) {        alert('成功喜欢了日志!');        window.location.reload();      } else if( data == -1 ) {        alert('你已经喜欢过了!');      } else if( data == -2 ) {        alert('你就别自恋了!');      }    });});//ctrl+enter 提交回复$("#comment-content").keydown(function (e) {  if (e.ctrlKey && e.keyCode == 13) {    addComment();  }});$("#reply-form-submit").click(function() {  addComment();});var prev_page = __($page_information.current_page)__;function addReplyTo(name) {  var t = '回复'+name+': '+$("#comment-content").val();  $("#comment-content").focus().val(t);}function addComment() {  book_id = __($book_information.member_blog_id)__;  content = $("#comment-content").val();  if(!content) {    alert("评论提交不能为空！");    return;  }  $.getJSON("__('library/ajaxAddComment'|site_url)__", {"book_id":book_id, "content":content}, function(data) {    newComment = wrapComment(data);    $("#comment-tbody").append( newComment );  });  $("#comment-content").val('');}function loadPage(page){    book_id = __($book_information.member_blog_id)__;    limit = __($page_information.limit)__;    page_offset = (page-1) * __($page_information.limit)__;        $.getJSON("__('library/ajaxGetBookComment'|site_url)__",{ "book_id":book_id, "page_offset":page_offset }, function(data){      $("#comment-tbody").empty();      for( i in data ) {        item = wrapComment( data[i] );        $("#comment-tbody").append( item );      }      $("#p-"+prev_page).removeClass("active");      $("#p-"+page).addClass("active");      prev_page = page;    });}function wrapComment(data) {  var item = '<tr id="m-'+data.member_message_id+'">'            +'<td style="width: 120px">'            +'<img src="'+data.member_image+'" alt="'+data.member_name+'" class="avatar-medium"><a href="__("profile"|site_url)__"?id='+data.member_id+'>'+data.member_name+'</a>'            +'</td>'            +'<td>'+data.content+'</td>'            +'<td class="pull-right">'+data.created_time+'</td>'            +'<td style="width: 50px">';  if( data.member_id != __($current_member_information.member_id)__ ) {    item +='<a href="#reply-box" class="act" onclick="addReplyTo(\''+data.member_name+'\')">回复</a>';  }  item += '</td></tr>';  return item;}</script>