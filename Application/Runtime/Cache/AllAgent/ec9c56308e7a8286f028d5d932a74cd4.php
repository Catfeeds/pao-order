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
		<aside class="sidebar">
			<p>查询品牌商</p>
			<p class="search-box">
				<input type="text" name="key" placeholder="品牌商名称">
				<button class="btn btn-default" type="button" onclick="search()">搜索</button>
			</p>
			<div id="mytable">
			<ul class="sidebar-list">
				<?php if(is_array($Arrlist)): $i = 0; $__LIST__ = $Arrlist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><li>
						<?php if(empty($v['restaurantNameArr'])): ?><button class="btn-none">-</button>
						<?php else: ?>
							<button class="btn-none">+</button><?php endif; ?>
						<span><?php echo ($v['business_name']); ?></span>
						<input type="hidden" name="business_id" value="<?php echo ($v['business_id']); ?>"/>
						<ul>
							<?php if(is_array($v['restaurantNameArr'])): $i = 0; $__LIST__ = $v['restaurantNameArr'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v1): $mod = ($i % 2 );++$i;?><li>
								<button class="btn-none">+</button>
								<span><?php echo ($v1['restaurant_name']); ?></span>
								<ul>
									<?php if(is_array($v1['City1Array'])): $i = 0; $__LIST__ = $v1['City1Array'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v2): $mod = ($i % 2 );++$i;?><li>
											<input type="hidden" name = "restaurant_name" value="<?php echo ($v1['restaurant_name']); ?>" />
											<a href="javascript:void(0)" style="color: white; text-decoration: none;" onclick="showinfo(<?php echo ($v['business_id']); ?>,<?php echo ($v2['city3']); ?>,this)"><?php echo ($v2['cityArr']); ?></a>
										</li><?php endforeach; endif; else: echo "" ;endif; ?>
								</ul>
							</li><?php endforeach; endif; else: echo "" ;endif; ?>
						</ul>
					</li><?php endforeach; endif; else: echo "" ;endif; ?>
			</ul>
			</div>
		</aside>
		<div class="right-content">
			<input type="hidden" name="session_manager_id" value="<?php echo (session('manager_id')); ?>" id="session_manager_id">
			<div class="container-fluid pre100">
				<div style="border-bottom:1px solid #000">
					日期：<input type="text" name="device_start_time" id="device_start_time" placeholder="注册时间"/>--	
					<input type="text" name="device_end_time" id="device_end_time" placeholder="到期时间"/>
					<input type="button" value="搜索" style="padding-left: 20px; padding-right: 20px;" onclick="search_time()"/>
				</div>
				<div id="listtable">
				<table class="device-table table-hover">
					<tr>
						<td>序号</td>
						<td>设备名称</td>
						<td>MAC</td>
						<td>注册时间</td>
						<td>到期时间</td>
						<td>设备状态</td>
						<td>详细地址</td>
						<td>操作</td>
					</tr>
					<?php if(is_array($deviceArr)): $i = 0; $__LIST__ = $deviceArr;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><tr>
								<td><?php echo ($key+1); ?></td>
								<td><?php echo ($v["device_name"]); ?></td>
								<td><?php echo ($v["device_code"]); ?></td>
								<td><?php echo (date("Y-m-d",$v["start_time"])); ?></td>
								<td><?php echo (date("Y-m-d",$v["end_time"])); ?></td>
								<?php if(($v["device_status"]) == "1"): ?><td>正常</td>
									<?php else: ?>
									<td>禁用</td><?php endif; ?>
								<td><?php echo ($v["address"]); ?></td>
								<td>
									<button class="btn btn-black" data-toggle="modal" onclick="modify(<?php echo ($v["device_id"]); ?>)">编辑</button>
									<button class="btn btn-black" data-target="#renew" data-toggle="modal">续费</button>
									<button class="btn btn-default" onclick="del(<?php echo ($v["device_id"]); ?>)">删除</button>
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
		</div>
	</section>


	<!--编辑模态框-->
	<div class="modal fade" id="editDevice" tabindex="-1" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-head">编辑设备</div>	
				<form id="myform">
				<input type="hidden" name="uuid" id="uuid" />
				<input type="hidden" name="uuid2" id="uuid2" />
				<input type="hidden" name="uuid3" id="uuid3" />
				<table class="table-condensed">
					<tr>
						<input type="hidden" name="device_id">
						<input type="hidden" name="restaurant_id">
						<td>设备名称:</td>
						<td>
							<input type="text" name="device_name">
						</td>
					</tr>
					<tr>
						<td>开始日期:</td>
						<td>
							<input type="text" name="start_time" disabled="true" id="startDate">
						</td>
					</tr>
					<tr>
						<td>结束日期:</td>
						<td>
							<input type="text" name="end_time" id="endtDate">
						</td>
					</tr>
					<tr>
						<td>详细地址:</td>
						<td>
							<input type="text" name="address">
						</td>
					</tr>
					<tr>
						<td>状态</td>
						<td>
							<input type="radio" name="state" value="1">正常
							<input type="radio" name="state" value="0">禁用
						</td>
					</tr>
				</table>
				</form>
				<div class="text-center">
					<button class="btn btn-black" type="button" onclick="commit()">保存</button>
					<button class="btn btn-default" data-dismiss="modal">关闭</button>
				</div>
			</div>
		</div>
	</div>
	
	<!--续费模态框-->
	<div class="modal fade" id="renew" tabindex="-1" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-head">设备续费</div>
				<table class="table-condensed">
					<tr>
						<td><?php echo ($renewArr["renew_time1"]); ?>年</td>
						<td><input type="radio" name="renew" value="1" checked="checked"></td>
					</tr>
					<tr>
						<td><?php echo ($renewArr["renew_time2"]); ?>年</td>
						<td><input type="radio" name="renew" value="2"></td>
					</tr>
					<tr>
						<td><?php echo ($renewArr["renew_time3"]); ?>年</td>
						<td><input type="radio" name="renew" value="3"></td>
					</tr>
				</table>
				<div class="text-center">
					<button class="btn btn-black" type="button">去支付</button>
					<button class="btn btn-default" data-dismiss="modal">关闭</button>
				</div>
			</div>
		</div>
	</div>
	
	<script src="/Public/bootstrap-datetimepicker-master/bootstrap-datetimepicker.min.js"></script>
	<script src="/Public/bootstrap-datetimepicker-master/bootstrap-datetimepicker.zh-CN.js"></script>
	<script src="/Public/js/dateSelect.js"></script>
	<script src="/Public/js/AllAgent/device.js"></script>
	<script type="text/javascript">
		$('.sidebar-list button').click(function(){
			$(this).siblings('ul').slideToggle();
		});
	</script>
</body>
</html>