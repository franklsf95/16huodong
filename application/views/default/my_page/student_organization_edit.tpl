<div class="span9"><form class="form-horizontal" action="__('my_page/save_form'|site_url)__" method="post"><legend>编辑个人资料</legend>  <div class="control-group">    <label class="control-label" for="inputUsername">用户名</label>    <div class="controls">      <input type="text" id="inputUsername" disabled value="__($member_information.member_account)__">    </div>  </div>  <div class="control-group">    <label class="control-label" for="inputSchool">学校</label>    <div class="controls">      <input type="text" id="inputSchool" disabled value="__($member_information.current_school_name)__">    </div>  </div>  <div class="control-group">    <label class="control-label" for="inputName">组织全名</label>    <div class="controls">      <input type="text" id="inputName" value="__($member_information.member_name)__" name="name">    </div>  </div>  <div class="control-group">    <label class="control-label" for="inputName">负责人</label>    <div class="controls">      <input type="text" id="inputName" value="__($member_information.principal)__" name="principal">    </div>  </div>  <div class="control-group">    <label class="control-label" for="inputTitle">职位</label>    <div class="controls">      <input type="text" id="inputTitle" value="__($member_information.member_title)__" name="title">    </div>  </div>  <div class="control-group">    <label class="control-label" for="inputEmail">E-mail</label>    <div class="controls">      <input type="text" id="inputEmail" value="__($member_information.member_email)__" name="email">    </div>  </div>  <div class="control-group">    <label class="control-label" for="inputTel">联系电话</label>    <div class="controls">      <input type="text" id="inputTell" value="__($member_information.member_phone)__" name="phone">    </div>  </div>  <div class="control-group">    <label class="control-label" for="inputQQ">QQ号</label>    <div class="controls">      <input type="text" id="inputQQ" value="__($member_information.member_qq)__" name="qq">    </div>  </div>  <div class="control-group">    <label class="control-label" for="inputAddress">地址</label>    <div class="controls">      <input type="text" class="span6" id="inputAddress" value="__($member_information.member_address)__" name="address">    </div>  </div>  <div class="control-group">    <label class="control-label" for="inputTag">标签</label>    <div class="controls">      <input type="text" class="span6" id="inputTag" value="__($member_information.member_tag)__" name="tag">    </div>  </div>  <div class="control-group">    <label class="control-label" for="inputProfile">关于本组织</label>    <div class="controls">      <textarea rows=5 class="span6" id="inputProfile" placeholder="这里的组织简介可以帮助活动参与者了解你~" name="description">__($member_information.member_description)__</textarea>    </div>  </div>  <div class="accordion" id="accordion2">  <div class="accordion-group">    <div class="accordion-heading">      <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseOne">修改密码...</a>    </div>    <div id="collapseOne" class="accordion-body collapse">      <div class="accordion-inner">          <div class="control-group">    <label class="control-label" for="inputPassword">原密码</label>    <div class="controls">      <input type="password" id="inputPassword" name="old_password">    </div>  </div>  <div class="control-group">    <label class="control-label" for="inputNewPassword">新密码</label>    <div class="controls">      <input type="password" id="inputNewPassword" name="new_password">    </div>  </div>  <div class="control-group">    <label class="control-label" for="inputNewPassword2">重复新密码</label>    <div class="controls">      <input type="password" id="inputNewPassword2" name="repeat_password">    </div>  </div>      </div>    </div>  </div>    <div class="form-actions">  <button type="submit" class="btn btn-primary">保存修改</button>  <button type="button" class="btn">返回</button>  </div></form><div class="well portrait-wrapper offset5">  <img src="__($member_information.member_image)__" class="polaroid portrait-preview">  <div class="fileupload fileupload-new" data-provides="fileupload">  <span class="btn btn-file"><span class="fileupload-new">上传新头像</span><span class="fileupload-exists">修改已上传头像</span><input type="file" /></span>  <span class="fileupload-preview"></span>  <a href="#" class="close fileupload-exists" data-dismiss="fileupload" style="float: none">×</a>  </div></div></div><!--/span-->