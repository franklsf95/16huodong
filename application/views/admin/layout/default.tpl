<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Transdmin Light</title>

<!-- CSS -->
<link href="__($config.application_prefix)__resources/admin/css/transdmin.css" rel="stylesheet" type="text/css" media="screen" />
<!--[if IE 6]><link rel="stylesheet" type="text/css" media="screen" href="__($config.application_prefix)__resources/admin/css/ie6.css" /><![endif]-->
<!--[if IE 7]><link rel="stylesheet" type="text/css" media="screen" href="__($config.application_prefix)__resources/admin/css/ie7.css" /><![endif]-->

<!-- JavaScripts-->
<script type="text/javascript" src="__($config.application_prefix)__resources/admin/js/public_admin.js"></script>
<script type="text/javascript" src="__($config.application_prefix)__resources/admin/js/jquery.js"></script>
<script type="text/javascript" src="__($config.application_prefix)__resources/admin/js/jquery.form.js"></script>
<!--script type="text/javascript" src="__($config.application_prefix)__resources/admin/js/jNice.js"></script-->
<script charset="utf-8" src="__($config.application_prefix)__inc/kindeditor/kindeditor-min.js"></script>
<script charset="utf-8" src="__($config.application_prefix)__inc/kindeditor/lang/zh_CN.js"></script>
<link rel="stylesheet" href="__($config.application_prefix)__inc/kindeditor/themes/default/default.css"/>
</head>
	
	<body>
	<div id="wrapper">
		
	__(include file="admin/layout/header.tpl")__
	__(include file="admin/layout/navigate.tpl")__
	
	<div id="containerHolder">
			<div id="container">
	
	__(include file="$sidebar.tpl")__
	__(include file="$template_content.tpl")__
	
					<div class="clear"></div>
			</div>
			<!-- // #container -->
		</div>	
		<!-- // #containerHolder -->
	__(include file="admin/layout/footer.tpl")__
	
    </div>
    <!-- // #wrapper -->
</body>
</html>