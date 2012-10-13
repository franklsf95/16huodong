					<form name="adminForm" action="__('admin/member'|site_url)__" method="post" id="adminForm">
					<div id="main">
						<h3>__('global_article'|lang_line)__</h3>
						
						<table cellpadding="0" cellspacing="0">
							<thead>
								<tr align="center">
								   <th><input class="check-all" type="checkbox"  name="toggle" onclick="checkAll(__($count)__)"  /></th>
								   <th>__('global_id'|lang_line)__</th>
								   <th>名称</th>
								   <th>发布者</th>
								   <th>发布时间</th>
								   <th>__('global_edit'|lang_line)__</th>
								</tr>
								
							</thead>
						 
							<tfoot>
								<tr>
									<td colspan="7">
										<div class="bulk-actions align-left">
											<select name="task">
												<option value="">__('global_choose_action'|lang_line)__</option>
												<option value="remove">__('global_delete'|lang_line)__</option>
											</select>
											<a href="#" onclick="applyFormAction();">__('global_apply_action'|lang_line)__</a>
										</div>
										
										<div class="pagination">
										__(assign var="index_page_name" value="admin/blog")__
										__(include file="admin/layout/pagination.tpl")__
										</div>
										<div class="clear"></div>
									</td>
								</tr>
							</tfoot>
						 
							<tbody>
							__(foreach name=all_blog_information from=$all_blog_information item=blog_information)__
							__(assign var="tr_class" value = $smarty.foreach.all_blog_information.index%2)__
								<tr align="center" __(if $tr_class)__ class="odd" __(/if)__ >
									<td><input type="checkbox" id="cb__($smarty.foreach.all_blog_information.index)__" name="cid[]" value="__($blog_information.member_blog_id)__"  onclick="isChecked(this.checked);" /></td>
									<td>__($blog_information.member_blog_id)__</td>
									<td>__($blog_information.name|truncate:14)__</td>
									<td>__($blog_information.member_name)__</td>
									<td>__($blog_information.created_time|date_format:"%Y-%m-%d")__</td>
									<td class="action"><a href="__('member_blog/index'|site_url)__?id=__($blog_information.member_blog_id)__" target="_blank" class="view">__('global_view'|lang_line)__</a><a href="__('admin/blog/edit'|site_url)__?cid=__($blog_information.member_blog_id)__" class="edit">__('global_edit'|lang_line)__</a><a href="__('admin/blog/remove'|site_url)__?cid=__($blog_information.member_blog_id)__" class="delete" onclick="if(confirm('确认删除？')){return true;}else{return false;}">__('global_delete'|lang_line)__</a></td>
								</tr>
							__(/foreach)__
							</tbody>
						</table>
						<input type="hidden" name="boxchecked" value="0" />
					</div>
					</form>