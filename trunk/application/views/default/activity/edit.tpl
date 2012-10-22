<div class="span9"><form class="form-horizontal activity-form" action="__('activity/save_form'|site_url)__" method="post"><legend>发起新活动~</legend>  <div class="control-group">    <label class="control-label" for="actName">活动标题</label>    <div class="controls">      <input type="text" class="input-xxlarge" id="actName" name="name" value="__($activity_information.name)__">    </div>  </div>  <div class="control-group">    <label class="control-label" for="actStartTime">开始时间</label>    <div class="controls row">      <input type="text" class="span2 datepicker" id="actStartTime" name="start_time" value="__($activity_information.start_time)__">      <span class="separator-label">结束时间</span>      <input type="text" class="span2 datepicker" id="actEndTime" name="end_time" value="__($activity_information.end_time)__">    </div>  </div>  <div class="control-group">    <label class="control-label" for="actExpense">活动费用</label>    <div class="controls input-append">      <span class="add-on">￥</span><input type="text" class="input-large" id="actExpense" name="price" value="__($activity_information.price)__">    </div>  </div>  <div class="control-group">    <label class="control-label" for="actLocation">活动地点</label>    <div class="controls">      <input type="text" class="input-xxlarge" id="actLocation" name="address" value="__($activity_information.address)__">    </div>  </div>  <div class="control-group">    <label class="control-label" for="actLocation">封面图片</label>    <div class="controls"><div class="fileupload fileupload-new" data-provides="fileupload">  <div class="fileupload-new thumbnail"><img src="__($activity_information.image)__" /></div>  <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; line-height: 20px;"></div>  <div style="padding-top: 10px">    <span class="btn btn-file"><span class="fileupload-new">上传封面</span><span class="fileupload-exists">换一个</span><input type="file"></span>    <input type="hidden" name="image" value="/upload/portrait.jpg">    <a href="#" class="btn fileupload-exists" data-dismiss="fileupload">扔掉封面</a>  </div></div>    </div>  </div>  <div class="control-group">    <label class="control-label" for="actOutline">一句话描述</label>    <div class="controls">      <input type="text" class="input-xxlarge" id="actOutline" name="description" value="__($activity_information.description)__">    </div>  </div>  <div class="control-group">    <label class="control-label" for="actContext">详细介绍</label>    <div class="controls">      <textarea rows=10 id="actContext" class="richtext-editor span6" placeholder="Enter text ..." name="content">__($activity_information.content)__</textarea>    </div>  </div>  <input type="hidden" value="__($cid)__" name="cid" id="cid" />  <div class="span7">    <button type="submit" class="btn btn-primary btn-block">发布活动!</button>  </div></form></div><!--/span-->