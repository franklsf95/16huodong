<ul>
__(if ($page_information.current_page > 1))__
<li><a href="#comment-container" onclick="loadPage(__($page_information.first_page)__)">&laquo;</a></li>
<li><a href="#comment-container" onclick="loadPage(__($page_information.previous_page)__)">&lsaquo;</a></li>
__(/if)__
__(foreach $page_information.all_pages as $page)__
<li class="__(if $page == $page_information.current_page)__active__(/if)__" id="p-__($page)__">
	<a href="#comment-container" onclick="loadPage(__($page)__)">__($page)__</a>
</li>
__(/foreach)__
__(if $page_information.current_page < $page_information.last_page)__
<li><a href="#comment-container" onclick="loadPage(__($page_information.next_page)__)">&rsaquo;</a></li>
<li><a href="#comment-container" onclick="loadPage(__($page_information.last_page)__)">&raquo;</a></li>
__(/if)__
</ul>