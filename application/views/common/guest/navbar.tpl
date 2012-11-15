<div class="navbar navbar-inverse navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container">
          <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </a>
          <a class="brand" href="{'index'|site_url}"><img alt="16活动网" src="{$config.asset}/img/banner_logo.png"></a>
          <div class="nav-collapse collapse">
            <a class="navbar-highlight" id="navbar-demo" href="{'welcome/demo'|site_url}">随便看看</a>
            <a class="navbar-highlight" id="navbar-contact" href="{'contact'|site_url}">联系我们</a>
            <form class="navbar-form pull-right" id="navbar-login" action="{'login/loginSubmit'|site_url}" method="post">
              <input class="span2" type="text" placeholder="用户名/邮箱" id="loginUsername" name="account">
              <input class="span2" type="password" placeholder="密码" id="loginPassword" name="password">
              <input type="hidden" name="ref" value="{$ref}">
              <button type="submit" class="btn btn-primary">登录</button>
              <div id="navbar-login-tools">
                <span class="navbar-login-item navbar-login-remember"><input type="checkbox" id="loginRemember" name="member_cookie" value="Y"><a href="#" id="remember-me-anchor">记住我</a></span>
                <span class="navbar-login-item navbar-login-forget" data-toggle="modal" data-target="#modal-findpass"><a href="#">忘记密码</a></span>
              </div>
            </form>
          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>
<div class="modal hide fade" id="modal-findpass">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h3>找回密码</h3>
  </div>
  <div class="modal-body">
  <form id="forget-form" class="form-horizontal" action="{'findpass/findPassSubmit'|site_url}" method="post">
    <div class="control-group">
      <label class="control-label" for="findUsername">用户名</label>
      <div class="controls">
        <input type="text" id="findUsername" name="findUsername">
      </div>
    </div>
    <div class="control-group">
      <label class="control-label" for="findEmail">注册邮箱</label>
      <div class="controls">
        <input type="text" id="findEmail" name="findEmail">
      </div>
    </div>
    <div class="modal-footer">
      <a class="btn" data-dismiss="modal" aria-hidden="true">取消</a>
      <button type="submit" class="btn btn-primary">提交</button>
    </div>

  </form>
  </div>
</div>