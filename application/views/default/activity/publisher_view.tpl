<script>	function attendActivity(activity_id){		$.getJSON("__('activity/attend_activity'|site_url)__?id="+activity_id,function(data){			if (data.status == 'Y') {				alert(data.str);				window.location.reload();			} else {				alert(data.str);				window.location.reload();			}		});	}		function attentionActivity(activity_id){		$.getJSON("__('activity/attention_activity'|site_url)__?id="+activity_id,function(data){			if (data.status == 'Y') {				alert(data.str);				window.location.reload();			} else {				alert(data.str);				window.location.reload();			}		});	}		function addReplyDiv(comment_id) {		if(comment_id != '') {			$(".reply_div").remove();			if (!$('#reply_div_'+comment_id).length > 0){				reply_div = '<div class=\"reply_div\" id="reply_div_'+comment_id+'">'+								'<form action=\"__("activity/addActivityCommentReply"|site_url)__\" name="addActivityCommentReplyForm" method=\"post\" onsubmit="return false;" >'+									'<textarea name=\"reply\"></textarea>'+									'<input type=\"hidden\" name=\"activity_comment_id\" value="'+comment_id+'" />'+									'<input type=\"submit\" value=\"回复\" onclick="addActivityCommentReply();" />'+								'</form>'+							'</div>';				$('#activity_comment_'+comment_id).after(reply_div);			}else {				$('#reply_div_'+comment_id).remove();			}		}	}		function addActivityComment(){		activity_id = '__($activity_information.activity_id)__';		content = $("#activity_comment").val();		if (content == '') {alert('内容不能为空'); return false;}		$.ajax({			url:'__("base_ajax_action_controller/addActivityComment"|site_url)__',			async: false,			type:'POST',			data: 'activity_id='+activity_id+'&content='+content,			dataType:'json',			success:function(activity_comment){				comment_box = '<li>'+								'<div class="activity_comment_box">'+									'<div class="member_image" style="float:left;"><img src="'+activity_comment.member_image+'" height="40" width="40" /></div>'+									'<div class="content">'+										'<div id="activity_comment_'+activity_comment.activity_comment_id+'">'+											'<p class="comment"><a href="__("member"|site_url)__?id='+activity_comment.member_id+'" class="member_name">'+activity_comment.member_name+'</a>:  '+activity_comment.content+'<a class="reply_button" onclick="addReplyDiv('+activity_comment.activity_comment_id+')" >回复</a></p>'+										'</div>'+										'<div class="clear"></div>'+									'</div>'+								'</div>'+								'<div class="clear"></div>'+							'</li>';				$("#view_activity_comment > ul").prepend(comment_box);				$("#activity_comment").val('');			}		});	}		function addActivityCommentReply(){		activity_comment_id = $("form[name=addActivityCommentReplyForm] input[name=activity_comment_id]").val();		reply = $("form[name=addActivityCommentReplyForm] textarea[name=reply]").val();		if (reply == '') {alert('内容不能为空'); return false;}		$.ajax({			url:'__("base_ajax_action_controller/addActivityCommentReply"|site_url)__',			async: false,			type:'POST',			data: 'activity_comment_id='+activity_comment_id+'&reply='+reply,			dataType:'json',			success:function(activity_comment){				$(".reply_div").remove();				$("#activity_comment_"+activity_comment.activity_comment_id).empty();				comment_box = '<p class="comment"><a href="__("member"|site_url)__?id='+activity_comment.member_id+'" class="member_name">'+activity_comment.member_name+'</a>:  '+activity_comment.content+'</p>'+								'<p class="reply">发布者:'+activity_comment.reply+'</p>';				$("#activity_comment_"+activity_comment.activity_comment_id).html(comment_box);				$("#activity_comment").val('');			}		});	}		function getActivityComment(page){		activity_id = __($activity_information.activity_id)__;		limit = __($page_information.limit)__;		page_offset = (page-1) * __($page_information.limit)__;				$.getJSON("__('base_ajax_action_controller/getActivityCommentInformation'|site_url)__?activity_id="+activity_id+"&limit="+limit+"&page_offset="+page_offset,function(data){			$("#view_activity_comment > ul").empty();			for (i in data){				comment_box = '<li>'+								'<div class="activity_comment_box">'+									'<div class="member_image" style="float:left;"><img src="'+data[i].member_image+'" height="40" width="40" /></div>'+									'<div class="content">'+										'<div id="activity_comment_'+data[i].activity_comment_id+'">'+											'<p class="comment"><a href="__("member"|site_url)__?id='+data[i].member_id+'" class="member_name">'+data[i].member_name+'</a>:  '+data[i].content;														if(data[i].reply == null){					comment_box += 				'<a class="reply_button" onclick="addReplyDiv('+data[i].activity_comment_id+')" >回复</a></p>';				}else {					comment_box += 			'</p>'+											'<p class="reply">回复:'+data[i].reply+'</p>';				}				comment_box += 			'</div>'+										'<div class="clear"></div>'+									'</div>'+								'</div>'+								'<div class="clear"></div>'+							'</li>';				$("#view_activity_comment > ul").append(comment_box);			}		})		return false;	}		function handleActivityAttend(activity_attend_id,action,member_id){		$.getJSON('__("activity/handle_activity_attend"|site_url)__',{activity_attend_id:activity_attend_id,action:action},function(data){			if(data.status == 'Y'){				$("#activity_attend_"+activity_attend_id+ "> .tools").empty().html('<span>已通过申请</span>');				member_img = $("#activity_attend_"+activity_attend_id+ "> .image > a > img").attr('src');				member_url = $("#activity_attend_"+activity_attend_id+ "> .image > a").attr('href');				member_name = $("#activity_attend_"+activity_attend_id+ "> .content > .name > a").html().substring(0,7);								member_message = '<li id="member_message_'+member_id+'">'+									'<div class="image"><a href=\"'+member_url+'"><img src="'+member_img+'" height="100" width="100" /></a></div>'+									'<div class="content">'+										'<span class="name"><a href=\"'+member_url+'\">'+member_name+'</a></span>'+										'<input type="checkbox" name="member_list[]" value="'+member_id+'" checked="checked" />'+									'</div>'+								'</li>';				$("ul.activity_attend_member_list").append(member_message);				alert(data.str);							}else if(data.status == 'N') {				$("#activity_attend_"+activity_attend_id).fadeOut("slow",function(){					$("#activity_attend_"+activity_attend_id).remove();					alert(data.str);				});			}					});	}</script><script>	var activity_image_width = 300;	//定义图片宽度	var current_activity_image_width = '__($activity_information.activity_image_width)__';	var current_activity_image_height = '__($activity_information.activity_image_height)__';		$(function() {				//导航提示		$('#nav_07').css('color','#ad4c4c');				$( "#tabs" ).tabs();				activity_image_height = (activity_image_width/current_activity_image_width)*current_activity_image_height;				$("#activity_image").width(activity_image_width);		$("#activity_image").height(activity_image_height);				$("#addActivityComment").click(function(){			addActivityComment();		});						$('.ajax_pagination').jqPagination({			paged: function(page) {				getActivityComment(page);			}		});	});</script><div id="page_frame">	<div class="left_side">		__(include file="__($template)__/layout/menu_box.tpl")__	</div>				<div class="right_side" id="activity_detail">		<div id="tabs">			<ul>				<li><a href="#tabs-1">活动详情</a></li>				<li><a href="#tabs-2">报名会员</a></li>				<li><a href="#tabs-3">关注会员</a></li>				<li><a href="#tabs-4">群发通知</a></li>			</ul>			<div id="tabs-1">				<div class="activity_content">					<div class="image"><img src="__($activity_information.activity_image)__" height="300" width="300" id="activity_image" /></div>					<div class="context">						<span class="name">__($activity_information.activity_name)__</span>						<span class="start_time"><span class="title">开始时间: </span>__($activity_information.start_time)__</span>						<span class="end_time"><span class="title">结束时间: </span>__($activity_information.end_time)__</span>						<span class="address"><span class="title">地点: </span>__($activity_information.activity_address)__</span>						<span class="publisher"><span class="title">发布者: </span><a href="__('member'|site_url)__?id=__($activity_information.member_id)__">__($activity_information.member_name)__</a></span>						<span class="type"><span class="title">活动类型: </span>__($activity_information.activity_type)__</span>						<span class="price"><span class="title">费用: </span>__($activity_information.activity_price)__</span>						<div class="number">							<span class="attend_number">__($activity_information.all_activity_attend_member_information|@count)__人参加</span>							<span class="attention_number">__($activity_information.all_activity_attention_member_information|@count)__人关注</span>						</div>						<div class="clear"></div>						<div class="tools">							__(if ($smarty.now < (($activity_information.end_time|strtotime)+(3600*24))))__							<span class="attention" onclick="attentionActivity('__($activity_information.activity_id)__')">__(if $activity_information.is_attention == 'Y')__取消关注__(else)__我要关注__(/if)__</span>							<span class="attend" onclick="attendActivity('__($activity_information.activity_id)__')">__(if $activity_information.is_attend == 'Y')__取消报名__(else)__我要报名__(/if)__</span>							__(else)__							<span class="closed">活动已结束</span>							__(/if)__						</div>					</div>										<div class="content">						<span class="title">活动详情</span>						<div class="context">__($activity_information.activity_content)__</div>					</div>				</div>								<div class="clear"></div>								<div class="view_activity_ablum">					<span class="title">活动相册</span>					<ul>						__(foreach name=all_activity_ablum_information from=$activity_information.all_activity_ablum_information item=activity_ablum_information)__						<li>							<div class="image"><img src="__($activity_ablum_information.ablum_image)__" height="" width="" /></div>							<span class="name">__($activity_ablum_information.ablum_name)__</span>						</li>						__(/foreach)__					</ul>				</div>								<div class="clear"></div>								<div class="view_activity_blog">					<span class="title">活动日志</span>					<ul>						__(foreach name=all_activity_blog_information from=$activity_information.all_activity_blog_information item=activity_blog_information)__						<li>							<div class="image"><img src="__($activity_ablum_information.ablum_image)__" height="" width="" /></div>							<span class="name">__($activity_ablum_information.ablum_name)__</span>						</li>						__(/foreach)__					</ul>				</div>								<div class="clear"></div>								<div class="view_activity_comment" id="view_activity_comment">					<span class="title">留言提问</span>					<ul>					__(foreach name=all_activity_comment_information from=$activity_information.all_activity_comment_information item=activity_comment_information)__						<li>							<div class="activity_comment_box">								<div class="member_image" style="float:left;"><img src="__($activity_comment_information.member_image)__" height="40" width="40" /></div>								<div class="content">									<div id="activity_comment___($activity_comment_information.activity_comment_id)__">										<p class="comment"><a href="__('member'|site_url)__?id=__($activity_comment_information.member_id)__" class="member_name">__($activity_comment_information.member_name)__</a>:  __($activity_comment_information.content)__										__(if $activity_comment_information.reply == '')__										<a class="reply_button" onclick="addReplyDiv('__($activity_comment_information.activity_comment_id)__')" >回复</a></p>										__(else)__										</p>										<p class="reply">发布者:__($activity_comment_information.reply)__</p>										__(/if)__									</div>																		<div class="clear"></div>								</div>							</div>							<div class="clear"></div>						</li>					__(/foreach)__					</ul>					<div class="ajax_pagination">						<a href="#" class="first" data-action="first">&laquo;</a>						<a href="#" class="previous" data-action="previous">&lsaquo;</a>						<input type="text" readonly="readonly" data-max-page="__($page_information.last_page)__" />						<a href="#" class="next" data-action="next">&rsaquo;</a>						<a href="#" class="last" data-action="last">&raquo;</a>					</div>					<div class="clear"></div>				</div>								<div class="add_activity_comment">					<form action="__('activity/save_comment'|site_url)__" method="post" onsubmit="return false;">						<p><textarea id="activity_comment" name="activity_comment"></textarea></p>						<p><input type="hidden" id="activity_id" name="activity_id" value="__($activity_information.activity_id)__" /></p>						<p><button type="submit" class="submit" id="addActivityComment" >发表</button></p>					</form>				</div>			</div>						<div id="tabs-2">				<ul class="view_activity_attend_member">					__(foreach name=all_activity_attend_member_information from=$activity_information.all_activity_attend_member_information item=activity_attend_member_information)__						<li id="activity_attend___($activity_attend_member_information.activity_attend_id)__">							<div class="image"><a href="__('member'|site_url)__?id=__($activity_attend_member_information.member_id)__"><img src="__($activity_attend_member_information.image)__" height="100" width="100" /></a></div>							<div class="content">								<span class="name"><span class="title">姓名:</span><a href="__('member'|site_url)__?id=__($activity_attend_member_information.member_id)__">__($activity_attend_member_information.name)__</a></span>								<span class="mobilephone"><span class="title">手机:</span>__($activity_attend_member_information.mobilephone)__</span>								<span class="email"><span class="title">Email:</span>__($activity_attend_member_information.email)__</span>								<span class="qq"><span class="title">QQ:</span>__($activity_attend_member_information.qq)__</span>							</div>							<div class="tools">								__(if $activity_attend_member_information.status == 'Y')__								<span>已通过申请</span>								__(else)__								<span onclick="handleActivityAttend('__($activity_attend_member_information.activity_attend_id)__','Y','__($activity_attend_member_information.member_id)__')">通过申请</span>								<span onclick="handleActivityAttend('__($activity_attend_member_information.activity_attend_id)__','N','__($activity_attend_member_information.member_id)__')">拒绝申请</span>								__(/if)__							</div>						</li>											__(/foreach)__				</ul>			</div>						<div id="tabs-3">				<ul class="view_activity_attention_member">					__(foreach name=all_activity_attention_member_information from=$activity_information.all_activity_attention_member_information item=activity_attention_member_information)__						<li>							<div class="image"><a href="__('member'|site_url)__?id=__($activity_attention_member_information.member_id)__"><img src="__($activity_attention_member_information.image)__" height="100" width="100" /></a></div>							<div class="content">								<span class="name"><span class="title">姓名:</span><a href="__('member'|site_url)__?id=__($activity_attention_member_information.member_id)__">__($activity_attention_member_information.name)__</a></span>								<span class="mobilephone"><span class="title">手机:</span>__($activity_attention_member_information.mobilephone)__</span>								<span class="email"><span class="title">Email:</span>__($activity_attention_member_information.email)__</span>								<span class="qq"><span class="title">QQ:</span>__($activity_attention_member_information.qq)__</span>							</div>						</li>											__(/foreach)__				</ul>			</div>						<div id="tabs-4">				<div class="send_activity_message">				<form name="addMemberMessageForm" id="addMemberMessageForm" action="__('message/save_form_array'|site_url)__" method="post">				<div class="message_box">					<span class="prompt" style="padding:5px 0px; display:block;">活动主办方可以在以下方框内输入活动通知，群发给申请通过的活动参与者。申请未通过者不会出现在下面的列表中。</span>					<textarea name="content" id="message_content"></textarea>					<input type="submit" value="发送" />				</div>								<ul class="activity_attend_member_list">					__(foreach name=all_activity_attend_member_information from=$activity_information.all_activity_attend_member_information item=activity_attend_member_information)__					__(if $activity_attend_member_information.status == 'Y')__						<li id="member_message___($activity_attend_member_information.member_id)__">							<div class="image"><a href="__('member'|site_url)__?id=__($activity_attend_member_information.member_id)__"><img src="__($activity_attend_member_information.image)__" height="100" width="100" /></a></div>							<div class="content">								<span class="name"><a href="__('member'|site_url)__?id=__($activity_attend_member_information.member_id)__">__($activity_attend_member_information.name|truncate:7:"..")__</span>								<input type="checkbox" name="member_list[]" value="__($activity_attend_member_information.member_id)__" checked="checked" />							</div>						</li>					__(/if)__					__(/foreach)__				</ul>				</form>				</div>			</div>					</div>	</div></div>