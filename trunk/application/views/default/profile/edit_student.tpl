<form class="form-horizontal" id="profile-form" action="__('profile/save_form'|site_url)__" method="post"><fieldset><legend>编辑个人资料</legend>  <div class="control-group">    <label class="control-label" for="inputUsername">用户名</label>    <div class="controls">      <input type="text" id="inputUsername" disabled value="__($member_information.member_account)__">    </div>  </div>  <div class="control-group">    <label class="control-label" for="inputSchool">学校</label>    <div class="controls">      <input type="text" id="inputSchool" disabled value="__($member_information.school_name)__">    </div>  </div>  <div class="control-group">    <label class="control-label" for="inputName">真实姓名</label>    <div class="controls">      <input type="text" id="inputName" value="__($member_information.member_name)__" name="name">    </div>  </div>  <div class="control-group">    <label class="control-label" for="inputGenderM">性别</label>    <div class="controls">      <label class="radio inline">        <input type="radio" id="inputGenderM" name="gender" value="M" __(if $member_information.member_gender == 'M')__checked="checked"__(/if)__> 男      </label>      <label class="radio inline">        <input type="radio" id="inputGenderF" name="gender" value="F" __(if $member_information.member_gender == 'F')__checked="checked"__(/if)__> 女      </label>    </div>  </div>  <div class="control-group">    <label class="control-label" for="inputBirthday">生日</label>    <div class="controls">      <input type="text" class="datepicker" value="__($member_information.member_birthday)__" id="inputBirthday" name="birthday">    </div>  </div>  <div class="control-group">    <label class="control-label" for="inputEmail">E-mail</label>    <div class="controls">      <input type="text" id="inputEmail" value="__($member_information.member_email)__" name="email">    </div>  </div>  <div class="control-group">    <label class="control-label" for="inputTel">联系电话</label>    <div class="controls">      <input type="text" id="inputTel" value="__($member_information.member_phone)__" name="phone">    </div>  </div>  <div class="control-group">    <label class="control-label" for="inputQQ">QQ号</label>    <div class="controls">      <input type="text" id="inputQQ" value="__($member_information.member_qq)__" name="qq">    </div>  </div>  <div class="control-group">    <label class="control-label" for="inputOrg">组织</label>    <div class="controls">      <input type="text" class="span6"  id="inputOrg" value="__($member_information.member_organisation)__" name="organisation">    </div>  </div>  <div class="control-group">    <label class="control-label" for="inputTitle">职位</label>    <div class="controls">      <input type="text" class="span6" id="inputTitle" value="__($member_information.member_title)__" name="title">    </div>  </div>  <div class="control-group">    <label class="control-label" for="inputAddress">地址</label>    <div class="controls">      <input type="text" class="span6" id="inputAddress" value="__($member_information.member_address)__" name="address">    </div>  </div>  <div class="control-group">    <label class="control-label" for="inputTag">标签</label>    <div class="controls">      <input type="text" class="span6" id="inputTag" value="__($member_information.member_tag)__" name="tag">    </div>  </div>  <div class="control-group">    <label class="control-label" for="inputProfile">关于我</label>    <div class="controls">      <textarea rows=5 class="span6" id="inputProfile" placeholder="这里的个人简介可以帮助主办方更了解你哦~" name="description">__($member_information.member_description)__</textarea>    </div>  </div>  <div class="well portrait-wrapper offset5">    <div class="portrait-thumbnail"><img id="portrait-view" src="__($member_information.member_image)__" alt="portrait-preview" /></div>    <div style="padding-top: 10px">      <span class="btn btn-file portrait-upload">更换头像</span>      <input type="hidden" id="portrait-url" name="image" value="__($member_information.member_image)__">    </div>  </div>  <div class="accordion" id="accordion2">  <div class="accordion-group">    <div class="accordion-heading">      <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseOne">修改密码...</a>    </div>    <div id="collapseOne" class="accordion-body collapse">      <div class="accordion-inner">                <div class="control-group">          <label class="control-label" for="inputPassword">原密码</label>          <div class="controls">            <input type="password" id="inputPassword" name="old_password">          </div>        </div>        <div class="control-group">          <label class="control-label" for="inputNewPassword">新密码</label>          <div class="controls">            <input type="password" id="inputNewPassword" name="new_password">          </div>        </div>        <div class="control-group">          <label class="control-label" for="inputNewPassword2">重复新密码</label>          <div class="controls">            <input type="password" id="inputNewPassword2" name="repeat_password">          </div>        </div>      </div><!--/accordion-inner-->    </div><!--/collapseOne-->  </div><!--/accordion-group-->  </div><!--/accordion-->    <div class="form-actions">  <button type="submit" class="btn btn-primary">保存修改</button>  <button type="button" class="btn">返回</button>  </div></fieldset></form>