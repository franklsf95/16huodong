<script src="{$config.asset}/js/jquery.masonry.min.js"></script><script src="{$config.asset}/js/waterfall.js"></script><script>var member_id = '{$member_information.member_id}';var current_id = 0;var Type = 'publish';$( function(){  {if $is_me}    $("#navbar-profile").addClass("active");  {/if}  showActivities();});$(window).scroll(function() {  var top = document.documentElement.scrollTop + document.body.scrollTop;  var bodyheight = $(document).height();  if (bodyheight - top - $(window).height() <= 100) {    showActivities();  }});$('.nav-tabs li').click( function() {  $('.nav-tabs li').removeClass('active');  $(this).addClass('active');  Type = $(this).attr('id');  resetWaterfall();  showActivities();});$('#add-friend-first').tooltip({  title : '只有好友才可以留言~',  placement: 'bottom',  trigger: 'hover'});function showActivities() {  updateWaterfall( "{'profile/ajaxGetCurrent"+Type+"Activity'|site_url}", wrapActivity );}function toggleFriend(target_id, deny){    $.getJSON("{'friend/ajaxToggleFriend'|site_url}?target_id="+target_id+"&deny="+deny,function(data) {      if( !data ) {        alert('Operation failed.');      } else {        window.location.reload();      }    });}</script>