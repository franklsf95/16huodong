					<form name="adminForm" action="{'admin/application_user'|site_url}" method="post" id="adminForm">
					<div id="main">
						<h3>{'application_user_manage'|lang_line}</h3>
						<input type="button" class="toolbar-button" value="{'global_add'|lang_line}"  onclick="window.location.href='{'admin/application_user/edit'|site_url}'" />
                    	<table cellpadding="0" cellspacing="0">
							<thead>
								<tr align="center">
								   <th><input class="check-all" type="checkbox" name="toggle" onclick="checkAll({$count})" /></th>
								   <th>{'global_id'|lang_line}</th>
								   <th>{'application_user_username'|lang_line}</th>
								   <th>{'application_group_name'|lang_line}</th>
								   <th>{'global_status'|lang_line}</th>
								   <th>{'global_email'|lang_line}</th>
								   <th>{'global_edit'|lang_line}</th>
								</tr>
							</thead>
							
							<tfoot>
								<tr>
									<td colspan="7">
										<div class="bulk-actions align-left">
											<select name="task">
												<option value="">{'global_choose_action'|lang_line}</option>
												<option value="remove">{'global_delete'|lang_line}</option>
											</select>
											<a href="#" onclick="applyFormAction();">{'global_apply_action'|lang_line}</a>
										</div>
										
										<div class="pagination">
										{assign var="index_page_name" value="admin/application_user"}
										{include file="admin/layout/pagination.tpl"}
										</div> <!-- End .pagination -->
										
										<div class="clear"></div>
									</td>
								</tr>
							</tfoot>
						 
							<tbody>
							{foreach name=all_application_user_infromation from=$all_application_user_information item=application_user_information}
							{assign var="tr_class" value = $smarty.foreach.all_application_user_infromation.index%2}
								<tr  align="center" {if $tr_class} class="odd" {/if}>
									<td><input type="checkbox" id="cb{$smarty.foreach.all_application_user_infromation.index}" name="cid[]" value="{$application_user_information.application_user_id}"  onclick="isChecked(this.checked);" /></td>
									<td>{$application_user_information.application_user_id}</td>
									<td>{$application_user_information.username}</td>
									<td>{$application_user_information.application_group_name}</td>
									<td>{if ($application_user_information.status == 'Y')}<img src="/asset/admin/img/activity.png" />{else}<img src="/asset/admin/img/unactivity.png" />{/if}</td>
									<td>{$application_user_information.email}</td>
									<td class="action"><a href="{'admin/application_user/edit'|site_url}?cid={$application_user_information.application_user_id}" class="edit">{'global_edit'|lang_line}</a>{if $current_application_user_information.application_user_id != $application_user_information.application_user_id}<a href="#" class="delete" onclick="removeRecordById({$application_user_information.application_user_id})">{'global_delete'|lang_line}</a> {/if}</td>
								</tr>
							{/foreach}
							</tbody>
						</table>
						<input type="hidden" name="boxchecked" value="0" />
					</div>
					</form>
