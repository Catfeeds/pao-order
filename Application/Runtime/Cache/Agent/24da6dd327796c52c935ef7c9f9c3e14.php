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

<!-- 查询 -->
<body>
<link rel="stylesheet" type="text/css" href="/Public/bootstrap-datetimepicker-master/bootstrap-datetimepicker.min.css">

<form action="/index.php/Agent/Sale/exportExcel" id="search_form" method="post">
    <div class="sale-search-box">
        <div class="datetime-search">
            <span>日期：</span>
            <input type="text" id="startDate" name="startDate" value="<?php echo ($startDate); ?>">
            <span>-</span>
            <input type="text" id="endtDate" name="endtDate" value="<?php echo ($endDate); ?>">
            <span class="ml-30">时间：</span>
            <input type="text" id="startTime" name="startTime" value="<?php echo ($startTime); ?>">
            <span>-</span>
            <input type="text" id="endTime" name="endTime" value="<?php echo ($endTime); ?>">
            <button class="btn btn-sm btn-primary" onclick="submit_form()" type="button">搜索</button>
            <button class="btn btn-sm btn-primary" type="button" onclick="exportway()">导出Excel</button>
        </div>
        <ul class="search-list clearfix">
            <li class="item">搜索范围：</li>
            <li class="item"><input type="radio" name="sortType" id="saleAmount" checked value="1"><label for="saleAmount">营业金额</label></li>

            <li class="item" >
                <label style="margin-left: 10px"><input type="radio" name="store" value="0" checked>所有店铺</label>
                <label><input type="radio" name="store" value="1"></label>
                <select name="restaurant" id="restaurant">
                    <?php if(is_array($restaurant)): $i = 0; $__LIST__ = $restaurant;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$rst): $mod = ($i % 2 );++$i;?><option value="<?php echo ($rst["restaurant_id"]); ?>">
                            <?php echo ($rst["restaurant_name"]); ?>
                        </option><?php endforeach; endif; else: echo "" ;endif; ?>
                </select>
            </li>
        </ul>
        <ul class="search-list clearfix">
            <li>支付方式：</li>
            <li>
                <input type="checkbox" id="all_pay" value="off" onchange="select_all_pay(this)" checked="checked"><label for="all_pay">所有</label>
            </li>
            <li>
                <input type="checkbox" name="pay_type[]" id="remainder" value="4" checked="checked"><label for="remainder">余额</label>
            </li>
           <!-- <li>
                <input type="checkbox" name="pay_type[]" id="aliPay" value="1" checked="checked"><label for="aliPay">支付宝</label>
            </li>
            <li>
                <input type="checkbox" name="pay_type[]" id="cash" value="0" checked="checked"><label for="cash">现金</label>
            </li>-->
        </ul>
        <!--<ul class="search-list clearfix">
            <li>就餐方式：</li>
            <li>
                <input type="checkbox" id="all_order_type" value="off" onchange="select_all_order(this)" checked="checked"><label for="all_order_type" >所有</label>
            </li>
            <li>
                <input type="checkbox" name="order_type[]" id="inShop" value="1" checked="checked"><label for="inShop">店内点餐</label>
            </li>
            <li>
                <input type="checkbox" name="order_type[]" id="take_out" value="2" checked="checked"><label for="take_out">打包带走</label>
            </li>
        </ul>-->
    </div>
</form>
<div class="search-result" id="orderInfo">

</div>
<div class="data-result">
    <span>统计结果:</span><br>
    <p>
        <span id="search_data"><?php echo ($startDate); ?> - <?php echo ($endDate); ?></span>
        <span class="ml-10" id="search_time">00:00:00 - 23:59:59</span>
       <!-- <span class="ml-10" id="search_food">菜品:所有</span>-->
        <span class="ml-10" id="search_pay_type">支付方式：微信、支付宝、现金、</span>
       <!-- <span class="ml-30" id="search_order_type">就餐方式：店内点餐、打包带走、</span>-->
        <span class="ml-30" id="restaurant_name" >店铺名称：所有店铺</span>
    </p>
    <span>总营业额</span><span class="ml-30" id="search_total_amount"><?php echo ($total_amount); ?>元</span>
</div>
<div>
    <ul class="pagination" id="detail-page">
        <?php echo ($page); ?>
    </ul>
</div>
<script src="/Public/bootstrap-datetimepicker-master/bootstrap-datetimepicker.min.js"></script>
<script src="/Public/bootstrap-datetimepicker-master/bootstrap-datetimepicker.zh-CN.js"></script>
<script src="/Public/js/dateSelect.js"></script>
<script src="/Public/js/Agent/sale_vipConsume.js"></script>
</body>

</html>