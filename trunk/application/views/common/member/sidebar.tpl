          <div class="sidebar">
            <img src="{$current_member_information.member_image}" class="img-polaroid portrait" alt="{$current_member_information.member_name}">
            <h4 id="my_name">{$current_member_information.member_name}</h4>
            <h5 id="my_school">{$current_member_information.school_name}</h5>
            <ul class="nav nav-list nav-stacked nav-pills">
              <li id="sidebar-edit-profile"><a href="{'profile/edit'|site_url}"><i class="icon-edit"></i> 编辑{if $current_member_information.member_type == 'stu'}个人{elseif $current_member_information.member_type == 'com'}公司{else}组织{/if}资料</a></li>
              <li id="sidebar-new-activity"><a href="{'activity/edit'|site_url}"><i class="icon-flag"></i> 发起新活动</a></li>
              <li id="sidebar-new-book"><a href="{'library/edit'|site_url}"><i class="icon-pencil"></i> 写新书</a></li>
              <li class="divider"></li>
              <li id="sidebar-my-activities"><a href="{'profile/history/p'|site_url}"><i class="icon-th-list"></i> 我发起的活动</a></li>
              <li id="sidebar-my-library"><a href="{'library/profile'|site_url}"><i class="icon-th"></i> 我的图书馆</a></li>
              <li id="sidebar-friend"><a href="{'friend'|site_url}"><i class="icon-user"></i> 我的好友</a></li>
              {if $all_system_message_notice|@count}
                <li class="dropdown-submenu active" id="sidebar-message">
                  <a href="{'message'|site_url}"><i class="icon-envelope"></i> 新消息</a>
                  <ul class="dropdown-menu">
                    {foreach $all_system_message_notice as $i}
                    <li><a href="{'message'|site_url}">
                    {if $i.type == 'activity'}{$i.count}个新的活动通知
                    {elseif $i.type == 'friend'}{$i.count}个新的好友通知
                    {elseif $i.type == 'book'}{$i.count}个新的微型书通知
                    {elseif $i.type == 'member_message'}{$i.count}条新的站内信
                    {/if}
                    </a></li>
                    {/foreach}
                  </ul>
                </li>
              {else}
              <li id="sidebar-message"><a href="{'message'|site_url}"><i class="icon-envelope"></i> 消息中心</a></li>
              {/if}
              <li class="divider"></li>
              <li id="sidebar-logout"><a href="{'login/logout'|site_url}"><i class="icon-off"></i> 登出</a></li>
            </ul>
          </div><!--/.sidebar -->