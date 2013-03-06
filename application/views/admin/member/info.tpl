					<div id="main">
						<h3>会员</h3>
						<div class="clear"></div>
						<form class="jNice">
							<fieldset>
								<p>
									<label>ID</label>
									<input class="text-small" type="text" value="{$member_information.member_id}" readonly="readonly" />
								</p>
								
								<p>
									<label>帐号</label>
									<input class="text-small" type="text" name="account" id="account" value="{$member_information.account}" readonly="readonly" />
								</p>
								
								<p>
									<label>昵称</label>
									<input class="text-small" type="text" name="name" id="name" value="{$member_information.name}" />
								</p>
								
								<p>
									<label>类型</label>
									<input class="text-small" type="text" value="{$member_information.member_type}" />
								</p>
								
								<p>
									<label>真实姓名</label>
									<input class="text-small" type="text" name="realname" id="realname" value="{$member_information.realname}" />
								</p>
								
								<p>
								
									<img src="{$member_information.image}">
								</p>
								
								<p>
									<label>性别</label>
									<input class="text-small" type="text" value="{$member_information.gender}" />
								</p>
								
								<p>
									<label>生日</label>
									<input class="text-small" type="text" value="{$member_information.birthday}" />
								</p>

								<p>
									<label>学校</label>
									<input class="text-small" type="text" value="{$member_information.school_name}" />
								</p>

								<p>
									<label>qq</label>
									<input class="text-small" type="text" value="{$member_information.qq}" />

								</p>
								
								<p>
									<label>电话</label>
									<input class="text-small" type="text" value="{$member_information.phone}" />
								</p>

								<p>
									<label>Email</label>
									<input class="text-small" type="text" value="{$member_information.email}" />
								</p>
								
								<p>
									<label>地址</label>
									<input class="text-small" type="text" value="{$member_information.address}" />
								</p>
								
								<p>
									<label>组织</label>
									<input class="text-small" type="text" value="{$member_information.organisation}" />
								</p>
								
								<p>
									<label>职位</label>
									<input class="text-small" type="text" value="{$member_information.title}" />
								</p>
								
								<p>
									<label>简介</label>
									<input class="text-small" type="text" value="{$member_information.description}" />
								</p>
								
								<p>
									<label>富文本简介</label>
									<input class="text-small" type="text" value="{$member_information.content}" />
								</p>
								
								<p>
									<label>接收邮件</label>
									<input class="text-small" type="text" value="{$member_information.accept_notification}" />
								</p>
								
								<p>
									<label>创建时间</label>
									<input class="text-small" type="text" value="{$member_information.created_time}" />
								</p>
								
								<p>
									<label>最后修改</label>
									<input class="text-small" type="text" value="{$member_information.modified_time}" />
								</p>
								
							</fieldset>
							
							<div class="clear"></div><!-- End .clear -->
							
						</form>
						
					</div> <!-- End #tab2 -->        