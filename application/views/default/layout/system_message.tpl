__(if $all_system_message_count)__
<div class="system_message_layout">
	<ul>
	__(foreach name=all_system_message_count from=$all_system_message_count item=system_message_count)__
		__(if ($system_message_count.type == 'activity_publish'))__
		<li><a href="__('system_message'|site_url)__#tabs-2">您的好友新发布了__($system_message_count.count)__个活动</a></li>
		__(elseif ($system_message_count.type == 'activity_edit'))__
		<li><a href="__('system_message'|site_url)__#tabs-2">您参加的__($system_message_count.count)__个活动内容改动</a></li>
		__(elseif ($system_message_count.type == 'activity_comment'))__
		<li><a href="__('system_message'|site_url)__#tabs-2">您发布的活动有__($system_message_count.count)__个新的评论</a></li>
		__(elseif ($system_message_count.type == 'activity_reply'))__
		<li><a href="__('system_message'|site_url)__#tabs-2">您发表的活动评论有__($system_message_count.count)__个新的回复</a></li>
		__(elseif ($system_message_count.type == 'friend_apply'))__
		<li><a href="__('system_message'|site_url)__#tabs-2">您有__($system_message_count.count)__条好友申请</a></li>
		__(elseif ($system_message_count.type == 'blog_comment'))__
		<li><a href="__('system_message'|site_url)__#tabs-2">您的日志有__($system_message_count.count)__条新的评论</a></li>
		__(elseif ($system_message_count.type == 'friend_apply'))__
		<li><a href="__('system_message'|site_url)__#tabs-2">您有__($system_message_count.count)__条好友请求</a></li>
		__(elseif ($system_message_count.type == 'friend_add'))__
		<li><a href="__('system_message'|site_url)__#tabs-2">您新增加了__($system_message_count.count)__个好友</a></li>
		__(/if)__
	__(/foreach)__
	</ul>
</div>
__(/if)__