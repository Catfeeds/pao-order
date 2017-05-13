<?php if (!defined('THINK_PATH')) exit();?>﻿<!DOCTYPE html>
<html lang="zh-CN">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

	<!-- Bootstrap 核心 CSS 文件 -->
	<link rel="stylesheet" href="/Public/bootstrap/css/bootstrap.min.css">
	<!-- layer CSS 文件 -->
	<link rel="stylesheet" href="/Public/css/layer.css">
	
	<!-- common CSS 文件 -->
	<link rel="stylesheet" href="/Public/css/common.css">
	<!-- main CSS 文件 -->
	<link rel="stylesheet" href="/Public/css/main.css">
	<!-- horizontal CSS 文件 -->
	<link rel="stylesheet" href="/Public/css/horizontal.css">
	
	<!-- 更换颜色 CSS 文件 -->
	<link rel="stylesheet" href="/Public/css/color_orange.css" id="global-css">
	<!-- HTML5 Shim 和 Respond.js 用于让 IE8 支持 HTML5元素和媒体查询 -->
	<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
	<script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
	<![endif]-->

	<!-- jQuery文件。务必在bootstrap.min.js 之前引入 -->
	
	<script src="/Public/js/jquery-3.1.0.min.js"></script>
	<!-- 最新的 Bootstrap 核心 JavaScript 文件 -->
	<script src="/Public/bootstrap/js/bootstrap.min.js"></script>
	<script src="/Public/js/home.js"></script>
	
	<script src="/Public/js/layer.js"></script>
	<script>
		$(function(){
			//横屏客户端模板颜色更改
			var tpl = $("#tpl").val();
			if(tpl==0){
				$('#global-css').attr('href','/Public/css/color_red.css');
			}else if(tpl==1){
				$('#global-css').attr('href','/Public/css/color_blue.css');
			}else if(tpl==2){
				$('#global-css').attr('href','/Public/css/color_green.css');
			}else if(tpl==3){
				$('#global-css').attr('href','/Public/css/color_yellow.css');
			}else if(tpl==4){
				$('#global-css').attr('href','/Public/css/color_black.css');
			}else{
				$('#global-css').attr('href','/Public/css/color_orange.css');
			}	
		})
	</script>
	
	<title>方雅点餐系统</title>
	
</head>

	

<body>
	<header class="home-header">
		<a href="/index.php/Home/Index/index">
			<img src="/Public/images/lt.png">
			<span>返回</span>
		</a>
	<input type="hidden" name="tpl" value="<?php echo ($tpl); ?>" id="tpl"/>
	</header>
	<div class="select">
		<div class="container-fluid">
			<h1 class="text-center green">请选择</h1>
			<div class="row">
				<div class="col-xs-6 forHere">
					<a href="/index.php/Home/Index/processRoute/process/select/order_type/1"><img src="/Public/images/restaurant.png"></a>
				</div>
				<div class="col-xs-6 goTo">
					<a href="/index.php/Home/Index/processRoute/process/select/order_type/2"><img src="/Public/images/take_out.png"></a>
				</div>
			</div>
		</div>
	</div>	
	<footer class="home-footer"></footer>
</body>
</html>