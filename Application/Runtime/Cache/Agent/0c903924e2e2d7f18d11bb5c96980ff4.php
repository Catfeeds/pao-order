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

<body>
<header class="header clearfix">
	<div class="pull-left">
		<ul class="clearfix">
			<li class="active">
				<a href="<?php echo U('Store/store');?>" target="main-frame">店铺管理</a>
			</li>
			<li>
				<a href="<?php echo U('Device/device');?>" target="main-frame">设备管理</a>
			</li>			
			<li id="statistics">
				<a href="javascript:void(0)" target="main-frame">数据统计</a>
				<div class="statistics-list">
					<a href="<?php echo U('Sale/index');?>" target="main-frame">店铺营业情况</a>
					<a href="<?php echo U('Sale/data');?>" target="main-frame">营业情况图表</a>
					<!-- <a href="<?php echo U('Sale/vipConsumeData');?>" target="main-frame">店铺会员统计</a> -->
				</div>
			</li>
			<!-- <li>
				<a href="<?php echo U('Members/index');?>" target="main-frame">会员管理</a>
			</li> -->
			<!--<li>
				<a href="<?php echo U('Admin/admin');?>" target="main-frame">管理员管理</a>
			</li>-->
            <!-- <li>
				<a href="<?php echo U('Members/pay');?>" target="main-frame">微信支付对接</a>
			</li> -->
			<li id="statistics2">
				<a href="javascript:void(0)" target="main-frame">激活码</a>
				<div class="statistics-list2">
					<a href="<?php echo U('Code/codeList');?>" target="main-frame">点餐机</a>
					<!-- <a href="<?php echo U('DeskCode/deskCode');?>" target="main-frame">餐桌二维码</a> -->
				</div>
			</li>
		</ul>
	</div>
	<div class="pull-right header-user">
		<button class="btn-none" data-toggle="modal" data-target="#edit-user" onclick="modify_manager(<?php echo (session('business_id')); ?>)">尊敬的：<span id="account"><?php echo (session('business_account')); ?></span></button>
		<button class="btn-none" onclick="loginout()">退出</button>
	</div>
</header>
<iframe src="<?php echo U('Store/store');?>" name="main-frame" class="main"></iframe>

<div class="modal fade in" id="edit-user" tabindex="-1" role="dialog">
	<div class="modal-dialog">
		<div class="password-modal">
			<div class="password-content">
				<div class="modal-head">修改密码</div>
				<div class="container-fluid">
					<table>
						<form id="myform">
							<tbody>
							<input type="hidden" name="manager_id"/>
							<tr>
								<td>帐号：</td>
								<td class="form-inline">
									<input type="text" name="manager_account" class="form-control" disabled="disabled"></td>
							</tr>
							<tr>
								<td>修改密码：</td>
								<td class="form-inline">
									<input type="password" name="manager_password" class="form-control"></td>
							</tr>
							<tr>
								<td>确认密码：</td>
								<td class="form-inline">
									<input type="password" name="manager_passwords" class="form-control"></td>
							</tr>
							</tbody>
						</form>
					</table>
				</div>
				<div class="text-center">
					<button type="button" class="btn btn-danger" data-dismiss="modal">关闭</button>
					<button type="button" class="btn btn-primary" onclick="update_account()">修改</button>
				</div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript" src="/Public/js/Agent/index.js"></script>
</body>
</html>