<div id="two_frame">	<div id="frame_l">		__(include file="__($template)__/layout/menu_box.tpl")__	</div>		<div id="frame_r">		<div class="notification_box"><!--此处用来写各种系统推送的消息--></div>		<div class="main_box">			<h3>参加活动列表</h3>			<ul>				__(foreach name=all_attend_activity_information from=$all_attend_activity_information item=attend_activity_information)__				<li><a href="__('activity/view'|site_url)__?id=__($attend_activity_information.activity_id)__">__($attend_activity_information.name)__</a></li>				__(/foreach)__			</ul>		</div>	</div></div>