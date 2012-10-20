					<form name="adminForm" action="__('admin/member'|site_url)__" method="post" id="adminForm">
					<div id="main">
						<h3>__('global_article'|lang_line)__</h3>
						<!--input type="button" class="toolbar-button" value="__('global_add'|lang_line)__"  onclick="window.location.href='__('admin/article/edit'|site_url)__'" /-->
						
						<select class="class_select" id="class_select" onchange="window.location.href='__('admin/member'|site_url)__?member_type='+this.value">
							<option value="">All</option>
							<option value="student" __(if $member_type == 'student')__selected="selected"__(/if)__>学生</option>
							<option value="student_organization" __(if $member_type == 'student_organization')__selected="student_organization"__(/if)__>学生组织</option>
							<option value="commonweal_organizat" __(if $member_type == 'commonweal_organizat')__selected="selected"__(/if)__>公益组织</option>
							<option value="company" __(if $member_type == 'company')__selected="selected"__(/if)__>公司</option>
						</select>
						
						<table cellpadding="0" cellspacing="0">
							<thead>
								<tr align="center">
								   <th><input class="check-all" type="checkbox"  name="toggle" onclick="checkAll(__($count)__)"  /></th>
								   <th>__('global_id'|lang_line)__</th>
								   <th>帐号</th>
								   <th>类型</th>
								   <th>名称</th>
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
										__(assign var="index_page_name" value="admin/member")__
										__(include file="admin/layout/pagination.tpl")__
										</div>
										<div class="clear"></div>
									</td>
								</tr>
							</tfoot>
						 
							<tbody>
							__(foreach name=all_member_information from=$all_member_information item=member_information)__
							__(assign var="tr_class" value = $smarty.foreach.all_member_information.index%2)__
								<tr align="center" __(if $tr_class)__ class="odd" __(/if)__ >
									<td><input type="checkbox" id="cb__($smarty.foreach.all_member_information.index)__" name="cid[]" value="__($member_information.member_id)__"  onclick="isChecked(this.checked);" /></td>
									<td>__($member_information.member_id)__</td>
									<td>__($member_information.account)__</td>
									<td>__($member_information.member_type)__</td>
									<td>__($member_information.name)__</td>
									<td class="action"><a href="__('member/index'|site_url)__?id=__($member_information.member_id)__" target="_blank" class="view">__('global_view'|lang_line)__</a><a href="__('admin/member/edit'|site_url)__?cid=__($member_information.member_id)__" class="edit">__('global_edit'|lang_line)__</a><a href="__('admin/member/remove'|site_url)__?cid=__($member_information.member_id)__" class="delete" onclick="if(confirm('确认删除？')){return true;}else{return false;}">__('global_delete'|lang_line)__</a></td>
								</tr>
							__(/foreach)__
							</tbody>
						</table>
						<input type="hidden" name="boxchecked" value="0" />
					</div>
					</form>