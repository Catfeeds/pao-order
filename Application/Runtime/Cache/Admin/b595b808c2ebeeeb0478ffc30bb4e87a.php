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
<body class="admin-body">
	<header class="admin-header">
		<div class="container-fluid clearfix">
			<div class="pull-left header-title">店铺后台</div>
			<div class="pull-right header-user text-right">
				<button class="btn-none" data-toggle="modal" >尊敬的：<span id="account"><?php echo (session('login_account')); ?></span></button> <!--onclick="modify_manager(<?php echo (session('re_admin_id')); ?>)" data-target="#edit-user"  -->
				<button class="btn-none" onclick="loginout()">退出</button>
			</div>
		</div>
	</header>

	<!-- 左侧导航栏 -->	
	<aside class="sidebar">
		<div class="admin-logo">
			<img src="<?php echo ($logo); ?>">
		</div>
		<ul class="sidebar-menu">
			<li class="treeview">
				<div class="treeview-header active">
					<a href="<?php echo U('Restaurant/index');?>" target='rightFrame'>商家信息</a>
					<div class="pull-right-container plus-icon"></div>
				</div>
			</li>
			<li class="treeview">
				<div class="treeview-header">
					<span>模板</span>
					<div class="pull-right-container plus-icon"></div>
				</div>
				<ul class="treeview-menu">
					<li>
						<a href="<?php echo U('Moudle/index');?>" target='rightFrame'>点餐流程</a>
					</li>
					<li>
						<a href="<?php echo U('Moudle/device');?>" target='rightFrame'>点餐设备界面</a>
					</li>

					<!-- <li>
						<a href="<?php echo U('Moudle/mobile');?>" target='rightFrame'>手机端界面</a>
					</li> -->
					<li>
						<a href="<?php echo U('Restaurant/receipt');?>" target='rightFrame'>用户小票模板</a>
					</li>
				</ul>
			</li>
			<li class="treeview">
				<div class="treeview-header">
					<span>设备管理</span>
					<div class="pull-right-container plus-icon"></div>
				</div>
				<ul class="treeview-menu">
					<li>
						<a href="<?php echo U('Device/index');?>" target='rightFrame'>点餐设备管理</a>
					</li>
					<!-- <li>
						<a href="<?php echo U('device/show_num_device');?>" target='rightFrame'>叫号屏管理</a>
					</li>
					<li>
						<a href="<?php echo U('Device/wechat');?>" target='rightFrame'>微信点餐</a>
					</li>
					<li>
						<a href="<?php echo U('billBoard/index');?>" target='rightFrame'>电子餐牌</a>
					</li>					
					<li>
						<a href="<?php echo U('Device/deskInfo');?>" target='rightFrame'>餐桌二维码</a>
					</li> -->
				</ul>
			</li>
			<li class="treeview">
				<div class="treeview-header">
					<a href="<?php echo U('Dishes/index');?>" target='rightFrame'>菜品设置</a>
					<div class="pull-right-container plus-icon"></div>
				</div>
			</li>
			<li class="treeview">
				<div class="treeview-header">
					<span>销售统计</span>
					<div class="pull-right-container plus-icon"></div>
				</div>
				<ul class="treeview-menu">
					<li>
						<a href="<?php echo U('Sale/food_chart');?>" target='rightFrame'>菜品图表</a>
					</li>
					<li>
						<a href="<?php echo U('Sale/index');?>" target='rightFrame'>查询</a>
					</li>
					<li>
						<a href="<?php echo U('Sale/data');?>" target='rightFrame'>数据表</a>
					</li>
				</ul>
			</li>
			<li class="treeview">
				<div class="treeview-header">
					<span>数据对接</span>
					<div class="pull-right-container plus-icon"></div>
				</div>
				<ul class="treeview-menu">
					<li>
						<a href="<?php echo U('DataDock/dataForPay');?>" target='rightFrame'>支付对接</a>
					</li>
					<li>
						<a href="<?php echo U('DataDock/printer');?>" target='rightFrame'>打印机对接</a>
					</li>
				</ul>
			</li>
			<!-- <li class="treeview">
				<div class="treeview-header">
					<a href="<?php echo U('Accounts/index');?>" target='rightFrame'>前台收银账号</a>
					<div class="pull-right-container plus-icon"></div>
				</div>
			</li> -->

			<!-- <li class="treeview">
				<div class="treeview-header">
					<span>增值系统</span>
					<div class="pull-right-container plus-icon"></div>
				</div>
				<ul class="treeview-menu">
					<li>
						<a href="#">餐桌定位系统</a>
					</li>
					<li>
						<a href="#">电子餐牌系统</a>
					</li>
				</ul>
			</li> -->
			<!-- <li class="treeview">
				<div class="treeview-header">
					<span>会员管理</span>
					<div class="pull-right-container plus-icon"></div>
				</div>
				<ul class="treeview-menu">
                    <li>
                        <a href="<?php echo U('Member/vip_group');?>" target='rightFrame'>会员组设置</a>
                    </li>
					<li>
						<a href="<?php echo U('Member/discount');?>" target='rightFrame'>消费折扣</a>
					</li>
					<li>
						<a href="<?php echo U('Member/prepaid');?>" target='rightFrame'>预充值</a>
					</li>
					<li>
						<a href="<?php echo U('Member/point_set');?>" target='rightFrame'>积分设置</a>
					</li>
					<li>
						<a href="<?php echo U('Member/point_consumptio');?>" target='rightFrame'>积分消费</a>
					</li>
				</ul>
			</li> -->

		</ul>
	</aside>

	<iframe id="rightFrame" name="rightFrame" scrolling="auto" src="<?php echo U('restaurant/index');?>"></iframe>

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
										<input type="text" name="manager_account" class="form-control"></td>
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
</body>
<script>
	function loginout(){
		var msg = confirm("确定要退出？");
		if(msg == true){
			$.ajax({
				type:"get",
				url:"/index.php/admin/Index/loginout",
				async:true,
				dataType:"json",
				success:function(data){
					if(data.code == 0){
						location.href = "/index.php/admin/Index/login";
					}else{
						location.href = "/index.php/home/checkstand/admin_login";
					}
				}
			});
		}
	}
	
	//管理员帐号修改
	function modify_manager(i){
		console.log(i);
		$.ajax({
			type:"get",
			url:"/index.php/Admin/index/account_edit/id/"+i+"",
			async:true,		
			dataType:"json",
			success:function(data){
				console.log(data);
				$("input[name='manager_id']").val(data.id);
				$("input[name='manager_account']").val(data.login_account);
				$("input[name='manager_password']").val(data.password);
				$("input[name='manager_passwords']").val(data.password);
			}
		});
		
	}
	
	function update_account(){
		var manager_account = $("input[name='manager_account']").val();
		var manager_password = $("input[name='manager_password']").val();
		var manager_passwords = $("input[name='manager_passwords']").val();
		if(manager_account && manager_password && manager_passwords){
			if(manager_password == manager_passwords){
				$.ajax({
					type:"post",
					url:"/index.php/Admin/index/update_account",
					async:true,
					data:$("#myform").serialize(),
					success:function(data){
						alert(data.msg);
						if(data.code == 1){
							$('#edit-user').modal('hide');
							$("#account").html(data.data);
						}
					},
				});
			}else{
				alert("密码不一致");
			}
		}else{
			alert("所显示项不能为空!")
		}
	}
	
</script>
</html>