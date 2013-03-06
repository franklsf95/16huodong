<html>
<head>
<link href="{$config.asset}/admin/css/transdmin.css" rel="stylesheet" type="text/css" />
<title>16Activity_Admin</title>
</head>
<body>
<script src="{$config.asset}/admin/js/jquery.js"></script>
<script src="{$config.asset}/admin/js/public_admin.js"></script>
<script src="{$config.asset}/admin/js/jNice.js"></script>
{include file="admin/layout/header.tpl"}

{include file="admin/layout/navigate.tpl"}
<div id="container">
{include file="$sidebar.tpl"}


{include file="$template_content.tpl"}

</div>
<div class="clear"></div>
<div>
{include file="admin/layout/footer.tpl"}
</div>
</body>

</html>