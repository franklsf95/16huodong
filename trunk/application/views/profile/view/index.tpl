<ul class="breadcrumb">  <li><a href="{'profile'|site_url}?id={$member_information.member_id}">{$member_information.member_name}</a> <span class="divider">/</span></li>  <li class="active">{$member_information.member_name}的主页</li></ul><div class="profile-container"><div class="content-heading">{$member_information.member_name}</div>  {include file="profile/view/`$member_information.member_type`.tpl"}</div><!--/profile-container--><div class="clear"></div><ul class="nav nav-tabs">  <li id="Publish" class="active"><a href="#">发起的活动</a></li>{if $member_information.member_type=='stu'}  <li id="Attend"><a href="#">参加的活动</a></li>  <li id="Follow"><a href="#">关注的活动</a></li>  <li class="dropdown">    <a class="dropdown-toggle" data-toggle="dropdown" href="#">历史<b class="caret"></b></a>    <ul class="dropdown-menu">      <li><a href="{'profile/history/p'|site_url}?member_id={$member_information.member_id}">发起的全部活动</a></li>      <li><a href="{'profile/history/a'|site_url}?member_id={$member_information.member_id}">参加的全部活动</a></li>      <li><a href="{'profile/history/f'|site_url}?member_id={$member_information.member_id}">关注的全部活动</a></li>    </ul>  </li>{else}  <li><a href="{'profile/history/p'|site_url}?member_id={$member_information.member_id}">历史</a></li>{/if}</ul><div id="waterfall"></div><div id="waterfall-loading"></div>