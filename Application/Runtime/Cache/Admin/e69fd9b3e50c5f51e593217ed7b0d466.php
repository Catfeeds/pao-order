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
<!-- 支付对接 -->
<script src="/Public/js/PayInfo.js"></script>
<body>
	<div class="container-fluid">
		<ul id="myTab" class="nav nav-tabs">
			<li class="active">
				<a href="#wxpay" data-toggle="tab">
					微信支付
				</a>
			</li>
			<li><a href="#alipay" data-toggle="tab">支付宝支付</a></li>
			<li><a href="#pay-select" data-toggle="tab">支付类型选择</a></li>
		</ul>
		<div id="myTabContent" class="tab-content">
			<div class="tab-pane fade in active" id="wxpay">
				<form action="javascript:void(0)" id="wxpayForm">
					<div class="form-group" style="margin-top: 12px">
						<label for="wxpay_appid">
							APPID:
							<input class="form-control" type="text" value="<?php echo ($wx_config["wxpay_appid"]); ?>" placeholder="绑定支付的APPID" name="wxpay_appid" id="wxpay_appid">
						</label>
					</div>
					<div class="form-group">
						<label for="wxpay_mchid">
							MCHID:
							<input class="form-control" type="text" value="<?php echo ($wx_config["wxpay_mchid"]); ?>" placeholder="商户号" name="wxpay_mchid" id="wxpay_mchid">
						</label>
					</div>
					<div class="form-group">
						<label for="wxpay_key">
							KEY:
							<input class="form-control" type="text" value="<?php echo ($wx_config["wxpay_key"]); ?>" placeholder="商户支付密钥" name="wxpay_key" id="wxpay_key">
						</label>

					</div>
					<div class="form-group">
						<label for="wxpay_appsecret">
							APPSECRET:
							<input class="form-control" type="text" value="<?php echo ($wx_config["wxpay_appsecret"]); ?>" placeholder="公众帐号secert" name="wxpay_appsecret" id="wxpay_appsecret">
						</label>
					</div>
					<div class="form-group">
						<label for="wxpay_child_mchid">
							CHILD_MCHID:
							<input class="form-control" type="text" value="<?php echo ($wx_config["wxpay_child_mchid"]); ?>" placeholder="子商户号（用于代理）" name="wxpay_child_mchid" id="wxpay_child_mchid">
						</label>
					</div>
				</form>
				<button data-paytype="wxpay" onclick="submitPayInfo(this)">
					修改/添加
				</button>
			</div>
			<div class="tab-pane fade" id="alipay">
				<div class="container-fluid">
					<div class="row">
						<h1 class="">授权步骤</h1>
					</div>
					<div class="row">
						<div><h3>第一步：申请支付宝对接</h3></div>
						<a style="margin-left: 98px" target="_blank" href="https://b.alipay.com/settling/index.htm?appId=2016121604351905" class="btn btn-primary btn-sm">前去支付宝申请</a>
						<p>准备资料：</p>
						<p>照片：营业执照、身份证正反面、店铺门前与店内照片</p>
						<p>资料：银联卡卡号、支付宝账号</p>
					</div>
					<div class="row">
						<h3>第二步：授权</h3>
						<!--<p>请在下方准确填写你要授权的支付宝PID</p>-->
						<!--<p>点击下方确定按钮，跳转到支付宝登陆页面</p>-->
						<!--<p>登陆支付宝，点击确认授权</p>-->
						<div class="container-fluid">
							<div class="row">
								支付宝PID：<input type="text" name="aliNumber" id="aliPid">
								<a href="javascript:void(0)" target="_blank" class="btn btn-primary btn-sm" onclick="changeUrl()">前去授权</a>
							</div>
							<div class="row">
								授权的PID：
								<?php if($pid == 0): ?><span>未授权</span>
									<?php else: ?>
									<span><?php echo ($pid); ?></span><?php endif; ?>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="tab-pane fade" id="pay-select">
				<div class="row">
					<?php if(is_array($pay_select)): $i = 0; $__LIST__ = $pay_select;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$pa_vo): $mod = ($i % 2 );++$i;?><div class="col-xs-3">
							<div class="pay-item">
								<p><?php echo ($pa_vo["name"]); ?></p>
								<img src="<?php echo ($pa_vo["img"]); ?>">
								<?php if($pa_vo['value'] == 1): ?><input type="radio" name="<?php echo ($pa_vo["config_name"]); ?>" value="1" checked onchange="changeStatus(this)">开启
									<input type="radio" name="<?php echo ($pa_vo["config_name"]); ?>" value="0" onchange="changeStatus(this)">关闭
									<?php else: ?>
									<input type="radio" name="<?php echo ($pa_vo["config_name"]); ?>" value="1" onchange="changeStatus(this)">开启
									<input type="radio" name="<?php echo ($pa_vo["config_name"]); ?>" value="0" checked onchange="changeStatus(this)">关闭<?php endif; ?>
							</div>
						</div><?php endforeach; endif; else: echo "" ;endif; ?>
				</div>
			</div>			
		</div>
	</div>
</body>
<script>
	function changeStatus(obj){
		var value = $(obj).val();
		var config_name = $(obj).attr("name");
		console.log(config_name);
		$.ajax({
			url:"/index.php/Admin/dataDock/selectPay",
			data:{"value":value,"config_name":config_name},
			type:"post",
			success:function(){
				console.log("成功");
			}
		});
	}
	function changeUrl(){
		var aliNumber = $("#aliPid").val();
		if(aliNumber){
			var url = "/index.php/component/test/testCreate/aliNumber/"+aliNumber;
			window.open(url);
		}
	}
</script>
</html>