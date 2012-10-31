{if ($page_information.current_page > 1)}
	<a href="{$index_page_name|site_url}?{$page_information.query_string_paging}&page={$page_information.first_page}" title="First Page">&laquo; First</a>

	<a href="{$index_page_name|site_url}?{$page_information.query_string_paging}&page={$page_information.previous_page}" title="Previous Page">&laquo; Previous</a>
{/if}

{foreach name=pages from=$page_information.all_pages item=page}
	<a href="{$index_page_name|site_url}?{$page_information.query_string_paging}&page={$page}" class="number {if $page == $page_information.current_page}current{/if}" title="{$page}">{$page}</a>
{/foreach}

{if $page_information.current_page < $page_information.last_page}
	<a href="{$index_page_name|site_url}?{$page_information.query_string_paging}&page={$page_information.next_page}" title="Next Page">Next &raquo;</a>
	<a href="{$index_page_name|site_url}?{$page_information.query_string_paging}&page={$page_information.last_page}" title="Last Page">Last &raquo;</a>
{/if}
	<a>{'gloabl_record_number'|lang_line}:{$count}</a>