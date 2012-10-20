<html>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<head>
<title><?php echo $message ?></title>
<link href="/application/views/default/css/error.css" rel="stylesheet" type="text/css" media="screen" />
</head>
<body>
	<div id="content">
		<div id="error_report">
			<div id="error_information"><?php echo $message ?></div>
			<div id="tools">
				<span class="note">点击此处</span>
				<span class="button" onclick="history.back()">返回</span>
			</div>
		</div>
	</div>
	
	<!--
		<?php
		 echo $message;
		?>
	-->
</body>
</html>