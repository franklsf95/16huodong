__(if ($page_information.current_page > 1))__
<li><a href="__($index_page_name|site_url)__?page=__($page_information.first_page)__&__($page_information.query_string_paging)__" title="First Page">&laquo;</a></li>
<li><a href="__($index_page_name|site_url)__?page=__($page_information.previous_page)__&__($page_information.query_string_paging)__" title="Previous Page">&lsaquo;</a></li>
__(/if)__
__(foreach name=pages from=$page_information.all_pages item=page)__
<li class="__(if $page == $page_information.current_page)__active__(/if)__"><a href="__($index_page_name|site_url)__?page=__($page)__&__($page_information.query_string_paging)__" title="__($page)__">__($page)__</a></li>
__(/foreach)__

__(if $page_information.current_page < $page_information.last_page)__
<li><a href="__($index_page_name|site_url)__?page=__($page_information.next_page)__&__($page_information.query_string_paging)__" title="Next Page">&rsaquo;</a></li>
<li><a href="__($index_page_name|site_url)__?page=__($page_information.last_page)__&__($page_information.query_string_paging)__" title="Last Page">&raquo;</a></li>
__(/if)__