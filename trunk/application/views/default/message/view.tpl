<div class="content-heading">__($my_info.member_name)__与__($target_info.member_name)__的消息记录</div><div id="reply-box">	<form id="reply-form" action="__('message/save_form'|site_url)__" method="post" class="span6">	<fieldset>		<textarea name="message_content" id="message-content" class="span6 reply-content" rows="3"></textarea>		<input name="member_id" type="hidden" value="__($target_info.member_id)__"/>		<input type="submit" class="btn btn-primary pull-right" value="留言" />	</form></div><table class="table table-striped"><tbody>__(foreach $all_member_message_information as $i)__<tr id="m-__($i.member_message_id)__">	<td style="width: 120px">	__(if $i.target_id == $my_info.member_id)__	<img src="__($my_info.member_image)__" alt="__($my_info.member_name)__" class="avatar-medium"><a href="__('profile'|site_url)__">__($my_info.member_name)__</a>	__(else)__	<img src="__($target_info.member_image)__" alt="__($target_info.member_name)__" class="avatar-medium"><a href="__('profile'|site_url)__?id=__($target_info.member_id)__">__($target_info.member_name)__</a>	__(/if)__	</td>	<td>__($i.content)__</td>	<td class="pull-right">__($i.created_time)__</td>	<td style="width: 50px">__(if $i.target_id == $target_info.member_id)__		<a href="#reply-box" class="act reply-btn">回复</a>__(/if)__	</td><tr>__(/foreach)__<tbody></table>