<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>取餐提醒</title>
	<link rel="stylesheet" type="text/css" href="/Public/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="/Public/css/remind.css">
	<script src='/Public/js/socket.io.js'></script>
	<script src='/Public/js/notify.js'></script>
	<script src='/Public/js/websocket.js'></script>
</head>
<body>
<input type="hidden" name="device_code" id="device_code" value="<?php echo ($device_code); ?>">
<div class="container-fluid" id="table">
	<div class="row">
		<div class="col-xs-5 coming">
			<header>准备中coming</header>
			<div id="comingDiv">
				<div id="comingCarousel" class="carousel slide" data-ride="carousel" >
					<!-- 轮播（Carousel）项目 -->
					<div class="carousel-inner" id="item1">
						<!--<div class="item active" >
							<ul class="clearfix">
								<?php if($resultArrLen == 0): ?><li style="opacity: 0">qweqwe</li><?php endif; ?>
								<?php if(is_array($resultArr)): $i = 0; $__LIST__ = array_slice($resultArr,0,16,true);if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><li id="coming<?php echo (substr($v["order_sn"],-5,5)); ?>"><?php echo (substr($v["order_sn"],-5,5)); ?></li><?php endforeach; endif; else: echo "" ;endif; ?>
							</ul>
						</div>-->
						<?php $__FOR_START_21463__=1;$__FOR_END_21463__=$total;for($k=$__FOR_START_21463__;$k < $__FOR_END_21463__;$k+=1){ ?><div <?php if($k==1): ?> class="item active" <?php else:?>class="item" <?php endif;?>>
								<ul>
									<?php if(is_array($resultArr)): $i = 0; $__LIST__ = array_slice($resultArr,($k-1)*16,16,true);if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><li id="coming<?php echo (substr($v["order_sn"],-5,5)); ?>"><?php echo (substr($v["order_sn"],-5,5)); ?></li><?php endforeach; endif; else: echo "" ;endif; ?>
								</ul>
							</div><?php } ?>
					</div>
					<input type="hidden" id="resultArrLen" value="<?php echo ($resultArrLen); ?>">    <!--comeing中的订单数量-->
				</div>
			</div>
		</div>
		<div class="col-xs-4 finish">
			<header>请取餐finish</header>
			<div id="serverDiv">
				<div id="serverCarousel" class="carousel slide" data-ride="carousel" data-interval="2000">
					<!-- 轮播（Carousel）项目 -->
					<div class="carousel-inner" id="item2">
						<div class="item active">
							<ul>
								<?php if(is_array($resultArr1)): $i = 0; $__LIST__ = array_slice($resultArr1,0,5,true);if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v1): $mod = ($i % 2 );++$i;?><li id="finish<?php echo (substr($v1["order_sn"],-5,5)); ?>"><?php echo (substr($v1["order_sn"],-5,5)); ?></li><?php endforeach; endif; else: echo "" ;endif; ?>
							</ul>
						</div>
						<?php $__FOR_START_25796__=1;$__FOR_END_25796__=$total1;for($b=$__FOR_START_25796__;$b < $__FOR_END_25796__;$b+=1){ ?><div class="item">
								<ul>
									<?php if(is_array($resultArr1)): $i = 0; $__LIST__ = array_slice($resultArr1,$b*5,5,true);if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v1): $mod = ($i % 2 );++$i;?><li id="finish<?php echo (substr($v1["order_sn"],-5,5)); ?>"><?php echo (substr($v1["order_sn"],-5,5)); ?></li><?php endforeach; endif; else: echo "" ;endif; ?>
								</ul>
							</div><?php } ?>
					</div>
					<input type="hidden" id="resultArrLen1" value="<?php echo ($resultArrLen1); ?>">
				</div>
			</div>
			<footer>请留意您取餐号</footer>
		</div>
		<div class="col-xs-3 ad">
			<div id="ad-carousel" class="carousel" data-ride="carousel">
				<!-- 轮播图片 -->
				<div class="carousel-inner">
					<div class="item">
						<img class="remind_ad" src="/<?php echo ($addr); ?>">
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- jQuery文件。务必在bootstrap.min.js 之前引入 -->
<script src="/Public/js/jquery-3.1.0.min.js"></script>
<!-- 最新的 Bootstrap 核心 JavaScript 文件 -->
<script src="/Public/bootstrap/js/bootstrap.min.js"></script>
<script src="/Public/js/prevent.js"></script>
<script>
	$(document).ready(function () {
		console.log("domain:");
		console.log(document.domain);
		// 连接服务端
		var socket = io('http://'+document.domain+':2120');
		// 连接后登录
        // socket连接成功后触发，用于初始化
		socket.on('connect', function(){
			var uid = $("#device_code").val();
			console.log("uid:");
			console.log(uid);
            // 表示发送了一个action命令，还有data数据
			socket.emit('login', uid);
		});
		// 后端推送来消息时
		socket.on('new_msg', function(msg){
			console.log("msg:");
			console.log(msg);

			msg = msg.replace(/&quot;/g, '"');
			console.log(msg);
			//将推送过来的msg(json字符串转json对象)
			var msgObj = JSON.parse(msg);

			//判断status的值来决定到底做哪一种行为
			if(msgObj){
				f();
				f1();
				if(msgObj['action'] == 'finish_order'){
					var order_sn = msgObj['order_sn'].substr(-5,5);
					var str = order_sn+"号顾客请取餐";
					try{
						JsObj.speak(str);
					}catch(e){
						console.log(e.name+ e.message);
					}
				}
			}
		});
	});

	function f(){
		$.ajax({
			type:"get",
			url:"/index.php/home/staff/refresh",
//			async:false,
			success:function(data){
				$('#comingDiv').html(data);

				$('#comingCarousel').carousel({
					interval: 3000,
					wrap:true,
				})
			}
		});
	}

	function f1(){
		$.ajax({
			type:"get",
			url:"/index.php/home/staff/refresh1",
//				async:false,
			success:function(data){
				$('#serverDiv').html(data);
				$('#serverCarousel').carousel({
					interval: 2000,
					wrap:true,
				})
			}
		});
	}

	$('#ad-carousel .item:first-child').addClass('active');
</script>
</body>
</html>