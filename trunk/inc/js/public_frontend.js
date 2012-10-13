/*
前台公共函数

*/
<reference path="../jquery/jquery-1.7.2.min.js" />

function addToFriend(friend_id){
	$.getJSON("__('base_ajax_action_controller/addToFriend'|site_url)__?friend_id="+friend_id,function(data){
			
		});

}