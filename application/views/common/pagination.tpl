<ul>
{if ($page_information.page > 1)}
<li><a href="{$page_information.url}?page={$page_information.first_page}{$page_information.get_string}" title="First Page">&laquo;</a></li>
<li><a href="{$page_information.url}?page={$page_information.previous_page}{$page_information.get_string}" title="Previous Page">&lsaquo;</a></li>
{/if}
{if $page_information.more_left} <li><a>...</a></li> {/if}
{foreach $page_information.all_pages as $page}
<li class="{if $page == $page_information.page}active{/if}"><a href="{$page_information.url}?page={$page}{$page_information.get_string}" title="{$page}">{$page}</a></li>
{/foreach}
{if $page_information.more_right} <li><a>...</a></li> {/if}
{if $page_information.page < $page_information.last_page}
<li><a href="{$page_information.url}?page={$page_information.next_page}{$page_information.get_string}" title="Next Page">&rsaquo;</a></li>
<li><a href="{$page_information.url}?page={$page_information.last_page}{$page_information.get_string}" title="Last Page">&raquo;</a></li>
{/if}
</ul>