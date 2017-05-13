<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title></title>
</head>
<body>
	<?php if(is_array($info2)): $i = 0; $__LIST__ = $info2;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v1): $mod = ($i % 2 );++$i;?><div class="food-list">
				<a href="#foodModal" class="container-fluid"  data-toggle="modal" onclick="findfoodinfo(<?php echo ($v1["food_id"]); ?>)">
					<div class="row">
						<div class="col-xs-4 img-content">
							<div class="img-box">
								<img src="/<?php echo ($v1["food_img"]); ?>">
							</div>
							
						</div>
						<div class="col-xs-8">
							<div class="food-name"><?php echo ($v1["food_name"]); ?></div>
							<div class="food-price">
								<span>&yen;<?php echo ($v1["food_price"]); ?></span>
								<span>/份</span>
							</div>
							<div class="clearfix star-cayenne">
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
										<?php if($v1["hot_level"] == 1): ?><img src="/Public/images/cayenne.png"><?php endif; ?>
										<?php if($v1["hot_level"] == 2): ?><img src="/Public/images/cayenne.png">
											<img src="/Public/images/cayenne.png"><?php endif; ?>
										<?php if($v1["hot_level"] == 3): ?><img src="/Public/images/cayenne.png">
											<img src="/Public/images/cayenne.png">
											<img src="/Public/images/cayenne.png"><?php endif; ?>
									</div>
								</div>
							</div>
						</div>
					</div>
				</a>						
			</div><?php endforeach; endif; else: echo "" ;endif; ?>
<!-- 		<?php if(is_array($info2)): $i = 0; $__LIST__ = $info2;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v1): $mod = ($i % 2 );++$i;?><div class="col-xs-6 col-sm-4 col-lg-3">
				<div class="food-list">
					<a href="javascript:void(0)"  data-toggle="modal" data-target="#foodModal" onclick="findfoodinfo(<?php echo ($v1["food_id"]); ?>)">
						<img src="/<?php echo ($v1["food_img"]); ?>">
					</a>
					<div class="food-details">
						<div class="star">
								<?php if($v1["star_level"] == 1): ?><span>★</span><?php endif; ?>
								<?php if($v1["star_level"] == 2): ?><span>★★</span><?php endif; ?>
								<?php if($v1["star_level"] == 3): ?><span>★★★</span><?php endif; ?>
								<?php if($v1["star_level"] == 4): ?><span>★★★★</span><?php endif; ?>
								<?php if($v1["star_level"] == 5): ?><span>★★★★★</span><?php endif; ?>
						</div>
						<div class="food-price">&yen;<?php echo ($v1["food_price"]); ?></div>
					</div>
					<a href="#" data-toggle="modal" data-target="#foodModal" class="food-name"><?php echo ($v1["food_name"]); ?></a>
				</div>
			</div><?php endforeach; endif; else: echo "" ;endif; ?> -->
</body>
</html>
<script>
	function findfoodinfo(i){
		$.ajax({
			type:"get",
			url:"/index.php/Mobile/Index/findfoodinfo/food_id/"+i+"",
			success:function(data){
				$("#modelfood").html(data);//加载模态框
			}
		});
	}
</script>