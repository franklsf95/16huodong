<ul class="breadcrumb">  <li><a href="__('profile'|site_url)__?id=__($member_information.member_id)__">__($member_information.member_name)__</a> <span class="divider">/</span></li>  <li class="active">__($member_information.member_name)__的个人主页</li></ul><div class="profile-container"><div class="content-heading">__($member_information.member_name)__</div><div class="profile-wrapper span3">  <div class="profile-item"><i class="icon-leaf"></i>__(if $member_information.member_gender == 'F')__女__(elseif $member_information.member_gender == 'M')__男__(else)__未知__(/if)__</div>  <div class="profile-item"><i class="icon-gift"></i>__($member_information.member_birthday|default:"还未出生")__</div>  <div class="profile-item"><i class="icon-tags"></i>__($member_information.member_tag)__</div></div><div class="profile-wrapper span3">  <div class="profile-item"><i class="icon-book"></i>__($member_information.school_name)__</div>  <div class="profile-item"><i class="icon-home"></i>__($member_information.member_organisation)__ __($member_information.member_title)__</div></div><div class="well portrait-wrapper offset6">  <img src="__($member_information.member_image)__" class="polaroid portrait-preview"></div><div class="description-wrapper span6">	<p>__($member_information.member_description|default:"我很懒，什么也没留下……")__</p></div><div class="clear"></div><div class="toolbox btn-group">__(if !$is_me)__	<button class="btn btn-primary" onclick="toggleFriend(__($member_information.member_id)__,0)"__(if $is_friend==-1)__disabled__(/if)__>  __(if $is_friend==0)__+ 加好友  __(elseif $is_friend==1 )__解除好友关系  __(elseif $is_friend==-1 )__已发送好友申请  __(elseif $is_friend==-2)__确认好友申请  __(/if)__  </button>  __(if $is_friend==2)__<button class="btn btn-primary" onclick="toggleFriend(__($member_information.member_id)__,1)">拒绝好友申请</button>__(/if)__	<button class="btn" disabled>发站内信</button>__(else)__  <a href="__('profile/edit'|site_url)__"><button class="btn btn-primary">编辑个人资料</button></a>__(/if)__</div></div><!--/profile-container--><div class="clear"></div><hr><div class="content-heading">正参加的活动<a href="__('activity/allAttends'|site_url)__" class="act content-subtitle">历史</a></div><div id="Attend-showcase"></div><div class="clear"></div><div class="content-heading">关注的活动<a href="__('activity/allFollows'|site_url)__" class="act content-subtitle">历史</a></div><div id="Attention-showcase"></div><div class="clear"></div><div class="content-heading">发起的活动<a href="__('activity/allPublishes'|site_url)__" class="act content-subtitle">历史</a></div><div id="Publish-showcase"></div><div class="clear"></div>