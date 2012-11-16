<ul class="breadcrumb">  <li><a href="{'library'|site_url}">人生图书馆</a> <span class="divider">/</span></li>  <li><a href="{'profile'|site_url}?id={$book_information.author_id}">{$book_information.author_name}</a> <span class="divider">/</span></li>  <li class="active">{$book_information.book_name}</li></ul><div class="book-container">	<div class="book-title"><h3>{$book_information.book_name}</h3></div>	<div class="book-author">By {$book_information.author_name}</div>	<div class="book-cover"><img src="{$book_information.book_image}" alt="{$book_information.book_name}"></div>	<div class="book-content">{$book_information.book_content}</div></div><!--/book-container--><div class="clear"></div><div class="toolbox btn-group">	<div class="btn btn-view-count">{$book_information.view_count} 人读过</div>	<div class="btn btn-primary" id="btn-like">赞 ({$book_information.like_count})</div>{if $book_information.is_author}  <a class="btn btn-primary" href="{'library/edit'|site_url}?id={$book_information.book_id}">编辑</a>  <a class="btn btn-primary" onclick="deleteBook({$book_information.book_id},{$book_information.author_id})">删除</a>{/if}</div><!--/book-container--><div class="content-heading">评论</div><div id="comment-container"><table class="table table-striped"><tbody id="comment-tbody">{foreach $comment_information as $i}<tr id="m-{$i.book_comment_id}">  <td class="comment-heading">  <img src="{$i.member_image}" alt="{$i.member_name}" class="avatar-medium"><a href="{'profile'|site_url}?id={$i.member_id}">{$i.member_name}</a>  </td>  <td class="comment-content">{$i.content}</td>  <td class="comment-timestamp">{$i.created_time}</td>  <td class="comment-reply-btn">{if $i.member_id != $current_member_id}<a href="#reply-box" class="act" onclick="addReplyTo('{$i.member_name}')">回复</a>{/if}</td></tr>{/foreach}<tbody></table>{if $page_information.count > 0}<div class="pagination">    {include file="common/ajax_pagination.tpl"}</div>{/if}<div id="add-comment-box">  <textarea name="book_comment" id="comment-content" class="span6 reply-content" rows="2"></textarea>  <div class="clear"></div>  <input type="submit" id="reply-form-submit" class="btn btn-primary" value="留言 (Ctrl+Enter)" /></div></div><!--/comment-container-->