<div class="profile-wrapper span3">  <div class="profile-item"><i class="icon-leaf"></i>{if $member_information.member_gender == 'F'}女{elseif $member_information.member_gender == 'M'}男{else}性别未知{/if}</div>  <div class="profile-item"><i class="icon-gift"></i>{$member_information.member_birthday|default:"生日未知"}</div>  <div class="profile-item tag-list"><i class="icon-tags"></i>{foreach $member_information.tags as $tag}<span class="badge tag">{$tag}</span>{/foreach}</div></div><div class="profile-wrapper span3">  <div class="profile-item"><i class="icon-book"></i>{$member_information.school_name}</div>  <div class="profile-item"><i class="icon-home"></i>{$member_information.member_organisation} {$member_information.member_title}</div></div><div class="well portrait-wrapper offset6">  <img src="{$member_information.member_image}" class="polaroid portrait-preview"></div><div class="description-wrapper span6">	<p>{$member_information.member_description|default:"我很懒，什么也没留下……"}</p></div><div class="clear"></div><div class="toolbox btn-group">{if !$is_me}	<button class="btn btn-primary" onclick="toggleFriend({$member_information.member_id},0)"{if $is_friend==-1}disabled{/if}>  {if $is_friend==0}+ 加好友  {elseif $is_friend==1 }解除好友关系  {elseif $is_friend==-1 }已发送好友申请  {elseif $is_friend==-2}确认好友申请  {/if}  </button>  {if $is_friend==2}<button class="btn btn-primary" onclick="toggleFriend({$member_information.member_id},1)">拒绝好友申请</button>{/if}	<a class="btn" {if $is_friend==1}href="{'message'|site_url}?target_id={$member_information.member_id}"{else}id="add-friend-first" disabled{/if}>给TA留言</a>{else}  <a href="{'profile/edit'|site_url}"><button class="btn btn-primary">编辑个人资料</button></a>{/if}</div>