	<div id="header">
		<div id="logo"><a href="{'index'|site_url}"><img src="{$config.template_prefix}images/logo.jpg" alt="16活动网" /></a></div>
		<div class="navigate">
			<a href="{'index'|site_url}"><div class="navigation_item" id="nav_home">首页</div></a>
                        <a href="{'search'|site_url}"><div class="navigation_item" id="nav_search">挖活动</div></a>
                        <a href="{'blog'|site_url}"><div class="navigation_item" id="nav_blog">人生图书馆</div></a>
                        {if $current_member_information.member_type == 'student' || $current_member_information.member_type == 'student_organization'}
			<a href="{'school'|site_url}"><div class="navigation_item" id="nav_school">我的学校</div></a>
                        {/if}
		</div>
	</div>