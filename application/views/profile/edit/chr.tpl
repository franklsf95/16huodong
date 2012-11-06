<legend>编辑组织资料</legend>  <div class="control-group">    <label class="control-label" for="inputUsername">用户名</label>    <div class="controls">      <input type="text" id="inputUsername" disabled value="{$current_member_information.account}">    </div>  </div>  <div class="control-group">    <label class="control-label" for="inputName">组织全名</label>    <div class="controls">      <input type="text" id="inputName" value="{$current_member_information.member_name}" name="name">    </div>  </div>  <div class="control-group">    <label class="control-label" for="inputPrincipal">负责人姓名</label>    <div class="controls">      <input type="text" id="inputPrincipal" value="{$current_member_information.principal}" name="principal">    </div>  </div>  <div class="control-group">    <label class="control-label" for="inputEmail">E-mail</label>    <div class="controls">      <input type="text" id="inputEmail" value="{$current_member_information.member_email}" name="email">    </div>  </div>  <div class="control-group">    <label class="control-label" for="inputTel">联系电话</label>    <div class="controls">      <input type="text" id="inputTel" value="{$current_member_information.member_phone}" name="phone">    </div>  </div>  <div class="control-group">    <label class="control-label" for="inputQQ">QQ号</label>    <div class="controls">      <input type="text" id="inputQQ" value="{$current_member_information.member_qq}" name="qq">    </div>  </div>  <div class="control-group">    <label class="control-label" for="inputAddress">地址</label>    <div class="controls">      <input type="text" class="span6" id="inputAddress" value="{$current_member_information.member_address}" name="address">    </div>  </div>  <div class="control-group">    <label class="control-label" for="inputTag">标签</label>    <div class="controls">      <input type="text" class="span6" id="inputTag" value="{$current_member_information.member_tag}" name="tag">    </div>  </div>  <div class="control-group">    <label class="control-label" for="memberTag">组织标签</label>    <div class="controls">      <div class="tag-list">{foreach $current_member_information.tags as $tag}<span class="badge tag tag-edit" onclick="$(this).remove()">{$tag}<input type="hidden" name="tag[]" value="{$tag}" /></span>{/foreach}</div>      <div id="tag-add"><input type="text" id="memberTag" placeholder="推荐标签: 公益,慈善" /><span class="badge" id="badge-add-tag"><a href="#">+</a></span></div>    </div>  </div>  <div class="control-group">    <label class="control-label" for="inputProfile">关于我</label>    <div class="controls">      <textarea rows=3 class="span6" id="inputProfile" name="description">{$current_member_information.member_description}</textarea>    </div>  </div>  <div class="control-group">    <label class="control-label" for="inputProfile">详细介绍页面</label>    <div class="controls">      <textarea rows=10 class="span6 richtext" id="inputProfile" placeholder="详细的组织介绍可使同学们更信任主办方，增加活动参与度~" name="content">{$current_member_information.content}</textarea>    </div>  </div>  <div class="well portrait-wrapper offset5">    <div class="portrait-thumbnail"><img id="portrait-view" src="{$current_member_information.member_image}" alt="portrait-preview" /></div>    <div style="padding-top: 10px">      <span class="btn btn-file portrait-upload">更换头像</span>      <input type="hidden" id="portrait-url" name="image" value="{$current_member_information.member_image}">    </div>  </div>