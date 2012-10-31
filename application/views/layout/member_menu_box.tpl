<div class="menu_box">
	<div class="menu_member_box">
		<div class="member_images"><img src="{$current_member_information.member_image}" height="145" width="151"></div>
		<div class="member_name"><span>{$current_member_information.member_name}</span></div>
	</div>
	<div class="menu_navigate_box">
		<ul>
			<li>
				<a href="{'activity'|site_url}" class="navigate">活动</a>
				<a href="{'activity/edit'|site_url}" class="navigate_tool">发布活动</a>
			</li>
			<li>
				<a href="{'blog'|site_url}" class="navigate">日志</a>
				<a href="{'blog/edit'|site_url}" class="navigate_tool">发布日志</a>
			</li>
			<li>
				<a href="{'album'|site_url}" class="navigate">相册</a>
				<a href="{'album/edit_photo'|site_url}" class="navigate_tool">上传照片</a>
			</li>
			
			<li>
				<a href="{'friend'|site_url}" class="navigate">好友</a>
				<a href="{'friend/add_friend'|site_url}" class="navigate_tool">寻找好友</a>
			</li>
		</ul>
	</div>
</div>