<ul class="breadcrumb">  <li><a href="{'message'|site_url}">站内信</a> <span class="divider">/</span></li>  <li class="active">我与<a href="{'profile/view'|site_url}/{$target_info.member_id}">{$target_info.member_name}</a>的站内信</li></ul><div class="content-heading">{$current_member_information.member_name}与{$target_info.member_name}的消息记录</div><div id="reply-box">	<form id="reply-form" action="{'message/send'|site_url}" method="post" class="span6">	<fieldset>		<textarea name="message_content" id="message-content" class="span6 reply-content" rows="3"></textarea>		<input name="member_id" type="hidden" value="{$target_info.member_id}"/>		<input type="submit" class="btn btn-primary pull-right" value="留言" />	</form></div><table class="table table-striped"><tbody>{foreach $all_member_message_information as $i}<tr id="m-{$i.member_message_id}">	<td class="comment-heading">	{if $i.member_id == $current_member_id}	<img src="{$current_member_information.member_image}" alt="{$current_member_information.member_name}" class="avatar-medium"><a href="{'profile/view'|site_url}">{$current_member_information.member_name}</a>	{else}	<img src="{$target_info.member_image}" alt="{$target_info.member_name}" class="avatar-medium"><a href="{'profile/view'|site_url}/{$target_info.member_id}">{$target_info.member_name}</a>	{/if}	</td>	<td class="comment-content">{$i.content}</td>	<td class="comment-timestamp">{$i.created_time}</td>	<td class="comment-reply-btn">{if $i.target_id == $current_member_id}		<a href="#" class="act reply-btn">回复</a>{/if}	</td><tr>{/foreach}<tbody></table>