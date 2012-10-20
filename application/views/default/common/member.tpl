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
    <style type="text/css">
.jumbotron {
  position: relative;
  padding: 40px 0;
  color: #fff;
  text-shadow: 0 1px 3px rgba(0,0,0,.4), 0 0 30px rgba(0,0,0,.075);
  background: #020031; /* Old browsers */
  background: -moz-linear-gradient(45deg,  #020031 0%, #6d3353 100%); /* FF3.6+ */
  background: -webkit-gradient(linear, left bottom, right top, color-stop(0%,#020031), color-stop(100%,#6d3353)); /* Chrome,Safari4+ */
  background: -webkit-linear-gradient(45deg,  #020031 0%,#6d3353 100%); /* Chrome10+,Safari5.1+ */
  background: -o-linear-gradient(45deg,  #020031 0%,#6d3353 100%); /* Opera 11.10+ */
  background: -ms-linear-gradient(45deg,  #020031 0%,#6d3353 100%); /* IE10+ */
  background: linear-gradient(45deg,  #020031 0%,#6d3353 100%); /* W3C */
  filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#020031', endColorstr='#6d3353',GradientType=1 ); /* IE6-9 fallback on horizontal gradient */
  -webkit-box-shadow: inset 0 3px 7px rgba(0,0,0,.2), inset 0 -3px 7px rgba(0,0,0,.2);
     -moz-box-shadow: inset 0 3px 7px rgba(0,0,0,.2), inset 0 -3px 7px rgba(0,0,0,.2);
          box-shadow: inset 0 3px 7px rgba(0,0,0,.2), inset 0 -3px 7px rgba(0,0,0,.2);
}

/* Link styles (used on .masthead-links as well) */
.jumbotron a {
  color: #fff;
  -webkit-transition: all .1s ease-in-out;
     -moz-transition: all .1s ease-in-out;
          transition: all .1s ease-in-out;
}
.jumbotron a:hover {
  text-decoration: none;
  color: #fff;
  color: rgba(255,255,255,.8);
  text-shadow: 0 0 10px rgba(255,255,255,.25);
}

.content-heading {
  color: #666;
  font-size: 24px;
  line-height: 24px;
  padding-top: 10px;
}

.content-heading hr {
  margin: 16px 0 20px;
}

.top-showcase-leftnav {
  border: 1px white solid;
  float: left;
  height: 120px;
  width: 20px;
  margin: 0 0 0 10px;
  background-color: #999;
}

.top-showcase-rightnav {
  border: 1px white solid;
  float: right;
  height: 120px;
  width: 20px;
  margin: 0 10px 0 0;
  background-color: #999;
}

.top-showcase-item {
  /*border: 1px white solid;*/
  width: 300px;
  height: 120px;
  float: left;
  margin: -10px 0 -10px 20px;
  padding: 10px 10px 10px 10px;
  text-align: left;
  font-size: 12px;
}

.top-showcase-item img {
  float: left;
  width: 120px;
  height: 120px;
  margin-right: 12px;
}

.top-showcase-item h3 {
  font-size: 16px;
  line-height: 20px;
  margin: 8px 0 6px 0;
}

.top-showcase-item li {
  list-style-type: none;
}

.top-showcase-item code {
  padding: 1px 3px;
  margin-right: 2px;
}

.main-showcase-item {
  width: 260px;
  margin: 10px;
  float: left;
}

.main-showcase-item img {
  width: 250px;
}
    </style>
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
<script>
$(function(){
  $('#container').masonry({
    // options
    itemSelector : '.main-showcase-item',
    columnWidth : 280
  });
});
</script>

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
              <li><a href="edit_profile.html">编辑个人资料</a></li>
              <li><a href="add_activity.html">发起新活动</a></li>
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

  </body>
</html>
