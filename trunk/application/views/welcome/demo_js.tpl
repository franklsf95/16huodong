<script>
'<h4><a href="{"welcome/demo_activity_view"|site_url}?id='+data[i].activity_id+'">'+data[i].activity_name+'</a></h4>'
'<ul>'
'<li>开始时间: '+data[i].start_time+'</li>'
'<li>结束时间: '+data[i].end_time+'</li>'
'<li>发起人: <a href="{"profile"|site_url}?id='+data[i].publisher_id+'">'+data[i].publisher_name+'</a></li>'
'<li><code>'+data[i].attend_count+'</code>人参与&nbsp;&nbsp;|&nbsp;&nbsp;<code>'+data[i].follow_count+'</code>人关注</li>'
'</ul></div>';