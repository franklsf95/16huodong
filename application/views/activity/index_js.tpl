<script>
'<h4><a href="{"activity/view"|site_url}?id='+act.activity_id+'">'+act.activity_name+'</a></h4>'
'<ul>'
'<li>开始时间: '+act.start_time+'</li>'
'<li>结束时间: '+act.end_time+'</li>'
'<li>发起人: <a href="{"profile"|site_url}?id='+act.publisher_id+'">'+act.publisher_name+'</a></li>'
'<li><code>'+act.attend_count+'</code>人参与&nbsp;&nbsp;|&nbsp;&nbsp;<code>'+act.follow_count+'</code>人关注</li>'
'</ul></div>';