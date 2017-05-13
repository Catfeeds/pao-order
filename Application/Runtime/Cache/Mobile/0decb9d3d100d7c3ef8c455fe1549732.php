<?php if (!defined('THINK_PATH')) exit();?>
<div class="modal-content">
    <div class="food-content" id="<?php echo ($info3["food_id"]); ?>">
        <div class="img-box">
            <img src="/<?php echo ($info3["food_img"]); ?>">
        </div>
        <div class="modal-detail">
            <div class="modal-detail-left text-left">
                <div class="modal-food-name" id="foodname"><?php echo ($info3["food_name"]); ?></div>
                <div class="red modal-price" value="<?php echo ($food_price); ?>">
                    <span>&yen;</span>
                    <span id="food_price" data-food_price="<?php echo ($food_price); ?>"><?php echo ($food_price); ?></span>
                </div>
            </div>
            <div class="modal-detail-right text-right">
                <div class="modal-price-content">
                    <button class="btn-none" onclick="decreaseNum(this)" data-food_id="<?php echo ($info3["food_id"]); ?>" data-food_price="<?php echo ($food_price); ?>">
                        <img src="/Public/images/minus_btn.png">
                    </button>
                    <span class="modal-num" id = "food_num">1</span>
                    <button class="btn-none" onclick="increaseNum(this)" data-food_id="<?php echo ($info3["food_id"]); ?>" data-food_price="<?php echo ($food_price); ?>">
                        <img src="/Public/images/plus_mobile.png">
                    </button>
                </div>
            </div>          
        </div>
        <p class="food-intro">
            <?php echo ($info3["food_desc"]); ?>
        </p>
        <div class="food-attr">
            <form action="javascript:void(0)" id="attr_form">
                <?php if(is_array($at_list)): $i = 0; $__LIST__ = $at_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$at_vo): $mod = ($i % 2 );++$i; if($at_vo['select_type'] == 0): ?><ul class="attr-list clearfix" id="first">
                            <li class="attr-item-name"><?php echo ($at_vo["type_name"]); ?></li>
                            <?php if(is_array($at_vo['attrs'])): $k = 0; $__LIST__ = $at_vo['attrs'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$ats_vo): $mod = ($k % 2 );++$k;?><li class="attr-select-item <?php echo ($ats_vo["length_type"]); ?>" onclick="changePrice()">
                                    <input type="radio" name = "radio<?php echo ($ats_vo["food_attribute_id"]); ?>"  value="<?php echo ($ats_vo["attribute_price"]); ?>" data-fd_at_id="<?php echo ($ats_vo["food_attribute_id"]); ?>" data-key = "<?php echo ($k); ?>"/>            
                                    <div class="attr-name">
                                        <span><?php echo ($ats_vo["attribute_name"]); ?></span>
                                    </div>
                                    <div>+<?php echo ($ats_vo["attribute_price"]); ?>元</div>
                                </li><?php endforeach; endif; else: echo "" ;endif; ?>
                        </ul>
                    <?php else: ?>            
                        <ul class="attr-list clearfix" id="third">
                            <li class="attr-item-name"><?php echo ($at_vo["type_name"]); ?></li>
                            <?php if(is_array($at_vo['attrs'])): $i = 0; $__LIST__ = $at_vo['attrs'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$ats_vo): $mod = ($i % 2 );++$i;?><li class="attr-select-item <?php echo ($ats_vo["length_type"]); ?>" onclick="changePrice()">
                                    <input type="checkbox" name = "checkbox<?php echo ($ats_vo["food_attribute_id"]); ?>"  value="<?php echo ($ats_vo["attribute_price"]); ?>" data-fd_at_id="<?php echo ($ats_vo["food_attribute_id"]); ?>"/>            
                                    <div class="attr-name"><?php echo ($ats_vo["attribute_name"]); ?></div>
                                    <div>+<?php echo ($ats_vo["attribute_price"]); ?>元</div>
                                </li><?php endforeach; endif; else: echo "" ;endif; ?>
                        </ul><?php endif; endforeach; endif; else: echo "" ;endif; ?>
            </form>
        </div>
    </div>
    
    
    <div class="modal-bottom">
        <button type="button" data-dismiss="modal" class="btn-close"><span>&lt;&nbsp;</span>关闭</button>
        <button type="button" id="food-checked" data-single_price="<?php echo ($food_price); ?>" data-attrs="" data-food_name="<?php echo ($info3["food_name"]); ?>" data-food_id="<?php echo ($info3["food_id"]); ?>" onclick="addOrderItem(this)">确认</button>
    </div>
</div>

<script src="/Public/js/Mobile/orderPopup_mobile.js"></script>