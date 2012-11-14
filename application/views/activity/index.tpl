<div class="accordion" id="accordion-search">
	<div class="accordion-group">
    <div class="accordion-heading">
      <a class="accordion-toggle" data-toggle="collapse" data-parent="accordion-search" href="#collapse-search">挖活动</a>
    </div>
    <div id="collapse-search" class="accordion-body collapse">
      <div class="accordion-inner" data-collapse="hide">
	    <form id="search-form" class="form-horizontal" action="{'search/queryActivity'|site_url}" method="post">
	    <fieldset>
	    	<div class="control-group">
                <label class="control-label" for="activity_name">活动名称</label>
                <div class="controls">
                	<input type="text" name="activity_name" id="activity_name">
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="member_type">发起人类别</label>
                <div class="controls">
                	<input type="radio" name="member_type" value="stu">学生</input>
                	<input type="radio" name="member_type" value="org">学生组织</input>
                	<input type="radio" name="member_type" value="chr">公益组织</input>
                	<input type="radio" name="member_type" value="com">公司</input>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="is_current_school">来自我的学校</label>
                <div class="controls">
                	<input type="checkbox" name="is_current_school" id="is_current_school">
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="is_open">报名未截止</label>
                <div class="controls">
                	<input type="checkbox" name="is_open" id="is_open">
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="is_active">活动未结束</label>
                <div class="controls">
                	<input type="checkbox" name="is_active" id="is_active">
                </div>
            </div>
	    	<input type="submit" class="btn btn-primary pull-right" value="搜索 (Ctrl+Enter)" />
	    </fielset>
	    </form>
      </div><!--/accordion-inner-->
    </div><!--/accordion-body-->
  </div><!--/accordion-group-->
</div><!--/accordion-->
<div class="content-heading">最新活动</div>
<div class="hot-tag-showcase toolbox">
    <a class="badge tag" id="tag-all">全部</a>
    {foreach $all_hot_activity_tag_information as $i}
        <a class="badge tag">{$i.tag}</a>
    {/foreach}
</div>
<div id="waterfall"></div>
<div id="waterfall-loading"></div>