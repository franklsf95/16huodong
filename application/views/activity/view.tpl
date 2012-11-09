<ul class="breadcrumb">  <li><a href="{'activity'|site_url}">挖活动</a> <span class="divider">/</span></li>  <li><a href="{'profile'|site_url}?id={$activity_information.publisher_id}">{$activity_information.publisher_name}的活动</a> <span class="divider">/</span></li>  <li class="active">{$activity_information.activity_name}</li></ul><div class="activity-container"><div class="content-heading">{$activity_information.activity_name} - 活动详情</div><div class="well activity-image-wrapper span2">  <img src="{$activity_information.activity_image}" class="polaroid activity-image" alt="activity-image"></div><div class="activity-wrapper span3">  <div class="activity-item"><i class="icon-calendar"></i>开始时间: {$activity_information.start_time}</div>  <div class="activity-item"><i class="icon-home"></i>活动类型: {$activity_information.activity_type}</div>  <div class="activity-item"><i class="icon-home"></i>地点: {$activity_information.address}</div>  <div class="activity-item"><i class="icon-home"></i>关注人数: {$activity_information.follow_count}</div>  <div class="activity-item tag-list"><i class="icon-tags"></i>{foreach $activity_information.tags as $tag}<span class="badge tag">{$tag}</span>{/foreach}</div></div><div class="activity-wrapper span3">  <div class="activity-item"><i class="icon-calendar"></i>结束时间: {$activity_information.end_time}</div>  <div class="activity-item"><i class="icon-home"></i>费用: ￥{$activity_information.price}</div>  <div class="activity-item"><i class="icon-home"></i>发起人: <a href="{'profile'|site_url}?id={$activity_information.publisher_id}">{$activity_information.publisher_name}</a></div>  <div class="activity-item"><i class="icon-home"></i>参加人数: {$activity_information.attend_count}</div></div><div class="description-wrapper span6">	<p>{$activity_information.description|default:"$ 一句话也不说 $"}</p></div><div class="toolbox btn-group span6">{if ($smarty.now < (($activity_information.end_time|strtotime)+(3600*24))) } {if $activity_information.is_publisher}    <a href="{'activity/edit'|site_url}?id={$activity_information.activity_id}" class="btn btn-primary" id="btn-edit">编辑活动详情</a>    <a href="{'activity/admin?id='|site_url}{$activity_information.activity_id}" class="btn btn-primary">管理活动</a>    <a href="{'message/compose?msg='|site_url}快来参加我发起的活动{$activity_information.activity_name}吧！" class="btn btn-primary">邀请好友参加活动</a> {else}    <div class="btn btn-primary" onclick="followActivity('{$activity_information.activity_id}')">{if $activity_information.is_attention}取消关注{else}我要关注{/if}</div>    <div class="btn btn-primary" onclick="attendActivity('{$activity_information.activity_id}')">{if $activity_information.is_attend}取消报名{else}我要参加{/if}</div> {/if}{else}    <div class="btn btn-primary" disabled>活动已结束</div>    <a href="{'activity/rate?plus=1&id='|site_url}{$activity_information.activity_id}" class="btn btn-primary" {if $activity_information.rate.rate1ed}disabled{/if}><i class="icon-thumbs-up icon-white"></i> {$activity_information.rate.rate1}</a>    <a href="{'activity/rate?plus=0&id='|site_url}{$activity_information.activity_id}" class="btn btn-primary" {if $activity_information.rate.rate2ed}disabled{/if}><i class="icon-thumbs-down icon-white"></i> {$activity_information.rate.rate2}</a>{/if}</div></div><!--/activity-container--><div class="clear"></div><div class="content-heading" id="container-header">详细介绍</div><div id="view-container">{$activity_information.content}</div><div class="content-heading">留言问答</div><div id="comment-container"><table class="table table-striped"><tbody id="comment-tbody">{foreach $all_activity_comment_information as $i}<tr id="m-{$i.member_message_id}">  <td style="width: 120px">  <img src="{$i.member_image}" alt="{$i.member_name}" class="avatar-medium"><a href="{'profile'|site_url}?id={$i.member_id}">{$i.member_name}</a>  </td>  <td>{$i.content}</td>  <td class="pull-right">{$i.created_time}</td>  {if $i.member_id != $current_member_information.member_id}  <td style="width: 50px">{if $i.target_id == $target_info.member_id}    <a href="#reply-box" class="act" onclick="addReplyTo('{$i.member_name}')">回复</a>{/if}  </td>  {/if}</tr>{/foreach}<tbody></table>{if $page_information.count > 0}<div class="pagination">    {include file="common/ajax_pagination.tpl"}</div>{/if}<div id="add-comment-box">    <form id="reply-form" action="{'activity/save_comment'|site_url}" method="post" class="span6">    <fieldset>      <textarea name="activity_comment" id="comment-content" class="span6 reply-content" rows="2"></textarea>      <input type="hidden" id="activity_id" name="activity_id" value="{$activity_information.activity_id}">      <input type="submit" class="btn btn-primary pull-right" value="留言 (Ctrl+Enter)" />    </fielset>    </form></div><!--/comment-container-->