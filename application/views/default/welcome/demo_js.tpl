<script>
'<h4><a href="__("activity/view"|site_url)__?id='+data[i].activity_id+'">'+data[i].activity_name+'</a></h4>'
'<ul>'
'<li>开始时间: '+data[i].start_time+'</li>'
'<li>结束时间: '+data[i].end_time+'</li>'
'<li>发起人: <a href="__("profile"|site_url)__?id='+data[i].member_id+'">'+data[i].member_name+'</a></li>'
'<li><code>'+data[i].attend_number+'</code>人参与&nbsp;&nbsp;|&nbsp;&nbsp;<code>'+data[i].attention_number+'</code>人关注</li>'
'</ul></div>';