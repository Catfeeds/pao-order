<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh-CN">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

	<!-- Bootstrap 核心 CSS 文件 -->
	<link rel="stylesheet" href="/Public/bootstrap/css/bootstrap.min.css">

	<!-- admin CSS 文件 -->
	<link rel="stylesheet" href="/Public/css/agent.css">
	<!-- HTML5 Shim 和 Respond.js 用于让 IE8 支持 HTML5元素和媒体查询 -->	
	<!--[if lt IE 9]>	
		<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
		<script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
	<![endif]-->

	<!-- jQuery文件。务必在bootstrap.min.js 之前引入 -->
	<script src="/Public/js/jquery-3.1.0.min.js"></script>
	<!-- 最新的 Bootstrap 核心 JavaScript 文件 -->
	<script src="/Public/bootstrap/js/bootstrap.min.js"></script>

	<!-- layer CSS 文件 -->
	<link rel="stylesheet" href="/Public/css/layer.css">
	<script src="/Public/js/layer.js"></script>
	<title>方雅点餐系统代理后台</title>
</head>

<body class="members-index">
	<link rel="stylesheet" type="text/css" href="/Public/bootstrap-datetimepicker-master/bootstrap-datetimepicker.min.css">
	<aside class="members-sidebar">
		<ul class="sidebar-menu">
			<li class="treeview">
			    <a href="<?php echo U('Members/vip_group');?>" target='memberiframe' class="treeview-header active">会员组设置</a>
			</li>
			<li class="treeview">
				<a  href="<?php echo U('Members/prepaid');?>" target='memberiframe' class="treeview-header">预充值</a>
			</li>
			<li class="treeview">
				<div class="treeview-header">积分管理</div>
				<ul class="treeview-menu">
					<li>
						<a href="<?php echo U('Members/point_set');?>" target='memberiframe'>积分设置</a>					
					</li>
					<li>
						<a href="<?php echo U('Members/point_consumptio');?>" target='memberiframe'>积分消费</a>
					</li>
				</ul>
			</li>
			<li class="treeview">
				<a href="<?php echo U('Members/members');?>" target='memberiframe' class="treeview-header">会员信息</a>
			</li>			
			<!--<li class="treeview">
				<a href="<?php echo U('Members/sms_marketing');?>" target='memberiframe' class="treeview-header">会员短信营销</a>
			</li>	-->
			<li class="treeview">
				<a href="<?php echo U('Members/sms_docking');?>" target='memberiframe' class="treeview-header">短信对接</a>
			</li>
			<li class="treeview">
				<a href="<?php echo U('Members/official_accounts');?>" target='memberiframe' class="treeview-header">公众号设置</a>
			</li>			
		</ul>
	</aside>
	<div class="right-content">
		<iframe src="<?php echo U('Members/vip_group');?>" class="member-iframe" name="memberiframe"></iframe>
	</div>

	<script src="/Public/bootstrap-datetimepicker-master/bootstrap-datetimepicker.min.js"></script>
	<script src="/Public/bootstrap-datetimepicker-master/bootstrap-datetimepicker.zh-CN.js"></script>
	<script src="/Public/js/membersManage.js"></script>

</body>
</html>