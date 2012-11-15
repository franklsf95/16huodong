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
        <link href="{$config.asset}/ie6/ie6.min.css" rel="stylesheet">
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
{include file="$view_folder/$template_content.tpl"}
<div class="clear"></div>
<hr>
      <footer>
        &copy; 16活动网 2012 | beta (r{$svn_version}) | <span data-toggle="modal" data-target="#modal-feedback"><a href="#">问题反馈</a></span>{if $base_tpl == 'common/member'} | <a href="{'contact_member'|site_url}">联系我们</a>{/if}
      </footer>
</div>

<div class="modal hide fade" id="modal-feedback">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h3>问题反馈</h3>
  </div>
  <form id="feedback-form" class="form-horizontal" action="{'index/saveFeedback'|site_url}" method="post">
	<div class="modal-body">
      <label>邮箱：</label>
      <input type="text" id="email" name="feedback_email"  style="width: 300px">
      <label>内容：</label>
      <textarea id="feedback" name="feedback" placeholder="详细的问题描述会让我们更好的帮助您~" style="width: 300px"></textarea>
	</div>
    <div class="modal-footer">
      <a class="btn" data-dismiss="modal" aria-hidden="true">取消</a>
      <button type="submit" class="btn btn-primary" onclick="alert('您的宝贵意见我们已经记录，将会尽快给您反馈')">提交</button>
    </div>
  </form>
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
<!--[if lt IE 9]>
    <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <script src="{$config.asset}/ie6/ie6.min.js"></script>
<![endif]-->
  </body>
</html>
