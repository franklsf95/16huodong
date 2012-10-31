					<div id="main">
						<h3>会员</h3>
						<div class="clear"></div>
						<form action="{'admin/activity/save_form'|site_url}" method="post" class="jNice">
							<fieldset>
								<p>
									<label>{'global_name'|lang_line}</label>
									<input class="text-small" type="text" name="name" id="name" value="{$activity_information.name}" />
								</p>
								
								<p>
									<label>开始时间</label>
									<input class="text-small" type="text" name="start_time" id="start_time" value="{$activity_information.start_time}" />
								</p>
								
								<p>
									<label>结束时间</label>
									<input class="text-small" type="text" name="end_time" id="end_time" value="{$activity_information.end_time}" />
								</p>
								
								<p>
									<label>内容</label>
									<textarea>{$activity_information.content}</textarea>
								</p>
								
								<input type="hidden" value="{$activity_id}" name="cid" id="cid" />
								<p>
									<input class="button" type="submit" value="Submit" />
								</p>
								
							</fieldset>
							
							<div class="clear"></div><!-- End .clear -->
							
						</form>
						
					</div> <!-- End #tab2 -->        