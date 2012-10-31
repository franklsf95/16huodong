	<div class="member_information">
		<div class="image"><img src="{$current_member_information.member_image}" height="100" width="100" /></div>
		<div class="name"><a href="{'my_page'|site_url}"><span>{$current_member_information.member_name}</span></a></div>
		<div class="school">{$current_member_information.current_school_name}</div>
	</div>
	
	<div class="member_tools">
            <div class="member_tool_item" id="nav_member"><a href="{'member'|site_url}">个人资料</a> <span class="sub"><a href="{'my_page/edit'|site_url}" id="nav_my_page_edit">编辑</a></span></div>
            <div class="member_tool_item" id="nav_activity"><a href="{'activity'|site_url}">我的活动</a> <span class="sub"><a href="{'activity/edit'|site_url}" id="nav_activity_edit">发布</a></span></div>
            <div class="member_tool_item" id="nav_my_blog"><a href="{'blog/my_blog'|site_url}">我的图书馆</a></div>
            <div class="member_tool_item" id="nav_friend"><a href="{'friend'|site_url}">我的好友</a></div>
            <div class="member_tool_item" id="nav_message"><a href="{'message'|site_url}">站内信</a></div>
            <div class="member_tool_item" id="nav_logout"><a href="{'login/logout'|site_url}">登出</a></div>
	</div>
	{if $all_system_message_count}
	<div class="member_message">
		<span class="title">NEW！</span>
		<ul>
			{foreach name=all_system_message_count from=$all_system_message_count item=system_message_count}
			{if ($system_message_count.type == 'activity_publish' && 1==2)}
			<li><a href="{'message'|site_url}#tabs-2">您的好友新发布了{$system_message_count.count}个活动</a></li>
			{elseif ($system_message_count.type == 'activity_edit' && 1==2)}
			<li><a href="{'message'|site_url}#tabs-2">您参加的{$system_message_count.count}个活动内容改动</a></li>
			{elseif ($system_message_count.type == 'activity_comment' && 1==2)}
			<li><a href="{'message'|site_url}#tabs-2">您发布的活动有{$system_message_count.count}个新的评论</a></li>
			{elseif ($system_message_count.type == 'activity_reply' && 1==2)}
			<li><a href="{'message'|site_url}#tabs-2">您发表的活动评论有{$system_message_count.count}个新的回复</a></li>
			{elseif ($system_message_count.type == 'friend_apply' && 1==2)}
			<li><a href="{'message'|site_url}#tabs-2">您有{$system_message_count.count}条好友申请</a></li>
			{elseif ($system_message_count.type == 'blog_comment' && 1==2)}
			<li><a href="{'message'|site_url}#tabs-2">您的日志有{$system_message_count.count}条新的评论</a></li>
			{elseif ($system_message_count.type == 'friend_apply' && 1==2)}
			<li><a href="{'message'|site_url}#tabs-2">您有{$system_message_count.count}条好友请求</a></li>
			{elseif ($system_message_count.type == 'friend_add' && 1==2)}
			<li><a href="{'message'|site_url}#tabs-2">您新增加了{$system_message_count.count}个好友</a></li>
			{elseif ($system_message_count.type == 'activity')}
			<li><a href="{'message'|site_url}#tabs-2">{$system_message_count.count}个新的活动通知</a></li>
			{elseif ($system_message_count.type == 'friend')}
			<li><a href="{'message'|site_url}#tabs-2">{$system_message_count.count}个新的好友通知</a></li>
			{elseif ($system_message_count.type == 'blog')}
			<li><a href="{'message'|site_url}#tabs-2">{$system_message_count.count}个新的日志通知</a></li>
			{elseif ($system_message_count.type == 'member_message')}
			<li><a href="{'message'|site_url}">{$system_message_count.count}个新的站内信通知</a></li>
			{/if}
			{/foreach}
		</ul>
		
		
	</div>
	{/if}