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
	<section class="clearfix">
		<aside class="sidebar">
			<p>查询店铺名称</p>
			<input type="hidden" name="uuid" id="uuid" />
			<p class="search-box">
				<input type="text" name="key" />
				<button class="btn btn-default" type="button" onclick="search()">搜索</button>
			</p>
			<ul class="sidebar-list" id="device_left">
				<?php if(is_array($Arrlist)): $i = 0; $__LIST__ = $Arrlist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><li>
					<button class="btn-none">+</button>
					<span><?php echo ($v["restaurant_name"]); ?></span>
					<ul>
						<?php if(is_array($v['CityArray'])): $i = 0; $__LIST__ = $v['CityArray'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v1): $mod = ($i % 2 );++$i;?><li>
							<button class="btn-none">+</button>
							<span><?php echo (L("$key")); ?></span>
							<ul>
								<?php if(is_array($v1)): $i = 0; $__LIST__ = $v1;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v2): $mod = ($i % 2 );++$i;?><li>
										<a href="javascript:void(0)" style="color: white; text-decoration: none;" onclick="showinfo(<?php echo ($v2["id"]); ?>)"><?php echo ($v2["address"]); ?></a>
									</li><?php endforeach; endif; else: echo "" ;endif; ?>
							</ul>
						</li><?php endforeach; endif; else: echo "" ;endif; ?>
					</ul>
				</li><?php endforeach; endif; else: echo "" ;endif; ?>
			</ul>
		</aside>
		<div class="right-content">
			<div class="container-fluid pre100" id="mytable">
				<table class="device-table table-hover">
					<tr>
						<td>序号</td>
						<td>设备名称</td>
						<td>机器ID</td>
						<td>最后注册时间</td>
						<td>到期时间</td>
						<td>所属店铺</td>
						<td>状态</td>
						<td></td>
					</tr>
					<?php if(is_array($deviceList)): $i = 0; $__LIST__ = $deviceList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v4): $mod = ($i % 2 );++$i;?><tr>
						<td><?php echo ($key+1); ?></td>
						<td><?php echo ($v4["device_name"]); ?></td>
						<td><?php echo ($v4["device_code"]); ?></td>
						<td><?php echo (date("Y-m-d",$v4["start_time"])); ?></td>
						<td><?php echo (date("Y-m-d",$v4["end_time"])); ?></td>
						<td>
							<select name="bingInfo" id="bindInfo" data-code_id="<?php echo ($v4["code_id"]); ?>" onchange="changeBindRes(this)">
								<?php if(is_array($restaurant_list)): $i = 0; $__LIST__ = $restaurant_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$rsl): $mod = ($i % 2 );++$i; if($rsl['restaurant_id'] == $v4['restaurant_id']): ?><option value="<?php echo ($rsl["restaurant_id"]); ?>" selected><?php echo ($rsl["restaurant_name"]); ?></option>
									<?php else: ?>
										<option value="<?php echo ($rsl["restaurant_id"]); ?>"><?php echo ($rsl["restaurant_name"]); ?></option><?php endif; endforeach; endif; else: echo "" ;endif; ?>
							</select>
						</td>
						<?php if(($v4["device_status"]) == "1"): ?><td>正常</td>
						<?php else: ?>
							<td>禁用</td><?php endif; ?>
						
						<td>
							<button class="btn btn-black" data-target="#editDevice" data-toggle="modal" onclick="modify(<?php echo ($v4["device_id"]); ?>)">编辑</button>
							<button class="btn btn-default" onclick="del(<?php echo ($v4["device_id"]); ?>)">删除</button>
							
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

	<div class="modal fade" id="editDevice" tabindex="-1" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-head">编辑品牌商</div>
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
						<td>状态</td>
						<td>
							<input type="radio" name="state" value="1">正常
							<input type="radio" name="state" value="0">禁用
						</td>
					</tr>
				</table>
				<div class="text-center">
					<button class="btn btn-black" onclick="commit()">保存</button>
					<button class="btn btn-default" data-dismiss="modal">关闭</button>
					
				</div>
			</div>
		</div>
	</div>
	<script src="/Public/bootstrap-datetimepicker-master/bootstrap-datetimepicker.min.js"></script>
	<script src="/Public/bootstrap-datetimepicker-master/bootstrap-datetimepicker.zh-CN.js"></script>
	<script src="/Public/js/dateSelect.js"></script>
	<script src="/Public/js/Agent/device.js"></script>
</body>
</html>