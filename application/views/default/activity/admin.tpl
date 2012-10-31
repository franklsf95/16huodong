<ul class="breadcrumb">  <li><a href="{'profile'|site_url}?id={$activity_information.member_id}">{$activity_information.member_name}</a> <span class="divider">/</span></li>  <li><a href="{'profile'|site_url}?id={$activity_information.member_id}">{$activity_information.member_name}的活动</a> <span class="divider">/</span></li>  <li><a href="{'activity/view'|site_url}?id={$activity_information.activity_id}">{$activity_information.activity_name}</a> <span class="divider">/</span></li>  <li class="active">管理活动</li></ul><div class="activity-container"><div class="content-heading">{$activity_information.activity_name} - 活动详情</div><div class="well activity-image-wrapper span2">  <img src="{$activity_information.activity_image}" class="polaroid activity-image" alt="activity-image"></div><div class="activity-wrapper span3">  <div class="activity-item"><i class="icon-calendar"></i>开始时间: {$activity_information.start_time}</div>  <div class="activity-item"><i class="icon-home"></i>活动类型: {$activity_information.activity_type}</div>  <div class="activity-item"><i class="icon-home"></i>地点: {$activity_information.activity_address}</div>  <div class="activity-item"><i class="icon-home"></i>关注人数: {$activity_information.all_follows|@count}</div>  <div class="activity-item" id="tag-list">{foreach from=$activity_information.activity_tag item=tag}<span class="badge tag">{$tag}</span>{/foreach}</div></div><div class="activity-wrapper span3">  <div class="activity-item"><i class="icon-calendar"></i>结束时间: {$activity_information.end_time}</div>  <div class="activity-item"><i class="icon-home"></i>费用: ￥{$activity_information.activity_price}</div>  <div class="activity-item"><i class="icon-home"></i>发起人: <a href="{'profile'|site_url}?id={$activity_information.member_id}">{$activity_information.member_name}</a></div>  <div class="activity-item"><i class="icon-home"></i>参加人数: {$activity_information.all_attends|@count}</div></div><div class="description-wrapper span6">  <p>{$activity_information.activity_description|default:"$ 一句话也不说 $"}</p></div><div class="toolbox btn-group span6">	<a href="{'activity/edit'|site_url}?id={$activity_information.activity_id}" class="btn btn-primary" id="btn-edit">编辑活动详情</a>	<div class="btn" id="btn-admin">管理活动</div>	<a href="{'activity/view'|site_url}?id={$activity_information.activity_id}" class="btn btn-primary" id="btn-view">查看活动</a></div></div><!--/activity-container--><div class="clear"></div><div id="admin-container">	<h4>报名列表</h4>	<table class="table table-striped">		<thead><th>姓名</th><th>学校</th><th>手机</th><th>E-mail</th><th>操作</th></thead>		<tbody>  		{foreach from=$activity_information.all_attends item=it}  		<tr id="row-{$it.activity_attend_id}">  			<td>{$it.name}</td>  			<td>{$it.school_name}</td>  			<td>{$it.phone}</td>  			<td>{$it.email}</td>  			<td class="tool">{if $it.status == 'Y'}已通过申请				{else}				<a onclick="handleActivityAttend('{$it.activity_attend_id}',1,'{$it.member_id}')">通过申请</a>				<a onclick="handleActivityAttend('{$it.activity_attend_id}',0,'{$it.member_id}')">拒绝申请</a>				{/if}			</td>  		</tr>  		{/foreach}  		</tbody>	</table>	<h4>关注成员列表</h4>	<table class="table table-striped">		<thead><th>姓名</th><th>学校</th></thead>		<tbody>  		{foreach from=$activity_information.all_follows item=it}  		<tr id="row-{$it.activity_attend_id}">  			<td>{$it.name}</td>  			<td>{$it.school_name}</td>  		</tr>  		{/foreach}  		</tbody>	</table>	<h4 class="btn btn-primary">给所有参加者群发通知 [无效]</h4></div><!--/admin-container-->