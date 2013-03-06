					<div id="main">
						<h3>{'site_manage'|lang_line}</h3>
						<div class="clear"></div>
						<form action="{'admin/site_manage/saveItem'|site_url}" method="post" class="jNice">
							<fieldset>
								<p>
									<label>单页记录加载数量（如搜索结果）</label>
									<input class="text-small" type="text" name="limit_query" value="{$site_manage_information.limit_query}" />
										
								</p>
								<p>
									<label>单页回复加载数量</label>
									<input class="text-small" type="text" name="limit_comment" value="{$site_manage_information.limit_comment}" />
								</p>
								<p>
									<label>留言板留言单页加载数量</label>
									<input class="text-small" type="text" name="limit_message" value="{$site_manage_information.limit_message}"/>
								</p>
								<p>
									<label>SVN程序版本号</label>
									<input class="text-small" type="text" name="svn_version" value="{$site_manage_information.svn_version}"/>
								</p>
								<p>
									<input type="submit" value="{'global_submit'|lang_line}" />
								</p>
								
							</fieldset>
							
							<div class="clear"></div><!-- End .clear -->
							
						</form>
						
					</div> <!-- End #tab2 -->        