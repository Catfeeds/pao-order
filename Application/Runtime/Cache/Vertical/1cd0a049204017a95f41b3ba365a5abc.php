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
	<link rel="stylesheet" href="/Public/css/vertical.css">

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

	<script type="text/javascript">
		$(function(){
			var shu_tpl = $("#shu_tpl").val();
			if(shu_tpl==0){
				$('#global-css').attr('href','/Public/css/color_red.css');
			}else if(shu_tpl==1){
				$('#global-css').attr('href','/Public/css/color_blue.css');
			}else if(shu_tpl==2){
				$('#global-css').attr('href','/Public/css/color_green.css');
			}else if(shu_tpl==3){
				$('#global-css').attr('href','/Public/css/color_yellow.css');
			}else if(shu_tpl==4){
				$('#global-css').attr('href','/Public/css/color_black.css');
			}else{
				$('#global-css').attr('href','/Public/css/color_orange.css');
			}
		})
	</script>
	
	<title>方雅点餐系统</title>

</head>

	


<body>
	<div id="ad-carousel" class="carousel" data-ride="carousel" data-interval="<?php echo ($time); ?>" onclick="location='/index.php/Vertical/Index/processRoute/process/index'">
		<div class="carousel-inner" role="listbox" id="listbox">
			<?php if(is_array($info)): $i = 0; $__LIST__ = $info;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><div class="item">
					<img src="/<?php echo ($v["advertisement_image_url"]); ?>" alt="点击开始点餐">
				</div><?php endforeach; endif; else: echo "" ;endif; ?>
		</div>
	</div>
</body>

</html>