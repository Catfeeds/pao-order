<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8"></head>
<body>
	<div class="container-fluid">
		<div class="row">
			<?php if(is_array($info2)): $i = 0; $__LIST__ = $info2;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v1): $mod = ($i % 2 );++$i;?><div class="col-xs-6">
					<a class="food-item" href="javascript:void(0)"  data-toggle="modal" data-target="#foodModal" data-food_id="<?php echo ($v1["food_id"]); ?>" onclick="findfoodinfo(this)">
						<div class="food-box">
							<div class="food-box-img">
								<img src="/<?php echo ($v1["food_img"]); ?>"></div>
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
										<?php if($v1["hot_level"] == 1): endif; ?>
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
</body>
</html>