<?php if (!defined('THINK_PATH')) exit();?>	<!--
    	作者：凯
    	时间：2017-01-09
    	描述：设备的ajax页
    -->
	<table class="device-table">
		<tr>
			<td>序号</td>
			<td>设备名称</td>
			<td>MAC</td>
			<td>最后注册时间</td>
			<td>到期时间</td>
			<td>设备状态</td>
			<td>详细地址</td>
			<td>操作</td>
		</tr>
		<?php if(is_array($deviceArr)): $i = 0; $__LIST__ = $deviceArr;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><tr>
					<td><?php echo ($key+1); ?></td>
					<td><?php echo ($v["device_name"]); ?></td>
					<td><?php echo ($v["device_code"]); ?></td>
					<td><?php echo (date("Y-m-d",$v["start_time"])); ?></td>
					<td><?php echo (date("Y-m-d",$v["end_time"])); ?></td>
					<?php if(($v["device_status"]) == "1"): ?><td>正常</td>
						<?php else: ?>
						<td>禁用</td><?php endif; ?>
					<td><?php echo ($v["address"]); ?></td>
					<td>
						<button class="btn btn-black" data-toggle="modal" onclick="modify(<?php echo ($v["device_id"]); ?>)">编辑</button>
						<button class="btn btn-black" data-target="#renew" data-toggle="modal">续费</button>
						<button class="btn btn-default" onclick="del(<?php echo ($v["device_id"]); ?>)">删除</button>
					</td>
				</tr><?php endforeach; endif; else: echo "" ;endif; ?>
	</table>
	<div>
	    <ul class="pagination" id="detail-page">
	        <?php echo ($page); ?>
	    </ul>
	</div>
				
	<script>
		$("#detail-page").children().children("a").click(function(){
			var page = parseInt($(this).data("page"));
			var device_start_time = $('#device_start_time').val();
			var device_end_time = $('#device_end_time').val();
			if(device_start_time && device_end_time != ""){
				url = "/index.php/allAgent/Device/searchDevicebyTime/device_start_time/"+device_start_time+"/device_end_time/"+device_end_time+"/page/"+page;
			}else{
				url = "/index.php/allAgent/Device/device_ajax/page/"+page;
			}
			$.ajax({
				type:"get",
				url:url,
				success:function(data){
					$("#listtable").html(data);
				},
				error:function(){
				 	alert("出错了");
				}
			});
		});
	</script>