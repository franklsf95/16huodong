<script>$("#navbar-library").addClass("active");$("#btn-like").click( function() {  $.getJSON("__('library/ajaxLikeBook'|site_url)__?id="+__($member_blog_information.member_blog_id)__,function(data){      if( !data ) {        alert('Operation failed.');      } else if( data == 1 ) {        alert('成功喜欢了日志!');        window.location.reload();      } else if( data == -1 ) {        alert('你已经喜欢过了!');      } else if( data == -2 ) {        alert('你就别自恋了!');      }    });})  </script>