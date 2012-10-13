<script>
			var editor;
			KindEditor.ready(function(K) {
				editor = K.create("#copyright", {
					allowFileManager : true
				});
				});
</script>
					<div id="main">
						<h3>__('site_manage'|lang_line)__</h3>
						<div class="clear"></div>
						<form action="__('admin/site_manage/save_form'|site_url)__" method="post" class="jNice">
							<fieldset>
								<p>
									<label>__('site_status'|lang_line)__</label>
										<select name="site_status" class="text-small">
											<option value="Y">__('global_open'|lang_line)__</option>
											<option value="N" __(if ($site_manage_information.site_status == 'N'))__ selected="selected" __(/if)__>__('global_close'|lang_line)__</option>
										</select>
										
								</p>
								<p>
									<label>__('site_name'|lang_line)__</label>
									<input class="text-small" type="text" name="site_name" value="__($site_manage_information.site_name)__" />
								</p>
								
								<p>
									<label>__('site_keyword'|lang_line)__</label>
									<input class="text-medium" type="text" name="site_keyword" value="__($site_manage_information.site_keyword)__"/>
								</p>
								
								<p>
									<label>__('site_description'|lang_line)__</label>
									<textarea class="text-medium textarea" name="site_description">__($site_manage_information.site_description)__</textarea>
								</p>
								
								<p>
									<label>__('site_copyright'|lang_line)__</label>
									<textarea name="site_copyright" id="copyright" style="width:650px">__($site_manage_information.site_copyright)__</textarea>
								</p>
								
								<p>
									<input type="submit" value="__('global_submit'|lang_line)__" />
								</p>
								
							</fieldset>
							
							<div class="clear"></div><!-- End .clear -->
							
						</form>
						
					</div> <!-- End #tab2 -->        