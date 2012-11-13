<div class="content-heading">热门活动 Top 10</div>
<div id="slider-hot-activities" class="slider">
{foreach $hot_activity_groups as $group}
<div class="slider-item-wrapper">
	{foreach $group as $i}
	<div class="slider-item" id="item-{$i.activity_id}">
		<a href="{"activity/view"|site_url}?id={$i.activity_id}"><img src="{$i.activity_image}" class="img-rounded"></a>
		<h4><a href="{"activity/view"|site_url}?id={$i.activity_id}">{$i.activity_name}</a></h4>
	</div>
	{/foreach}
</div><!--/wrapper-->
{/foreach}
</div>

<div class="content-heading">全站动态</div>
<div id="news-feed-container"></div>

