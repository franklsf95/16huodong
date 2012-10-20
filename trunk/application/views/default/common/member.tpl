<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>我的首页 | 16活动网 | 栾思飞</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <link href="__($config.template_prefix)__asset/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="__($config.template_prefix)__asset/css/jasny-bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="__($config.template_prefix)__asset/css/global.css" rel="stylesheet" type="text/css" />
__(if $more_css )__
__(include file="$more_css.tpl")__
__(/if)__
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
  </head>

  <body>

    <div class="navbar navbar-inverse navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container">
          <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </a>
          <a class="brand" href="__('index'|site_url)__"><img alt="16活动网" src="__($config.template_prefix)__asset/img/banner_logo.png"></a>
          <div class="nav-collapse collapse">
            <ul class="nav">
              <li class="active"><a href="__('index'|site_url)__">首页</a></li>
              <li><a href="profile.html">个人主页</a></li>
              <li><a href="activities.html">挖活动</a></li>
              <li><a href="library.html">人生图书馆</a></li>
            </ul>
            <form class="navbar-search pull-right">
  				<input type="text" class="search-query" placeholder="搜搜看看~">
			       </form>
            <a class="brand" id="nav_contact" href="__('contact_member'|site_url)__">联系我们</a>
          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>

    <div class="container">
      <div class="row">
        <div class="span3">
          <div class="affix sidebar">
            <ul class="nav nav-stacked nav-pills">
              <li class="nav-header">About me</li>
              <img src="img/default_portrait.jpg" class="img-polaroid portrait" width=180>
              <h4 class="my_name">栾思飞</h4>
              <h5 class="my_school">中国人民大学附属中学</h5>
              <li><a href="__('my_page/edit'|site_url)__">编辑个人资料</a></li>
              <li><a href="__('activity/edit'|site_url)__">发起新活动</a></li>
              <li><a href="add_book.html">写新书</a></li>
              <li><a href="#">我的好友</a></li>
              <li><a href="#">站内信</a></li>
              <li><a href="__('login/logout'|site_url)__">登出</a></li>
              <li class="nav-header">系统消息</li>
              <li><a href="#">Link</a></li>
              <li><a href="#">Link</a></li>
              <li><a href="#">Link</a></li>
            </ul>
          </div><!--/.sidebar -->
        </div><!--/span-->
__(include file="$template_content.tpl")__
      </div><!--/row-->

    </div><!--/.fluid-container-->

    </div> <!-- /container -->

    <script src="__($config.template_prefix)__asset/js/jquery.min.js"></script>
    <script src="__($config.template_prefix)__asset/js/bootstrap.min.js"></script>
    <script src="__($config.template_prefix)__asset/js/jquery.masonry.min.js"></script>
    <script>
$( function(){
  $('#container').masonry({
    // options
    itemSelector : '.main-showcase-item',
    columnWidth : 280
  });
});
</script>
__(if $more_js )__
__(include file="$more_js.tpl")__
__(/if)__
  </body>
</html>
