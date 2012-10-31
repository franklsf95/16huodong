          <div class="affix sidebar">
            <img src="{$current_member_information.member_image}" class="img-polaroid portrait" alt="{$current_member_information.member_name}">
            <h4 class="my_name">{$current_member_information.member_name}</h4>
            <h5 class="my_school">{$current_member_information.current_school_name}</h5>
            <ul class="nav nav-stacked nav-pills">
              <li id="sidebar-edit-profile"><a href="{'profile/edit'|site_url}"><i class="icon-edit"></i> 编辑{if $current_member_information.member_type == 'student'}个人{elseif $current_member_information.member_type == 'company'}公司{else}组织{/if}资料</a></li>
              <li id="sidebar-new-activity"><a href="{'activity/edit'|site_url}"><i class="icon-flag"></i> 发起新活动</a></li>
              <li id="sidebar-my-library"><a href="{'library/profile'|site_url}"><i class="icon-th"></i> 我的图书馆</a></li>
              <li id="sidebar-new-book"><a href="{'library/edit'|site_url}"><i class="icon-pencil"></i> 写新书</a></li>
              <li id="sidebar-friend"><a href="{'friend'|site_url}"><i class="icon-user"></i> 我的好友</a></li>
              <li id="sidebar-message"><a href="{'message'|site_url}"><i class="icon-envelope"></i> 站内信</a></li>
              <li id="sidebar-logout"><a href="{'login/logout'|site_url}"><i class="icon-off"></i> 登出</a></li>
              {if $all_system_message_count}
              <li class="nav-header">你有新消息~</li>
              {foreach $all_system_message_count as $i}
                {if ($i.type == 'activity')}
                <li class="active"><a href="{'message'|site_url}#tabs-2">{$i.count}个新的活动通知</a></li>
                {elseif ($i.type == 'friend')}
                <li class="active"><a href="{'message'|site_url}#tabs-2">{$i.count}个新的好友通知</a></li>
                {elseif ($i.type == 'blog')}
                <li class="active"><a href="{'message'|site_url}#tabs-2">{$i.count}个新的日志通知</a></li>
                {elseif ($i.type == 'member_message')}
                <li class="active"><a href="{'message'|site_url}">{$i.count}条新的站内信</a></li>
                {/if}
              {/foreach}
              {/if}
            </ul>
          </div><!--/.sidebar -->