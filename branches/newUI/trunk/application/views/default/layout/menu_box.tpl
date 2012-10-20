	<div class="member_information">
		<div class="image"><img src="__($current_member_information.member_image)__" height="100" width="100" /></div>
		<div class="name"><a href="__('my_page'|site_url)__"><span>__($current_member_information.member_name)__</span></a></div>
		<div class="school">__($current_member_information.current_school_name)__</div>
	</div>
	
	<div class="member_tools">
            <div class="member_tool_item" id="nav_member"><a href="__('member'|site_url)__">个人资料</a> <span class="sub"><a href="__('my_page/edit'|site_url)__" id="nav_my_page_edit">编辑</a></span></div>
            <div class="member_tool_item" id="nav_activity"><a href="__('activity'|site_url)__">我的活动</a> <span class="sub"><a href="__('activity/edit'|site_url)__" id="nav_activity_edit">发布</a></span></div>
            <div class="member_tool_item" id="nav_my_blog"><a href="__('blog/my_blog'|site_url)__">我的图书馆</a></div>
            <div class="member_tool_item" id="nav_friend"><a href="__('friend'|site_url)__">我的好友</a></div>
            <div class="member_tool_item" id="nav_message"><a href="__('message'|site_url)__">站内信</a></div>
            <div class="member_tool_item" id="nav_logout"><a href="__('login/logout'|site_url)__">登出</a></div>
	</div>
	__(if $all_system_message_count)__
	<div class="member_message">
		<span class="title">NEW！</span>
		<ul>
			__(foreach name=all_system_message_count from=$all_system_message_count item=system_message_count)__
			__(if ($system_message_count.type == 'activity_publish' && 1==2))__
			<li><a href="__('message'|site_url)__#tabs-2">您的好友新发布了__($system_message_count.count)__个活动</a></li>
			__(elseif ($system_message_count.type == 'activity_edit' && 1==2))__
			<li><a href="__('message'|site_url)__#tabs-2">您参加的__($system_message_count.count)__个活动内容改动</a></li>
			__(elseif ($system_message_count.type == 'activity_comment' && 1==2))__
			<li><a href="__('message'|site_url)__#tabs-2">您发布的活动有__($system_message_count.count)__个新的评论</a></li>
			__(elseif ($system_message_count.type == 'activity_reply' && 1==2))__
			<li><a href="__('message'|site_url)__#tabs-2">您发表的活动评论有__($system_message_count.count)__个新的回复</a></li>
			__(elseif ($system_message_count.type == 'friend_apply' && 1==2))__
			<li><a href="__('message'|site_url)__#tabs-2">您有__($system_message_count.count)__条好友申请</a></li>
			__(elseif ($system_message_count.type == 'blog_comment' && 1==2))__
			<li><a href="__('message'|site_url)__#tabs-2">您的日志有__($system_message_count.count)__条新的评论</a></li>
			__(elseif ($system_message_count.type == 'friend_apply' && 1==2))__
			<li><a href="__('message'|site_url)__#tabs-2">您有__($system_message_count.count)__条好友请求</a></li>
			__(elseif ($system_message_count.type == 'friend_add' && 1==2))__
			<li><a href="__('message'|site_url)__#tabs-2">您新增加了__($system_message_count.count)__个好友</a></li>
			__(elseif ($system_message_count.type == 'activity'))__
			<li><a href="__('message'|site_url)__#tabs-2">__($system_message_count.count)__个新的活动通知</a></li>
			__(elseif ($system_message_count.type == 'friend'))__
			<li><a href="__('message'|site_url)__#tabs-2">__($system_message_count.count)__个新的好友通知</a></li>
			__(elseif ($system_message_count.type == 'blog'))__
			<li><a href="__('message'|site_url)__#tabs-2">__($system_message_count.count)__个新的日志通知</a></li>
			__(elseif ($system_message_count.type == 'member_message'))__
			<li><a href="__('message'|site_url)__">__($system_message_count.count)__个新的站内信通知</a></li>
			__(/if)__
			__(/foreach)__
		</ul>
		
		
	</div>
	__(/if)__