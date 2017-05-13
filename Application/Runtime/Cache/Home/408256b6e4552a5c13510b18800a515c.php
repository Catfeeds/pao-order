<?php if (!defined('THINK_PATH')) exit();?>﻿<!DOCTYPE html>
<html lang="zh-CN">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

	<!-- Bootstrap 核心 CSS 文件 -->
	<link rel="stylesheet" href="/Public/bootstrap/css/bootstrap.min.css">
	<!-- layer CSS 文件 -->
	<link rel="stylesheet" href="/Public/css/layer.css">
	
	<!-- common CSS 文件 -->
	<link rel="stylesheet" href="/Public/css/common.css">
	<!-- main CSS 文件 -->
	<link rel="stylesheet" href="/Public/css/main.css">
	<!-- horizontal CSS 文件 -->
	<link rel="stylesheet" href="/Public/css/horizontal.css">
	
	<!-- 更换颜色 CSS 文件 -->
	<link rel="stylesheet" href="/Public/css/color_orange.css" id="global-css">
	<!-- HTML5 Shim 和 Respond.js 用于让 IE8 支持 HTML5元素和媒体查询 -->
	<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
	<script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
	<![endif]-->

	<!-- jQuery文件。务必在bootstrap.min.js 之前引入 -->
	
	<script src="/Public/js/jquery-3.1.0.min.js"></script>
	<!-- 最新的 Bootstrap 核心 JavaScript 文件 -->
	<script src="/Public/bootstrap/js/bootstrap.min.js"></script>
	<script src="/Public/js/home.js"></script>
	
	<script src="/Public/js/layer.js"></script>
	<script>
		$(function(){
			//横屏客户端模板颜色更改
			var tpl = $("#tpl").val();
			if(tpl==0){
				$('#global-css').attr('href','/Public/css/color_red.css');
			}else if(tpl==1){
				$('#global-css').attr('href','/Public/css/color_blue.css');
			}else if(tpl==2){
				$('#global-css').attr('href','/Public/css/color_green.css');
			}else if(tpl==3){
				$('#global-css').attr('href','/Public/css/color_yellow.css');
			}else if(tpl==4){
				$('#global-css').attr('href','/Public/css/color_black.css');
			}else{
				$('#global-css').attr('href','/Public/css/color_orange.css');
			}	
		})
	</script>
	
	<title>方雅点餐系统</title>
	
</head>

	

<!-- 支付页 -->
<body>
	<header class="home-header">
		<a href="javascript:void(0)" onclick="jpushCloseWeiGuang()">
			<img src="/Public/images/lt.png">
			<span>重新点餐</span>
			<input type="hidden" name="tpl" value="<?php echo ($tpl); ?>" id="tpl"/>
		</a>
	</header>
	<input type="hidden" id="total_amount" name="total_amount" value="<?php echo ($order["total_amount"]); ?>">
	<input type="hidden" name="order_sn" id="order_sn" value="<?php echo ($order["order_sn"]); ?>">
	
	<div class="pay-wrapper">
		<div class="pay text-center">
			<h2>
				共：&yen;
				<span class="red"><?php echo ($_GET['price']); ?></span>
				元
			</h2>
			<div class="pay-select">
				<?php if(is_array($pay_select)): $i = 0; $__LIST__ = $pay_select;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$ps_va): $mod = ($i % 2 );++$i; if($ps_va['s_num'] == 1): if($ps_va['value'] == 1): ?><div class="pay-item">
								<a href="javascript:void(0)">
									<img src="/index.php/home/WxChat/qrc/order_sn/<?php echo ($order["order_sn"]); ?>" id="wxpay" class="pay-item-img">
									<p>微信支付</p>
								</a>
							</div><?php endif; endif; ?>
					<?php if($ps_va['s_num'] == 3): ?><input type="hidden" value="<?php echo ($ps_va['value']); ?>" id="mpay"><?php endif; ?>
					<?php if($ps_va['s_num'] == 4): if($ps_va['value'] == 1): ?><div class="pay-item">
								<a href="javascript:void(0)">
									<div class="pay-iframe-content" id="zqr_code">
						<!--				<iframe src="/index.php/home/AlipayDirect/index/order_sn/<?php echo ($order["order_sn"]); ?>" border="0" id="alipayIframe"></iframe>-->
										<img src="/index.php/home/AlipayDirect/alipay_code/order_sn/<?php echo ($order["order_sn"]); ?>" id="alipay" class="pay-item-img">
									</div>
									<p>支付宝支付</p>
									<input type="hidden" name="qr_code" value="<?php echo ($_GET['qr_code']); ?>"/>
								</a>
							</div><?php endif; endif; endforeach; endif; else: echo "" ;endif; ?>
			</div>
		</div>
	</div>
	<footer class="home-footer text-center">
		本页面在<span class="footer-time" id="time">70</span>秒后自动关闭
		<?php if($ps_va['s_num'] == 2): if($ps_va['value'] == 1): ?><div class="pay-item">
					<div class="customer-cash-pay">
						<button class="common-btn" onclick="cashPay()">我要到收银台支付</button>
					</div>
				</div><?php endif; endif; ?>
	</footer>
	<audio controls="controls" preload id="music" hidden>
		<source src="/Public/wav/payFinish.wav" type="audio/mpeg" />
	</audio>
	<script>
		function cashPay(){
			var order_sn = $("#order_sn").val();
			console.log(order_sn);
			$.ajax({
				url:'/index.php/home/index/jpushCashPay',
				type:"post",
				dataType:'json',
				data:{"order_sn":order_sn},
				success:function(data){
					console.log(data);
					//返回结果code为1时,调用android通知打印及打印
					if(data.code == 1){
						JsObj.CompletePay(order_sn);
						jpushCloseWeiGuang();
					}else{
						console.log("处理数据出错");
					}
				},
				error:function(){
					alert("出错了");
				}
			});
		}

		//定时用ajax获取后台订单的状态，当下单的订单状态为已支付时实现页面的跳转
		var j;
		window.onload = function myFun(){
			var temp = $("#mpay").val();
			if(temp == 1){
				jpush();
			}
			j = setInterval("getOrderStatus()",3000);
		};

		function getOrderStatus(){
			var order_sn = $("#order_sn").val();
			console.log(order_sn);
			var postData = {"order_sn": order_sn};

			postData = (function(obj){ // 转成post需要的字符串.
				var str = "";

				for(var prop in obj){
					str += prop + "=" + obj[prop] + "&"
				}
				return str;
			})(postData);
			var xhr = new XMLHttpRequest();
			xhr.open("post","/index.php/home/index/getOrderStatus", 'true');
			xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			xhr.onreadystatechange = function (){
				var XMLHttpReq = xhr;
				if (XMLHttpReq.readyState == 4) {
					if (XMLHttpReq.status == 200) {
						var text = XMLHttpReq.responseText;
						console.log(text);
						var msg = eval('('+text+')');
						console.log(msg);
						if(msg['code'] == 1){
//							clearInterval(j);
//							var music = $("#music")[0];
//							music.addEventListener("ended",function(){
//								location.href="/index.php/home/index/finish";
//							});
//							music.play();
							JsObj.CompletePay(order_sn);
							location.href="/index.php/home/index/finish";
						}
					}
				}
			};
			xhr.send(postData);
		}

		//设定倒数秒数
		var t = 70;
		//显示倒数秒数
		function showTime(){
			t -= 1;
			document.getElementById('time').innerHTML= t;
			if(t==3){
				JsObj.CloseVguang();
			}
			if(t==0){
				location.href='/index.php/Home/Index/processRoute/process/select/order_type/1';
				return;
			}
			//每秒执行一次,showTime()
			setTimeout("showTime()",1000);
		}
		//执行showTime()
		showTime();

		$(function(){
			var price = $("#total_amount").val();
			//alert(pagenum);
			$('#price').html(price);
		});

		function jpush(){
			var order_sn = $("#order_sn").val();
			JsObj.OpenVguang(order_sn);
		}

		function jpushCloseWeiGuang(){
			JsObj.CloseVguang();
			location.href = "/index.php/home/index/index";
		}
	</script>
</body>
</html>