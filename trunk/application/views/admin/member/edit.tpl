					<div id="main">
						<h3>会员</h3>
						<div class="clear"></div>
						<form action="{'admin/member/save_form'|site_url}" method="post" class="jNice">
							<fieldset>
								<p>
									<label>帐号</label>
									<input class="text-small" type="text" name="account" id="account" value="{$member_information.account}" readonly="readonly" />
								</p>
								
								<p>
									<label>{'global_name'|lang_line}</label>
									<input class="text-small" type="text" name="name" id="name" value="{$member_information.name}" />
								</p>
								
								<p>
									<label>{'global_password'|lang_line}</label>
									<input class="text-small" type="password" name="password" id="password" value="" />
								</p>
								
								<input type="hidden" value="{$member_id}" name="cid" id="cid" />
								<p>
									<input class="button" type="submit" value="Submit" />
								</p>
								
							</fieldset>
							
							<div class="clear"></div><!-- End .clear -->
							
						</form>
						
					</div> <!-- End #tab2 -->        