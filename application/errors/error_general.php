<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title><?php echo $heading ?> | 16活动网，我们中学生自己的活动网站</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="robots" content="noindex">
    
    <link href="/asset/css/bootstrap.css" rel="stylesheet" type="text/css" />
    <link href="/asset/css/global.css" rel="stylesheet" type="text/css" />
    <style type="text/css">
    	.error-container {
    		background-image: url('/application/errors/error.png');
    		background-repeat: no-repeat;
    		margin-top: -50px;
        padding: 500px 0 0 660px;
    		height: 120px;
    	}
      .error-container p {
        color: #111;
        font-size: 28px;
        line-height: 40px;
      }
      .btn-error {
        position: relative;
        left: -400px;
        top: -240px;
        font-size: 32px;
        color: #000;
        cursor: pointer;
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
          <a class="brand" href="/"><img alt="16活动网" src="/asset/img/banner_logo.png"></a>
          <div class="nav-collapse collapse">
            <a class="navbar-highlight" id="navbar-contact" href="/contact">联系我们</a>
          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>
    <div class="container">
      <div class="row">
      <div class="span12 error-container">
        <a class="btn-error" onclick="history.back()">点我返回&gt;&lt;</a>
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
