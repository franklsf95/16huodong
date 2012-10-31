	<h3>找回密码</h3>
	<hr>
<form class="form-horizontal" action="{'findpass/resetPassSubmit'|site_url}?vcode={$vcode}" method="post">
  <div class="control-group">
    <label class="control-label" for="password">输入新密码</label>
    <div class="controls">
      <input type="password" id="password" name="password">
    </div>
  </div>
  <div class="control-group">
    <label class="control-label" for="password2">确认新密码</label>
    <div class="controls">
      <input type="password" id="password2" name="password">
    </div>
  </div>
  <button type="submit" class="btn btn-primary offset1">修改密码</button>
</form>
	<p><code>STEP 2 of 3</code></p>
	<div class="progress progress-striped">
  		<div class="bar" style="width: 67%;"></div>
	</div>