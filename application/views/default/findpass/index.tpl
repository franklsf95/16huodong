<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>{$site_name}</title>
<meta name="keywords" content="{$site_keyword}" />
<meta name="description" content="{$site_description}" />

<!-- CSS -->
 <link href="{$config.template_prefix}css/login.css" rel="stylesheet" type="text/css" media="screen" />
<!-- CSS End -->

<script type="text/javascript" src="{$config.application_inc}jquery/jquery-1.7.2.min.js"></script>

<!--validationEngine-->
<script type="text/javascript" src="{$config.application_inc}jquery/validationEngine/jquery.validationEngine.js"></script>
<script type="text/javascript" src="{$config.application_inc}jquery/validationEngine/languages/jquery.validationEngine-zh_CN.js"></script>
<link rel="stylesheet" href="{$config.application_inc}jquery/validationEngine/css/validationEngine.jquery.css" type="text/css" media="all" />
<!--end-->


</head>

<body>
<script>
	$(function(){
		$("form").validationEngine();
		
		$(":input").focus(function(){
			$(this).validationEngine('hide');
		});
	});
	
</script>

<script type='text/javascript'>
function refreshCaptcha()
{
	var img = document.images['captchaimg'];
	img.src = img.src.substring(0,img.src.lastIndexOf("?"))+"?rand="+Math.random()*10000;
}
</script> 

<div id="body_frame">
	
	<div id="login_main">
		<div id="login_box">
			<form action="{'findpass/findPassSubmit'|site_url}" method="post">
				<h3>输入用户名</h3>
				<fieldset>
					<p><input name="account" class="validate[required]" type="text" /></p>
					<p><button type="submit">确定</button></p>
				</fieldset>
			</form>
		</div>
	</div>
	
	
</div>
</body>
</html>