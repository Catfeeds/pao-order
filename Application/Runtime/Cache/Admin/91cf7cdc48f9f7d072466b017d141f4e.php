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
<!-- 查询 -->
<body>
    <link rel="stylesheet" type="text/css" href="/Public/bootstrap-datetimepicker-master/bootstrap-datetimepicker.min.css">
    <div class="container-fluid">
    	<div class="datetime-search">
    		<form  method="get" id="myform">
    	    <span>日期：</span>
    	    <input type="text" id="startDate" name="startDate" value="<?php echo ($startDate); ?>">
    	    <span>-</span>
    	    <input type="text" id="endtDate" name="endtDate" value="<?php echo ($endDate); ?>">
    	    <span class="ml-30">时间：</span>
    	    <input type="text" id="startTime" name="startTime" value="<?php echo ($startTime); ?>">
    	    <span>-</span>
    	    <input type="text" id="endTime" name="endTime" value="<?php echo ($endTime); ?>">
    	    <button class="btn btn-sm btn-primary" type="button" data-commit_type = "0" onclick="search(this)">搜索</button>
    	    <button class="btn btn-sm btn-primary" type="button" data-commit_type = "1" onclick="search(this)">导出Excel</button>
    	    </form>
    	</div>
    	<div class="dishes-sale" id="ajax_html">
    		<h4>菜品统计：</h4>
    		<?php if(is_array($all_foodinfo)): $i = 0; $__LIST__ = $all_foodinfo;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><div class="dishes-sale-item">
    			<div class="sale-item-head">
	    			<div class="clearfix">
					    <div class="pull-left text-right">
					    	<?php if(($v["Num_sum"] == 0) and ($v["Num_sum1"] == 0)): ?><button class="btn">-</button>
					    	<?php else: ?>
					    	 	<button class="btn" onclick="open-sale-item">+</button><?php endif; ?>
					    </div>
					    <div class="pull-left dishes-sale-name">
					        <span><?php echo ($v["food_name"]); ?></span>
					    </div>
					    <div class="pull-left">
					        <div class="dishes-sale-progress" style="width:<?php echo ($v[food_num]*$step_length); ?>px;"></div>
					        <span class="dishes-sale-num"><span style="color: red;"><?php echo ($v["food_num"]); ?></span>份</span>
				    	</div>
					</div>
    			</div>
    			<div class="dishes-sale-info">
					<table class="text-center">
						<?php if(($v["Num_sum"]) == "0"): else: ?>
						<tr>
							<td><?php echo ($v["year"]); ?>年</td>
							<?php if(is_array($v['lastyear_allOrderNum'])): $i = 0; $__LIST__ = $v['lastyear_allOrderNum'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v1): $mod = ($i % 2 );++$i;?><td><span style="color: red;"><?php echo ($v1); ?></span>份</td><?php endforeach; endif; else: echo "" ;endif; ?>
						</tr><?php endif; ?>
						<?php if(($v["Num_sum1"]) == "0"): else: ?>	
						<tr>
							<td><?php echo ($v["year1"]); ?>年</td>
							<?php if(is_array($v['lastyear_allOrderNum1'])): $i = 0; $__LIST__ = $v['lastyear_allOrderNum1'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v2): $mod = ($i % 2 );++$i;?><td><span style="color: red;"><?php echo ($v2); ?></span>份</td><?php endforeach; endif; else: echo "" ;endif; ?>
						</tr><?php endif; ?>
						
						<?php if(($v["Num_sum"] == 0) and ($v["Num_sum1"] == 0)): else: ?>
							<tr>
								<td></td>
								<td>1月</td>
								<td>2月</td>
								<td>3月</td>
								<td>4月</td>
								<td>5月</td>
								<td>6月</td>
								<td>7月</td>
								<td>8月</td>
								<td>9月</td>
								<td>10月</td>
								<td>11月</td>
								<td>12月</td>
							</tr><?php endif; ?>
					</table>
				</div>
    		</div><?php endforeach; endif; else: echo "" ;endif; ?>
    		<h4>菜品属性统计：</h4>
    		<?php if(is_array($all_attributeArr)): $i = 0; $__LIST__ = $all_attributeArr;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$a_atr): $mod = ($i % 2 );++$i;?><div class="sale-item-head">
    			<div class="clearfix">
				    <div class="pull-left text-right">
				    	<button class="btn">-</button>
				    </div>
				    <div class="pull-left dishes-sale-name">
				        <span><?php echo (L("$key")); ?></span>
				    </div>
				    <div class="pull-left">
				        <div class="dishes-sale-progress" style="width:<?php echo ($a_atr*$step_length); ?>px;"></div>
				        <span class="dishes-sale-num"><span style="color: red;"><?php echo ($a_atr); ?></span>份</span>
			    	</div>
				</div>
			</div><?php endforeach; endif; else: echo "" ;endif; ?>
    		<div>
				<ul class="pagination" id="detail-page">
					<?php echo ($page); ?>
				</ul>
			</div>
    	</div>
    </div>
    <script src="/Public/bootstrap-datetimepicker-master/bootstrap-datetimepicker.min.js"></script>
	<script src="/Public/bootstrap-datetimepicker-master/bootstrap-datetimepicker.zh-CN.js"></script>
	<script src="/Public/js/dateSelect.js"></script>
	<script src="/Public/js/Admin-Restaurant/Sale_food_chart.js"></script>
</body>