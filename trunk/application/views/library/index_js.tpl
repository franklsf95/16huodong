<script>$( function(){    $("#navbar-library").addClass("active");    showBooks();    $(window).scroll(function() {			if (document.body.clientHeight - document.documentElement.scrollTop -  document.documentElement.clientHeight <= 10 ){				showBooks();			}	});});var page_offset = 0;var limit = 6;var current_id = 0;var refresh_lock = false;function showBooks(){	if (!refresh_lock) {			refresh_lock = true;			$.ajax({				url:"{'base_ajax_action_controller/getAllMemberBlogInformation'|site_url}",				data:'page_offset='+page_offset+'&limit='+limit,				type: "GET",				dataType: "JSON",				async: false,				success:function(data){					for(i in data){						current_id++;						var book = '<div class="main-showcase-item" id="item-'+current_id+'">'+'<a href="{"library/view"|site_url}?id='+data[i].book_id+'">'+'<img src="'+data[i].book_image+'" class="img-rounded"></a>'+'<h4><a href="{"library/view"|site_url}?id='+data[i].book_id+'">'+data[i].book_name+'</a></h4>'+'<ul>'+'<li>发表于 '+data[i].created_time+'</li>'+'<li>作者: <a href="{"library/profile"|site_url}?id='+data[i].author_id+'">'+data[i].author_name+'</a></li>'+'<li><code>'+data[i].view_count+'</code>人读过&nbsp;&nbsp;|&nbsp;&nbsp;<code>'+data[i].like_count+'</code>人喜欢</li>'+'</ul></div>';						$("#main-showcase").append(book);					}					page_offset += limit;					refresh_lock = false;				}			});		}}</script>