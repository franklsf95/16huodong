<div class="span4">
          <div class="well sidebar-reg">
          <form id="reg-form" class="form-horizontal" action="__('register/saveForm'|site_url)__" method="post">
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
      <div class="tabbable" id="reg-fields">
        <div class="tab-content">
          <ul class="nav nav-tabs">
              <li class="active"><a href="#reg-stu" data-toggle="tab" id="tab-stu">学生</a></li>
              <li><a href="#reg-org" data-toggle="tab" id="tab-org">学生组织</a></li>
              <li><a href="#reg-chr" data-toggle="tab" id="tab-chr">公益组织</a></li>
              <li><a href="#reg-com" data-toggle="tab" id="tab-com">公司</a></li>
          </ul>
          <input type="hidden" name="member_type" value="student" id="input-type">
              <div class="tab-pane active" id="reg-stu">
                <div class="control-group">
                  <label class="control-label" for="name">真实姓名</label>
                  <div class="controls">
                    <input type="text" name="student-name" id="name">
                  </div>
                </div>
                <div class="control-group">
                <label class="control-label" for="select-province-1">城市</label>
                <div class="controls">
                  <select id="select-province-1" class="span1">
                    <option>北京</option>
                    <option>其他</option>
                  </select>
                  <select id="select-area-1" class="area-list" style="width: 100px">
                    <option></option>
                  </select>
                </div>
              </div>
                <div class="control-group">
                  <label class="control-label" for="select-school-1">学校</label>
                  <div class="controls">
                    <input type="text" class="typeahead" id="select-school-1" data-provide="typeahead" placeholder="输入中有下拉提示~">
                    <input type="hidden" id="input-school-id" name="current_school_id">
                  </div>
                </div>
              </div>
              <div class="tab-pane" id="reg-org">
                <div class="control-group">
                  <label class="control-label" for="orgName">组织全名</label>
                  <div class="controls">
                    <input type="text" name="student_organization-name" id="orgName">
                  </div>
                </div>
                <div class="control-group">
                <label class="control-label" for="select-province-2">城市</label>
                <div class="controls">
                  <select id="select-province-2" class="span1">
                    <option>北京</option>
                    <option>其他</option>
                  </select>
                  <select id="select-area-2" class="area-list" style="width: 100px">
                    <option></option>
                  </select>
                </div>
              </div>
                <div class="control-group">
                  <label class="control-label" for="select-school-2">学校</label>
                  <div class="controls">
                    <input type="text" class="typeahead" id="select-school-2" data-provide="typeahead" placeholder="输入中有下拉提示~">
                  </div>
                </div>
              </div>
              <div class="tab-pane" id="reg-chr">
                <div class="control-group">
                  <label class="control-label" for="chrName">组织全名</label>
                  <div class="controls">
                    <input type="text" name="commonweal_organization-name" id="chrName">
                  </div>
                </div>
              </div>
              <div class="tab-pane" id="reg-com">
                <div class="control-group">
                  <label class="control-label" for="comName">公司全名</label>
                  <div class="controls">
                    <input type="text" name="company-name" id="comName">
                  </div>
                </div>
              </div>
        </div>
      </div>
            <button type="submit" class="btn btn-primary btn-block" id="submit-btn">提交~</button>
      </fieldset>
      </form>
          </div><!--/.well -->
</div><!--/span-->