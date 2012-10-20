<div class="member_information">
		<div class="image"><img src="__($current_member_information.member_image)__" height="100" width="100" /></div>
		<div class="name"><a href="__('my_page/member_information?act=view'|site_url)__"><span>__($current_member_information.member_name)__</span></a></div>
		<div class="school">__($current_member_information.current_school_name)__</div>
</div>


<div class="member_tools">
	<ul>
		<li>
			<a href="#" class="navigate" onclick="attentionActivity(__($activity_information.activity_id)__)">我要关注</a>
		</li>
		<li>
			<a href="#" class="navigate" onclick="attendActivity(__($activity_information.activity_id)__)" >我要参加</a>
		</li>
	</ul>
</div>

<div class="member_message">
	<span class="title">NEW！</span>
	
</div>