					<form name="adminForm" action="{'admin/member'|site_url}" method="post" id="adminForm">
					<div id="main">
						<h3>会员</h3>
						<!--input type="button" class="toolbar-button" value="{'global_add'|lang_line}"  onclick="window.location.href='{'admin/article/edit'|site_url}'" /-->
						
						<select class="class_select" id="class_select" onchange="window.location.href='{'admin/member'|site_url}?member_type='+this.value">
							<option value="">All</option>
							<option value="student" {if $member_type == 'student'}selected="selected"{/if}>学生</option>
							<option value="student_organization" {if $member_type == 'student_organization'}selected="student_organization"{/if}>学生组织</option>
							<option value="commonweal_organizat" {if $member_type == 'commonweal_organizat'}selected="selected"{/if}>公益组织</option>
							<option value="company" {if $member_type == 'company'}selected="selected"{/if}>公司</option>
						</select>
						
						<table cellpadding="0" cellspacing="0">
							<thead>
								<tr align="center">
								   <th><input class="check-all" type="checkbox"  name="toggle" onclick="checkAll({$count})"  /></th>
								   <th>{'global_id'|lang_line}</th>
								   <th>帐号</th>
								   <th>类型</th>
								   <th>昵称</th>
								   <th>真实姓名</th>
								 
							
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
										{assign var="index_page_name" value="admin/member"}
										{include file="admin/layout/pagination.tpl"}
										</div>
										<div class="clear"></div>
									</td>
								</tr>
							</tfoot>
						 
							<tbody>
							{foreach name=all_member_information from=$all_member_information item=member_information}
							{assign var="tr_class" value = $smarty.foreach.all_member_information.index%2}
								<tr align="center" {if $tr_class} class="odd" {/if} >
									<td><input type="checkbox" id="cb{$smarty.foreach.all_member_information.index}" name="cid[]" value="{$member_information.member_id}"  onclick="isChecked(this.checked);" /></td>
									<td>{$member_information.member_id}</td>
									<td>{$member_information.account}</td>
									<td>{$member_information.member_type}</td>
									<td>{$member_information.name}</td>
									<td>{$member_information.realname}</td>
									
									<td class="action"><a href="{'admin/member/info'|site_url}/{$member_information.member_id}" target="_blank" class="view">{'global_view'|lang_line}</a><a href="{'admin/member/edit'|site_url}?cid={$member_information.member_id}" class="edit">{'global_edit'|lang_line}</a><a href="{'admin/member/remove'|site_url}?cid={$member_information.member_id}" class="delete" onclick="if(confirm('确认删除？')) return true;else return false;">{'global_delete'|lang_line}</a></td>
								</tr>
							{/foreach}
							</tbody>
						</table>
						<input type="hidden" name="boxchecked" value="0" />
					</div>
					</form>