<ul class="breadcrumb">  <li><a href="{'profile'|site_url}?id={$member_id}">{$member_name}</a> <span class="divider">/</span></li>  <li class="active">{$member_name}的微型图书馆</li></ul><hr><div class="content-heading">{$member_name}喜欢的微型书</div><div id="like-showcase"></div><div class="clear"></div><div class="content-heading">{$member_name}发表的微型书</div><div id="book-showcase">{foreach $information as $i}  <div class="showcase-item" id="item-1">    <a href="{'library/view'|site_url}?id={$i.book_id}"><img src="{$i.book_image}" class="img-rounded"></a>    <h4><a href="{'library/view'|site_url}?id={$i.book_id}">{$i.book_name}</a></h4>    <div>发表于 {$i.created_time}</div>    {if $is_me}    <div class="btn-group toolbox">      <a class="btn btn-primary" href="{'library/edit'|site_url}?id={$i.book_id}">编辑</a>      <a class="btn btn-primary" onclick="deleteBook({$i.book_id},{$member_id})">删除</a>    </div>    {/if}  </div>{/foreach}</div><div class="clear"></div>