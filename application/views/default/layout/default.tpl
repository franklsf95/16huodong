<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>__($site_name)__</title>
<meta name="keywords" content="__($site_keyword)__" />
<meta name="description" content="__($site_description)__" />

<!-- CSS -->
 <link href="__($config.template_prefix)__css/global.css" rel="stylesheet" type="text/css" media="screen" />
 <link href="__($config.application_inc)__jquery/css/ui-lightness/jquery-ui-1.8.19.custom.css" rel="stylesheet" type="text/css" media="screen" />
 <link href="__($config.application_inc)__jquery/css/jquery.ui.all.css" rel="stylesheet" type="text/css" media="screen" />
 <link href="__($config.application_inc)__jquery/css/jquery.ui.tabs.css" rel="stylesheet" type="text/css" media="screen" />
 <link rel="stylesheet" href="__($config.application_inc)__kindeditor/themes/default/default.css"/>
<!-- CSS End -->


<!-- JavaScripts -->
<script type="text/javascript" src="__($config.application_inc)__jquery/jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="__($config.application_inc)__jquery/jquery.form.js"></script>
<script type="text/javascript" src="__($config.application_inc)__jquery/jquery-ui-1.8.19.custom.min.js"></script>
<!--validationEngine-->
<script type="text/javascript" src="__($config.application_inc)__jquery/validationEngine/jquery.validationEngine.js"></script>
<script type="text/javascript" src="__($config.application_inc)__jquery/validationEngine/languages/jquery.validationEngine-zh_CN.js"></script>
<link rel="stylesheet" href="__($config.application_inc)__jquery/validationEngine/css/validationEngine.jquery.css" type="text/css" media="all" />
<!--end-->

<!--Pagination-->
<script type="text/javascript" src="__($config.application_inc)__jquery/pagination/jqpagination.min.js"></script>
<link rel="stylesheet" href="__($config.application_inc)__jquery/pagination/jqpagination.css" type="text/css" media="all" />
<!--end-->

<script type="text/javascript" charset="utf-8" src="__($config.application_inc)__kindeditor/kindeditor-min.js"></script>
<script type="text/javascript" charset="utf-8" src="__($config.application_inc)__kindeditor/lang/zh_CN.js"></script>


<!-- JavaScripts End-->

</head>

<body>

<div id="body_frame">
	
    __(include file="__($template)__/layout/header.tpl")__
	
	
	__(include file="$template_content.tpl")__
    
    __(include file="__($template)__/layout/footer.tpl")__
</div>


</body>
</html>
