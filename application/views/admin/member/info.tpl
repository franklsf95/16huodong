					<div id="main">
						<h3>会员</h3>
						<div class="clear"></div>
						<form action="{'admin/member/saveItem'|site_url}" method="post" class="jNice">
							<fieldset>
								<p>
									<label>帐号</label>
									<input class="text-small" type="text" name="account" id="account" value="{$member_information.account}" readonly="readonly" />
								</p>
								
								<p>
									<label>昵称</label>
									<input class="text-small" type="text" name="name" id="name" value="{$member_information.name}" />
								</p>
								
								<p>
									<label>密码</label>
									<input class="text-small" type="text" name="password" id="password" value="{$member_information.password}" />
								</p>
																<p>
									<label>姓名</label>
									<input class="text-small" type="text" name="realname" id="realname" value="{$member_information.realname}" />
								</p>
				<p>
								
									<img src="{$member_information.image}">
								</p>
													<p>
									<label>性别</label>
									<input class="text-small" type="text" name="realname" id="realname" value="{$member_information.gender}" />
								</p>
				<p>
									<label>生日</label>
									<input class="text-small" type="text" name="realname" id="realname" value="{$member_information.birthday}" />
								</p>

				<p>
									<label>学校</label>
									<input class="text-small" type="text" name="realname" id="realname" value="{$member_information.school_name}" />
								</p>

				<p>
									<label>qq</label>
									<input class="text-small" type="text" name="realname" id="realname" value="{$member_information.qq}" />

								</p>
				<p>
									<label>电话</label>
									<input class="text-small" type="text" name="realname" id="realname" value="{$member_information.phone}" />
								</p>

				<p>
									<label>Email</label>
									<input class="text-small" type="text" name="realname" id="realname" value="{$member_information.email}" />
								</p>
				<p>
									<label>地址</label>
									<input class="text-small" type="text" name="realname" id="realname" value="{$member_information.address}" />
								</p>
								<input type="hidden" value="{$member_id}" name="cid" id="cid" />
								<p>
								<a href="/admin/member">返回</a>
								</p>
								
							</fieldset>
							
							<div class="clear"></div><!-- End .clear -->
							
						</form>
						
					</div> <!-- End #tab2 -->        