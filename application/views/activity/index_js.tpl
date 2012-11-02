<script>$( function(){    showActivities();    $(window).scroll(function() {			if (document.body.clientHeight - document.documentElement.scrollTop -  document.documentElement.clientHeight <= 10 ){				showActivities();			}	});});$("#navbar-activity").addClass("active");$(".tag").click(function() {	reloadActivities( $(this).html() );});var page_offset = 0;var limit = 6;var refresh_lock = false;function showActivities() {	if (!refresh_lock) {		refresh_lock = true;		$.getJSON("{'activity/ajaxGetLatestActivities'|site_url}", {			"page_offset": page_offset,			"limit": limit		}, function(data) {			for(i in data) {				$("#main-showcase").append( wrapActivity( i+1, data[i]) );			}			page_offset = page_offset +  limit;			refresh_lock = false;		});	}}function reloadActivities( tag ) {	$('#main-showcase').fadeOut('fast');	$('#main-showcase').empty();	$.getJSON("{'activity/ajaxGetActivityInformationByTag'|site_url}",{ "tag":tag }, function(data) {		console.log(data);		$("#main-showcase").fadeIn('fast');		if( data.length == 0 ) {			$('#main-showcase').append("<p>无结果</p>");		} else {			for( i in data ) {				activity = wrapActivity( i+1, data[i] );				$("#main-showcase").append( activity );			}		}	});}function wrapActivity( id, act ) {	var a = '<div class="main-showcase-item" id="item-'+id+'">'+'<a href="{"activity/view"|site_url}?id='+act.activity_id+'">'+'<img src="'+act.activity_image+'" class="img-rounded"></a>'+'<h4><a href="{"activity/view"|site_url}?id='+act.activity_id+'">'+act.activity_name+'</a></h4>'+'<ul>'+'<li>开始时间: '+act.start_time+'</li>'+'<li>结束时间: '+act.end_time+'</li>'+'<li>发起人: <a href="{"profile"|site_url}?id='+act.member_id+'">'+act.member_name+'</a></li>'+'<li><code>'+act.attend_number+'</code>人参与&nbsp;&nbsp;|&nbsp;&nbsp;<code>'+act.attention_number+'</code>人关注</li>'+'</ul></div>';	return a;}</script>