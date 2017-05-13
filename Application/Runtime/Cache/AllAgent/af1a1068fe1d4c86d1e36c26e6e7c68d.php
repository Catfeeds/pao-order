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
	.redcolor{
		color: red;
	}
</style>
<body>
<section class="container-fluid">
	<div class="main-content">
		<input type="hidden" name="session_manager_id" value="<?php echo (session('manager_id')); ?>" id="session_manager_id"/>
		<div style="border-bottom:1px solid #000">
		<form action="/index.php/allAgent/Agent/agent" method="get">		
			品牌商:<input type="text" name="business_name" id="key2"/>
			帐号: <input type="text" name="business_account" id="key1"/>
			<button class="btn-black add-agent">搜索</button>
		</form>
		</div>
		<?php echo tpl_AuthCheck('AllAgent/add_business',$_SESSION['manager_id'],'or','<button data-toggle="modal" class="btn-black add-agent" style="float:right" onclick="addAgent()">新增品牌商</button>','');?>
		<div id="mytable">
			<table class="agent-table table-hover">
				<thead>
				<tr class="text-center">
					<td>序号</td>
					<td>品牌商</td>
					<td>账号</td>
					<td>等级</td>
					<td>公司名称</td>
					<td>联系人</td>
					<td>手机号码</td>
					<td>备注</td>
					<td></td>
				</tr>
				</thead>
				<tbody>
				<?php if(is_array($Arrlist)): $i = 0; $__LIST__ = $Arrlist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><tr>
						<td><?php echo ($i); ?></td>
						<td><?php echo ($v["business_name"]); ?></td>
						<td><?php echo ($v["business_account"]); ?></td>
						<?php if(($v["business_grade"]) == "0"): ?><td>低</td><?php endif; ?>
						<?php if(($v["business_grade"]) == "1"): ?><td>中</td><?php endif; ?>
						<?php if(($v["business_grade"]) == "2"): ?><td>高</td><?php endif; ?>
						<td><?php echo ($v["corporate_name"]); ?></td>
						<td><?php echo ($v["business_contact"]); ?></td>
						<td><?php echo ($v["business_phone"]); ?></td>
						<td class="agent-detail">
							<span><?php echo ($v["business_ps"]); ?></span>
						</td>
						<td>
							<button class="btn btn-black" data-toggle="modal" onclick="modify(<?php echo ($v["business_id"]); ?>)">编辑</button>
							<button class="btn btn-default" onclick="delinfo(<?php echo ($v["business_id"]); ?>)">删除</button>
						</td>
					</tr><?php endforeach; endif; else: echo "" ;endif; ?>
			</table>
			<div>
				<ul class="pagination" id="detail-page">
					<?php echo ($page); ?>
				</ul>
			</div>
			</tbody>
		</div>
	</div>
</section>

<div class="modal fade" id="addAgent" tabindex="-1" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-head" id="title">编辑品牌商</div>
			<form action = "/index.php/AllAgent/Agent/add_business" method="post" id="myform">
				<table>
					<input type="hidden" name="form_id" value="1">
					<input type="hidden" name="business_id">
					<tr>
						<td>名称：</td>
						<td>
							<input type="text" name="business_name" placeholder="品牌商名称"><span class="redcolor"> * </span></td>
					</tr>
					<tr>
						<td>账号：</td>
						<td>
							<input type="text" name="business_account" placeholder="品牌商帐号" id="business_account"><span class="redcolor"> * </span></td>
					</tr>
					<tr>
						<td>密码：</td>
						<td>
							<input type="password" name="business_password" placeholder="品牌商密码"><span class="redcolor"> * </span></td>
					</tr>
					<tr>
						<td>确认密码：</td>
						<td>
							<input type="password" name="business_passwords" placeholder="品牌商密码"><span class="redcolor"> * </span></td>
					</tr>
					<tr>
						<td>公司名称：</td>
						<td>
							<input type="text" name="corporate_name" placeholder="公司名称"></td>
					</tr>
					<tr>
						<td>等级：</td>
						<td>
							<select id="grade">
								<option>请选择</option>
								<option value="0">低</option>
								<option value="1">中</option>
								<option value="2">高</option>
							</select>
						<span class="redcolor"> * </span>	
						</td>
					</tr>
					<tr>
						<td>联系人：</td>
						<td>
							<input type="text" name="business_contact" placeholder="联系人名称"><span class="redcolor"> * </span></td>
					</tr>
					<tr>
						<td>手机：</td>
						<td>
							<input type="text" name="business_phone" placeholder="联系人手机号码"><span class="redcolor"> * </span></td>
					</tr>
					<tr>
						<td>备注：</td>
						<td>
							<textarea id="business_ps" name="business_ps" placeholder="相关信息备注"></textarea>
						</td>
					</tr>
				</table>
				<div class="text-center">
					<button class="btn btn-black" type="button" onclick="commit()">保存</button>
					<button class="btn btn-default" data-dismiss="modal">关闭</button>
					<input type="reset" name="reset" id="reset" style="display: none;"/>
				</div>
			</form>
		</div>
	</div>
</div>
</body>
<script src="/Public/js/AllAgent/agent.js"></script>