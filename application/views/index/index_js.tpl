<script src="{$config.asset}/js/jquery.bxSlider.min.js"></script><script src="{$config.asset}/js/jquery.masonry.min.js"></script><script src="{$config.asset}/js/waterfall.js"></script><script src="{$config.asset}/js/timeago.js"></script><script>$("#navbar-index").addClass("active");$(".slider").bxSlider();$( function(){    startNewsFeed();});$(window).scroll(function() {	var top = document.documentElement.scrollTop + document.body.scrollTop;	var bodyheight = $(document).height();	if (bodyheight - top - $(window).height() <= 100) {		continueNewsFeed();	}});function startNewsFeed() {	Waterfall( "{'index/ajaxGetNewsFeed'|site_url}", 'start', { wrapFunction: wrapNewsItem, callBack: runTimeAgo } );}function continueNewsFeed() {	Waterfall( "{'index/ajaxGetNewsFeed'|site_url}", 'continue', { wrapFunction: wrapNewsItem, callBack: runTimeAgo } );}function runTimeAgo() {	$('time').timeago();}var wrapNewsItem = function( id, data ) {	var href, item_name, item_image;	if( data.activity_id > 0 ) {		href = '"{"activity/view"|site_url}/'+data.activity_id+'"';		item_name = data.activity_name;		item_image = data.activity_image;	} else if( data.book_id > 0 ) {		href = '"{"library/view"|site_url}/'+data.book_id+'"';		item_name = data.book_name;		item_image = data.book_image;	}	var str = '<div class="waterfall-item" id="item-'+id+'">'+'<a href='+href+'>'+'<img src="'+item_image+'" class="img-rounded"></a>'+'<div class="waterfall-item-bottom">'+'<a class="waterfall-item-heading" href='+href+'>'+item_name+'</a>'+data.message+'</div>'+'<div class="timeago-wrapper"><time class="timeago" datetime='+data.created_time+'></time></div>'+'</div>';	return str;};</script>