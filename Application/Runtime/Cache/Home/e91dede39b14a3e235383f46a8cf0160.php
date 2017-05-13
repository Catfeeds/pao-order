<?php if (!defined('THINK_PATH')) exit();?><script src="/Public/js/Home/orderPopup.js"></script>
<div class="modal-dialog">
	<div class="modal-content">
		<div class="food-content">
			<div class="row" id="<?php echo ($info3["food_id"]); ?>">
				<div class="col-sm-6">
					<div class="modal-img-content">
						<img src="/<?php echo ($info3["food_img"]); ?>" class="modal-food-img">
					</div>
				</div>
				<div class="col-sm-6">
					<p class="modal-title" id="foodname"><?php echo ($info3["food_name"]); ?></p>
					<p class="food-intro"><?php echo ($info3["food_desc"]); ?></p>
					<div class="modal-price-content clearfix">
						<div class="pull-left">
							<div class="modal-price" >
								<span class="red">&yen;</span>
								<!--<span class="red" id="food_price" data-food_price="<?php echo ($info3["food_price"]); ?>"><?php echo ($info3["food_price"]); ?></span>-->
								<span class="red" id="food_price" data-food_price="<?php echo ($food_price); ?>"><?php echo ($food_price); ?></span>/
								<span id="show_num">1</span>份
							</div>
						</div>
						<div class="pull-right text-right">
							<button class="btn-none" onclick="decreaseNum(this)" data-food_id="<?php echo ($info3["food_id"]); ?>" data-food_price="<?php echo ($food_price); ?>">
								<img src="/Public/images/minus_btn.png" >
							</button>
							<span class="modal-num" id = "food_num">1</span>
							<button class="btn-none" onclick="increaseNum(this)" data-food_id="<?php echo ($info3["food_id"]); ?>" data-food_price="<?php echo ($food_price); ?>">
								<img src="/Public/images/plus_btn.png">
							</button>
						</div>
					</div>					
				</div>
			</div>
			<div class="food-attr">
				<form action="javascript:void(0)" id="attr_form">
				<?php if(is_array($at_list)): $ki = 0; $__LIST__ = $at_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$at_vo): $mod = ($ki % 2 );++$ki; if($at_vo['select_type'] == 0): ?><ul class="attr-list clearfix" id="first">
							<li class="attr-item-name"><?php echo ($at_vo["type_name"]); ?>:</li>
							<?php if(is_array($at_vo['attrs'])): $k = 0; $__LIST__ = $at_vo['attrs'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$ats_vo): $mod = ($k % 2 );++$k;?><li class="attr-select-item <?php echo ($ats_vo["length_type"]); ?>" onclick="changePrice()">
									<input type="radio" name = "radio<?php echo ($ki); ?>"  value="<?php echo ($ats_vo["attribute_price"]); ?>" data-fd_at_id="<?php echo ($ats_vo["food_attribute_id"]); ?>" data-key = "<?php echo ($k); ?>"/>
									<?php echo ($ats_vo["attribute_name"]); ?><br> + <?php echo ($ats_vo["attribute_price"]); ?>元
								</li><?php endforeach; endif; else: echo "" ;endif; ?>
						</ul>
						<?php else: ?>
						<ul class="attr-list clearfix" id="third">
							<li class="attr-item-name"><?php echo ($at_vo["type_name"]); ?>:</li>
							<?php if(is_array($at_vo['attrs'])): $i = 0; $__LIST__ = $at_vo['attrs'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$ats_vo): $mod = ($i % 2 );++$i;?><li class="attr-select-item <?php echo ($ats_vo["length_type"]); ?>" onclick="changePrice()">
									<input type="checkbox" name = "checkbox<?php echo ($ats_vo["food_attribute_id"]); ?>"  value="<?php echo ($ats_vo["attribute_price"]); ?>" data-fd_at_id="<?php echo ($ats_vo["food_attribute_id"]); ?>"/>
									<?php echo ($ats_vo["attribute_name"]); ?> <br>+ <?php echo ($ats_vo["attribute_price"]); ?>元
								</li><?php endforeach; endif; else: echo "" ;endif; ?>
						</ul><?php endif; endforeach; endif; else: echo "" ;endif; ?>
				</form>
			</div>
		</div>
		<div class="modal-bottom clearfix">
			<button type="button" data-dismiss="modal" class="btn-close">取消</button>
			<button type="button" id="food-checked" data-single_price="<?php echo ($food_price); ?>" data-attrs="" data-food_name="<?php echo ($info3["food_name"]); ?>" data-food_id="<?php echo ($info3["food_id"]); ?>" onclick="addOrderItem(this)">确认</button>
		</div>
	</div>
</div>