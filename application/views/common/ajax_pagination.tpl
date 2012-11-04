<ul>
{if $page_information.page > 1}
<li><a href="#comment-container" onclick="loadPage({$page_information.first_page})">&laquo;</a></li>
<li><a href="#comment-container" onclick="loadPage({$page_information.previous_page})">&lsaquo;</a></li>
{/if}
{if $page_information.more_left} <li><a>...</a></li> {/if}
{foreach $page_information.all_pages as $page}
<li class="{if $page == $page_information.page}active{/if}" id="p-{$page}">
	<a href="#comment-container" onclick="loadPage({$page})">{$page}</a>
</li>
{/foreach}
{if $page_information.more_right} <li><a>...</a></li> {/if}
{if $page_information.page < $page_information.last_page}
<li><a href="#comment-container" onclick="loadPage({$page_information.next_page})">&rsaquo;</a></li>
<li><a href="#comment-container" onclick="loadPage({$page_information.last_page})">&raquo;</a></li>
{/if}
</ul>