					<div id="main">
						<h3>会员</h3>
						<div class="clear"></div>
						<form action="__('admin/blog/save_form'|site_url)__" method="post" class="jNice">
							<fieldset>
								<p>
									<label>__('global_name'|lang_line)__</label>
									<input class="text-small" type="text" name="name" id="name" value="__($blog_information.name)__" />
								</p>
								
								<p>
									<label>内容</label>
									<textarea>__($blog_information.content)__</textarea>
								</p>
								
								<input type="hidden" value="__($member_blog_id)__" name="cid" id="cid" />
								<p>
									<input class="button" type="submit" value="Submit" />
								</p>
								
							</fieldset>
							
							<div class="clear"></div><!-- End .clear -->
							
						</form>
						
					</div> <!-- End #tab2 -->        