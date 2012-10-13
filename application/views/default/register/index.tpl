<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>__($site_name)__</title>
<meta name="keywords" content="__($site_keyword)__" />
<meta name="description" content="__($site_description)__" />

<!--JS-->
<script type="text/javascript" src="__($config.application_inc)__jquery/jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="__($config.application_inc)__jquery/jquery-ui-1.8.19.custom.min.js"></script>

<!--JS END-->

<!--validationEngine-->
<script type="text/javascript" src="__($config.application_inc)__jquery/validationEngine/jquery.validationEngine.js"></script>
<script type="text/javascript" src="__($config.application_inc)__jquery/validationEngine/languages/jquery.validationEngine-zh_CN.js"></script>
<link rel="stylesheet" href="__($config.application_inc)__jquery/validationEngine/css/validationEngine.jquery.css" type="text/css" media="all" />
<!--end-->


<!-- CSS -->

<link href="__($config.application_inc)__jquery/css/ui-lightness/jquery-ui-1.8.19.custom.css" rel="stylesheet" type="text/css" media="screen" />
<link href="__($config.template_prefix)__css/register.css" rel="stylesheet" type="text/css" media="screen" />
<!-- CSS End -->
</head>

<body>

<script>
	$(function() {
		$( "#register_box" ).tabs();
		
		$( "#select_school_box" ).dialog({
			autoOpen: false,
			show: "blind",
			hide: "explode",
			buttons: {"确认":function(){
						$( "#select_school_box" ).dialog( "close" );
					},
					"取消":function(){
						$( "#select_school_box" ).dialog( "close" );
					}
			},
			open:function(){
				if ($("#select_province").css('display') == 'none') {
					selectCurrenSchool('province','');
				};
			}
		});
		
		$("input[name='current_school']").focus(function(){
			$( "#select_school_box" ).dialog( "open" );
		});
		
		$("form").validationEngine();
		
		$(":input").focus(function(){
			$(this).validationEngine('hide');
		});
		
	});
	
</script>

<script>
	function selectCurrenSchool(type,id) {
		if (type == 'province'){
			$.getJSON("__('base_ajax_controller/getAllProvinceInformation'|site_url)__",function(data){
				var province_html = '';
				for (i in data){
					if (data[i].has_city == 'N') {
						province_html = province_html + '<a onclick=\"selectCurrenSchool(\'area\','+data[i].area_id+')\">'+data[i].name+'</a>';
					} else {
						province_html = province_html + '<a onclick=\"selectCurrenSchool(\'city\','+data[i].area_id+')\">'+data[i].name+'</a>';
					}
					$("#select_province").html(province_html);
					$("#select_province").css('display','block');
				}
			});
				
		}else if (type == 'city'){
			$.getJSON("__('base_ajax_controller/getAllCityInformation'|site_url)__?city_id="+id,function(data){
				var city_html = '';
				for (i in data){
					city_html = city_html + '<a onclick=\"selectCurrenSchool(\'area\','+data[i].area_id+')\">'+data[i].name+'</a> ';
					$("#select_city").html(city_html);
					$("#select_city").css('display','block');
				}
			});
		}else if (type == 'area'){
			$.getJSON("__('base_ajax_controller/getAllAreaInformation'|site_url)__?area_id="+id,function(data){
				var area_html = '';
				for (i in data){
					area_html = area_html + '<a onclick=\"selectCurrenSchool(\'school\','+data[i].area_id+')\">'+data[i].name+'</a> ';
					$("#select_area").html(area_html);
					$("#select_area").css('display','block');
				}
			});
			
		}else if (type == 'school'){
			$.getJSON("__('base_ajax_controller/getAllSchoolInformation'|site_url)__?area_id="+id,function(data){
				var school_html = '';
				for (i in data){
					school_html = school_html + '<a onclick=\"selectCurrenSchool(\'current_school\','+data[i].school_id+')\">'+data[i].name+'</a> ';
					$("#select_school").html(school_html);
					$("#select_school").css('display','block');
				}
			});
			
		}else if (type == 'current_school'){
			$.getJSON("__('base_ajax_controller/getSchoolInformation'|site_url)__?school_id="+id,function(data){
				$("input[name='current_school']").val(data.name);
				$("input[name='current_school_id']").val(data.school_id);
				$("input[name='current_school']").validationEngine('hide');
				$( "#select_school_box" ).dialog( "close" );
			});
		}
	}

</script>

<div id="body_frame">
	
	<div id="register_main">
		
		<div id="register_box" style="clear:both;">
			<ul>
				<li><a href="#student">学生</a></li>
				<li><a href="#student_organization">学生组织</a></li>
				<li><a href="#commonweal_organization">公益组织</a></li>
				<li><a href="#company">公司</a></li>
			</ul>
			
			<div id="student" class="index_tabs register_form">
				<form action="__('register/saveForm'|site_url)__" method="post">
					<fieldset>
						<p><label>帐号:</label><input type="text" class="validate[required,custom[account]]" name="account" /></p>
						<p><label>密码:</label><input id="password1" type="password" class="validate[required,custom[password]]" name="password" /></p>
						<p><label>重复:</label><input type="password" class="validate[required,equals[password1]]" name="re_password" /></p>
						<p><label>真实姓名:</label><input type="text" name="name" class="member_name validate[required]" /></p>
						<p class="note">【为了方便活动主办方联系你，请务必填写真实姓名】</p>
						<p><label>学校:</label><input id="current_school" class="validate[required]" type="text" name="current_school" readonly="readonly" />
							<input type="hidden" name="current_school_id" />
						</p>
						<p><label>邮箱:</label><input type="text" class="validate[required,custom[email]]" name="email" /></p>
						<input type="hidden" name="member_type" value="student">
						<p><button type="submit">注册</button></p>
					</fieldset>
				</form>
			</div>
			
			<div id="student_organization" class="index_tabs register_form">
				<form action="__('register/saveForm'|site_url)__" method="post">
					<fieldset>
						<p><label>帐号:</label><input type="text" class="validate[required,custom[account]]" name="account" /></p>
						<p><label>密码:</label><input id="password2" type="password" class="validate[required,custom[password]]" name="password" /></p>
						<p><label>重复:</label><input type="password" class="validate[required,equals[password2]]" name="re_password" /></p>
						<p><label>组织名称:</label><input type="text" name="name" class="member_name validate[required]" /></p>
						<p class="note">【请填写完整组织名称】</p>
						<p><label>学校:</label><input id="current_school" class="validate[required]" type="text" name="current_school" readonly="readonly" />
							<input type="hidden" name="current_school_id" />
						</p>
						<p><label>邮箱:</label><input type="text" class="validate[required,custom[email]]" name="email" /></p>
						<input type="hidden" name="member_type" value="student_organization">
						<p><button type="submit">注册</button></p>
					</fieldset>
				</form>
			</div>
			
			<div id="commonweal_organization" class="index_tabs register_form">
				<form action="__('register/saveForm'|site_url)__" method="post">
					<fieldset>
						<p><label>帐号:</label><input type="text" class="validate[required,custom[account]]" name="account" /></p>
						<p><label>密码:</label><input id="password3" type="password" class="validate[required,custom[password]]" name="password" /></p>
						<p><label>重复:</label><input type="password" class="validate[required,equals[password3]]" name="re_password" /></p>
						<p><label>组织名称:</label><input type="text" name="name" class="member_name validate[required]" /></p>
						<p class="note">【请填写完整组织名称】</p>
						<p><label>邮箱:</label><input type="text" name="email" class="validate[required,custom[email]]" /></p>
						<input type="hidden" name="member_type" value="commonweal_organization">
						<p><button type="submit">注册</button></p>
					</fieldset>
				</form>
			</div>
			
			<div id="company" class="index_tabs register_form">
				<form action="__('register/saveForm'|site_url)__" method="post">
					<fieldset>
						<p><label>帐号:</label><input type="text" class="validate[required,custom[account]]" name="account" /></p>
						<p><label>密码:</label><input id="password4" type="password" class="validate[required,custom[password]]" name="password" /></p>
						<p><label>重复:</label><input type="password" class="validate[required,equals[password4]]" name="re_password" /></p>
						<p><label>公司名称:</label><input type="text" name="name" class="member_name validate[required]" /></p>
						<p class="note">【请填写完整公司名称】</p>
						<p><label>邮箱:</label><input type="text" class="validate[required,custom[email]]" name="email" /></p>
						<input type="hidden" name="member_type" value="company">
						<p><button type="submit">注册</button></p>
					</fieldset>
				</form>
			</div>
		</div>
		
		<div id="select_school_box">
			<div id="select_province"></div>
			<div id="select_city"></div>
			<div id="select_area"></div>
			<div id="select_school"></div>
		</div>
		
	</div>
	
	
</div>
</body>
</html>