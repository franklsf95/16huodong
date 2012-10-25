<div class="content-heading">站内信</div><div class="accordion" id="accordion-messages">	<div class="accordion-group">    <div class="accordion-heading">      <a class="accordion-toggle" data-toggle="collapse" data-parent="accordion-messages" href="#collapse-member">好友消息</a>      <a href="#modal-compose" class="btn btn-primary pull-right" data-toggle="modal">发送新消息</a>    </div>    <div id="collapse-member" class="accordion-body collapse in">      <div class="accordion-inner">		<table class="table table-striped">		<tbody>		__(foreach $all_member_message_information as $i)__		<tr id="mm-__($i.system_message_id)__">			<td><img class="avatar-medium" src="__($i.target_image)__" alt="__($i.target_name)__"></td>			<td>__(if ($i.member_id == $current_member_id))__发给: __(/if)__<a href="__('profile'|site_url)__?id=__($i.target_id)__">__($i.target_name)__</a></td>			<td>__($i.content)__</td>			<td><a href="__('message/view'|site_url)__?target_id=__(if ($i.member_id == $current_member_id))____($i.target_id)____(else)____($i.member_id)____(/if)__"><b>共 __($i.count)__ 条消息</b></a>		</tr>		__(/foreach)__		<tbody>		</table>      </div><!--/accordion-inner-->    </div><!--/accordion-body-->  </div><!--/accordion-group--><div class="accordion-group">    <div class="accordion-heading">      <a class="accordion-toggle" data-toggle="collapse" data-parent="accordion-messages" href="#collapse-system">系统消息</a>    </div>    <div id="collapse-system" class="accordion-body collapse in">      <div class="accordion-inner"><table class="table table-striped"><tbody><tr><td><b>活动消息</b></td></tr>__(foreach $all_system_message_information.all_activity_message_information as $i)__<tr id="sm-__($i.system_message_id)__">	<td class="new-message">__(if $i.is_new == 'Y')__New!__(/if)__</td>	<td>	__(if $i.type == 'edit_activity')__	您参加的 <a href="__('message/gotoactmsg'|site_url)__?id=__($i.activity_id)__&mid=__($i.system_message_id)__">__($i.activity_name)__</a> 修改了活动内容	__(elseif $i.type == 'new_comment')__		<a href="__('profile'|site_url)__?id=__($i.member_id)__">__($i.member_name)__</a> 评论了<a href="__('message/gotoactmsg'|site_url)__?id=__($i.activity_id)__&mid=__($i.system_message_id)__">__($i.activity_name)__</a>	__(elseif $i.type == 'new_reply')__		<a href="__('profile'|site_url)__?id=__($i.member_id)__">__($i.member_name)__</a> 回复了您对<a href="__('message/gotoactmsg'|site_url)__?id=__($i.activity_id)__&mid=__($i.system_message_id)__">__($i.activity_name)__</a>的评论	__(elseif $i.type == 'attend_activity')__		<a href="__('profile'|site_url)__?id=__($i.member_id)__">__($i.member_name)__</a> 报名参加<a href="__('message/gotoactmsg'|site_url)__?id=__($i.activity_id)__&mid=__($i.system_message_id)__">__($i.activity_name)__</a>	__(elseif $i.type == 'activity_apply_pass')__		<a href="__('profile'|site_url)__?id=__($i.member_id)__">__($i.member_name)__</a> 通过了您对<a href="__('message/gotoactmsg'|site_url)__?id=__($i.activity_id)__&mid=__($i.system_message_id)__">__($i.activity_name)__</a>的报名	__(elseif $i.type == 'publish_activity')__		<a href="__('profile'|site_url)__?id=__($i.member_id)__">__($i.member_name)__</a> 发布了<a href="__('message/gotoactmsg'|site_url)__?id=__($i.activity_id)__&mid=__($i.system_message_id)__">__($i.activity_name)__</a>	__(elseif $i.type == 'invite_attend_activity')__		<a href="__('profile'|site_url)__?id=__($i.member_id)__">__($i.member_name)__</a> 邀请您参加 <a href="__('message/gotoactmsg'|site_url)__?id=__($i.activity_id)__&mid=__($i.system_message_id)__">__($i.activity_name)__</a>	__(/if)__	</td>	<td><button class="act act-primary" onclick="dealSystemMessage('__($i.system_message_id)__')"><i class="icon-ok"></i></button></td></tr>__(/foreach)__<tr><td></td></tr><tr><td><b>好友消息</b></td></tr>__(foreach $all_system_message_information.all_member_message_information as $i)__<tr id="sm-__($i.system_message_id)__">	<td class="new-message">__(if $i.is_new == 'Y')__New!__(/if)__</td>	<td>	__(if $i.type == 'apply_friend')__		<a href="__('message/gotomembermsg'|site_url)__?id=__($i.member_id)__&mid=__($i.system_message_id)__">__($i.member_name)__</a> 申请成为你的好友	__(elseif $i.type == 'add_friend')__		<a href="__('message/gotomembermsg'|site_url)__?id=__($i.member_id)__&mid=__($i.system_message_id)__">__($i.member_name)__</a> 已和你成为好友	__(/if)__	</td>	<td><button class="act act-primary" onclick="dealSystemMessage('__($i.system_message_id)__')"><i class="icon-ok"></i></button></td></tr>__(/foreach)__<tr><td></td></tr><tr></tr><tr><td><b>图书馆消息</b></td></tr>__(foreach $all_system_message_information.all_blog_message_information as $i)__<tr id="sm-__($i.system_message_id)__">	<td class="new-message">__(if $i.is_new == 'Y')__New!__(/if)__</td>	<td>	__(if $i.type == 'apply_friend')__		<a href="__('member'|site_url)__?id=__($i.member_id)__">__($i.member_name)__</a> 评论了您的日志<a href="__('message/gotoblogmsg'|site_url)__?id=__($i.member_blog_id)__&mid=__($i.system_message_id)__">__($i.member_blog_name)__</a>	__(/if)__	</td>	<td><button class="act act-primary" onclick="dealSystemMessage('__($i.system_message_id)__')"><i class="icon-ok"></i></button></td></tr>__(/foreach)__<tbody></table>      </div><!--/accordion-inner-->    </div><!--/accordion-body-->  </div><!--/accordion-group--></div><!--/accordion--><div class="modal hide fade" id="modal-compose">  <div class="modal-header">    <button type="button" class="close" data-dismiss="modal">×</button>    <h3>发送新消息</h3>  </div>  <form class="span5" id="compose-form" action="__('message/save_form'|site_url)__" method="post"><fieldset>  	<div class="modal-body">	<div id="member-list" class="pull-right"></div>    	<label>选择好友 (回车)</label>    	<input id="member-selector" type="text">    	<input id="member-id" name="member_id" type="hidden">    	<label>内容：</label>    	<textarea name="message_content" id="message_content"></textarea>  	</div>  	<div class="modal-footer">    	<button type="submit" class="btn btn-primary">发送 (Ctrl+Enter)</button>  	</div>  </fieldset></form></div>