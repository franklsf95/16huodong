{if $all_system_message_count}
<div class="system_message_layout">
	<ul>
	{foreach name=all_system_message_count from=$all_system_message_count item=system_message_count}
		{if ($system_message_count.type == 'activity_publish')}
		<li><a href="{'system_message'|site_url}#tabs-2">您的好友新发布了{$system_message_count.count}个活动</a></li>
		{elseif ($system_message_count.type == 'activity_edit')}
		<li><a href="{'system_message'|site_url}#tabs-2">您参加的{$system_message_count.count}个活动内容改动</a></li>
		{elseif ($system_message_count.type == 'activity_comment')}
		<li><a href="{'system_message'|site_url}#tabs-2">您发布的活动有{$system_message_count.count}个新的评论</a></li>
		{elseif ($system_message_count.type == 'activity_reply')}
		<li><a href="{'system_message'|site_url}#tabs-2">您发表的活动评论有{$system_message_count.count}个新的回复</a></li>
		{elseif ($system_message_count.type == 'friend_apply')}
		<li><a href="{'system_message'|site_url}#tabs-2">您有{$system_message_count.count}条好友申请</a></li>
		{elseif ($system_message_count.type == 'blog_comment')}
		<li><a href="{'system_message'|site_url}#tabs-2">您的日志有{$system_message_count.count}条新的评论</a></li>
		{elseif ($system_message_count.type == 'friend_apply')}
		<li><a href="{'system_message'|site_url}#tabs-2">您有{$system_message_count.count}条好友请求</a></li>
		{elseif ($system_message_count.type == 'friend_add')}
		<li><a href="{'system_message'|site_url}#tabs-2">您新增加了{$system_message_count.count}个好友</a></li>
		{/if}
	{/foreach}
	</ul>
</div>
{/if}