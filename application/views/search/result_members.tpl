<div class="search-result-container">	<div class="content-heading">搜索结果：{$search_query}</div>	<hr>{foreach $all_members as $i}	<div class="result-item">		<a href="{'profile'|site_url}?id={$i.member_id}"><img src="{$i.member_image}" alt="{$i.member_name}" class="avatar-large"></a>		<h4><a href="{'profile'|site_url}?id={$i.member_id}">{$i.member_name}</a></h4>		<div class="result-member-row">			<span class="result-member-description"><i class="icon-th-large"></i> {if $i.member_type == 'stu'}学生{elseif $i.member_type == 'org'}学生组织{elseif $i.member_type == 'chr'}公益组织{elseif $i.member_type == 'com'}公司{/if}</span>			<span class="result-member-description"><i class="icon-leaf"></i> {if $i.gender == 'F'}女{elseif $i.gender == 'M'}男{else}未知{/if}</span>		</div>		<div class="result-member-row">			{if $i.school_name}<span class="result-member-description"><i class="icon-book"></i> {$i.school_name}</span>{/if}		</div>		<div class="result-member-row">			<span class="result-member-description">{if $i.organisation}<i class="icon-home"></i>{$i.organisation} {$i.title}{elseif $i.principal}<i class="icon-user"></i> {$i.principal}{/if}</span>		</div>		<hr>	</div>{/foreach}</div><!--/search-result-container--><div class="pagination">	{include file="common/pagination.tpl"}</div>