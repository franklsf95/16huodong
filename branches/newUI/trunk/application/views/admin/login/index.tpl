<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Transdmin Light</title>

<!-- CSS -->
<!-- <link href="__($config.application_prefix)__resources/admin/css/transdmin.css" rel="stylesheet" type="text/css" media="screen" /> -->
<!--[if IE 6]><link rel="stylesheet" type="text/css" media="screen" href="__($config.application_prefix)__resources/admin/css/ie6.css" /><![endif]-->
<!--[if IE 7]><link rel="stylesheet" type="text/css" media="screen" href="__($config.application_prefix)__resources/admin/css/ie7.css" /><![endif]-->

<!-- JavaScripts-->
<script type="text/javascript" src="__($config.application_prefix)__resources/admin/js/jquery.js"></script>
</head>
	
<body>
	<div style="margin:200px 200px auto 200px; background: #eee; padding:5px;">
		<div style="background: #fff; border: 1px solid #ddd; text-align:center">
		<form action="__('admin/login/loginSubmit'|site_url)__" method="post">
			<p>__('global_application_user_login'|lang_line)__</p>
			<p>
				__('global_username'|lang_line)__:<input type="text" name="username" />
			</p>
			
			<p>
				__('global_password'|lang_line)__:<input type="password" name="password" />
			</p>
			<p>
				<input type="submit" /> <input type="reset" />
			</p>
		</div>
	</div>
</body>
</html>