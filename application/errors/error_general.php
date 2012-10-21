<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>出错啦 | 16活动网，我们中学生自己的活动网站</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    
    <link href="/application/views/default/asset/css/bootstrap.css" rel="stylesheet" type="text/css" />
    <link href="/application/views/default/asset/css/jasny-bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="/application/views/default/asset/css/global.css" rel="stylesheet" type="text/css" />
    <style type="text/css">
    	.error_container {
    		background-image: url('/application/errors/error.png');
    		background-repeat: no-repeat;
    		margin-top: -50px;
    		height: 600px;
    	}
      	.error_container p {
        	font-size: 24px;
        	margin: 100px 0 0 560px;
        	line-height: 40px;
      	}
    </style>
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
          <a class="brand" href="http://localhost/index.php/index"><img alt="16活动网" src="/application/views/default/asset/img/banner_logo.png"></a>
          <div class="nav-collapse collapse">
            <a class="brand" id="nav_contact" href="http://localhost/index.php/contact">联系我们</a>
          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>
    <div class="container">
      <div class="row">
      <div class="span12 error_container">
      	<?php echo $message ?>
      </div>
      </div><!--/row-->

      <hr>

      <footer>
        <p>&copy; 16活动网 2012</p>
      </footer>

    </div><!--/.fluid-container-->

    </div> <!-- /container -->
  </body>
</html>
