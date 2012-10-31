<div class="member_information">
		<div class="image"><img src="{$current_member_information.member_image}" height="100" width="100" /></div>
		<div class="name"><a href="{'my_page/member_information?act=view'|site_url}"><span>{$current_member_information.member_name}</span></a></div>
		<div class="school">{$current_member_information.current_school_name}</div>
</div>


<div class="member_tools">
	<ul>
		<li>
			<a href="#" class="navigate" onclick="attentionActivity({$activity_information.activity_id})">我要关注</a>
		</li>
		<li>
			<a href="#" class="navigate" onclick="attendActivity({$activity_information.activity_id})" >我要参加</a>
		</li>
	</ul>
</div>

<div class="member_message">
	<span class="title">NEW！</span>
	
</div>