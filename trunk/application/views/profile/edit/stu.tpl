<legend>编辑个人资料</legend>  <div class="control-group">    <label class="control-label" for="inputUsername">用户名</label>    <div class="controls">      <input type="text" id="inputUsername" disabled value="{$current_member_information.account}">    </div>  </div>  <div class="control-group">    <label class="control-label" for="inputSchool">学校</label>    <div class="controls">      <input type="text" id="inputSchool" disabled value="{$current_member_information.school_name}">    </div>  </div>  <div class="control-group">    <label class="control-label" for="inputName">真实姓名</label>    <div class="controls">      <input type="text" id="inputName" value="{$current_member_information.member_name}" name="name">    </div>  </div>  <div class="control-group">    <label class="control-label" for="inputGenderM">性别</label>    <div class="controls">      <label class="radio inline">        <input type="radio" id="inputGenderM" name="gender" value="M" {if $current_member_information.member_gender == 'M'}checked="checked"{/if}> 男      </label>      <label class="radio inline">        <input type="radio" id="inputGenderF" name="gender" value="F" {if $current_member_information.member_gender == 'F'}checked="checked"{/if}> 女      </label>    </div>  </div>  <div class="control-group">    <label class="control-label" for="inputBirthday">生日</label>    <div class="controls">      <input type="text" class="datepicker" value="{$current_member_information.member_birthday}" id="inputBirthday" name="birthday">    </div>  </div>  <div class="control-group">    <label class="control-label" for="inputEmail">E-mail</label>    <div class="controls">      <input type="text" id="inputEmail" value="{$current_member_information.member_email}" name="email">    </div>  </div>  <div class="control-group">    <label class="control-label" for="inputTel">联系电话</label>    <div class="controls">      <input type="text" id="inputTel" value="{$current_member_information.member_phone}" name="phone">    </div>  </div>  <div class="control-group">    <label class="control-label" for="inputQQ">QQ号</label>    <div class="controls">      <input type="text" id="inputQQ" value="{$current_member_information.member_qq}" name="qq">    </div>  </div>  <div class="control-group">    <label class="control-label" for="inputOrg">组织</label>    <div class="controls">      <input type="text" class="span6"  id="inputOrg" value="{$current_member_information.member_organisation}" name="organisation">    </div>  </div>  <div class="control-group">    <label class="control-label" for="inputTitle">职位</label>    <div class="controls">      <input type="text" class="span6" id="inputTitle" value="{$current_member_information.member_title}" name="title">    </div>  </div>  <div class="control-group">    <label class="control-label" for="inputAddress">家庭地址</label>    <div class="controls">      <input type="text" class="span6" id="inputAddress" value="{$current_member_information.member_address}" name="address">    </div>  </div>  <div class="control-group">    <label class="control-label" for="memberTag">个人标签</label>    <div class="controls">      <div class="tag-list">{foreach $current_member_information.tags as $tag}<span class="badge tag tag-edit" onclick="$(this).remove()">{$tag}<input type="hidden" name="tag[]" value="{$tag}" /></span>{/foreach}</div>      <div id="tag-add"><input type="text" id="memberTag" placeholder="推荐标签: 公益,慈善" /><a class="badge" id="badge-add-tag">+</a></div>    </div>  </div>  <div class="control-group">    <label class="control-label" for="inputProfile">关于我</label>    <div class="controls">      <textarea rows=5 class="span6" id="inputProfile" placeholder="这里的个人简介可以帮助主办方更了解你哦~" name="description">{$current_member_information.member_description}</textarea>      <div class="richtext hidden"></div>    </div>  </div>  <div class="well portrait-wrapper offset5">    <div class="portrait-thumbnail"><img id="portrait-view" src="{$current_member_information.member_image}" alt="portrait-preview" /></div>    <div style="padding-top: 10px">      <span class="btn btn-file portrait-upload">更换头像</span>      <input type="hidden" id="portrait-url" name="image" value="{$current_member_information.member_image}">    </div>  </div>