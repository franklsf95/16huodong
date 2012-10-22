<div class="span9"><div class="activity-container"><div class="content-heading">__($activity_information.activity_name)__ - 活动详情</div><div class="well activity-image-wrapper span2">  <img src="__($activity_information.activity_image)__" class="polaroid activity-image"></div><div class="activity-wrapper span3">  <div class="activity-item"><i class="icon-calendar"></i>开始时间: __($activity_information.start_time)__</div>  <div class="activity-item"><i class="icon-home"></i>活动类型: __($activity_information.activity_type)__</div>  <div class="activity-item"><i class="icon-home"></i>地点: __($activity_information.activity_address)__</div>  <div class="activity-item"><i class="icon-home"></i>关注人数: __($activity_information.all_activity_attention_member_information|@count)__</div>  <div class="activity-item rate-wrapper">    <span class="badge badge-rate"><a href="__('activity/rate1?id='|site_url)____($activity_information.activity_id)__"><i>+ __($rate1)__</i></a></span>    <span class="badge badge-rate"><a href="__('activity/rate2?id='|site_url)____($activity_information.activity_id)__"><i>- __($rate2)__</i></a></span>  </div></div><div class="activity-wrapper span3">  <div class="activity-item"><i class="icon-calendar"></i>结束时间: __($activity_information.end_time)__</div>  <div class="activity-item"><i class="icon-home"></i>费用: ￥__($activity_information.activity_price)__</div>  <div class="activity-item"><i class="icon-home"></i>发起人: <a href="__('member'|site_url)__?id=__($activity_information.member_id)__">__($activity_information.member_name)__</a></div>  <div class="activity-item"><i class="icon-home"></i>参加人数: __($activity_information.all_activity_attend_member_information|@count)__</div></div><div class="description-wrapper span6">	<p>__($activity_information.activity_description|default:"$ 一句话也不说 $")__</p></div><div class="toolbox btn-group span6">__(if ($smarty.now < (($activity_information.end_time|strtotime)+(3600*24))) )__    <div class="btn btn-primary" onclick="followActivity('__($activity_information.activity_id)__')">__(if $activity_information.is_attention == 'Y')__取消关注__(else)__我要关注__(/if)__</div>    <div class="btn btn-primary" onclick="attendActivity('__($activity_information.activity_id)__')">__(if $activity_information.is_attend == 'Y')__取消报名__(else)__我要参加__(/if)__</div>__(else)__    <div class="btn btn-primary" disabled>活动已结束</div>__(/if)__</div></div><!--/activity-container--><div class="clear"></div><div class="content-heading">详细介绍</div><div id="activity-content-container">__($activity_information.activity_content)__</div><div class="content-heading">留言问答</div><div class="view_activity_comment" id="view_activity_comment">          <ul>          __(foreach name=all_activity_comment_information from=$activity_information.all_activity_comment_information item=activity_comment_information)__            <li>              <div class="activity_comment_box">                <div class="member_image" style="float:left;"><img src="__($activity_comment_information.member_image)__" height="40" width="40" /></div>                <div class="content">                  <div id="activity_comment___($activity_comment_information.activity_comment_id)__">                    <p class="comment"><a href="__('member'|site_url)__?id=__($activity_comment_information.member_id)__" class="member_name">__($activity_comment_information.member_name)__</a>:  __($activity_comment_information.content)__</p>                    __(if $activity_comment_information.reply != '')__                    <p class="reply">发布者:__($activity_comment_information.reply)__</p>                    __(/if)__                  </div>                  <div class="clear"></div>                </div>              </div>              <div class="clear"></div>            </li>          __(/foreach)__          </ul>          __(if $page_information.last_page != 0)__          <div class="ajax_pagination">            <a href="#" class="first" data-action="first">&laquo;</a>            <a href="#" class="previous" data-action="previous">&lsaquo;</a>            <input type="text" readonly="readonly" data-max-page="__($page_information.last_page)__" />            <a href="#" class="next" data-action="next">&rsaquo;</a>            <a href="#" class="last" data-action="last">&raquo;</a>          </div>          __(/if)__          <div class="clear"></div>        </div>                <div class="add_activity_comment">          <form action="__('activity/save_comment'|site_url)__" method="post" onsubmit="return false;">            <p><textarea id="activity_comment" name="activity_comment"></textarea></p>            <p><input type="hidden" id="activity_id" name="activity_id" value="__($activity_information.activity_id)__" /></p>            <p><button type="submit" class="submit" id="addActivityComment" >发表</button></p>          </form>        </div>        </div><!--/span-->