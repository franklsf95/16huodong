<script>	$(function() {				//导航提示		$('#nav_08').css('color','#ad4c4c');				$( "#birthday" ).datepicker({			dateFormat:'yy-mm-dd',			defaultDate:'{$member_information.birthday}',			changeMonth: true,			changeYear: true			});					var editor = KindEditor.editor({						allowFileManager : false,						allowImageParameter : false					});				//var upload = KindEditor.create({		//	uploadJson:{$config.application_inc}kindeditor/php/upload_json.php?type=portrait,		//});				KindEditor('#portrait_view').click(function() {			editor.uploadJson = '{$config.application_inc}kindeditor/php/upload_portrait_json.php',			editor.loadPlugin('image', function() {				editor.plugin.imageDialog({					imageUrl : KindEditor('#image').val(),					clickFn : function(url, title, width, height, border, align) {						KindEditor('#portrait_view').attr('src',url);						KindEditor('#image').val(url);						editor.hideDialog();					}				});			});		});				$("form").validationEngine();				$(":input").focus(function(){			$(this).validationEngine('hide');		});			});</script></script><div id="page_frame">	<div class="left_side">		{include file="{$template}/layout/menu_box.tpl"}	</div>		<div class="right_side" id="member_edit">		<form action="{'my_page/save_form'|site_url}?act=save" method="post">				<fieldset>					<div class="left">						<p>							<label>帐号:</label>							<input name="account" id="account" type="text" value="{$member_information.member_account}" readonly="readonly" />						</p>												<p>							<label>原密码:</label>							<input name="old_password" type="password" value="" />						</p>												<p>							<label>新密码:</label>							<input name="new_password" type="password" value="" />						</p>												<p>							<label>重复密码:</label>							<input name="repeat_password" type="password" value="" />						</p>											</div>															<div class="right">						<p class="portrait">							<label>头像:</label>							<img src="{$member_information.member_image}" id="portrait_view" height="200" width="200" />							<input type="hidden" name="image" id="image" value="{$member_information.member_image}"/>						</p>					</div>										<div class="clear"></div>										<div class="left">						<p>							<label>组织名称:</label>							<input name="name" class="validate[required]" id="name" type="text" value="{$member_information.member_name}"/>						</p>												<p>							<label>负责人:</label>							<input name="principal" id="principal" type="text" value="{$member_information.principal}"/>						</p>												<p>							<label>职务:</label>							<input name="title" id="title" type="text" value="{$member_information.member_title}"/>						</p>					</div>										<div class="right">						<p>							<label>QQ:</label>							<input name="qq" id="qq" type="text" value="{$member_information.member_qq}" />						</p>												<p>							<label>邮箱:</label>							<input name="email" class="validate[required,custom[email]]" id="email" type="text" value="{$member_information.member_email}"/>						</p>												<p>							<label>电话:</label>							<input name="phone" id="phone" type="text" value="{$member_information.member_phone}"/>						</p>										</div>										<div class="clear"></div>										<div class="all">						<p>							<label>地址:</label>							<input name="address" id="address" type="text" value="{$member_information.member_address}" style="width:660px;"/>						</p>												<p>							<label>标签:</label>							<input name="tag" id="tag" type="text" value="{$member_information.member_tag}" style="width:660px;"/>						</p>												<p>							<label>简介:</label>							<textarea name="description" id="description">{$member_information.member_description}</textarea>						</p>						<p><span class="prompt">在申请参加活动后，你的姓名，邮箱地址和个人简介会发送到活动主办方处，请认真填写保证这三项信息的准确有效性。更完善的简介可以帮助主办方更了解你哦~</span></p>										</div>					<p><input type="submit" value="保存修改" class="submit"></p>				</fieldset>		</form>	</div></div>