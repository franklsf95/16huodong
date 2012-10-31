<div class="accordion" id="accordion-search">
	<div class="accordion-group">
    <div class="accordion-heading">
      <a class="accordion-toggle" data-toggle="collapse" data-parent="accordion-search" href="#collapse-search">挖活动</a>
    </div>
    <div id="collapse-search" class="accordion-body collapse">
      <div class="accordion-inner" data-collapse="hide">
	    <form id="search-form" action="{'search'|site_url}" method="post">
	    <fieldset>
	    	<label>test</label>
	    	<input type="submit" class="btn btn-primary pull-right" value="留言 (Ctrl+Enter)" />
	    </fielset>
	    </form>
      </div><!--/accordion-inner-->
    </div><!--/accordion-body-->
  </div><!--/accordion-group-->
</div><!--/accordion-->
<div class="row">
	<div class="span6">
		<div class="content-heading">最新活动</div>
		<div id="main-showcase"></div>
	</div>
	<div class="span3">
		<div class="content-heading">热门标签</div>
		<div class="hot-tag-showcase toolbox">
			{foreach $all_hot_activity_tag_information as $i}
				<a class="badge tag">{$i.tag}</a>
			{/foreach}
		</div>
		<div class="content-heading">本周活跃</div>
		<div class="toolbox">
			<p>这里显示发布活动最多的用户</p>
		</div>
		<div class="content-heading">最热门活动</div>
		<div class="toolbox">
			<p>这里显示关注人数最多的活动</p>
		</div>
	</div>
</div>