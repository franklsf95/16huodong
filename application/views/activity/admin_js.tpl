<script>function handleActivityAttend(activity_attend_id,action,member_id) {    $.getJSON('{"activity/handle_activity_attend"|site_url}',{ activity_attend_id:activity_attend_id,action:action },function(data) {      if( data.status ) { //success        if( action ) {          message = '已通过 ID='+member_id+' 的申请';          $("#row-"+activity_attend_id+" .tool").html('已通过申请');        } else {          message = '已拒绝 ID='+member_id+' 的申请';          $("#row-"+activity_attend_id).fadeOut("slow",function(){            $("#row-"+activity_attend_id).remove();          });        }      } else {        message = 'Operation failed.';      }      alert( message );    });}$('.form-submit').click(function() {  $('#message-compose-form').submit();})$(document).ready(function () {$('.intro').tooltip();});</script><script src="/asset/js/bootstrap-tooltip.js"></script>