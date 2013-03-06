					<div id="main">
						<h3>{'application_user_manage'|lang_line}</h3>
						<div class="clear"></div>
						<form action="{'admin/application_user/save_form'|site_url}" method="post" class="jNice" name="adminForm">
							<fieldset>
								<p>
									<label>{'global_application_group'|lang_line}</label>
										<select name="application_group_id" class="text-small">
											{foreach name="all_application_group_information" from=$all_application_group_information item=application_group}
											<option value="{$application_group.application_group_id}">{$application_group.name}</option>
											{/foreach}
										</select>
										
								</p>
								
								<p>
									<label>{'global_status'|lang_line}</label>
									<select name="status" class="text-small">
										<option value="Y">{'global_show'|lang_line}</option>
										<option value="N" {if $application_user_information.status == 'N'} checked="checked" {/if}>{'global_hidden'|lang_line}</option>
									</select>
								</p>
								
								<p>
									<label>{'global_username'|lang_line}</label>
									<input class="text-small" type="text" name="username" value="{$application_user_information.username}" {if ($application_user_information.username != '')} readonly="readonly"{else if} onblur="checkUsername(this.value)" {/if}/><img id="username_right" src="/asset/admin/img/activity.png" /><img id="username_wrong" src="/asset/admin/img/unactivity.png" />
								</p>
								
								{if ($cid != '')}
								<p>
									<label>{'global_old_password'|lang_line}</label>
									<input class="text-medium" type="password" name="old_password" value="{$application_user_information.password}" onchange="checkPassword('{$cid}',this.value)"/><img id="password_right" src="/asset/admin/img/activity.png" /><img id="password_wrong" src="/asset/admin/img/unactivity.png" />
								</p>
								{/if}
								
								<p>
									<label>{'global_password'|lang_line}</label>
									<input class="text-medium" type="password" name="password" value="" onblur="checkRepeatPassword()"/>
								</p>
								
								<p>
									<label>{'global_repeat_password'|lang_line}</label>
									<input class="text-medium" type="password" name="repeat_password" value="" onblur="checkRepeatPassword()"/><span id="message_repeat_password" style="color:red; line-height:24px;"></a>
								</p>
								
								<p>
									<label>{'global_name'|lang_line}</label>
									<input class="text-small" type="text" name="name" id="name" value="{$application_user_information.name}" />
								</p>
								
								<p>
									<label>{'global_email'|lang_line}</label>
									<input class="text-small" type="text" name="email" id="email" value="{$application_user_information.email}" />
								</p>
								<input type="hidden" value="{$cid}" name="cid" id="cid" />
								<p>
									<input class="button" type="button" value="{'global_submit'|lang_line}" onclick="checkForm()" />
								</p>
								
							</fieldset>
							
							<div class="clear"></div><!-- End .clear -->
							
						</form>
						
					</div> <!-- End #tab2 -->
					
<script>

	function checkPassword(application_user_id,password){
		if (password == '') {
			$("#password_right").css('display','none');
			$("#password_wrong").css('display','none');
		} else {
			$.ajax({
				url:"{'admin/ajax_controller/checkPassword'|site_url}",
				data:"application_user_id="+application_user_id+"&password="+password,
				type:"GET",
				dataType:"json",
				success:function(data){
					if (data.result == 'Y'){
						$("#password_wrong").css('display','none');
						$("#password_right").css('display','block');
						$(":button").attr('disabled','');
					} else {
						$("#password_right").css('display','none');
						$("#password_wrong").css('display','block');
						$(":button").attr('disabled','disabled');
					}
				}
			});
		}
	}
	
	function checkUsername(username){
		if (username == '') {
			$("#username_right").css('display','none');
			$("#username_wrong").css('display','none');
		} else {
			$.ajax({
				url:"{'admin/ajax_controller/checkUsername'|site_url}",
				data:"username="+username,
				type:"GET",
				dataType:"json",
				success:function(data){
					if (data.result == 'Y'){
						$("#username_wrong").css('display','none');
						$("#username_right").css('display','block');
						$(":button").attr('disabled','');
					} else {
						$("#username_right").css('display','none');
						$("#username_wrong").css('display','block');
						$(":button").attr('disabled','disabled');
					}
				}
			});
		}
	}
	
	
	function checkRepeatPassword(){
		var form = document.adminForm
		if (form.repeat_password.value != form.password.value){
			$("#message_repeat_password").html('*密码不一致');
		}else {
			$("#message_repeat_password").html('');
		}
	}
	
	
	
	function checkForm(){
		var form = document.adminForm
		if (form.username.value == '') {
			alert('帐号不能为空');
			return false;
		}
		
		if (form.password.value.length < 6) {
			alert('密码不能小于6位');
			return false;
		}
		
		if (form.repeat_password.value != form.password.value) {
			alert('两次密码不一致');
			return false;
		}
		
		form.submit();
	}

</script>

<script>
	checkPassword('{$cid}','');
	checkUsername('');
</script>