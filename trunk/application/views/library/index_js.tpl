<script>
'<h4><a href="{"library/view"|site_url}?id='+data[i].book_id+'">'+data[i].book_name+'</a></h4>'
'<ul>'
'<li>发表于 '+data[i].created_time+'</li>'
'<li>作者: <a href="{"library/profile"|site_url}?id='+data[i].author_id+'">'+data[i].author_name+'</a></li>'
'<li><code>'+data[i].view_count+'</code>人读过&nbsp;&nbsp;|&nbsp;&nbsp;<code>'+data[i].like_count+'</code>人喜欢</li>'
'</ul></div>';