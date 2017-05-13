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
	<script src="/Public/js/layer.js"></script>
	<title>方雅点餐系统总后台</title>
</head>

<body>
	<link rel="stylesheet" type="text/css" href="/Public/bootstrap-datetimepicker-master/bootstrap-datetimepicker.min.css">

	<section class="clearfix">
		<aside class="set-sidebar">
			<h3 class="text-center">系统设置</h3>
			
			<ul class="sidebar-list">
				<li class="active">
					<span>系统设置1</span>
				</li>
				<li onclick="show_renew()">
					<span>设备续费属性修改</span>
				</li>
				<li>
					<span>其它设置</span>
				</li>
				<li>
					<span>系统设置4</span>
				</li>
			</ul>
		</aside>
		<div class="right-content" id="show_right">
			
		</div>
	</section>
	<script type="text/javascript" src="/Public/js/AllAgent/systemset.js"></script>
</body>
</html>