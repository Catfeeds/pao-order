<?php if (!defined('THINK_PATH')) exit();?><div class="restaurant-info" style=" margin-left: 20px;">
		<form action="javascript:void(0)" id="restaurant_form">
			<div class="form-group">
				<label for="restaurant_name">第一个续费年限：</label>
				<input type="text" class="form-control" value="<?php echo ($renewArr["renew_time1"]); ?>" name="renew_time1"  placeholder="请输入设备续费选择时间">
			</div>
			<div class="form-group">
				<label for="telephone1">第二个续费年限：</label>
				<input type="text" class="form-control" value="<?php echo ($renewArr["renew_time2"]); ?>" name="renew_time2"  placeholder="请输入设备续费选择时间">
			</div>
			<div class="form-group">
				<label for="telephone2">第三个续费年限：</label>
				<input type="text" class="form-control" value="<?php echo ($renewArr["renew_time3"]); ?>" name="renew_time3"  placeholder="请输入设备续费选择时间">
			</div>
		</form>
		<button class="btn btn-sm btn-primary align-right" onclick="update_renew()">编辑</button>
	</div>