<?php if (!defined('THINK_PATH')) exit();?><div class="content">
	<div class="modal-header text-center">
		<button type="button" class="close-btn" data-dismiss="modal">
			<span aria-hidden="true">&times;</span>
		</button>
		<span><?php echo (substr($info1["order_sn"],-5,5)); ?></span>
	</div>
	<div class="modal-body">
		<div class="container-fluid">
			<div class="row">
				<div class="col-xs-8">
					<table class="modal-table">
						<?php if(is_array($info2)): $i = 0; $__LIST__ = $info2;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><tr>
								<td><?php echo ($v["food_name"]); ?></td>
								<td>&yen;<?php echo ($v["food_price2"]); ?></td>
							</tr><?php endforeach; endif; else: echo "" ;endif; ?>
					</table>
				</div>
				<div class="col-xs-4">
					<div class="modal-button-content">
						<?php if($info1["order_status"] == 11): ?><button id="cancel" class="modal-btn none-btn" onclick="changestatu1(<?php echo ($v["order_id"]); ?>)">核销</button>
							<?php else: ?>
							<button id="takeMeal" class="modal-btn none-btn" onclick="changestatu(<?php echo ($v["order_id"]); ?>)">请取餐</button><?php endif; ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>