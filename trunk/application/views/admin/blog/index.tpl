					<form name="adminForm" action="{'admin/member'|site_url}" method="post" id="adminForm">
					<div id="main">
						<h3>{'global_article'|lang_line}</h3>
						
						<table cellpadding="0" cellspacing="0">
							<thead>
								<tr align="center">
								   <th><input class="check-all" type="checkbox"  name="toggle" onclick="checkAll({$count})"  /></th>
								   <th>{'global_id'|lang_line}</th>
								   <th>名称</th>
								   <th>发布者</th>
								   <th>发布时间</th>
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
										{assign var="index_page_name" value="admin/blog"}
										{include file="admin/layout/pagination.tpl"}
										</div>
										<div class="clear"></div>
									</td>
								</tr>
							</tfoot>
						 
							<tbody>
							{foreach name=all_blog_information from=$all_blog_information item=blog_information}
							{assign var="tr_class" value = $smarty.foreach.all_blog_information.index%2}
								<tr align="center" {if $tr_class} class="odd" {/if} >
									<td><input type="checkbox" id="cb{$smarty.foreach.all_blog_information.index}" name="cid[]" value="{$blog_information.member_blog_id}"  onclick="isChecked(this.checked);" /></td>
									<td>{$blog_information.member_blog_id}</td>
									<td>{$blog_information.name|truncate:14}</td>
									<td>{$blog_information.member_name}</td>
									<td>{$blog_information.created_time|date_format:"%Y-%m-%d"}</td>
									<td class="action"><a href="{'member_blog/index'|site_url}?id={$blog_information.member_blog_id}" target="_blank" class="view">{'global_view'|lang_line}</a><a href="{'admin/blog/edit'|site_url}?cid={$blog_information.member_blog_id}" class="edit">{'global_edit'|lang_line}</a><a href="{'admin/blog/remove'|site_url}?cid={$blog_information.member_blog_id}" class="delete" onclick="if(confirm('确认删除？')){return true;}else{return false;}">{'global_delete'|lang_line}</a></td>
								</tr>
							{/foreach}
							</tbody>
						</table>
						<input type="hidden" name="boxchecked" value="0" />
					</div>
					</form>