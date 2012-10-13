					<form name="adminForm" action="__('admin/application_user'|site_url)__" method="post" id="adminForm">
					<div id="main">
						<h3>__('application_user_manage'|lang_line)__</h3>
						<input type="button" class="toolbar-button" value="__('global_add'|lang_line)__"  onclick="window.location.href='__('admin/application_user/edit'|site_url)__'" />
                    	<table cellpadding="0" cellspacing="0">
							<thead>
								<tr align="center">
								   <th><input class="check-all" type="checkbox" name="toggle" onclick="checkAll(__($count)__)" /></th>
								   <th>__('global_id'|lang_line)__</th>
								   <th>__('application_user_username'|lang_line)__</th>
								   <th>__('application_group_name'|lang_line)__</th>
								   <th>__('global_status'|lang_line)__</th>
								   <th>__('global_email'|lang_line)__</th>
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
										__(assign var="index_page_name" value="admin/application_user")__
										__(include file="admin/layout/pagination.tpl")__
										</div> <!-- End .pagination -->
										
										<div class="clear"></div>
									</td>
								</tr>
							</tfoot>
						 
							<tbody>
							__(foreach name=all_application_user_infromation from=$all_application_user_information item=application_user_information)__
							__(assign var="tr_class" value = $smarty.foreach.all_application_user_infromation.index%2)__
								<tr  align="center" __(if $tr_class)__ class="odd" __(/if)__>
									<td><input type="checkbox" id="cb__($smarty.foreach.all_application_user_infromation.index)__" name="cid[]" value="__($application_user_information.application_user_id)__"  onclick="isChecked(this.checked);" /></td>
									<td>__($application_user_information.application_user_id)__</td>
									<td>__($application_user_information.username)__</td>
									<td>__($application_user_information.application_group_name)__</td>
									<td>__(if ($application_user_information.status == 'Y'))__<img src="__($config.application_prefix)__resources/admin/img/activity.png" />__(else)__<img src="__($config.application_prefix)__resources/admin/img/unactivity.png" />__(/if)__</td>
									<td>__($application_user_information.email)__</td>
									<td class="action"><a href="__('admin/application_user/edit'|site_url)__?cid=__($application_user_information.application_user_id)__" class="edit">__('global_edit'|lang_line)__</a>__(if $current_application_user_information.application_user_id != $application_user_information.application_user_id)__<a href="#" class="delete" onclick="removeRecordById(__($application_user_information.application_user_id)__)">__('global_delete'|lang_line)__</a> __(/if)__</td>
								</tr>
							__(/foreach)__
							</tbody>
						</table>
						<input type="hidden" name="boxchecked" value="0" />
					</div>
					</form>
