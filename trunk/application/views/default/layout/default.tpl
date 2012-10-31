<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>{$site_name}</title>
<meta name="keywords" content="{$site_keyword}" />
<meta name="description" content="{$site_description}" />

<!-- CSS -->
 <link href="{$config.template_prefix}css/global.css" rel="stylesheet" type="text/css" media="screen" />
 <link href="{$config.application_inc}jquery/css/ui-lightness/jquery-ui-1.8.19.custom.css" rel="stylesheet" type="text/css" media="screen" />
 <link href="{$config.application_inc}jquery/css/jquery.ui.all.css" rel="stylesheet" type="text/css" media="screen" />
 <link href="{$config.application_inc}jquery/css/jquery.ui.tabs.css" rel="stylesheet" type="text/css" media="screen" />
 <link rel="stylesheet" href="{$config.application_inc}kindeditor/themes/default/default.css"/>
<!-- CSS End -->


<!-- JavaScripts -->
<script type="text/javascript" src="{$config.application_inc}jquery/jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="{$config.application_inc}jquery/jquery.form.js"></script>
<script type="text/javascript" src="{$config.application_inc}jquery/jquery-ui-1.8.19.custom.min.js"></script>
<!--validationEngine-->
<script type="text/javascript" src="{$config.application_inc}jquery/validationEngine/jquery.validationEngine.js"></script>
<script type="text/javascript" src="{$config.application_inc}jquery/validationEngine/languages/jquery.validationEngine-zh_CN.js"></script>
<link rel="stylesheet" href="{$config.application_inc}jquery/validationEngine/css/validationEngine.jquery.css" type="text/css" media="all" />
<!--end-->

<!--Pagination-->
<script type="text/javascript" src="{$config.application_inc}jquery/pagination/jqpagination.min.js"></script>
<link rel="stylesheet" href="{$config.application_inc}jquery/pagination/jqpagination.css" type="text/css" media="all" />
<!--end-->

<script type="text/javascript" charset="utf-8" src="{$config.application_inc}kindeditor/kindeditor-min.js"></script>
<script type="text/javascript" charset="utf-8" src="{$config.application_inc}kindeditor/lang/zh_CN.js"></script>


<!-- JavaScripts End-->

</head>

<body>

<div id="body_frame">
	
    {include file="{$template}/layout/header.tpl"}
	
	
	{include file="$template_content.tpl"}
    
    {include file="{$template}/layout/footer.tpl"}
</div>


</body>
</html>
