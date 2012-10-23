<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>__($template_title)__ |__(if $current_member_information)__ __($current_member_information.member_name)__ |__(/if)__ 16活动网，我们中学生自己的活动网站</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    __(if $base_tpl == 'default/common/member')__<meta name="robots" content="noindex">__(/if)__

    <link href="__($config.template_prefix)__asset/css/global.css" rel="stylesheet" type="text/css" />
    <link href="__($config.template_prefix)__asset/css/bootstrap.css" rel="stylesheet" type="text/css" />
    <link href="__($config.template_prefix)__asset/css/jasny-bootstrap.min.css" rel="stylesheet" type="text/css" />
    __(include file="$base_tpl/css.tpl")__
    __(if $more_css )__
    __(include file="$view_folder/$more_css.tpl")__
    __(/if)__

    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
  </head>

  <body>
__(include file="$base_tpl/navbar.tpl")__
    <div class="container">
      <div class="row">
<!--sidebar-->
__(if $base_tpl == 'default/common/guest')__
<div class="span4">
__(else)__
<div class="span3">
__(/if)__
__(include file="$base_tpl/sidebar.tpl")__ 
</div>  
<!--/sidebar-->

<!--content-->
__(if $base_tpl == 'default/common/guest')__
<div class="span8">
__(else)__
<div class="span9">
__(/if)__

<div class="alert alert-block">
  <button type="button" class="close" data-dismiss="alert">×</button>
  <p><strong>Warning!</strong> 此网站现在处于新老UI交替状态；如果你不幸跌入了旧UI，请单击首页即可回到新UI。     by franklsf95 2012-10-22</p>
  <p>请测试以下页面：所有未登录页面、首页、学生个人主页、学生编辑个人资料、活动详情页（不包括评论）、发起活动页。</p>
</div>
__(include file="$view_folder/$template_content.tpl")__
<div class="clear"></div>
<hr>
      <footer>
        <p>&copy; 16活动网 2012</p>
      </footer>
</div>
<!--/content-->

      </div><!--/row-->
    </div> <!-- /container -->
    <script src="__($config.template_prefix)__asset/js/jquery.js"></script>
    <script src="__($config.template_prefix)__asset/js/bootstrap.min.js"></script>
__(include file="$base_tpl/js.tpl")__
__(if $more_js )__
__(include file="$view_folder/$more_js.tpl")__
__(/if)__
  </body>
</html>
