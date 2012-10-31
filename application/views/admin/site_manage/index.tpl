<script>
			var editor;
			KindEditor.ready(function(K) {
				editor = K.create("#copyright", {
					allowFileManager : true
				});
				});
</script>
					<div id="main">
						<h3>{'site_manage'|lang_line}</h3>
						<div class="clear"></div>
						<form action="{'admin/site_manage/save_form'|site_url}" method="post" class="jNice">
							<fieldset>
								<p>
									<label>{'site_status'|lang_line}</label>
										<select name="site_status" class="text-small">
											<option value="Y">{'global_open'|lang_line}</option>
											<option value="N" {if ($site_manage_information.site_status == 'N')} selected="selected" {/if}>{'global_close'|lang_line}</option>
										</select>
										
								</p>
								<p>
									<label>{'site_name'|lang_line}</label>
									<input class="text-small" type="text" name="site_name" value="{$site_manage_information.site_name}" />
								</p>
								
								<p>
									<label>{'site_keyword'|lang_line}</label>
									<input class="text-medium" type="text" name="site_keyword" value="{$site_manage_information.site_keyword}"/>
								</p>
								
								<p>
									<label>{'site_description'|lang_line}</label>
									<textarea class="text-medium textarea" name="site_description">{$site_manage_information.site_description}</textarea>
								</p>
								
								<p>
									<label>{'site_copyright'|lang_line}</label>
									<textarea name="site_copyright" id="copyright" style="width:650px">{$site_manage_information.site_copyright}</textarea>
								</p>
								
								<p>
									<input type="submit" value="{'global_submit'|lang_line}" />
								</p>
								
							</fieldset>
							
							<div class="clear"></div><!-- End .clear -->
							
						</form>
						
					</div> <!-- End #tab2 -->        