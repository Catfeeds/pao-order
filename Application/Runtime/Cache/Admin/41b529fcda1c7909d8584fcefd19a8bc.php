<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh-CN">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

	<!-- Bootstrap 核心 CSS 文件 -->
	<link rel="stylesheet" href="/Public/bootstrap/css/bootstrap.min.css">

	<!-- admin CSS 文件 -->
	<link rel="stylesheet" href="/Public/css/admin.css">
	<link rel="stylesheet" href="/Public/css/layer.css">
	<!-- HTML5 Shim 和 Respond.js 用于让 IE8 支持 HTML5元素和媒体查询 -->	
	<!--[if lt IE 9]>	
		<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
		<script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
	<![endif]-->

	<!-- jQuery文件。务必在bootstrap.min.js 之前引入 -->
	<script src="/Public/js/jquery-3.1.0.min.js"></script>
	<!-- 最新的 Bootstrap 核心 JavaScript 文件 -->
	<script src="/Public/bootstrap/js/bootstrap.min.js"></script>
	<script src="/Public/js/common.js"></script>
	<script src="/Public/js/layer.js"></script>


	<title>方雅点餐系统 | 店铺后台</title>
</head>
<!-- 点餐设备管理 -->
<body>
<div class="container-fluid">
	<table class="device-table table-bordered">
		<tr>
			<td>序号</td>
			<td>设备名称</td>
			<td>机器码</td>
			<td>到期日期</td>
			<td>状态</td>
		</tr>
		<?php if(is_array($device_list)): $i = 0; $__LIST__ = $device_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
				<td><?php echo ($i); ?></td>
				<td><?php echo ($vo["device_name"]); ?></td>
				<td><?php echo ($vo["device_code"]); ?></td>
				<td>2017-11-05</td>
				<?php if($vo["device_status"] == 1): ?><td>开启</td>
					<?php else: ?>
					<td>关闭</td><?php endif; ?>
			</tr><?php endforeach; endif; else: echo "" ;endif; ?>
	</table>
	<div class="text-center device-page">
		<ul class="pagination">
			<?php echo ($page); ?>
		</ul>
	</div>
</div>
</body>
</html>