<div class="say">
	<div class="say_t"><img src="{$config.template_prefix}images/member_say_01.gif" /></div>
	<div class="input_box"><textarea name="say" id="say"></textarea></div>
	<div class="say_tools"><button type="button"  onclick="submit_say()" class="submit" >发布</button></div>
</div>

<script>
function submit_say(){
	var content = $("#say").val();
	$.ajax({
			url:"{'base_ajax_action_controller/saveMemberSay'|site_url}",
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