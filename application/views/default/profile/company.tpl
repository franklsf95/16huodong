<script>	var current_top = 20;	var current_left = 0;	var page_offset = 0;	var limit = 6;	var member_id = '{$member_information.member_id}';	var current_id_num = 0;	var image_width = 210;		function addMemberActivityShow(){		$.ajax({			url:"{'base_ajax_action_controller/getCurrentAttendActivity'|site_url}",			data:'member_id='+member_id+'&page_offset='+page_offset+'&limit='+limit,			type: "GET",			dataType: "JSON",			async: false,			success:function(data){				for(i in data){					//alert('top='+top+';left='+left);					current_id_num++;					current_id = 'ia_'+ current_id_num;					var member_activity_show = ''+												'<div class=\"member_activity_show\" id=\"'+current_id+'\">'+													'<div class=\"image\"><a href=\"{"activity/view"|site_url}?id='+data[i].activity_id+'\" ><img src=\"'+data[i].activity_image+'\" /></a></div>'+													'<div class="title">'+														'<a href=\"{"profile"|site_url}?id='+data[i].member_id+'\" class=\"publisher\">'+data[i].member_name+'</a> 发起活动 <a href=\"{"activity/view"|site_url}?id='+data[i].activity_id+'\" class=\"activity_name\">'+data[i].activity_name+'</a>'+													'</div>'+													'<div class=\"start_time\">开始时间: '+data[i].start_time+'</div>'+													'<div class=\"end_time\">结束时间: '+data[i].end_time+'</div>'+													'<div class=\"number\">'+														'<div class=\"attend_number\"><span>'+data[i].attend_number+'</span>人参加</div>'+														'<div class=\"attention_number\"><span>'+data[i].attention_number+'</span>人关注</div>'+													'</div>'+												'</div>';										$("#activity_list_content").append(member_activity_show);										$('#'+current_id).css('top',current_top);					$('#'+current_id).css('left',current_left);					$('#'+current_id).css('display','none');										//处理图片尺寸问题					//var current_image = new Image(); 					//current_image.src = data[i].activity_image;					var current_image_width = data[i].activity_image_width;					var current_image_height = data[i].activity_image_height;										image_height = (image_width/current_image_width)*current_image_height;										$('#'+current_id+' > .image > a > img').width(image_width)					$('#'+current_id+' > .image > a > img').height(image_height)										var div_height = $('#'+current_id).outerHeight();					current_content_height = current_top + div_height;					if(parseFloat($("#activity_list_content").height()) < current_content_height) {						$("#activity_list_content").height(current_content_height) ;						//alert('修改后：'+parseFloat($("#activity_list_content").height()));					}										//calculate top parameter					if (current_id_num < 3) {						current_top = 20;					}else {						previous_id = '#ia_'+(current_id_num + 1 - 3);						//alert(previous_id);						previous_div = $(previous_id);						previous_div_position = previous_div.position();						previous_div_position_top = previous_div_position.top;												current_top = parseFloat(previous_div_position_top) + parseFloat(previous_div.outerHeight()) + 20;					}														$('#'+current_id).fadeIn("slow");					current_left = (current_id_num%3)*250 + (current_id_num%3)*20;				}				page_offset = page_offset +  limit;							}					});	}		function addToFriend(target_id){		$.getJSON("{'base_ajax_action_controller/addToFriend'|site_url}?target_id="+target_id,function(data){			alert(data.str);			window.location.reload();		});	}		$(function(){				//导航提示		$('#nav_02').css('color','#ad4c4c');			$( "#dialog_box" ).dialog({			autoOpen: false,			show: "blind",			hide: "explode",			buttons: {"确认":function(){						$("#addMemberMessageForm").submit();						//addMemberMessage();					},					"取消":function(){						$( "#dialog_box" ).dialog( "close" );					}			}		});				addMemberActivityShow();				$( "#addMemberMessage" ).click(function() {			$( "#dialog_box" ).dialog( "open" );			return false;		});			});		$(window).scroll(function() {		if (document.body.clientHeight - document.documentElement.scrollTop -  document.documentElement.clientHeight <= 10 ){			addMemberActivityShow();		}	});</script><div id="page_frame">	<div class="left_side">		{include file="{$template}/layout/menu_box.tpl"}	</div>		<div class="right_side" id="member_page">						<div class="member_information">				<div class="image"><img src="{$member_information.member_image}" height="135" width="135" /></div>				<div class="content">					<div class="context">						<span class="name">{$member_information.member_name}</span>						<div class="left">							<span>{$member_information.member_address}</span>							<span>电话:{$member_information.member_phone}</span>							<span>负责人:{$member_information.member_principal}</span>						</div>												<div class="right">							<span>邮箱:{$member_information.member_email}</span>							<span class="tag">标签:{$member_information.member_tag}</span>						</div>					</div>					{if !$member_information.my_page}					<div class="tools">						<span class="add_friend" onclick="addToFriend({$member_information.member_id})">{if $member_information.is_friend == 'Y'}取消好友{else}添加好友{/if}</span>						<span class="add_message" id="addMemberMessage">留言</span>					</div>					{/if}				</div>				<div class="clear"></div>				<div class="description">{$member_information.member_description|default:" 暂无简介"}</div>			</div>						<div class="activity_list">				<div class="tabs">					<ul>						<li>正参加的活动</li>					</ul>					<div class="clear"></div>				</div>							<div class="content" id="activity_list_content">				</div>			</div>									<div class="member_message_edit" title="站内信" id="dialog_box" style="display:none;" >				<form name="addMemberMessageForm" id="addMemberMessageForm" action="{'message/save_form'|site_url}" method="post">				<fieldset>					<p>						收件人:{$member_information.member_name}						<input name="member_id" type="hidden" id="member_id" value="{$member_information.member_id}" />					</p>										<p>						<textarea name="message_content" id="message_content"></textarea>					</p>									</fieldset>				</form>			</div>							</div>	</div>