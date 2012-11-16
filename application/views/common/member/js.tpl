    <script>
var wrapActivity = function( id, act ) {
  var str = 
'<div class="waterfall-item" id="item-'+id+'">'+'<a href="{"activity/view"|site_url}?id='+act.activity_id+'">'+'<img src="'+act.activity_image+'" class="img-rounded"></a>'
+'<h4><a href="{"activity/view"|site_url}?id='+act.activity_id+'">'+act.activity_name+'</a></h4>'
+'<div class="waterfall-item-bottom"><ul>'
+'<li>开始时间: '+act.start_time+'</li>'
+'<li>结束时间: '+act.end_time+'</li>'
+'<li>发起人: <a href="{"profile"|site_url}?id='+act.publisher_id+'">'+act.publisher_name+'</a></li>'
+'<li><code>'+act.attend_count+'</code>人参与&nbsp;&nbsp;|&nbsp;&nbsp;<code>'+act.follow_count+'</code>人关注</li>'
+'</ul></div></div>';
  return str;
};

var wrapBook = function( id, book ) {
  var str = 
'<div class="waterfall-item" id="item-'+id+'">'+'<a href="{"library/view"|site_url}?id='+book.book_id+'">'+'<img src="'+book.book_image+'" class="img-rounded"></a>'
+'<h4><a href="{"library/view"|site_url}?id='+book.book_id+'">'+book.book_name+'</a></h4>'
+'<div class="waterfall-item-bottom"><ul>'
+'<li>发表于 '+book.created_time+'</li>'
+'<li>作者: <a href="{"profile"|site_url}?id='+book.author_id+'">'+book.author_name+'</a></li>'
+'<li><code>'+book.view_count+'</code>人读过&nbsp;&nbsp;|&nbsp;&nbsp;<code>'+book.like_count+'</code>人喜欢</li>'
+'</ul></div></div>';
  return str;
};
    </script>