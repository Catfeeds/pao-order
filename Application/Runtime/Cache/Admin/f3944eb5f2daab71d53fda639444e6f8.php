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
<body>
	<div class="container-fluid" id="tbody">
		<div class="container-fluid clearfix">
			<div class="pull-left">
				<h4>前台收银帐号</h4>
			</div>
			<div class="pull-right">
				<input type="text" placeholder="请输入收银员姓名" name="key" id="key" class="form-control search-form"/>
				<button type="button" class="btn btn-primary" id="sel" >查询</button>
			</div>				
		</div>
		<table class="table table-bordered">
			<thead>
				<tr>
					<th>ID</th>
					<th>收银员名称</th>
					<th>帐号</th>
					<!-- <th>密码</th>	 -->
					<th>收银员性别</th>
					<!--<th>收银员地址</th>-->
					<th>操作</th>
				</tr>
			</thead>
			<tbody id="mytable">
				<?php if(is_array($cashierArr)): $i = 0; $__LIST__ = $cashierArr;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><tr>
						<td><?php echo ($key+1); ?></td>
						<td><?php echo ($v["cashier_name"]); ?></td>
						<td><?php echo ($v["cashier_phone"]); ?></td>
						<!-- <td><?php echo (md5($v["cashier_pwd"])); ?></td>				 -->
						<td>
							<?php if($v["cashier_sex"] == 1): ?>男
								<?php else: ?>			
								女<?php endif; ?>
						</td>
					<!--	<td><?php echo ($v["cashier_address"]); ?></td>-->
						<td>
							<button type="button" class="btn btn-info btn-sm"  data-toggle="modal" data-target="#addSort" onclick="modify(<?php echo ($v["cashier_id"]); ?>)" >编辑</button>
							<button type="button" class="btn btn-default btn-sm" onclick = "del(<?php echo ($v["cashier_id"]); ?>)">删除</button>
						</td>
					</tr><?php endforeach; endif; else: echo "" ;endif; ?>
			</tbody>
		</table>
		<div class="row">
			<div class="col-xs-9 col-sm-10 text-center">
				<ul class="pagination" id="detail-page"><?php echo ($page); ?></ul>
			</div>
			<div class="col-xs-3 col-sm-2 text-right">
				<button type="button" class="btn btn-default" data-toggle="modal" id="addwindow" >添加帐号</button>
			</div>		
		</div>
	</div>
	

	<div class="modal fade" id="addSort" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<form id="myform" enctype="multipart/form-data">
					<div class="modal-header"></div>
					<div class="modal-body" style="width: 475px;">
						<input type="hidden" name="commit_way"/>
						<input type="hidden" name="Cashier_id"/>
						<p>
							<span>名称：</span>
							<input type="text" name="Cashier_name" placeholder="请输入名称">
							<span style="color: red;">(*)</span>
						</p>
						<p>
							<span>帐号：</span>
							<input type="text" name="Cashier_phone" placeholder="请输入纯数字组合">
							<span style="color: red;">(*)</span>
						</p>
						<p>
							<span>密码：</span>
							<input type="password" name="Cashier_pwd" placeholder="请输入纯数字组合">	
							<span style="color: red;">(*)</span>
						</p>
						<p>
							<span>确定密码：</span>
							<input type="password" name="Cashier_pwds" placeholder="请输入纯数字组合">	
							<span style="color: red;">(*)</span>
						</p>
						<p>
							性别：
							<input type="radio" name="Cashier_sex" value="1" checked="checked">
							男
							<input type="radio" name="Cashier_sex" value="0" >女</p>
						<!--<p>
							<span>地址：</span>
							<textarea name="Cashier_address" cols=30 rows=2></textarea>
						</p>-->

					</div>
					<div class="modal-footer">
						<button type="button" class="admin-btn" data-dismiss="modal">关闭</button>
						<button type="button" class="admin-btn"  id="commit" >提交</button><!--data-dismiss="modal"-->
						<input type="reset" name="reset" style="display: none;"/>
					</div>
				</form>
			</div>

		</div>

	</div>

</body>
<script src="/Public/js/Admin-Restaurant/admin_accounts.js"></script>
</html>