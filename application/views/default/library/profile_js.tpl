<script>$( function(){  {if $my_page}  $("#sidebar-my-library").addClass("active");  {/if}/**/  showLikes();} );var page_offset = 0;var limit = 6;var member_id = '{$member_id}';var current_id = 0;function showLikes(){    $.ajax({      url:"{'base_ajax_action_controller/getPreferBlogInformation'|site_url}",      data:'member_id='+member_id+'&page_offset='+page_offset+'&limit='+limit,      dataType: "JSON",      success:function(data){        console.log(data);        for(i in data){          current_id++;          var act = '<div class="showcase-item" id="item-'+current_id+'">'+'<a href="{"library/view"|site_url}?id='+data[i].member_blog_id+'">'+'<img src="'+data[i].member_blog_image+'" class="img-rounded"></a>'+'<h4><a href="{"activity/view"|site_url}?id='+data[i].member_blog_id+'">'+data[i].member_blog_name+'</a></h4>'+'<ul>'+'<li>发表于 '+data[i].created_time+'</li>'+'<li>作者: <a href="{"library/profile"|site_url}?id='+data[i].member_id+'">'+data[i].member_name+'</a></li>'+'<li><code>'+data[i].visit_number+'</code>人读过&nbsp;&nbsp;|&nbsp;&nbsp;<code>'+data[i].prefer_number+'</code>人喜欢</li>'+'</ul></div>';          $("#like-showcase").append( act );        }        page_offset = page_offset + limit;      }          });}function deleteBlog(id, author) {  if( confirm('真的要删除微型书#'+id+'?')) {    $.getJSON('{"library/ajaxDeleteBook"|site_url}?member_blog_id='+id+"&author_id="+author,function(data){        if( data ) {          window.location.reload();        } else {          alert('Operation failed.');        }      });  }}</script>