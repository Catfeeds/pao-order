<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>核销员</title>
	<!-- Bootstrap 核心 CSS 文件 -->
	<link rel="stylesheet" href="/Public/bootstrap/css/bootstrap.min.css">

	<link rel="stylesheet" type="text/css" href="/Public/css/remind.css">
	<script src='/Public/js/socket.io.js'></script>
	<script src='/Public/js/notify.js'></script>
	<script src='/Public/js/websocket.js'></script>
</head>
<body>
<input type="hidden" name="device_code" id="device_code" value="<?php echo ($device_code); ?>">
<div class="clerk clearfix">
	<?php if(is_array($info)): $i = 0; $__LIST__ = $info;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i; if($v["order_status"] == 11): ?><button id = "<?php echo ($v["order_id"]); ?>" class="order-number order-check" data-toggle="modal" data-target="#myModal" onclick="showinfo(<?php echo ($v["order_id"]); ?>)"><?php echo ($v["order_sn"]); ?></button>
			<?php else: ?>
			<button id = "<?php echo ($v["order_id"]); ?>" class="order-number" data-toggle="modal" data-target="#myModal" onclick="showinfo(<?php echo ($v["order_id"]); ?>)"><?php echo ($v["order_sn"]); ?></button><?php endif; endforeach; endif; else: echo "" ;endif; ?>
</div>

<!-- Modal -->
<div class="modal" id="myModal" tabindex="-1" role="dialog">
	<div class="modal-dialog" id="modal">

	</div>
</div>

<!-- jQuery文件。务必在bootstrap.min.js 之前引入 -->
<script src="/Public/js/jquery-3.1.0.min.js"></script>
<!-- 最新的 Bootstrap 核心 JavaScript 文件 -->
<script src="/Public/bootstrap/js/bootstrap.min.js"></script>
<script src="/Public/js/prevent.js"></script>
<script>
	function showinfo(i){
		$.ajax({
			type:"get",
			url:"/index.php/home/staff/getorderinfo/order_id/"+i+"",
			success:function(data){
//				console.log(data);
				$('#modal').html(data);
			},
			error:function(){
				console.log("访问出错");
			}
		});
	}

	//改变状态
	function changestatu(i){
		//alert(i);
		$('#myModal').modal("hide");
		$.ajax({
			type:"get",
			url:"/index.php/home/staff/changestatus/order_id/"+i+"",
			dataType:"json",
			async:true,
			success:function(data){
				if(data.data == 1){ // 请取单状态修改成功
					$("#"+i+"").addClass("order-check");//按了请取餐以后变成蓝色
				}
			}
		});
	}

	//核销
	function changestatu1(i){
		$('#myModal').modal("hide");
		$.ajax({
			type:"get",
			url:"/index.php/home/staff/changestatus1/order_id/"+i+"",
			dataType:"json",
			async:true,
			success:function(data){
				if(data.data == 1){
					location.reload();
				}
			}
		});
	}
</script>
<script>
	$(document).ready(function () {
		console.log("domain:");
		console.log(document.domain);
		// 连接服务端
		var socket = io('http://'+document.domain+':2120');
		// 连接后登录
		socket.on('connect', function(){
			var uid = $("#device_code").val();
			socket.emit('login', uid);
		});
		// 后端推送来消息时
		socket.on('new_msg', function(msg){
			if(msg){
				location.href = "";
			}
		});
	});
</script>
</body>
</html>