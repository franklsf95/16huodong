<div class="span3">
          <div class="affix sidebar">
            <ul class="nav nav-stacked nav-pills">
              <img src="__($current_member_information.member_image)__" class="img-polaroid portrait">
              <h4 class="my_name">__($current_member_information.member_name)__</h4>
              <h5 class="my_school">__($current_member_information.current_school_name)__</h5>
              <li><a href="__('my_page/edit'|site_url)__">编辑__(if $current_member_information.member_type == 'student')__个人__(elseif $current_member_information.member_type == 'company')__公司__(else)__组织__(/if)__资料</a></li>
              <li><a href="__('activity/edit'|site_url)__">发起新活动</a></li>
              <li><a href="add_book.html">写新书</a></li>
              <li><a href="__('friend'|site_url)__">我的好友</a></li>
              <li><a href="__('message'|site_url)__">站内信</a></li>
              <li><a href="__('login/logout'|site_url)__">登出</a></li>
              <li class="nav-header">系统消息</li>
              <li><a href="#">Link</a></li>
              <li><a href="#">Link</a></li>
              <li><a href="#">Link</a></li>
            </ul>
          </div><!--/.sidebar -->
        </div><!--/span-->