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
<!-- 数据表 -->
<body>
	<div class="container-fluid">
		<input type="hidden" value="<?php echo ($restaurant_id); ?>" name="restaurant_id" id="restaurant_id">
		<div class="month-data" id="month_data" data-month_data='<?php echo ($sales_for_month); ?>' data-month_cash = '<?php echo ($cash_for_month); ?>' data-month_alipay = '<?php echo ($alipay_for_month); ?>' data-month_wechat = '<?php echo ($wechat_for_month); ?>' data-month_remainder = '<?php echo ($remainder_for_month); ?>'>
			<p>月份：
				<select id="month" onchange="monthData()">
					<?php $__FOR_START_26162__=1;$__FOR_END_26162__=13;for($mo=$__FOR_START_26162__;$mo < $__FOR_END_26162__;$mo+=1){ if($mo == $month): ?><option value="<?php echo ($mo); ?>" selected="selected" ><?php echo ($mo); ?>月</option>
							<?php else: ?>
							<option value="<?php echo ($mo); ?>"><?php echo ($mo); ?>月</option><?php endif; } ?>
				</select>
			</p>
			<div id="month_canvas"></div>
			<p class="ml-30 mt-10" id="salesInfo"><?php echo ($salesInfo); ?></p>
		</div>
		<div class="year-data" id="year_data" data-year_data='<?php echo ($sales_for_year); ?>' data-year_cash = '<?php echo ($cash_for_year); ?>' data-year_alipay = '<?php echo ($alipay_for_year); ?>' data-year_wechat = '<?php echo ($wechat_for_year); ?>' data-year_remainder = '<?php echo ($remainder_for_year); ?>'>
			<p>年表:
				<select id="year" onchange="yearData()">
					<?php if(is_array($year_list)): $i = 0; $__LIST__ = $year_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v_year): $mod = ($i % 2 );++$i; if($v_year == $year): ?><option value="<?php echo ($v_year); ?>" selected><?php echo ($v_year); ?></option>
							<?php else: ?>
							<option value="<?php echo ($v_year); ?>"><?php echo ($v_year); ?></option><?php endif; endforeach; endif; else: echo "" ;endif; ?>
				</select>
			</p>
			<div id="year_canvas"></div>
		</div>
	</div>
	<!-- 柱状图插件 -->
	<script src="/Public/js/echarts.min.js"></script>
	<!-- 数据填充 -->
	<script src="/Public/js/chart-data.js"></script>
</body>
</html>