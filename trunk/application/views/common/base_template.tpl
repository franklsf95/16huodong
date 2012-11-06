<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>{$template_title} | 16活动网，我们中学生自己的活动网站</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    {if $base_tpl == 'common/member'}<meta name="robots" content="noindex">{/if}

    <link href="{$config.asset}/css/bootstrap.css" rel="stylesheet" type="text/css" />
    <link href="{$config.asset}/css/global.css" rel="stylesheet" type="text/css" />
    {include file="$base_tpl/css.tpl"}
    {if $more_css }
    {include file="$view_folder/$more_css.tpl"}
    {/if}

    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
  </head>

  <body>
{include file="$base_tpl/navbar.tpl"}
    <div class="container">
      <div class="row">
<!--sidebar-->
{if $base_tpl == 'common/guest'}
<div class="span4">
{else}
<div class="span3">
{/if}
{include file="$base_tpl/sidebar.tpl"} 
</div>  
<!--/sidebar-->

<!--content-->
{if $base_tpl == 'common/guest'}
<div class="span8">
{else}
<div class="span9">
{/if}
<!--
<div class="alert alert-block">
  <button type="button" class="close" data-dismiss="alert">×</button>
  <p><strong>Warning!</strong> 此网站现在处于新老UI交替状态；如果你不幸跌入了旧UI，请单击首页即可回到新UI。     by franklsf95 2012-10-22</p>
  <p>请测试以下页面：所有未登录页面、首页、个人主页和编辑资料、所有活动页面（不包括评论）。</p>
</div>-->
{include file="$view_folder/$template_content.tpl"}
<div class="clear"></div>
<hr>
      <footer>
        <p>&copy; 16活动网 2012</p>
      </footer>
</div>
<!--/content-->

      </div><!--/row-->
    </div> <!-- /container -->
    <script src="{$config.asset}/js/jquery.min.js"></script>
    <script src="{$config.asset}/js/bootstrap.min.js"></script>
{include file="$base_tpl/js.tpl"}
{if $more_js }
{include file="$view_folder/$more_js.tpl"}
{/if}
  </body>
</html>
