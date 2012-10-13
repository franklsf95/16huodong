					<div id="main">
						<h3>会员</h3>
						<div class="clear"></div>
						<form action="__('admin/member/save_form'|site_url)__" method="post" class="jNice">
							<fieldset>
								<p>
									<label>帐号</label>
									<input class="text-small" type="text" name="account" id="account" value="__($member_information.account)__" readonly="readonly" />
								</p>
								
								<p>
									<label>__('global_name'|lang_line)__</label>
									<input class="text-small" type="text" name="name" id="name" value="__($member_information.name)__" />
								</p>
								
								<p>
									<label>__('global_password'|lang_line)__</label>
									<input class="text-small" type="password" name="password" id="password" value="" />
								</p>
								
								<input type="hidden" value="__($member_id)__" name="cid" id="cid" />
								<p>
									<input class="button" type="submit" value="Submit" />
								</p>
								
							</fieldset>
							
							<div class="clear"></div><!-- End .clear -->
							
						</form>
						
					</div> <!-- End #tab2 -->        