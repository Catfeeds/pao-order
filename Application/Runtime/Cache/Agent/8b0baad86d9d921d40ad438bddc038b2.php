<?php if (!defined('THINK_PATH')) exit();?>	<table class="device-table table-hover">
		<tr>
			<td>序号</td>
			<td>设备名称</td>
			<td>机器ID</td>
			<td>最后注册时间</td>
			<td>到期时间</td>
			<td>所属店铺</td>
			<td>状态</td>
			<td></td>
		</tr>
		<?php if(is_array($deviceList)): $i = 0; $__LIST__ = $deviceList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v4): $mod = ($i % 2 );++$i;?><tr>
			<td><?php echo ($key+1); ?></td>
			<td><?php echo ($v4["device_name"]); ?></td>
			<td><?php echo ($v4["device_code"]); ?></td>
			<td><?php echo (date("Y-m-d",$v4["start_time"])); ?></td>
			<td><?php echo (date("Y-m-d",$v4["end_time"])); ?></td>
			<td>
				<select name="bingInfo" id="bindInfo" data-code_id="<?php echo ($v4["code_id"]); ?>" onchange="changeBindRes(this)">
					<?php if(is_array($restaurant_list)): $i = 0; $__LIST__ = $restaurant_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$rsl): $mod = ($i % 2 );++$i; if($rsl['restaurant_id'] == $v4['restaurant_id']): ?><option value="<?php echo ($rsl["restaurant_id"]); ?>" selected><?php echo ($rsl["restaurant_name"]); ?></option>
						<?php else: ?>
							<option value="<?php echo ($rsl["restaurant_id"]); ?>"><?php echo ($rsl["restaurant_name"]); ?></option><?php endif; endforeach; endif; else: echo "" ;endif; ?>
				</select>
			</td>
			<?php if(($v4["device_status"]) == "1"): ?><td>正常</td>
			<?php else: ?>
				<td>禁用</td><?php endif; ?>
			
			<td>
				<button class="btn btn-black" data-target="#editDevice" data-toggle="modal" onclick="modify(<?php echo ($v4["device_id"]); ?>)">编辑</button>
				<button class="btn btn-default" onclick="del(<?php echo ($v4["device_id"]); ?>)">删除</button>
				
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
			$.ajax({
				url:"/index.php/agent/Device/device_ajax/page/"+page,
				type:"get",
				success:function(data){
					$("#mytable").html(data);
				},
				error:function(){
					alert("出错了");
				  }
			   });
	    });
	</script>