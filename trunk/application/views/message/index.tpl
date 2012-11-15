<div class="content-heading">消息中心</div><a href="#modal-compose" class="btn btn-primary pull-right" data-toggle="modal">发送新消息</a><div class="accordion" id="accordion-messages">	<div class="accordion-group">    <div class="accordion-heading">      <a class="accordion-toggle" data-toggle="collapse" data-parent="accordion-messages" href="#collapse-member">好友消息</a>    </div>    <div id="collapse-member" class="accordion-body collapse in">      <div class="accordion-inner">		<table class="table table-striped">		<tbody>		{foreach $all_member_message_information as $i}		<tr id="mm-{$i.system_message_id}">			{if $i.member_id == $current_member_id}			<td><img class="avatar-medium" src="{$i.target_image}" alt="{$i.target_name}"></td>			<td>发给: <a href="{'profile'|site_url}?id={$i.target_id}">{$i.target_name}</a></td>			<td>{$i.content}</td>			<td><a href="{'message/view'|site_url}?target_id={$i.target_id}"><b>共 {$i.count} 条消息</b></a>			{else}			<td><img class="avatar-medium" src="{$i.member_image}" alt="{$i.member_name}"></td>			<td>来自: <a href="{'profile'|site_url}?id={$i.member_id}">{$i.member_name}</a></td>			<td>{$i.content}</td>			<td><a href="{'message/view'|site_url}?target_id={$i.member_id}"><b>共 {$i.count} 条消息</b></a>			{/if}		</tr>		{/foreach}		<tbody>		</table>      </div><!--/accordion-inner-->    </div><!--/accordion-body-->  </div><!--/accordion-group--><div class="accordion-group">    <div class="accordion-heading">      <a class="accordion-toggle" data-toggle="collapse" data-parent="accordion-messages" href="#collapse-system">系统消息</a>    </div>    <div id="collapse-system" class="accordion-body collapse in">      <div class="accordion-inner"><table class="table table-striped"><tbody>{if $new_system_messages|@count==0 }没有新的系统消息{/if}{foreach $new_system_messages as $i}{if $i.category != 'member_message'}<tr id="sm-{$i.system_message_id}">	<td class="new-message">New!</td>	<td>	{if $i.type == 'edit_activity'}		你参加的<b>{$i.detail.activity_name}</b>修改了活动内容</td>	{elseif $i.type == 'new_comment' && $i.type=='activity'}		<a href="{'profile'|site_url}?id={$i.member_id}">{$i.member_name}</a> 评论了活动 <b>{$i.detail.activity_name}</b>	{elseif $i.type == 'new_reply'}		<a href="{'profile'|site_url}?id={$i.member_id}">{$i.member_name}</a> 回复了你对活动 <b>{$i.detail.activity_name}</b>的评论	{elseif $i.type == 'attend_activity'}		<a href="{'profile'|site_url}?id={$i.member_id}">{$i.member_name}</a> 报名参加活动 <b>{$i.detail.activity_name}</b>	{elseif $i.type == 'attend_approve'}		<a href="{'profile'|site_url}?id={$i.member_id}">{$i.member_name}</a> 通过了你对活动 <b>{$i.detail.activity_name}</b>的报名	{elseif $i.type == 'new_activity'}		<a href="{'profile'|site_url}?id={$i.member_id}">{$i.member_name}</a> 发起了活动 <b>{$i.detail.activity_name}</b>	{elseif $i.type == 'invite_attend_activity'}		<a href="{'profile'|site_url}?id={$i.member_id}">{$i.member_name}</a> 邀请你参加活动 <b>{$i.detail.activity_name}</b>	{elseif $i.type == 'rate_request'}		<a href="{'profile'|site_url}?id={$i.member_id}">{$i.member_name}</a> 邀请你给活动 <b>{$i.detail.activity_name}</b>打分	{elseif $i.type == 'apply_friend'}		<a href="{'message/redirectMsg'|site_url}?pid={$i.member_id}&mid={$i.system_message_id}">{$i.member_name}</a> 申请成为你的好友	{elseif $i.type == 'approve_friend'}		<a href="{'message/redirectMsg'|site_url}?pid={$i.member_id}&mid={$i.system_message_id}">{$i.member_name}</a> 已和你成为好友	{elseif $i.type == 'new_comment' && $i.category == 'book'}		<a href="{'member'|site_url}?id={$i.member_id}">{$i.member_name}</a> 评论了你的微型书 <b>{$i.detail.book_name}</b>	{elseif $i.type == 'new_book'}		<a href="{'member'|site_url}?id={$i.member_id}">{$i.member_name}</a> 出版了微型书 <b>{$i.detail.book_name}</b>	{/if}	</td>	{if $i.category=='activity'}		{$t='a'}{$id=$i.detail.activity_id}{$text='查看活动'}		{if $i.type=='attend_activity'}			{$t='d'}{$text='管理活动'}		{/if}	{elseif $i.category=='friend'}{$t='p'}{$id=$i.member_id}{$text='去TA的主页'}	{elseif $i.category=='book'}{$t='b'}{$id=$i.detail.book_id}{$text='去看微型书'}	{/if}	<td class="pull-right">		<div class="btn-group">			<a href="{'message/redirectMsg'|site_url}?{$t}id={$id}&mid={$i.system_message_id}" class="btn btn-primary">{$text}</a>			<button class="btn" onclick="markAsRead('{$i.system_message_id}')">标为已读</button>		</div> 	</td></tr>{/if}{/foreach}</tbody></table>      </div><!--/accordion-inner-->    </div><!--/accordion-body-->  </div><!--/accordion-group--></div><!--/accordion--><div class="modal hide fade" id="modal-compose">	<div class="modal-header">		<button type="button" class="close" data-dismiss="modal">×</button>		<h4>发送新消息</h4>	</div>	<div class="modal-body">		<div id="member-list">			{foreach $all_friends as $i}			<div class="member-click" id="m-{$i.member_id}" onclick="selectMember({$i.member_id})">				<img class="avatar-small" src="{$i.member_image}" alt="{$i.member_name}">				<span class="member-name">{$i.member_name}</span>			</div>			{/foreach}		</div>		<form id="message-compose-form" action="{'message/send'|site_url}" method="post"><fieldset>		    <label>输入好友姓名 (回车查询)</label>		    <input id="member-selector" type="text">		    <input id="member-id" name="member_id" type="hidden">		    <label>内容：</label>		    <textarea id="message-content" name="message_content"></textarea>		</fieldset></form>	</div>	<div class="modal-footer">		<button class="btn btn-primary form-submit">发送 (Ctrl+Enter)</button>	</div></div>