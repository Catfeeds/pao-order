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
<!-- 点餐设备 -->
<body>
<div class="container-fluid" id="row">
	<!-- 点餐设备界面 start-->
	<div class="device-horizontal" >
		<div class="device-left">横屏:</div>
		<div class="clearfix">
			<?php if(is_array($info)): $i = 0; $__LIST__ = array_slice($info,0,1,true);if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><div class="pull-left device-item">
					<div class="ad-imgBox">
						<img src="<?php echo ($v["group_img_url"]); ?>">
					</div>
					<div class="mt-5 clearfix">
						<div class="color-select color-red pull-left">
							<input type="radio" name="color" class="color1" value="0"/>
						</div>
						<div class="color-select color-blue pull-left">
							<input type="radio" name="color" class="color1" value="1"/>
						</div>
						<div class="color-select color-green pull-left">
							<input type="radio" name="color" class="color1" value="2"/>
						</div>
						<div class="color-select color-yellow pull-left">
							<input type="radio" name="color" class="color1" value="3"/>
						</div>
						<div class="color-select color-brown pull-left">
							<input type="radio" name="color" class="color1" value="4"/>
						</div>
						<div class="color-select color-orange pull-left">
							<input type="radio" name="color" class="color1" value="5"/>
						</div>					
					</div>
					<div>
						<?php if(($v['status']) == "1"): ?><input type="radio" name = "heng" class="hengradio" data-tpltype = "1" value="<?php echo ($v["restaurant_page_group_id"]); ?>" checked="checked">
						<?php else: ?>
							<input type="radio" name = "heng" class="hengradio" data-tpltype = "1" value="<?php echo ($v["restaurant_page_group_id"]); ?>"><?php endif; ?>
						<span class="ml-10"><?php echo ($v["group_name"]); ?></span>
					</div>
				</div><?php endforeach; endif; else: echo "" ;endif; ?>
			<?php if(is_array($info)): $i = 0; $__LIST__ = array_slice($info,1,null,true);if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><div class="pull-left device-item">
					<div class="ad-imgBox">
						<img src="<?php echo ($v["group_img_url"]); ?>">
					</div>
					<div class="mt-5">
						<span>模板名：<span style="color: red;"><?php echo ($v["group_name"]); ?></span></span>
					</div>
					<div>
						<?php if(($v['status']) == "1"): ?><input type="radio" name = "heng" class="hengradio" data-tpltype = "1" value="<?php echo ($v["restaurant_page_group_id"]); ?>" checked="checked">订制模板
						<?php else: ?>
							<input type="radio" name = "heng" class="hengradio" data-tpltype = "1" value="<?php echo ($v["restaurant_page_group_id"]); ?>">订制模板<?php endif; ?>
					</div>
				</div><?php endforeach; endif; else: echo "" ;endif; ?>
			<div class="pull-left device-item">
				<div class="ad-imgBox">
					<img src="">
				</div>
				<div class="mt-5">
					<input type="text" placeholder="请输入模板注册码" data-tpltype = "1"  onchange="findTelp(this)"></div>
				<div>
					<input type="radio" name = "heng" class="hengradio">订制模板</div>
			</div>
		</div>	
	</div>
	<div class="device-vertical" id="row1">
		<div class="device-left">竖屏:</div>
		<div class="clearfix">
			<?php if(is_array($info2)): $i = 0; $__LIST__ = array_slice($info2,0,1,true);if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v2): $mod = ($i % 2 );++$i;?><div class="pull-left device-item">
				<div class="ad-imgBox">
					<img src="<?php echo ($v2["group_img_url"]); ?>">
				</div>			
				<div class="mt-5 clearfix">
					<div class="color-select color-red pull-left">
						<input type="radio" name="color_shu" class="color2" value="0" />
					</div>
					<div class="color-select color-blue pull-left">
						<input type="radio" name="color_shu" class="color2" value="1" />
					</div>
					<div class="color-select color-green pull-left">
						<input type="radio" name="color_shu" class="color2" value="2" />
					</div>
					<div class="color-select color-yellow pull-left">
						<input type="radio" name="color_shu" class="color2" value="3"/>
					</div>
					<div class="color-select color-brown pull-left">
						<input type="radio" name="color_shu" class="color2" value="4"/>
					</div>
					<div class="color-select color-orange pull-left">
						<input type="radio" name="color_shu" class="color2" value="5"/>
					</div>
				</div>
				<div>
					<?php if(($v2['status']) == "1"): ?><input type="radio" name = "shu" value="<?php echo ($v2["restaurant_page_group_id"]); ?>" data-tpltype = '2' class="shuradio" checked="checked">
					<?php else: ?>
						<input type="radio" name = "shu" value="<?php echo ($v2["restaurant_page_group_id"]); ?>" data-tpltype = '2' class="shuradio"><?php endif; ?>
					<span class="ml-10"><?php echo ($v2["group_name"]); ?></span>
				</div>
			</div><?php endforeach; endif; else: echo "" ;endif; ?>
			<?php if(is_array($info2)): $i = 0; $__LIST__ = array_slice($info2,1,null,true);if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v2): $mod = ($i % 2 );++$i;?><div class="pull-left device-item">
					<div class="ad-imgBox">
						<img src="<?php echo ($v2["group_img_url"]); ?>">
					</div>
					<div class="mt-5">
						<span>模板名：<span style="color: red;"><?php echo ($v2["group_name"]); ?></span></span>
					</div>
					<div>
						<?php if(($v2['status']) == "1"): ?><input type="radio" name = "shu" value="<?php echo ($v2["restaurant_page_group_id"]); ?>" data-tpltype = '2' class="shuradio" checked="checked">订制模板
						<?php else: ?>
							<input type="radio" name = "shu" value="<?php echo ($v2["restaurant_page_group_id"]); ?>" data-tpltype = '2' class="shuradio">订制模板<?php endif; ?>
					</div>
				</div><?php endforeach; endif; else: echo "" ;endif; ?>
			<div class="pull-left device-item">
				<div class="ad-imgBox">
					<img src="">
				</div>
					<div class="mt-5">
						<input type="text" placeholder="请输入模板名称" data-tpltype='2' onchange="findTelp(this)">
					</div>
					<div>
						<input type="radio" name = "shu" value="<?php echo ($v2["restaurant_page_group_id"]); ?>" class="shuradio">订制模板
					</div>
			</div>
		</div>		
	</div>
</div>
</body>
<script type="text/javascript" src="/Public/js/Moudle_device_mobile.js"></script>
</html>