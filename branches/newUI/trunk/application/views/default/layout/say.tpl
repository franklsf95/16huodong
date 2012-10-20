<div class="say">
	<div class="say_t"><img src="__($config.template_prefix)__images/member_say_01.gif" /></div>
	<div class="input_box"><textarea name="say" id="say"></textarea></div>
	<div class="say_tools"><button type="button"  onclick="submit_say()" class="submit" >发布</button></div>
</div>

<script>
function submit_say(){
	var content = $("#say").val();
	$.ajax({
			url:"__('base_ajax_action_controller/saveMemberSay'|site_url)__",
			data:"content="+content,
			type:"POST",
			dataType:"json",
			success:function(data){
				alert('发布成功');
				$("#say").val('');
				
			}
	});
}



</script>