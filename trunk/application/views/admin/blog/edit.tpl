					<div id="main">
						<h3>会员</h3>
						<div class="clear"></div>
						<form action="{'admin/blog/save_form'|site_url}" method="post" class="jNice">
							<fieldset>
								<p>
									<label>{'global_name'|lang_line}</label>
									<input class="text-small" type="text" name="name" id="name" value="{$blog_information.name}" />
								</p>
								
								<p>
									<label>内容</label>
									<textarea>{$blog_information.content}</textarea>
								</p>
								
								<input type="hidden" value="{$member_blog_id}" name="cid" id="cid" />
								<p>
									<input class="button" type="submit" value="Submit" />
								</p>
								
							</fieldset>
							
							<div class="clear"></div><!-- End .clear -->
							
						</form>
						
					</div> <!-- End #tab2 -->        