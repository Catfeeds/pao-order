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

	<form id="search_form" action="/index.php/Admin/Sale/exportExcel" method="post">
		<div class="search-box">
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
				<li>搜索范围：</li>
				<li><input type="radio" name="sortType" id="saleAmount" checked value="1"><label for="saleAmount">营业金额</label></li>
				<li><input type="radio" id="food_nameTag" name="sortType" value="2"><label for="food_nameTag">菜品：</label><input
						type="text" id="food_name" name="food_name"></li>
			</ul>
			<ul class="search-list clearfix">
				<li>支付方式：</li>
				<li>
					<input type="checkbox" id="all_pay" value="off" onchange="select_all_pay(this)" checked="checked"><label for="all_pay">所有</label>
				</li>
				<li>
					<input type="checkbox" name="pay_type[]" id="weixin" value="2" checked="checked"><label for="weixin">微信</label>
				</li>
				<li>
					<input type="checkbox" name="pay_type[]" id="aliPay" value="1" checked="checked"><label for="aliPay">支付宝</label>
				</li>
				<li>
					<input type="checkbox" name="pay_type[]" id="cash" value="0" checked="checked"><label for="cash">现金</label>
				</li>
                <li>
                    <input type="checkbox" name="pay_type[]" id="remainder" value="4" checked="checked"><label for="remainder">余额</label>
                </li>
			</ul>
			<ul class="search-list clearfix">
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
			</ul>
		</div>
	</form>
	<div class="search-result" id="orderInfo">

	</div>
	<div class="data-result">
		<span>统计结果:</span><br>
		<p>
			<span id="search_data"><?php echo ($startDate); ?> - <?php echo ($endDate); ?></span>
			<span class="ml-10" id="search_time">00:00:00 - 23:59:59</span>
			<span class="ml-10" id="search_food">菜品:所有</span>
			<span class="ml-10" id="search_pay_type">支付方式：微信、支付宝、现金、余额</span>
			<span class="ml-30" id="search_order_type">就餐方式：店内点餐、打包带走、</span>
		</p>
		<span>总营业额</span><span class="ml-30" id="search_total_amount"><?php echo ($total_amount); ?>元</span>
	</div>
	<script src="/Public/bootstrap-datetimepicker-master/bootstrap-datetimepicker.min.js"></script>
	<script src="/Public/bootstrap-datetimepicker-master/bootstrap-datetimepicker.zh-CN.js"></script>
	<script src="/Public/js/dateSelect.js"></script>
</body>
<script>
	$(function(){
		var form = $("#search_form")[0];
		var formData = new FormData(form);
		$.ajax({
			url:'/index.php/admin/sale/orderInfo',
			data:formData,
			type:"post",
			contentType:false,
			processData:false,
			async:false,
			cache:false,
			success:function(data){
				$("#orderInfo").html(data);
				putData();
			}
		});
	});

	function exportExcel(){
		var form = $("#search_form")[0];
		var formDate = new FormData(form);
		$.ajax({	
			type:"post",
			url:"/index.php/Admin/Sale/exportExcel",
			data:formDate,
			dataType:"json",
			contentType:false,
			processData:false,
			async:false,
			cache:false,
			success:function(msg){
				console.log("导出成功");
			},
			error:function(){
				console.log("访问出错");
			}
		});
	}

	function submit_form(){
		var form = $("#search_form")[0];
		url = "/index.php/admin/sale/orderInfo";
		var temp = $("input[name='sortType']:checked").val();
		if($("#food_name").val() != "" && temp == 2){
			url = "/index.php/admin/sale/countFoodSale";
		}
		var formDate = new FormData(form);
		$.ajax({
			url:url,
			data:formDate,
			type:"post",
			cache:false,
			contentType:false,
			processData:false,
			success:function(data) {
				$("#orderInfo").html(data);
				putData();
			}
		});
	}

	function select_all_pay(obj){
		var value = $(obj).val();
		if(value == "off"){
			$(obj).val("on");
			var t1 = $(obj).parent().parent().find("li");
			$.each(t1,function(k1,v1){
				$(this).children().prop("checked","checked");
			});
		}else{
			$(obj).val("off");
			var t2 = $(obj).parent().parent().find("li");
			$.each(t2,function(k2,v2){
				$(this).children().prop("checked",false);
			});
		}
	}

	function select_all_order(obj){
		var value = $(obj).val();
		if(value == "off"){
			$(obj).val("on");
			var t1 = $(obj).parent().parent().find("li");
			$.each(t1,function(k1,v1){
				$(this).children().prop("checked",true);
			});
		}else{
			$(obj).val("off");
			var t2 = $(obj).parent().parent().find("li");
			$.each(t2,function(k2,v2){
				$(this).children().prop("checked",false);
			});
		}
	}

	function putData(){
		//修改统计结果
		var startDate = $("#startDate").val();
		var endDate = $("#endtDate").val();
		$("#search_data").html(startDate+" - "+endDate);

		var food_name = $("#food_name").val();
		if(food_name){
			$("#search_food").html("菜品:"+food_name);
		}else{
			$("#search_food").val("所有");
		}

		var pay_type = $("#pay_str").val();
		if(pay_type == ""){
			$("#search_pay_type").html("支付方式：所有");
		}else{
			$("#search_pay_type").html("支付方式："+pay_type);
		}

		var order_type = $("#order_str").val();
		if(order_type == ""){
			$("#search_order_type").html("就餐方式：所有");
		}else{
			$("#search_order_type").html("就餐方式："+order_type);
		}


		var search_total_amount = $("#total_amount").val();
		$("#search_total_amount").html(search_total_amount+"元");
	}
	
	function exportway(){
		var value = $("input[name='sortType']:checked").val();
		if(value == 1){
			$("#search_form").attr('action','/index.php/Admin/Sale/exportExcel');
		}else{
			$("#search_form").attr('action','/index.php/Admin/Sale/exportExcel1');
		}
		$("#search_form").submit();
	}
</script>
</html>