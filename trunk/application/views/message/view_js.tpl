<script src="{$config.asset}/js/jquery.validate.min.js"></script><script>$(".reply-btn").click(function() {	var t = '回复{$target_info.member_name}: '+$("#message-content").val();	$("#message-content").focus().val(t);});$("#reply-form").validate({	rules: {		message_content : {			required: true		}	}});</script>