					<div id="main">
						<h3>会员</h3>
						<div class="clear"></div>
						<form action="__('admin/activity/save_form'|site_url)__" method="post" class="jNice">
							<fieldset>
								<p>
									<label>__('global_name'|lang_line)__</label>
									<input class="text-small" type="text" name="name" id="name" value="__($activity_information.name)__" />
								</p>
								
								<p>
									<label>开始时间</label>
									<input class="text-small" type="text" name="start_time" id="start_time" value="__($activity_information.start_time)__" />
								</p>
								
								<p>
									<label>结束时间</label>
									<input class="text-small" type="text" name="end_time" id="end_time" value="__($activity_information.end_time)__" />
								</p>
								
								<p>
									<label>内容</label>
									<textarea>__($activity_information.content)__</textarea>
								</p>
								
								<input type="hidden" value="__($activity_id)__" name="cid" id="cid" />
								<p>
									<input class="button" type="submit" value="Submit" />
								</p>
								
							</fieldset>
							
							<div class="clear"></div><!-- End .clear -->
							
						</form>
						
					</div> <!-- End #tab2 -->        