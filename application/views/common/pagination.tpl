<ul>
{if ($page_information.current_page > 1)}
<li><a href="{$index_page_name|site_url}?page={$page_information.first_page}&{$page_information.query_string_paging}" title="First Page">&laquo;</a></li>
<li><a href="{$index_page_name|site_url}?page={$page_information.previous_page}&{$page_information.query_string_paging}" title="Previous Page">&lsaquo;</a></li>
{/if}
{foreach $page_information.all_pages as $page}
<li class="{if $page == $page_information.current_page}active{/if}"><a href="{$index_page_name|site_url}?page={$page}&{$page_information.query_string_paging}" title="{$page}">{$page}</a></li>
{/foreach}

{if $page_information.current_page < $page_information.last_page}
<li><a href="{$index_page_name|site_url}?page={$page_information.next_page}&{$page_information.query_string_paging}" title="Next Page">&rsaquo;</a></li>
<li><a href="{$index_page_name|site_url}?page={$page_information.last_page}&{$page_information.query_string_paging}" title="Last Page">&raquo;</a></li>
{/if}
</ul>