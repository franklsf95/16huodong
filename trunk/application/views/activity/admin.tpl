<ul class="breadcrumb">  <li><a href="{'profile/view'|site_url}/{$activity_information.publisher_id}">{$activity_information.publisher_name}</a> <span class="divider">/</span></li>  <li><a href="{'profile/view'|site_url}/{$activity_information.publisher_id}">{$activity_information.publisher_name}的活动</a> <span class="divider">/</span></li>  <li><a href="{'activity/view'|site_url}/{$activity_information.activity_id}">{$activity_information.activity_name}</a> <span class="divider">/</span></li>  <li class="active">管理活动</li></ul><div class="activity-container"><div class="content-heading">管理活动：{$activity_information.activity_name}</div><div class="well activity-image-wrapper span2">  <img src="{$activity_information.activity_image}" class="polaroid activity-image" alt="activity-image"></div><div class="activity-wrapper span3">  <div class="activity-item"><i class="icon-time"></i>活动开始: {$activity_information.start_time}</div>  <div class="activity-item"><i class="icon-calendar"></i>报名开始: {$activity_information.apply_start_time}</div>  <div class="activity-item"><i class="icon-eye-open"></i>费用: ￥{$activity_information.price}</div>  <div class="activity-item"><i class="icon-bell"></i>关注人数: {$activity_information.follow_count}</div></div><div class="activity-wrapper span3">  <div class="activity-item"><i class="icon-time"></i>结束时间: {$activity_information.end_time}</div>  <div class="activity-item"><i class="icon-calendar"></i>结束时间: {$activity_information.apply_end_time}</div>  <div class="activity-item"><i class="icon-bullhorn"></i>发起人: <a href="{'profile/view'|site_url}/{$activity_information.publisher_id}">{$activity_information.publisher_name}</a></div>  <div class="activity-item"><i class="icon-globe"></i>参加人数: {$activity_information.attend_count}</div></div><div class="activity-wrapper span6">  <div class="activity-item"><i class="icon-home"></i>地点: {$activity_information.address}</div>  <div class="activity-item tag-list"><i class="icon-tags"></i>{foreach $activity_information.tags as $tag}<span class="badge tag">{$tag}</span>{/foreach}</div></div><div class="description-wrapper span6">  <p>来源网址：<code>{$activity_information.url}</code></p>  <p>{$activity_information.description|default:"$ 一句话也不说 $"}</p></div><div class="toolbox btn-group span6">	<a href="{'activity/edit'|site_url}/{$activity_information.activity_id}" class="btn btn-primary" id="btn-edit">编辑活动详情</a>	<div class="btn" id="btn-admin">管理活动</div>	<a href="{'activity/view'|site_url}/{$activity_information.activity_id}" class="btn btn-primary" id="btn-view">查看活动</a></div></div><!--/activity-container--><div class="clear"></div><div id="admin-container">	<h4>报名列表</h4>	<table class="table table-striped">		<thead><th>姓名</th><th>学校</th><th>手机</th><th>E-mail</th><th>操作</th></thead>		<tbody>  		{foreach from=$activity_information.all_attends item=it}  		<tr id="row-{$it.activity_attend_id}">  			<td><a href="{'profile/view'|site_url}/{$it.member_id}">{$it.member_name}</a></td>  			<td>{$it.school_name}</td>  			<td>{if $it.show_info}{$it.phone}{else}-{/if}</td>  			<td>{if $it.show_info}{$it.email}{else}-{/if}</td>  			<td class="tool">{if $it.approved}已通过申请{else}				<a href="#" onclick="handleActivityAttend('{$it.activity_attend_id}',1,'{$it.member_id}')">通过申请</a>				<a href="#" onclick="handleActivityAttend('{$it.activity_attend_id}',0,'{$it.member_id}')">拒绝申请</a>				{/if}			</td>  		</tr>  		{/foreach}  		</tbody>	</table><a href="#modal-compose" class="btn btn-primary pull-right" data-toggle="modal">给所有参加者群发通知</a>	<h4>关注成员列表</h4>	<table class="table table-striped">		<thead><th>姓名</th><th>学校</th></thead>		<tbody>  		{foreach from=$activity_information.all_follows item=it}  		<tr id="row-{$it.activity_attend_id}">  			<td><a href="{'profile/view'|site_url}/{$it.member_id}">{$it.member_name}</a></td>  			<td>{$it.school_name}</td>  		</tr>  		{/foreach}  		</tbody>	</table></div><!--/admin-container--><div class="modal hide fade" id="modal-compose">  <div class="modal-header">    <button type="button" class="close" data-dismiss="modal">×</button>    <h4>给参与者群发通知</h4>  </div>  <div class="modal-body">    <form id="message-compose-form" action="{'message/sendToAll'|site_url}" method="post"><fieldset>        <label>发送给的参与者（单击以删除）：</label>        <div class="tag-list">        {foreach $activity_information.all_attends as $i}          <span class="badge tag tag-edit" onclick="$(this).remove()">{$i.member_name}<input type="hidden" name="member_list[]" value="{$i.member_id}" /></span>        {/foreach}        </div>        <label>内容：</label>        <textarea class="span5" rows="5" id="message-content" name="message_content"></textarea>    </fieldset></form>  </div>  <div class="modal-footer">    <button class="btn btn-primary form-submit">发送 (Ctrl+Enter)</button>  </div></div>