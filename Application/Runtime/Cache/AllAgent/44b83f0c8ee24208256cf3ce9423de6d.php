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

<style>
	.red_color{
		color: red;
	}
</style>
<body>
	<section class="container-fluid">
		<div class="main-content">		
			<?php echo tpl_AuthCheck('AllAgent/add_admin',$_SESSION['manager_id'],'or','<button data-toggle="modal" class="btn-black add-agent" onclick="showmodel()">新增管理员</button>','');?>
			<div id="mytable">
			<table class="table table-hover">
				<tr>
					<th>序号</th>
					<th>管理员帐号</th>
					<th>管理员密码</th>
					<th>管理员级别</th>
					<th>品牌商权限</th>
					<th>设备权限</th>
					<th>管理员权限</th>
					<th>手机号码</th>
					<th>备注</th>
					<th>操作</th>
				</tr>
				<?php if(is_array($Arrlist)): $i = 0; $__LIST__ = $Arrlist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><tr>	
					<td><?php echo ($key+1); ?></td>
					<td><?php echo ($v["manager_account"]); ?></td>
					<td>
						<span class="agent-psd">
							<?php echo (md5($v["manager_password"])); ?>
						</span>
					</td>		
					<td><?php echo ($v["title"]); ?></td>
					<td>品牌商(<?php if($v["title"] == '超级管理员'): ?>新增/编辑/删除
					<?php elseif($v["title"] == '高级管理员'): ?>新增/编辑/删除
					<?php elseif($v["title"] == '中级管理员'): ?>新增/编辑
					<?php else: endif; ?>);</td>
					<td>设备(<?php if($v["title"] == '超级管理员'): ?>新增/编辑/删除
					<?php elseif($v["title"] == '高级管理员'): ?>编辑/删除
					<?php elseif($v["title"] == '中级管理员'): ?>
					<?php else: endif; ?>);</td>
					<td>管理员(<?php if($v["title"] == '超级管理员'): ?>新增/编辑/删除
					<?php elseif($v["title"] == '高级管理员'): ?>
					<?php elseif($v["title"] == '中级管理员'): ?>
					<?php else: endif; ?>);</td>
					<td><?php echo ($v["manager_phone"]); ?></td>
					<td><?php echo ($v["manager_ps"]); ?></td>
					<td>
						<button class="btn btn-black" data-target="#addAdmin" data-toggle="modal" onclick="modify_admin(<?php echo ($v["manager_id"]); ?>)">编辑</button>
						<button class="btn btn-default" onclick="del_admin(<?php echo ($v["manager_id"]); ?>)">删除</button>
					</td>
				</tr><?php endforeach; endif; else: echo "" ;endif; ?>
			</table>
			<div>
			    <ul class="pagination" id="detail-page">
			        <?php echo ($page); ?>
			    </ul>
			</div>
			</div>
		</div>
	</section>

	<div class="modal fade" id="addAdmin" tabindex="-1" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-head" id="admintext">新增管理员</div>
				<form>
				<input type="hidden" name="commit_way" />
				<input type="hidden" name="manager_id" />
				<table>
					<tr>
						<td>账号：</td>
						<td>
							<input type="text" name="manager_account"><span class="red_color"> * </span></td>
					</tr>
					<tr>
						<td>密码：</td>
						<td>
							<input type="password" name="manager_password"><span class="red_color"> * </span></td>
					</tr>
					<tr>
						<td>确认密码：</td>
						<td>
							<input type="password" name="manager_passwords"><span class="red_color"> * </span></td>
					</tr>
					
					<tr id="admin_group">
						<td>管理员级别：</td>
						<td>
							<select id="group_id">
								<option value="0">--请选择--</option>
								<?php if(is_array($all_admingroup)): $i = 0; $__LIST__ = $all_admingroup;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v1): $mod = ($i % 2 );++$i;?><option value="<?php echo ($v1["id"]); ?>"><?php echo ($v1["title"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
							</select><span class="red_color"> * </span>
						</td>
					</tr>
					<tr>
						<td>手机：</td>
						<td>
							<input type="text" name="manager_phone"><span class="red_color"> * </span></td>
					</tr>
					<tr>
						<td>备注</td>
						<td>
							<textarea name="manager_ps" id="manager_ps"></textarea>
						</td>
					</tr>
				</table>
				<div class="text-center">
					<button class="btn btn-black" type="button" id="commit">保存</button>
					<button class="btn btn-default" data-dismiss="modal">关闭</button>
					<input type="reset" name="reset" style="display: none;">
				</div>
				</form>
			</div>
		</div>
	</div>
</body>
<script src="/Public/js/AllAgent/admin.js"></script>
</html>