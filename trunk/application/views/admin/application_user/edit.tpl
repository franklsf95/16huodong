					<div id="main">
						<h3>__('application_user_manage'|lang_line)__</h3>
						<div class="clear"></div>
						<form action="__('admin/application_user/save_form'|site_url)__" method="post" class="jNice" name="adminForm">
							<fieldset>
								<p>
									<label>__('global_application_group'|lang_line)__</label>
										<select name="application_group_id" class="text-small">
											__(foreach name="all_application_group_information" from=$all_application_group_information item=application_group)__
											<option value="__($application_group.application_group_id)__">__($application_group.name)__</option>
											__(/foreach)__
										</select>
										
								</p>
								
								<p>
									<label>__('global_status'|lang_line)__</label>
									<select name="status" class="text-small">
										<option value="Y">__('global_show'|lang_line)__</option>
										<option value="N" __(if $application_user_information.status == 'N')__ checked="checked" __(/if)__>__('global_hidden'|lang_line)__</option>
									</select>
								</p>
								
								<p>
									<label>__('global_username'|lang_line)__</label>
									<input class="text-small" type="text" name="username" value="__($application_user_information.username)__" __(if ($application_user_information.username != ''))__ readonly="readonly"__(else if)__ onblur="checkUsername(this.value)" __(/if)__/><img id="username_right" src="__($config.application_prefix)__resources/admin/img/activity.png" /><img id="username_wrong" src="__($config.application_prefix)__resources/admin/img/unactivity.png" />
								</p>
								
								__(if ($cid != ''))__
								<p>
									<label>__('global_old_password'|lang_line)__</label>
									<input class="text-medium" type="password" name="old_password" value="" onchange="checkPassword('__($cid)__',this.value)"/><img id="password_right" src="__($config.application_prefix)__resources/admin/img/activity.png" /><img id="password_wrong" src="__($config.application_prefix)__resources/admin/img/unactivity.png" />
								</p>
								__(/if)__
								
								<p>
									<label>__('global_password'|lang_line)__</label>
									<input class="text-medium" type="password" name="password" value="" onblur="checkRepeatPassword()"/>
								</p>
								
								<p>
									<label>__('global_repeat_password'|lang_line)__</label>
									<input class="text-medium" type="password" name="repeat_password" value="" onblur="checkRepeatPassword()"/><span id="message_repeat_password" style="color:red; line-height:24px;"></a>
								</p>
								
								<p>
									<label>__('global_name'|lang_line)__</label>
									<input class="text-small" type="text" name="name" id="name" value="__($application_user_information.name)__" />
								</p>
								
								<p>
									<label>__('global_email'|lang_line)__</label>
									<input class="text-small" type="text" name="email" id="email" value="__($application_user_information.email)__" />
								</p>
								<input type="hidden" value="__($cid)__" name="cid" id="cid" />
								<p>
									<input class="button" type="button" value="__('global_submit'|lang_line)__" onclick="checkForm()" />
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
				url:"__('admin/ajax_controller/checkPassword'|site_url)__",
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
				url:"__('admin/ajax_controller/checkUsername'|site_url)__",
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
	checkPassword('__($cid)__','');
	checkUsername('');
</script>