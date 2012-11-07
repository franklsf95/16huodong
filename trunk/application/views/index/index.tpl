<div class="row">
	<div class="span6">
		<div class="content-heading">全站动态</div>
		<div id="news-feed-container"></div>
	</div>
	<div class="span3">
		<div class="content-heading"><a href="{'activity'|site_url}">热门活动</a></div>
		<div id="hot-showcase">
{foreach $hot_activities as $i}
<div class="hot-showcase-item" id="item-{$i.activity_id}">
	<a href="{"activity/view"|site_url}?id={$i.activity_id}"><img src="{$i.activity_image}" class="img-rounded"></a>
	<h4><a href="{"activity/view"|site_url}?id={$i.activity_id}">{$i.activity_name}</a></h4>
	<ul>
		<li>开始时间: {$i.start_time}</li>
		<li>结束时间: {$i.end_time}</li>
		<li>发起人: <a href="{"profile"|site_url}?id={$i.publisher_id}">{$i.publisher_name}</a></li>
		<li><code>{$i.attend_count}</code>人参与&nbsp;&nbsp;|&nbsp;&nbsp;<code>{$i.follow_count}</code>人关注</li>
	</ul>
</div>
{/foreach}
		</div>
	</div>
</div>