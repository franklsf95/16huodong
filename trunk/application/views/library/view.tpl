<ul class="breadcrumb">  <li><a href="{'profile'|site_url}?id={$book_information.member_id}">{$book_information.member_name}</a> <span class="divider">/</span></li>  <li><a href="{'library/profile'|site_url}?id={$book_information.member_id}">{$book_information.member_name}的微型书</a> <span class="divider">/</span></li>  <li class="active">{$book_information.member_blog_name}</li></ul><div class="book-container">	<div class="book-title"><h3>{$book_information.member_blog_name}</h3></div>	<div class="book-author">By {$book_information.member_name}</div>	<div class="book-cover"><img src="{$book_information.member_blog_image}" alt="{$book_information.member_blog_name}"></div>	<div class="book-content">{$book_information.member_blog_content}</div></div><!--/book-container--><div class="clear"></div><div class="toolbox btn-group">	<div class="btn">{$book_information.visit_number} 人读过</div>	<div class="btn btn-primary" id="btn-like">赞 ({$book_information.prefer_number})</div></div><!--/book-container--><div class="content-heading">评论</div><div id="comment-container"><table class="table table-striped"><tbody id="comment-tbody">{foreach $all_book_comment_information as $i}<tr id="m-{$i.member_message_id}">  <td style="width: 120px">  <img src="{$i.member_image}" alt="{$i.member_name}" class="avatar-medium"><a href="{'profile'|site_url}?id={$i.member_id}">{$i.member_name}</a>  </td>  <td>{$i.content}</td>  <td class="pull-right">{$i.created_time}</td>  {if $i.member_id != $current_member_information.member_id}  <td style="width: 50px">{if $i.target_id == $target_info.member_id}    <a href="#reply-box" class="act" onclick="addReplyTo('{$i.member_name}')">回复</a>{/if}  </td>  {/if}</tr>{/foreach}<tbody></table>{if $page_information.count > 0}<div class="pagination">    {include file="common/ajax_pagination.tpl"}</div>{/if}<div id="add-comment-box">    <form id="reply-form" class="span6">    <fieldset>      <textarea name="book_comment" id="comment-content" class="span6 reply-content" rows="2"></textarea>      <input type="submit" id="reply-form-submit" class="btn btn-primary pull-right" value="留言 (Ctrl+Enter)" />    </fielset>    </form></div><!--/comment-container-->