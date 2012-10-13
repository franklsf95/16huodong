					<form name="adminForm" action="__('admin/member'|site_url)__" method="post" id="adminForm">
					<div id="main">
						<h3>__('global_article'|lang_line)__</h3>
						<!--input type="button" class="toolbar-button" value="__('global_add'|lang_line)__"  onclick="window.location.href='__('admin/article/edit'|site_url)__'" /-->
						
						<select class="class_select" id="class_select" onchange="window.location.href='__('admin/activity'|site_url)__?expiry='+this.value">
							<option value="">All</option>
							<option value="N" __(if $expiry == 'N')__selected="selected"__(/if)__>未过期</option>
							<option value="Y" __(if $expiry == 'Y')__selected="selected"__(/if)__>已过期</option>
						</select>
						
						<table cellpadding="0" cellspacing="0">
							<thead>
								<tr align="center">
								   <th><input class="check-all" type="checkbox"  name="toggle" onclick="checkAll(__($count)__)"  /></th>
								   <th>__('global_id'|lang_line)__</th>
								   <th>活动名称</th>
								   <th>发布者</th>
								   <th>开始时间</th>
								   <th>结束时间</th>
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
										__(assign var="index_page_name" value="admin/activity")__
										__(include file="admin/layout/pagination.tpl")__
										</div>
										<div class="clear"></div>
									</td>
								</tr>
							</tfoot>
						 
							<tbody>
							__(foreach name=all_activity_information from=$all_activity_information item=activity_information)__
							__(assign var="tr_class" value = $smarty.foreach.all_activity_information.index%2)__
								<tr align="center" __(if $tr_class)__ class="odd" __(/if)__ >
									<td><input type="checkbox" id="cb__($smarty.foreach.all_activity_information.index)__" name="cid[]" value="__($activity_information.activity_id)__"  onclick="isChecked(this.checked);" /></td>
									<td>__($activity_information.activity_id)__</td>
									<td>__($activity_information.name|truncate:14)__</td>
									<td>__($activity_information.member_name)__</td>
									<td>__($activity_information.start_time)__</td>
									<td>__($activity_information.end_time)__</td>
									<td class="action"><a href="__('activity/index'|site_url)__?id=__($activity_information.activity_id)__" target="_blank" class="view">__('global_view'|lang_line)__</a><a href="__('admin/activity/edit'|site_url)__?cid=__($activity_information.activity_id)__" class="edit">__('global_edit'|lang_line)__</a><a href="__('admin/activity/remove'|site_url)__?cid=__($activity_information.activity_id)__" class="delete" onclick="if(confirm('确认删除？')){return true;}else{return false;}">__('global_delete'|lang_line)__</a></td>
								</tr>
							__(/foreach)__
							</tbody>
						</table>
						<input type="hidden" name="boxchecked" value="0" />
					</div>
					</form>