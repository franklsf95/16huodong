__(if ($page_information.current_page > 1))__
	<a href="__($index_page_name|site_url)__?__($page_information.query_string_paging)__&page=__($page_information.first_page)__" title="First Page">&laquo; First</a>

	<a href="__($index_page_name|site_url)__?__($page_information.query_string_paging)__&page=__($page_information.previous_page)__" title="Previous Page">&laquo; Previous</a>
__(/if)__

__(foreach name=pages from=$page_information.all_pages item=page)__
	<a href="__($index_page_name|site_url)__?__($page_information.query_string_paging)__&page=__($page)__" class="number __(if $page == $page_information.current_page)__current__(/if)__" title="__($page)__">__($page)__</a>
__(/foreach)__

__(if $page_information.current_page < $page_information.last_page)__
	<a href="__($index_page_name|site_url)__?__($page_information.query_string_paging)__&page=__($page_information.next_page)__" title="Next Page">Next &raquo;</a>
	<a href="__($index_page_name|site_url)__?__($page_information.query_string_paging)__&page=__($page_information.last_page)__" title="Last Page">Last &raquo;</a>
__(/if)__
	<a>__('gloabl_record_number'|lang_line)__:__($page_information.count)__</a>