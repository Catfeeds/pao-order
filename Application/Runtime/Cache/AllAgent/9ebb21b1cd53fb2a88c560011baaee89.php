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

	<header class="header clearfix">
		<div class="pull-left">
			<ul class="clearfix">
				<li class="active">
					<a href="<?php echo U('Agent/agent');?>" target="main-iframe">品牌商管理</a>
				</li>
				<li>
					<a href="<?php echo U('Device/device');?>" target="main-iframe">设备管理</a>
				</li>
				<li>
					<a href="<?php echo U('Admin/admin');?>" target="main-iframe">管理员管理</a>
				</li>
				<li>
					<a href="<?php echo U('Code/code');?>" target="main-iframe">注册码</a>
				</li>
				<!-- <li>
					<a href="<?php echo U('deskQrc/qrc_code');?>" target="main-iframe">餐桌二维码</a>
				</li>
				<li>
					<a href="<?php echo U('Systemset/set');?>" target="main-iframe">系统设置</a>
				</li> -->
			</ul>
		</div>
		<div class="pull-right header-user">
			<button class="btn-none" data-toggle="modal" data-target="#edit-user" onclick="modify_manager(<?php echo (session('manager_id')); ?>)">尊敬的：<span id="account"><?php echo (session('manager_account')); ?></span></button>
			<button class="btn-none" onclick="loginout()">退出</button>
		</div>
	</header>

	<iframe src="<?php echo U('Agent/agent');?>" class="main" name="main-iframe"></iframe>

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
	<script src="/Public/js/AllAgent/index.js"></script>
</html>