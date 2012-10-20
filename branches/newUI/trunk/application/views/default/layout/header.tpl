	<div id="header">
		<div id="logo"><a href="__('index'|site_url)__"><img src="__($config.template_prefix)__images/logo.jpg" alt="16活动网" /></a></div>
		<div class="navigate">
			<a href="__('index'|site_url)__"><div class="navigation_item" id="nav_home">首页</div></a>
                        <a href="__('search'|site_url)__"><div class="navigation_item" id="nav_search">挖活动</div></a>
                        <a href="__('blog'|site_url)__"><div class="navigation_item" id="nav_blog">人生图书馆</div></a>
                        __(if $current_member_information.member_type == 'student' || $current_member_information.member_type == 'student_organization')__
			<a href="__('school'|site_url)__"><div class="navigation_item" id="nav_school">我的学校</div></a>
                        __(/if)__
		</div>
	</div>