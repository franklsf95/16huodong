<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>__($site_name)__</title>
<meta name="keywords" content="__($site_keyword)__" />
<meta name="description" content="__($site_description)__" />

<!--JS-->
<script type="text/javascript" src="__($config.application_inc)__jquery/jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="__($config.application_inc)__jquery/jquery-ui-1.8.19.custom.min.js"></script>
<script charset="utf-8" src="__($config.application_inc)__kindeditor/kindeditor-min.js"></script>
<script charset="utf-8" src="__($config.application_inc)__kindeditor/lang/zh_CN.js"></script>
<!--JS END-->

<!-- CSS -->

<link href="__($config.application_inc)__jquery/css/ui-lightness/jquery-ui-1.8.19.custom.css" rel="stylesheet" type="text/css" media="screen" />
<link href="__($config.template_prefix)__css/register.css" rel="stylesheet" type="text/css" media="screen" />
 <link href="__($config.application_inc)__jquery/css/jquery.ui.all.css" rel="stylesheet" type="text/css" media="screen" />
 <link rel="stylesheet" href="__($config.application_inc)__kindeditor/themes/default/default.css"/>
<!-- CSS End -->
</head>

<body>
<script>
	$(function() {
			
		var editor = KindEditor.editor({
						allowFileManager : false,
						allowImageParameter : false
					});
		
		
		KindEditor('#portrait_view').click(function() {
			editor.uploadJson = '__($config.application_inc)__kindeditor/php/upload_portrait_json.php',
			editor.loadPlugin('image', function() {
				editor.plugin.imageDialog({
					imageUrl : KindEditor('#image').val(),
					clickFn : function(url, title, width, height, border, align) {
						KindEditor('#portrait_view').attr('src',url);
						KindEditor('#image').val(url);
						editor.hideDialog();
					}
				});
			});
		});
	});
</script>

<div id="body_frame">
	
	<div class="detail_information">
		<div id="detail_student">
			<form class="detail_form" action="__('register/save_detail_information'|site_url)__" method="post">
				<fieldset>
					<div class="left">
						<p><label>负责人:</label><input type="text" name="principal" /></p>
						<p><label>QQ:&nbsp;&nbsp;&nbsp;&nbsp;</label><input type="text" name="qq" /></p>
						<p><label>电话:&nbsp;&nbsp;</label><input type="text" name="phone" /></p>
					</div>
					<div class="right">
						<p><label>头像:&nbsp;</label><img id="portrait_view" src="__($member_information.member_image)__" height="150" width="150" /><input type="hidden" name="image" id="image" value="__($member_information.member_image)__" /></p>
						
					</div>
					<div class="clear"></div>
					<div class="all">
						<p><label>地址:&nbsp;&nbsp;</label><input type="text" name="address" style="width:368px;" /></p>
						<p><label>标签:&nbsp;&nbsp;</label><input type="text" name="tag" style="width:368px;" /></p>
						<p class="note">【请用','间隔，譬如'慈善,公益,学生,健康'】</p>
					</div>
					<div class="clear"></div>
					<div class="all">
						<p><label>备注:&nbsp;&nbsp;</label><textarea name="description" ></textarea></p>
					</div>
					<div class="clear"></div>
					
					<div>
						<p><button type="submit">提交</button></p>
					</div>
					
					
					
					
					
					
				</fieldset>
			</form>
		</div>
	</div>
	
	
</div>
</body>
</html>