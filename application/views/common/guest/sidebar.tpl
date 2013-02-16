          <div class="well sidebar-reg">
          <form id="reg-form" class="form-horizontal" action="{'welcome/register'|site_url}" method="post">
            <fieldset>
              <legend>加入16活动网~</legend>
              <div class="control-group">
                <label class="control-label" for="username">用户名</label>
                <div class="controls">
                  <input type="text" name="username" id="username" placeholder="英文、数字或下划线，用于登录">
                </div>
              </div>
              <div class="control-group">
                <label class="control-label" for="password">密码</label>
                <div class="controls">
                  <input type="password" name="password" id="password" placeholder="至少6位">
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
          <input type="hidden" name="member_type" value="stu" id="input-type">
              <div class="tab-pane active" id="reg-stu">
                <div class="control-group">
                  <label class="control-label" for="name">昵称</label>
                  <div class="controls">
                    <input type="text" name="stu-name" id="name" placeholder="显示给大家的名字~">
                  </div>
                </div>
                <div class="control-group">
                <label class="control-label" for="select-province-1">城市</label>
                <div class="controls">
                  <select id="select-province-1" class="span1" onchange="initializeArea()" name="city1" style="width: 70px">
                    <option value="20">上海</option>
                    <option value="1">北京</option>
                  </select>
                  <select id="select-area-1" class="area-list" style="width: 100px" name="area1">
                    <option></option>
                  </select>
                </div>
              </div>
                <div class="control-group">
                  <label class="control-label" for="select-school-1">学校</label>
                  <div class="controls">
                    <input type="text" class="typeahead" id="select-school-1" name="stu-school" data-provide="typeahead" placeholder="输入中有下拉提示~">
                    <input type="hidden" id="input-school-id" name="school_id">
                  </div>
                </div>
              </div>
              <div class="tab-pane" id="reg-org">
                <div class="control-group">
                  <label class="control-label" for="orgName">组织全名</label>
                  <div class="controls">
                    <input type="text" name="org-name" id="orgName">
                  </div>
                </div>
                <div class="control-group">
                <label class="control-label" for="select-province-2">城市</label>
                <div class="controls">
                  <select id="select-province-2" class="span1" onchange="initializeArea2()" name="city2">
                    <option value="20">上海</option>
                    <option value="1">北京</option>
                  </select>
                  <select id="select-area-2" class="area-list" style="width: 100px" name="area2">
                    <option></option>
                  </select>
                </div>
              </div>
                <div class="control-group">
                  <label class="control-label" for="select-school-2">学校</label>
                  <div class="controls">
                    <input type="text" class="typeahead" id="select-school-2" name="org-school" data-provide="typeahead" placeholder="输入中有下拉提示~">
                  </div>
                </div>
              </div>
              <div class="tab-pane" id="reg-chr">
                <div class="control-group">
                  <label class="control-label" for="chrName">组织全名</label>
                  <div class="controls">
                    <input type="text" name="chr-name" id="chrName">
                  </div>
                </div>
              </div>
              <div class="tab-pane" id="reg-com">
                <div class="control-group">
                  <label class="control-label" for="comName">公司全名</label>
                  <div class="controls">
                    <input type="text" name="com-name" id="comName" placeholder="与公益组织相同，暂不启用">
                  </div>
                </div>
              </div>
        </div>
      </div>
            <button type="submit" class="btn btn-primary btn-block" id="submit-btn">注册!</button>
      </fieldset>
      </form>
          </div><!--/.well -->