					<form name="adminForm" action="{'admin/member'|site_url}" method="post" id="adminForm">
					<div id="main">
						<h3>{'global_article'|lang_line}</h3>
						<!--input type="button" class="toolbar-button" value="{'global_add'|lang_line}"  onclick="window.location.href='{'admin/article/edit'|site_url}'" /-->
						
						<select class="class_select" id="class_select" onchange="window.location.href='{'admin/activity'|site_url}?expiry='+this.value">
							<option value="">All</option>
							<option value="N" {if $expiry == 'N'}selected="selected"{/if}>未过期</option>
							<option value="Y" {if $expiry == 'Y'}selected="selected"{/if}>已过期</option>
						</select>
						
						<table cellpadding="0" cellspacing="0">
							<thead>
								<tr align="center">
								   <th><input class="check-all" type="checkbox"  name="toggle" onclick="checkAll({$count})"  /></th>
								   <th>{'global_id'|lang_line}</th>
								   <th>活动名称</th>
								   <th>发布者</th>
								   <th>开始时间</th>
								   <th>结束时间</th>
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
										{assign var="index_page_name" value="admin/activity"}
										{include file="admin/layout/pagination.tpl"}
										</div>
										<div class="clear"></div>
									</td>
								</tr>
							</tfoot>
						 
							<tbody>
							{foreach name=all_activity_information from=$all_activity_information item=activity_information}
							{assign var="tr_class" value = $smarty.foreach.all_activity_information.index%2}
								<tr align="center" {if $tr_class} class="odd" {/if} >
									<td><input type="checkbox" id="cb{$smarty.foreach.all_activity_information.index}" name="cid[]" value="{$activity_information.activity_id}"  onclick="isChecked(this.checked);" /></td>
									<td>{$activity_information.activity_id}</td>
									<td>{$activity_information.name|truncate:14}</td>
									<td>{$activity_information.member_name}</td>
									<td>{$activity_information.start_time}</td>
									<td>{$activity_information.end_time}</td>
									<td class="action"><a href="{'activity/index'|site_url}?id={$activity_information.activity_id}" target="_blank" class="view">{'global_view'|lang_line}</a><a href="{'admin/activity/edit'|site_url}?cid={$activity_information.activity_id}" class="edit">{'global_edit'|lang_line}</a><a href="{'admin/activity/remove'|site_url}?cid={$activity_information.activity_id}" class="delete" onclick="if(confirm('确认删除？')){return true;}else{return false;}">{'global_delete'|lang_line}</a></td>
								</tr>
							{/foreach}
							</tbody>
						</table>
						<input type="hidden" name="boxchecked" value="0" />
					</div>
					</form>