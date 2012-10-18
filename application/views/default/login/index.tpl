<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>__($site_name)__</title>
<meta name="keywords" content="__($site_keyword)__" />
<meta name="description" content="__($site_description)__" />

<!-- CSS -->
 <link href="__($config.template_prefix)__css/login.css" rel="stylesheet" type="text/css" media="screen" />
<!-- CSS End -->

<script type="text/javascript" src="__($config.application_inc)__jquery/jquery-1.7.2.min.js"></script>

<!--validationEngine-->
<script type="text/javascript" src="__($config.application_inc)__jquery/validationEngine/jquery.validationEngine.js"></script>
<script type="text/javascript" src="__($config.application_inc)__jquery/validationEngine/languages/jquery.validationEngine-zh_CN.js"></script>
<link rel="stylesheet" href="__($config.application_inc)__jquery/validationEngine/css/validationEngine.jquery.css" type="text/css" media="all" />
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

<div id="body_frame">
	
	<div id="login_main">
		<div id="login_box">
			<form action="__('login/loginSubmit'|site_url)__" method="post">
				<h3><a>登录</a>|<a href="__('register'|site_url)__">注册</a>|<a href="__('findpass'|site_url)__">找回密码</a></h3>
				<fieldset>
					<p><input name="account" class="validate[required]" type="text" /></p>
					<p><input name="password" class="validate[required]" type="password" /></p>
					<p class="checkbox"><input type="checkbox" name="member_cookie" value="Y" /><span>下次自动登录</span></p>
					<p><button type="submit">登录</button></p>
				</fieldset>
			</form>
		</div>
	</div>
	
	
</div>
</body>
</html>