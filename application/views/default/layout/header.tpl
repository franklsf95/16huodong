	<div id="header">
		<div id="logo"><a href="__('index'|site_url)__"><img src="__($config.template_prefix)__images/logo.jpg" alt="16活动网" /></a></div>
		<div class="navigate">
			<ul >
				<li><a href="__('index'|site_url)__" id="nav_01">首页</a></li>
				<li><a href="__('member'|site_url)__"  id="nav_02" >个人主页</a></li>
				<li><a href="__('blog'|site_url)__" id="nav_03" >人生图书馆</a></li>
				__(if $current_member_information.member_type == 'student' || $current_member_information.member_type == 'student_organization')__
				<li><a href="__('school'|site_url)__" id="nav_04">我的学校</a></li>
				__(/if)__
				<li><a href="__('search'|site_url)__" id="nav_05">挖活动</a></li>
				<li><a href="__('message'|site_url)__" id="nav_06">站内信</a></li>
			</ul>
			<a href="__('login/logout'|site_url)__" class="logout">登出</a>
		</div>
	</div>