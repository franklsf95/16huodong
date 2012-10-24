          <div class="affix sidebar">
            <img src="__($current_member_information.member_image)__" class="img-polaroid portrait" alt="__($current_member_information.member_name)__">
            <h4 class="my_name">__($current_member_information.member_name)__</h4>
            <h5 class="my_school">__($current_member_information.current_school_name)__</h5>
            <ul class="nav nav-stacked nav-pills">
              <li id="sidebar-edit-profile"><a href="__('profile/edit'|site_url)__"><i class="icon-edit"></i> 编辑__(if $current_member_information.member_type == 'student')__个人__(elseif $current_member_information.member_type == 'company')__公司__(else)__组织__(/if)__资料</a></li>
              <li id="sidebar-new-activity"><a href="__('activity/edit'|site_url)__"><i class="icon-flag"></i> 发起新活动</a></li>
              <li id="sidebar-my-library"><a href="__('library/profile'|site_url)__"><i class="icon-th"></i> 我的图书馆</a></li>
              <li id="sidebar-new-book"><a href="__('library/edit'|site_url)__"><i class="icon-pencil"></i> 写新书</a></li>
              <li id="sidebar-friend"><a href="__('friend'|site_url)__"><i class="icon-user"></i> 我的好友</a></li>
              <li id="sidebar-message"><a href="__('message'|site_url)__"><i class="icon-envelope"></i> 站内信</a></li>
              <li id="sidebar-logout"><a href="__('login/logout'|site_url)__"><i class="icon-off"></i> 登出</a></li>
              __(if $all_system_message_count)__
              <li class="nav-header">你有新消息~</li>
              __(foreach $all_system_message_count as $i)__
                __(if ($i.type == 'activity'))__
                <li class="active"><a href="__('message'|site_url)__#tabs-2">__($i.count)__个新的活动通知</a></li>
                __(elseif ($i.type == 'friend'))__
                <li class="active"><a href="__('message'|site_url)__#tabs-2">__($i.count)__个新的好友通知</a></li>
                __(elseif ($i.type == 'blog'))__
                <li class="active"><a href="__('message'|site_url)__#tabs-2">__($i.count)__个新的日志通知</a></li>
                __(elseif ($i.type == 'member_message'))__
                <li class="active"><a href="__('message'|site_url)__">__($i.count)__条新的站内信</a></li>
                __(/if)__
              __(/foreach)__
              __(/if)__
            </ul>
          </div><!--/.sidebar -->