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

	


<!-- 收银 -->
<body class="order-body">
<input type="hidden" name="isOpenNum" id="isOpenNum" value="<?php echo (session('isOpenNum')); ?>">
<input type="hidden" name="tpl" value="<?php echo ($tpl); ?>" id="tpl"/>

	<header class="home-header">
		<a href="/index.php/Home/Index/index" class="order-return">
			<img src="/Public/images/lt.png">
			<span>重新点餐</span>
		</a>
		<div class="text-center order-head">方雅自助点餐系统</div>
	</header>

	<div class="order">
		<!-- 左边分类 start -->
		<div class="order-left">
			<ul class="sorts-list">
				<?php if(is_array($info)): $i = 0; $__LIST__ = $info;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><li>
						<a href="" data-toggle="tab" id="category_type" onclick="showtypefood(<?php echo ($v["food_category_id"]); ?>)">
							<span><?php echo ($v["food_category_name"]); ?></span>
						</a>
					</li><?php endforeach; endif; else: echo "" ;endif; ?>
			</ul>
		</div> <!-- 左边分类 end -->

		<!-- 中间菜品列表 start -->
		<div class="order-content">
			<div class="container-fluid">
				<div class="tab-content" id="food_info">
					<div class="tab-pane fade in active" id="recommend">
						<div class="row">
							<?php if(is_array($info1)): $i = 0; $__LIST__ = $info1;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v1): $mod = ($i % 2 );++$i;?><div class="col-sm-6 col-md-4">
									<a href="javascript:void(0)" class="food-item"  data-toggle="modal" data-target="#foodModal" data-food_id="<?php echo ($v1["food_id"]); ?>" onclick="findfoodinfo(this)">
										<div class="food-box">
											<div class="food-box-img">
												<img src="/<?php echo ($v1["food_img"]); ?>">
											</div>
											<div class="clearfix">
												<div class="pull-left">
													<div class="star">
														<?php if($v1["star_level"] == 1): ?><span></span><?php endif; ?>
														<?php if($v1["star_level"] == 2): ?><span>★★</span><?php endif; ?>
														<?php if($v1["star_level"] == 3): ?><span>★★★</span><?php endif; ?>
														<?php if($v1["star_level"] == 4): ?><span>★★★★</span><?php endif; ?>
														<?php if($v1["star_level"] == 5): ?><span>★★★★★</span><?php endif; ?>
													</div>
												</div>
												<div class="pull-right text-right">
													<div class="cayenne">
														<?php if($v1["hot_level"] == 0): endif; ?>
														<?php if($v1["hot_level"] == 1): ?><!-- <img src="/Public/images/cayenne.png"> --><?php endif; ?>
														<?php if($v1["hot_level"] == 2): ?><img src="/Public/images/cayenne.png">
															<img src="/Public/images/cayenne.png"><?php endif; ?>
														<?php if($v1["hot_level"] == 3): ?><img src="/Public/images/cayenne.png">
															<img src="/Public/images/cayenne.png">
															<img src="/Public/images/cayenne.png"><?php endif; ?>
													</div>
												</div>
											</div>
										</div>
										<div class="food-details">
											<div class="food-name"><?php echo ($v1["food_name"]); ?></div>
											<div class="food-price">&yen;<?php echo ($v1["food_price"]); ?></div>
										</div>
									</a>
								</div><?php endforeach; endif; else: echo "" ;endif; ?>
						</div>
					</div>
				</div>
			</div>
		</div><!-- 菜品列表 end -->

		<!-- 右边已选菜品 start -->
		<div class="order-right">
			<div class="container-fluid">
				<!-- 菜品选择列表 start -->
				<div class="food-select" id="foodlist">

				</div><!-- 菜品选择列表 end -->
			</div>

			<div class="total" >
				<p>合计：&yen;<span id="Total">0.00</span>元</p>
				<button class="common-btn place-order-btn" onclick="PlaceOrder2()">
					<span>立即下单</span>
					<img src="/Public/images/gt.png">
				</button>
			</div>
		</div><!-- 右边已选菜品 end -->
	</div>

	<!-- 菜品Modal -->
	<div class="modal fade" id="foodModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="food-modal-dialog" id="modelfood">

		</div>
	</div>
	<!-- 餐桌Modal -->
	<div class="modal" id="tableModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="tableModal-return">
				<button class="btn-none" data-dismiss="modal">
					<span>&lt;</span>
					<span>返回点餐</span>
				</button>
			</div>
			<div class="number text-center">
				<div class="number-tips">1.领取点餐机旁边的餐牌号</div>
				<div class="number-tips">2.输入餐牌号，按确认</div>
				<div class="number-input">
					<input type="text" id="numtext" data-order_type="<?php echo ($_GET['order_type']); ?>" value="" readonly="readonly">
					
					<button id="btn" onclick="placeor()">确认</button>
				</div>
				<div class="number-table clearfix">
					<div class="pull-left">
						<table>
							<tr>
								<td>
									<button class="num-btn">1</button>
								</td>
								<td>
									<button class="num-btn">2</button>
								</td>
								<td>
									<button class="num-btn">3</button>
								</td>
							</tr>
							<tr>
								<td>
									<button class="num-btn">4</button>
								</td>
								<td>
									<button class="num-btn">5</button>
								</td>
								<td>
									<button class="num-btn">6</button>
								</td>
							</tr>
							<tr>
								<td>
									<button class="num-btn">7</button>
								</td>
								<td>
									<button class="num-btn">8</button>
								</td>
								<td>
									<button class="num-btn">9</button>
								</td>
							</tr>
						</table>
					</div>
					<div class="pull-left number-table-right">
						<table>
							<tr>
								<td>
									<button class="num-btn">0</button>
								</td>
							</tr>
							<tr>
								<td>
									<button id="del-num">
										<p>删</p>除
									</button>
								</td>
							</tr>
						</table>
					</div>
				</div>				
			</div>
		</div>
	</div>
</body>
<script src="/Public/js/Home/order.js"></script>
</html>