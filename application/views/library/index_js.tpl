<script>
'<h4><a href="{"library/view"|site_url}?id='+book.book_id+'">'+book.book_name+'</a></h4>'
'<ul>'
'<li>发表于 '+book.created_time+'</li>'
'<li>作者: <a href="{"library/profile"|site_url}?id='+book.author_id+'">'+book.author_name+'</a></li>'
'<li><code>'+book.view_count+'</code>人读过&nbsp;&nbsp;|&nbsp;&nbsp;<code>'+book.like_count+'</code>人喜欢</li>'
'</ul></div>';