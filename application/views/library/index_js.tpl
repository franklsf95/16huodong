<script>
'<h4><a href="{"library/view"|site_url}?id='+data[i].member_blog_id+'">'+data[i].member_blog_name+'</a></h4>'
'<ul>'
'<li>发表于 '+data[i].created_time+'</li>'
'<li>作者: <a href="{"library/profile"|site_url}?id='+data[i].member_id+'">'+data[i].member_name+'</a></li>'
'<li><code>'+data[i].visit_number+'</code>人读过&nbsp;&nbsp;|&nbsp;&nbsp;<code>'+data[i].prefer_number+'</code>人喜欢</li>'
'</ul></div>';