<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh-CN">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

	<!-- Bootstrap 核心 CSS 文件 -->
	<!-- <link rel="stylesheet" href="/Public/bootstrap/css/bootstrap.min.css"> -->
    <link rel="stylesheet" href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<!-- mobile CSS 文件 -->
	<link rel="stylesheet" href="/Public/css/mobile.css">
	<!-- 替换颜色 css 文件 -->
	<link rel="stylesheet" href="/Public/css/color_red.css" id="global-css">

	<!-- HTML5 Shim 和 Respond.js 用于让 IE8 支持 HTML5元素和媒体查询 -->
	<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
	<script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
	<![endif]-->

	<!-- jQuery文件。务必在bootstrap.min.js 之前引入 -->
	<!-- <script src="/Public/js/jquery-3.1.0.min.js"></script> -->
	<script src="http://apps.bdimg.com/libs/jquery/2.1.4/jquery.min.js"></script>
	<!-- 最新的 Bootstrap 核心 JavaScript 文件 -->
	<!-- <script src="/Public/bootstrap/js/bootstrap.min.js"></script> -->
	<script src="http://apps.bdimg.com/libs/bootstrap/3.3.4/js/bootstrap.min.js"></script>
	<script src="/Public/js/mobile.js"></script>

	<title>方雅点餐系统</title>
</head>
<!-- 点餐页 -->
<body>
	<header class="home-header" id="restaurantInfo" data-restaurant_id="<?php echo ($_GET['restaurant_id']); ?>" data-desk_code="<?php echo ($_GET['desk_code']); ?>">
		<span><?php echo ($wx_order_title); ?></span>
	</header>

	<div class="order">
		<!-- 左边分类 start -->
		<div class="order-left">
			<ul class="sorts-list">
				<?php if(is_array($info)): $i = 0; $__LIST__ = $info;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><li>
						<a href="javascript:void(0)"  id="category_type" onclick="showtypefood(<?php echo ($v["food_category_id"]); ?>)">
							<!-- <img src="/<?php echo ($v["image"]); ?>"> -->
							<span><?php echo ($v["food_category_name"]); ?></span>
						</a>
					</li><?php endforeach; endif; else: echo "" ;endif; ?>
			</ul>
		</div> <!-- 左边分类 end -->

		<!-- 中间菜品列表 start -->
		<div class="order-content" id="food_info">
			<?php if(is_array($info1)): $i = 0; $__LIST__ = $info1;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v1): $mod = ($i % 2 );++$i;?><div class="food-list">
						<a href="#foodModal" class="container-fluid"  data-toggle="modal" data-food_id="<?php echo ($v1["food_id"]); ?>" onclick="findfoodinfo(this)">
							<div class="row">
								<div class="col-xs-5 img-content">
									<div class="img-box">
										<img src="/<?php echo ($v1["food_img"]); ?>">
									</div>
									
								</div>
								<div class="col-xs-7">
									<div class="food-name">
										<span><?php echo ($v1["food_name"]); ?></span>
									</div>
									<div class="clearfix star-cayenne">
										<div class="pull-left">
											<div class="star">
												<?php if($v1["star_level"] == 1): ?><span>★</span><?php endif; ?>
												<?php if($v1["star_level"] == 2): ?><span>★★</span><?php endif; ?>
												<?php if($v1["star_level"] == 3): ?><span>★★★</span><?php endif; ?>
												<?php if($v1["star_level"] == 4): ?><span>★★★★</span><?php endif; ?>
												<?php if($v1["star_level"] == 5): ?><span>★★★★★</span><?php endif; ?>
											</div>
										</div>
										<div class="pull-right text-right">
											<div class="cayenne">
												<?php if($v1["hot_level"] == 0): endif; ?>
												<?php if($v1["hot_level"] == 1): ?><img src="/Public/images/cayenne.png"><?php endif; ?>
												<?php if($v1["hot_level"] == 2): ?><img src="/Public/images/cayenne.png">
													<img src="/Public/images/cayenne.png"><?php endif; ?>
												<?php if($v1["hot_level"] == 3): ?><img src="/Public/images/cayenne.png">
													<img src="/Public/images/cayenne.png">
													<img src="/Public/images/cayenne.png"><?php endif; ?>
											</div>
										</div>
									</div>
									<div class="food-price">
										<span>&yen;<?php echo ($v1["food_price"]); ?></span>
										<span>/份</span>
									</div>
								</div>
							</div>
							
						</a>						
					</div><?php endforeach; endif; else: echo "" ;endif; ?>
		</div><!-- 菜品列表 end -->
	</div>

	<footer class="home-footer">
		<button class="cart" data-toggle="modal" data-target="#cartModal" >
			<span class="glyphicon glyphicon-shopping-cart"></span>
			<div class="cart-num" id="numv">0</div>
		</button>
		<b>&yen;<span id="Total">0.00</span></b>
		<button type="button" class="btn-none common-btn" id="check-pay" onclick="PlaceOrder()">选好了</button>
	</footer>

	<!-- Modal -->	
	<div class="modal fade" id="foodModal" tabindex="-1" role="dialog">
		<div class="modal-dialog" id="modelfood">

		</div>
	</div>

	<!-- Modal -->	
	<div class="modal fade" id="cartModal" tabindex="-1" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button class="btn-none" onclick="clearorder()">
						<span class="glyphicon glyphicon-trash"></span>
						<span>清空</span>
					</button>
					<span>购物车</span>
				</div>
				<div class="modal-body">
					<ul id="foodlist">
						<!--<li class="cart-item">
							<div class="cart-left">牛肉面牛肉面牛肉面牛肉面牛肉面牛肉面</div>
							<div class="cart-right">
								<button class="btn-none">
									<img src="/Public/images/minus_btn.png">
								</button>
								<span>1</span>
								<button class="btn-none">
									<img src="/Public/images/plus_mobile.png">
								</button>
								<span class="red">&yen;12.00元</span>
								<b></b>
							</div>
						</li>-->
					</ul>
				</div>
			</div>
		</div>

	</div>
</body>
<script>
	/*$(function(){
			var pagenum = $("table_num").val();
			if(!pagenum){
				pagenum = 000;
			}
			$('#Tables').html(pagenum);
		})*/
	function showtypefood(i){
		//alert(i);
		$.ajax({
			type:"get",
			url:"/index.php/Mobile/Index/showtypefood/type/"+i+"",
			//dataType:"json",
			success:function(data){
				$("#food_info").html(data);
			}
		});
	}
	
	function findfoodinfo(obj){
		var food_id = $(obj).data('food_id');
		console.log(food_id);
		$.ajax({
			type:"get",
			url:"/index.php/Mobile/Index/findfoodinfo/food_id/"+food_id+"",
			success:function(data){
				$("#modelfood").html(data);//加载模态框
			}
		});
	}
	
	function PlaceOrder(){
		var total = Number($("#Total").html()).toFixed(2);
		console.log(total);
		if (total == 0) {
			alert("尚没有添加菜品");
		} else {
			var list = {};
			$('#foodlist li').each(function(k,v){
				var temp = [];
				temp["0"] = $(this).data("food_id");
				temp["1"] = $(this).data("food_num");
				temp["2"] = $(this).data("attrs");
				list[k] = temp;
			});
			console.log(list);
			$.ajax({
				type: "post",
				url: "/index.php/Mobile/Index/PlaceOrder/",
				data: list,
				dataType: 'json',
				success: function (data) {
					if (data.code == 1) {
						var order_sn = data.data['order_sn'];
						var Total = $("#Total").html();
						window.location.href = "/index.php/Mobile/Index/pay/order_sn/"+order_sn+"";
					}
				},
				error: function () {
					alert("there is a error!");
				}
			});
		}
	}
	
	$(function(){		
		if(<?php echo ($tpl['tplcolor2_id']); ?>==0){
			$('#global-css').attr('href','/Public/css/color_red.css');
		}else if(<?php echo ($tpl['tplcolor2_id']); ?>==1){
			$('#global-css').attr('href','/Public/css/color_blue.css');
		}else if(<?php echo ($tpl['tplcolor2_id']); ?>==2){
			$('#global-css').attr('href','/Public/css/color_green.css');
		}else if(<?php echo ($tpl['tplcolor2_id']); ?>==3){
			$('#global-css').attr('href','/Public/css/color_yellow.css');
		}else if(<?php echo ($tpl['tplcolor2_id']); ?>==4){
			$('#global-css').attr('href','/Public/css/color_black.css');
		}else{
			$('#global-css').attr('href','/Public/css/color_orange.css');
		}	
	});

	//将店铺id和餐桌号保存在本地存储中
	$(function(){
		var restaurantInfo = $("#restaurantInfo").data();
		var restaurant_id = restaurantInfo["restaurant_id"];
		var desk_code = restaurantInfo["desk_code"];
		console.log(restaurant_id);
		console.log(desk_code);
		sessionStorage.setItem("restaurant_id",restaurant_id);
		sessionStorage.setItem("desk_code",desk_code);
	});
</script>
</html>