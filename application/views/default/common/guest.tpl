<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>__($template_title)__ | 16活动网</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <link href="__($config.template_prefix)__asset/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="__($config.template_prefix)__asset/css/jasny-bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="__($config.template_prefix)__asset/css/global.css" rel="stylesheet" type="text/css" />
    <style type="text/css">
      body {
        padding-top: 120px;
        padding-bottom: 40px;
	  }
	  .tab-pane input {
		  width: 186px;
	  }
    #reg-form .control-group {
      width: 320px;
    }
    #reg-form .control-label {
      text-align: left;
      padding-left: 5px;
      width: 60px;
    }
    #reg-form .controls {
      margin-left: 80px;
    }
    #nav_contact {
      float: left;
    }
    .navbar-login-item {
      font-size: 13px;
      position: relative;
      top: 4px;
    }
    .navbar-login-item input {
      margin-right: 6px;
      position: relative;
      top: -4px;
    }
    .navbar-login-forget {
      left: 120px;
    }
    .navbar-login-item a {
      color: #aaa;
    }
    .navbar-login-item a:hover {
      text-decoration: none;
      color: #eee;
    }
    label.valid {
      width: 24px;
      height: 24px;
      background: url("__($config.template_prefix)__asset/img/valid.png") center center no-repeat;
      display: inline-block;
      text-indent: -9999px;
    }
    label.error {
      font-size: 13px;
      font-weight: bold;
      color: red;
      padding-left: 8px;
      margin-top: 2px;
    }
    .controls input {
      width: 190px;
    }
    .controls select {
      margin-right: 20px;
    }
    #submit-btn {
      margin-top: 20px;
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
          <a class="brand" href="__('index'|site_url)__"><img alt="16活动网" src="__($config.template_prefix)__asset/img/banner_logo.png"></a>
          <div class="nav-collapse collapse">
            <a class="brand" id="nav_contact" href="__('contact'|site_url)__">联系我们</a>
            <form class="navbar-form pull-right" id="navbar-login" action="__('login/loginSubmit'|site_url)__" method="post">
              <input class="span2" type="text" placeholder="用户名" id="loginUsername" name="account">
              <input class="span2" type="password" placeholder="密码" id="loginPassword" name="password">
              <button type="submit" class="btn btn-primary">登录</button>
              <div id="navbar-login-tools">
                <span class="navbar-login-item navbar-login-remember"><input type="checkbox" id="loginRemember" name="member_cookie" value="Y"><a>记住我</a></span>
                <span class="navbar-login-item navbar-login-forget" data-toggle="modal" data-target="#modal-findpass"><a href="#">忘记密码</a></span>
              </div>
            </form>
          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>

    <div class="container">
      <div class="row">
        <div class="span4">
          <div class="well sidebar-reg">
          <form id="reg-form" class="form-horizontal">
            <fieldset>
              <legend>加入16活动网~</legend>
              <div class="control-group">
                <label class="control-label" for="username">用户名</label>
                <div class="controls">
                  <input type="text" name="username" id="username">
                </div>
              </div>
              <div class="control-group">
                <label class="control-label" for="password">密码</label>
                <div class="controls">
                  <input type="password" name="password" id="password">
                </div>
              </div>
              <div class="control-group">
                <label class="control-label" for="password2">确认密码</label>
                <div class="controls">
                  <input type="password" name="password2" id="password2">
                </div>
              </div>
              <div class="control-group">
                <label class="control-label" for="email">E-mail</label>
                <div class="controls">
                  <input type="text" name="email" id="email">
                </div>
              </div>
              <div class="control-group">
                <label class="control-label" for="city">城市</label>
                <div class="controls">
                  <select id="city" class="span1">
                    <option>北京</option>
                    <option>其他</option>
                  </select>
                  <select id="district" style="width: 100px">
                    <option>海淀区</option>
                    <option>其他</option>
                  </select>
                </div>
              </div>
      <div class="tabbable tabs-below" id="reg-fields">
  			<div class="tab-content">
            	<div class="tab-pane active" id="reg-stu">
                <div class="control-group">
                  <label class="control-label" for="school">学校</label>
                  <div class="controls">
                    <input type="text" class="typeahead" data-provide="typeahead" data-items="4" data-source='["中国人民大学附属中学","北京师范大学附属实验中学","Arizona","Arkansas","California","Colorado","Connecticut","Delaware","Florida","Georgia","Hawaii","Idaho","Illinois","Indiana","Iowa","Kansas","Kentucky","Louisiana","Maine","Maryland","Massachusetts","Michigan","Minnesota","Mississippi","Missouri","Montana","Nebraska","Nevada","New Hampshire","New Jersey","New Mexico","New York","North Dakota","North Carolina","Ohio","Oklahoma","Oregon","Pennsylvania","Rhode Island","South Carolina","South Dakota","Tennessee","Texas","Utah","Vermont","Virginia","Washington","West Virginia","Wisconsin","Wyoming"]'>
                  </div>
                </div>
                <div class="control-group">
                  <label class="control-label" for="name">真实姓名</label>
                  <div class="controls">
                    <input type="text" name="name" id="name">
                  </div>
                </div>
              </div>
              <div class="tab-pane" id="reg-org">
                <div class="control-group">
                  <label class="control-label" for="orgName">组织全名</label>
                  <div class="controls">
                    <input type="text" name="orgName" id="orgName">
                  </div>
                </div>
              </div>
              <div class="tab-pane" id="reg-chr">
                <div class="control-group">
                  <label class="control-label" for="chrName">组织全名</label>
                  <div class="controls">
                    <input type="text" name="chrName" id="chrName">
                  </div>
                </div>
              </div>
              <div class="tab-pane" id="reg-com">
                <div class="control-group">
                  <label class="control-label" for="comName">公司全名</label>
                  <div class="controls">
                    <input type="text" name="comName" id="comName">
                  </div>
                </div>
              </div>
  			</div>
        <ul class="nav nav-tabs">
              <li class="active"><a href="#reg-stu" data-toggle="tab">学生</a></li>
              <li><a href="#reg-org" data-toggle="tab">学生组织</a></li>
              <li><a href="#reg-chr" data-toggle="tab">公益组织</a></li>
              <li><a href="#reg-com" data-toggle="tab">公司</a></li>
        </ul>
			</div>
            <button type="submit" class="btn btn-danger btn-block" id="submit-btn">提交~</button>
		  </form>
          </div><!--/.well -->
        </div><!--/span-->
        
__(include file="$template_content.tpl")__

      </div><!--/row-->

      <hr>

      <footer>
        <p>&copy; 16活动网 2012</p>
      </footer>

    </div><!--/.fluid-container-->

    </div> <!-- /container -->

<div class="modal hide fade" id="modal-findpass">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h3>找回密码</h3>
  </div>
  <div class="modal-body">
  <form id="forget-form" class="form-horizontal">
    <div class="control-group">
      <label class="control-label" for="findUsername">用户名</label>
      <div class="controls">
        <input type="text" id="findUsername">
      </div>
    </div>
    <div class="control-group">
      <label class="control-label" for="findEmail">注册邮箱</label>
      <div class="controls">
        <input type="text" name="email" id="findEmail">
      </div>
    </div>
  </form>
  <div class="alert alert-success">我们已经向你的注册邮箱中发送了一封邮件；请点击邮件中的链接来重新设置密码。</div>
  </div>
  <div class="modal-footer">
    <a class="btn" data-dismiss="modal" aria-hidden="true">取消</a>
    <a href="#" class="btn btn-primary">提交</a>
  </div>
</div>

    <script src="__($config.template_prefix)__asset/js/jquery.min.js"></script>
    <script src="__($config.template_prefix)__asset/js/jquery.validate.min.js"></script>
    <script src="__($config.template_prefix)__asset/js/bootstrap.min.js"></script>
    <script>
    $( function() {
      $('.typeahead').typeahead();
      $('#reg-form').validate({
      rules: {
        username: {
          minlength: 6,
          required: true
        },
        password: {
          minlength: 6,
          required: true
        },
        password2: {
          equalTo: "#password",
          required: true
        },
        email: {
          email: true,
          required: true
        },
        name: {
          minlength: 2,
          maxlength: 6,
          required: true
        }
      },
      highlight: function(label) {
        $(label).closest('.control-group').addClass('error');
      },
      success: function(label) {
        label
          .text('OK!').addClass('valid')
          .closest('.control-group').addClass('success');
      } });
    });
    </script>

  </body>
</html>
