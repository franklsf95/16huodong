<div class="profile-container"><div class="content-heading">__($member_information.member_name)__</div><div class="profile-wrapper span3">  <div class="profile-item"><i class="icon-user"></i>__($member_information.member_principal)__</div>  <div class="profile-item"><i class="icon-envelope"></i>__($member_information.member_email)__</div>  <div class="profile-item"><i class="icon-tags"></i>__($member_information.member_tag)__</div></div><div class="profile-wrapper span3">  <div class="profile-item"><i class="icon-book"></i>__($member_information.member_school_name)__</div>  <div class="profile-item"><i class="icon-bell"></i>__($member_information.member_phone)__</div></div><div class="well portrait-wrapper offset6">  <img src="__($member_information.member_image)__" class="polaroid portrait-preview"></div><div class="description-wrapper span6">	<p>__($member_information.member_description|default:"我很懒，什么也没留下……")__</p></div><div class="clear"></div><div class="toolbox btn-group">__(if !$member_information.my_page)__	<button class="btn btn-primary" onclick="addFriend(__($member_information.member_id)__)">__(if $member_information.is_friend == 'Y')__解除好友关系__(else)__+ 加好友__(/if)__</button>	<button class="btn" disabled>发站内信</button>__(else)__  <a href="__('profile/edit'|site_url)__"><button class="btn btn-primary">编辑组织资料</button></a>__(/if)__</div></div><!--/profile-container--><div class="clear"></div><hr><div class="content-heading">发起的活动<a href="__('activity/allPublishes'|site_url)__" class="act content-subtitle">历史</a></div><div id="Publish-showcase"></div><div class="clear"></div>