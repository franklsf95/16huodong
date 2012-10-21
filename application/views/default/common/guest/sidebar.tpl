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
              <input type="hidden" name="member_type" value="student" id="input-type">
          </ul>
              <div class="tab-pane active" id="reg-stu">
                <div class="control-group">
                  <label class="control-label" for="name">真实姓名</label>
                  <div class="controls">
                    <input type="text" name="name" id="name">
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
                <div class="control-group">
                  <label class="control-label" for="school">学校</label>
                  <div class="controls">
                    <input type="text" class="typeahead" data-provide="typeahead" data-items="4" data-source='["中国人民大学附属中学","北京师范大学附属实验中学","Arizona","Arkansas","California","Colorado","Connecticut","Delaware","Florida","Georgia","Hawaii","Idaho","Illinois","Indiana","Iowa","Kansas","Kentucky","Louisiana","Maine","Maryland","Massachusetts","Michigan","Minnesota","Mississippi","Missouri","Montana","Nebraska","Nevada","New Hampshire","New Jersey","New Mexico","New York","North Dakota","North Carolina","Ohio","Oklahoma","Oregon","Pennsylvania","Rhode Island","South Carolina","South Dakota","Tennessee","Texas","Utah","Vermont","Virginia","Washington","West Virginia","Wisconsin","Wyoming"]'>
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
      </div>
            <button type="submit" class="btn btn-primary btn-block" id="submit-btn">提交~</button>
      </form>
          </div><!--/.well -->
</div><!--/span-->