<script src="{$config.asset}/js/jquery.masonry.min.js"></script><script src="{$config.asset}/js/waterfall.js"></script><script>var tag = '';$( function(){	$("#navbar-activity").addClass("active");    startActivities();});$(window).scroll(function() {	var top = document.documentElement.scrollTop + document.body.scrollTop;	var bodyheight = $(document).height();	if (bodyheight - top - $(window).height() <= 100) {		if( tag == '' ) continueActivities();		else 			continueByTag();	}});$(".tag:not(#tag-all)").click(function() {	tag = $(this).html();	startByTag();});$("#tag-all").click(function() {	tag = '';	startActivities();});function startActivities() {	Waterfall( "{'activity/ajaxGetLatestActivities'|site_url}", 'start', { type:'activity' } );}function continueActivities() {	Waterfall( "{'activity/ajaxGetLatestActivities'|site_url}", 'continue', { type:'activity' } );}function startByTag() {	Waterfall( "{'activity/ajaxGetActivitiesByTag'|site_url}?tag="+tag, 'start', { type:'activity' } );}function continueByTag() {	Waterfall( "{'activity/ajaxGetActivitiesByTag'|site_url}?tag="+tag, 'continue', { type:'activity' } );}</script>