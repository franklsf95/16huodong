<script>
	var current_top = 20;
	var current_left = 0;
	var page_offset = 0;
	var limit = 6;
	var current_id_num = 0;
	var image_width = 210;
	var refresh_lock = false;
	
	function addIndexActivityShow(){
		if (!refresh_lock) {
			refresh_lock = true;
			$.ajax({
				url:"__('base_ajax_action_controller/getNewActivityInformation'|site_url)__",
				data:'page_offset='+page_offset+'&limit='+limit,
				type: "GET",
				dataType: "JSON",
				async: false,
				success:function(data){
					for(i in data){
						current_id_num++;
						current_id = 'ia_'+ current_id_num;
						var index_activity_show = ''+
													'<div class=\"index_activity_show\" id=\"'+current_id+'\">'+
														'<div class=\"image\"><a href=\"__("activity/view"|site_url)__?id='+data[i].activity_id+'\"><img src=\"'+data[i].activity_image+'\" /></a></div>'+
														'<div class="title">'+
															'<a href=\"__("member"|site_url)__?id='+data[i].member_id+'\" class=\"publisher\">'+data[i].member_name+'</a> 发起活动 <a href=\"__("activity/view"|site_url)__?id='+data[i].activity_id+'\" class=\"activity_name\">'+data[i].activity_name+'</a>'+
														'</div>'+
														'<div class=\"start_time\">开始时间: '+data[i].start_time+'</div>'+
														'<div class=\"end_time\">结束时间: '+data[i].end_time+'</div>'+
														'<div class=\"number\">'+
															'<div class=\"attend_number\"><span>'+data[i].attend_number+'</span>人参加</div>'+
															'<div class=\"attention_number\"><span>'+data[i].attention_number+'</span>人关注</div>'+
														'</div>'+
													'</div>';
						
						$("#activity_list_content").append(index_activity_show);
						
						$('#'+current_id).css('top',current_top);
						$('#'+current_id).css('left',current_left);
						$('#'+current_id).css('display','none');
						
						//处理图片尺寸问题
						//var current_image = new Image(); 
						//current_image.src = data[i].activity_image;
						var current_image_width = data[i].activity_image_width;
						var current_image_height = data[i].activity_image_height;
						
						image_height = (image_width/current_image_width)*current_image_height;
						
						$('#'+current_id+' > .image > a > img').width(image_width)
						$('#'+current_id+' > .image > a > img').height(image_height)
						
						var div_height = $('#'+current_id).outerHeight();
						current_content_height = current_top + div_height;
						if(parseFloat($("#activity_list_content").height()) < current_content_height) {
							$("#activity_list_content").height(current_content_height) ;
							//alert('修改后：'+parseFloat($("#activity_list_content").height()));
						}else {
							//alert(div_height);
						}
						
						//calculate top parameter
						if (current_id_num < 3) {
							current_top = 20;
						}else {
							previous_id = '#ia_'+(current_id_num + 1 - 3);
							//alert(previous_id);
							previous_div = $(previous_id);
							previous_div_position = previous_div.position();
							previous_div_position_top = previous_div_position.top;
							
							current_top = parseFloat(previous_div_position_top) + parseFloat(previous_div.outerHeight()) + 20;
						}
					
						
						$('#'+current_id).fadeIn("slow");	//这边会因为展开速度过慢而导致高度错误
						current_left = (current_id_num%3)*250 + (current_id_num%3)*20;
					}
					page_offset = page_offset +  limit;
					refresh_lock = false;
				}
			});
		}
	}
	
	function getIndexActivityRecommend(action_type){
		if (action_type == 'add_activity') {
			$.ajax({
				url:"__('base_ajax_action_controller/getHotActivityInformation'|site_url)__",
				data:'page_offset='+0+'&limit='+10,
				type: "GET",
				dataType: "JSON",
				async: false,
				success:function(data){
					var n = 0;
					window.activity_recommend_content = new Array();
					for(i in data){
						if(data[i].activity_name.length > 11) {
							data[i].activity_name = data[i].activity_name.substr(0,11) + '...';
						}
						var index_activity_recommend_show = '<div class=\"index_activity_recommend_show\" id="index_activity_recommend_'+n+'" >'+
																'<div class=\"image\"><a href=\"__("activity/view"|site_url)__?id='+data[i].activity_id+'\"><img src=\"'+data[i].activity_image+'\" width=\"105\" height=\"105\"></a></div>'+
																'<div class="context">'+
																	'<div class="title"><a href="__("activity/view"|site_url)__?id='+data[i].activity_id+'">'+data[i].activity_name+'</a></div>'+
																	'<div class="start_time">开始时间: '+data[i].start_time+'</div>'+
																	'<div class="end_time">结束时间: '+data[i].end_time+'</div>'+
																	'<div class="publisher"><a href=\"__("member"|site_url)__?id='+data[i].member_id+'\">'+data[i].member_name+'</a></div>'+
																	'<div class="number">'+
																		'<div class="attend_number"><span>'+data[i].attend_number+'</span>人参加</div>'+
																		'<div class="attention_number"><span>'+data[i].attention_number+'</span>人关注</div>'+
																	'</div>'+
																'</div>'+
															'</div>';
						activity_recommend_content[n] = index_activity_recommend_show;
						n++;
					}
					$("#activity_recommend_content").append(activity_recommend_content[0]);
					$("#activity_recommend_content").append(activity_recommend_content[1]);
					
					$('#index_activity_recommend_0,#index_activity_recommend_1').fadeIn('slow');
					
					current_index_activity_recommend = 1;
				}
			});
		} else {
			if (action_type == 'right'){
				if (current_index_activity_recommend + 1 < activity_recommend_content.length) {
					$('#activity_recommend_content .index_activity_recommend_show').fadeOut('slow');
					$('#activity_recommend_content .index_activity_recommend_show').remove();
				
					for (i = 1; i <= 2 ; i++ ){
						if (current_index_activity_recommend + 1 < activity_recommend_content.length) {
							current_index_activity_recommend++;
							$("#activity_recommend_content").append(activity_recommend_content[current_index_activity_recommend]);
						} else {
							current_index_activity_recommend++;
						}
					}
					$('#activity_recommend_content .index_activity_recommend_show').fadeIn('slow');
				}
			} else if (action_type == 'left'){
				if (current_index_activity_recommend - 1 > 0) {
					current_index_activity_recommend--;
					$('#activity_recommend_content .index_activity_recommend_show').fadeOut('slow');
					$('#activity_recommend_content .index_activity_recommend_show').remove();
					for (i = 1; i <= 2 ; i++ ){
						if (current_index_activity_recommend - 1 >= 0) {
							current_index_activity_recommend--;
							$("#activity_recommend_content").prepend(activity_recommend_content[current_index_activity_recommend]);
						} else {
							
						}
					}
					
					$('#activity_recommend_content .index_activity_recommend_show').fadeIn('slow');
					current_index_activity_recommend++;
				}
			}
		}
	}
	
	$(function(){
		
		//导航提示
		$('#nav_01').css('color','#ad4c4c');
		
		addIndexActivityShow();
		getIndexActivityRecommend('add_activity');
		
		$(window).scroll(function() {
			if (document.body.clientHeight - document.documentElement.scrollTop -  document.documentElement.clientHeight <= 10 ){
				addIndexActivityShow();
			}
		});
		
	});
	
</script>


<div id="index_frame">
	<div class="left_side">
	__(include file="__($template)__/layout/menu_box.tpl")__
	</div>
	
	<div class="right_side">
		<div class="activity_recommend">
			<span class="title">热门活动TOP10</span>
			
			<div class="content" id="activity_recommend_content">
				<div class="arrows_left"><img src="__($config.template_prefix)__images/ico/arrows_left.gif" onclick="getIndexActivityRecommend('left')" ></div>
				<div class="arrows_right"><img src="__($config.template_prefix)__images/ico/arrows_right.gif" onclick="getIndexActivityRecommend('right')" ></div>
			</div>
		</div>
		
		
		<div class="activity_list">
			<span class="title">最新活动</span>
			<div class="content" id="activity_list_content">
				
					
			</div>
		</div>
		
		
	</div>
<div class="clear"></div>
</div>