<?php if (!defined('THINK_PATH')) exit();?> <table id="mytr">
        <tr class="text-center">
            <th></th>
            <th>排序</th>
            <th>名称</th>
            <th>图片</th>
            <th>价格</th>
            <th>类别</th>
            <th>星级</th>
            <th>时价</th>
            <th>状态</th>
            <th><button onclick="location.href = '/index.php/admin/Dishes/add'" class="btn btn-primary">新增菜品</button></th>
        </tr>
        <?php if(is_array($info)): $i = 0; $__LIST__ = $info;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><tr>
        	<td><?php echo ($key+1); ?></td>
    		<td><button class="btn-none moveup" data-sort="<?php echo ($v["sort"]); ?>" data-food_id = "<?php echo ($v["food_id"]); ?>" onclick="moveup2(this)"><img src="/Public/images/up.png" ></button>
        		<button class="btn-none movedown" data-sort="<?php echo ($v["sort"]); ?>" data-food_id = "<?php echo ($v["food_id"]); ?>" onclick="movedown2(this)"><img src="/Public/images/down.png"></button>
			</td>
			<td><?php echo ($v["food_name"]); ?></td>
			<td><img src = "/<?php echo ($v["food_img"]); ?>" class="dishes-img" style="width: 70px; height: 47px;"></td>
			<td><?php echo ($v["food_price"]); ?>元</td>
			<td><?php echo ($v["food_category_name"]); ?></td>
			   <input type="hidden" name="food_category_id" id="food_category_id" value="<?php echo ($v["food_category_id"]); ?>"/>  
			<?php if($v["star_level"] == 1): ?><td>★</td><?php endif; ?>
				<?php if($v["star_level"] == 2): ?><td>★★</td><?php endif; ?>
				<?php if($v["star_level"] == 3): ?><td>★★★</td><?php endif; ?>
				<?php if($v["star_level"] == 4): ?><td>★★★★</td><?php endif; ?>
				<?php if($v["star_level"] == 5): ?><td>★★★★★</td><?php endif; ?>
			<?php if(($v["is_prom"]) == "0"): ?><td>关闭</td>
			<?php else: ?>
				<td>开启</td><?php endif; ?>
			<?php if(($v["is_sale"]) == "0"): ?><td>下架</td>
			<?php else: ?>
				<td>上架</td><?php endif; ?>	
			<td>
				<button class="btn btn-primary" onclick="modify_food(this)" data-food_id = "<?php echo ($v["food_id"]); ?>" data-food_category_id = "<?php echo ($v["food_category_id"]); ?>">编辑</button>
				<button class="btn btn-info" onclick="changestatu(<?php echo ($v["food_id"]); ?>)"><?php if(($v["is_sale"]) == "1"): ?>下架<?php else: ?>上架<?php endif; ?></button>
				<button class="btn btn-default" onclick = "delfoodinfo1(<?php echo ($v["id"]); ?>)">删除</button>
			</td>
        </tr><?php endforeach; endif; else: echo "" ;endif; ?>
    </table>
    <div class="text-center">
		<ul class="pagination" id="detail-page"><?php echo ($page); ?></ul>
	</div>
                    
<script>	
 	//菜品记录表排序，但排序ID是用的(food表),上移数据
 	function moveup2(obj){
 		var when_sort = $(obj).data('sort');
 		var when_food_id = $(obj).data('food_id');
 		var page = $(".current").data('page');	//当前页数
 		var food_category_id = $("input[name='food_category_id']").val();        //分类名称
 		if(page == undefined){
 			page = 1;
 		}
 		$.ajax({
 			type:"get",
 			url:"/index.php/admin/dishes/moveup2/food_category_id/"+food_category_id+"/when_sort/"+when_sort+"/when_food_id/"+when_food_id,
 			async:true,
 			dataType:"json",
 			success:function(data){
				if(data.code == 1){
			    	$.ajax({
			    		type:"get",
						url:"/index.php/admin/Dishes/deskInfo2/food_category_id/"+food_category_id+"/page/"+page,
						success:function(data){
							$("#all").html(data);
						},
						error:function(){
							alert("出错了");
						}
					});	
		 		}
 			}
 		});
 	}
 	
 	//菜品记录表排序，但排序ID是用的(food表),下移数据
 	function movedown2(obj){
 		var when_sort = $(obj).data('sort');
 		var when_food_id = $(obj).data('food_id');
 		var page = $(".current").data('page');	//当前页数
 		var food_category_id = $("input[name='food_category_id']").val();        //分类名称
 		if(page == undefined){
 			page = 1;
 		}
 		$.ajax({
 			type:"get",
 			url:"/index.php/admin/dishes/movedown2/food_category_id/"+food_category_id+"/when_sort/"+when_sort+"/when_food_id/"+when_food_id,
 			async:true,
 			dataType:"json",
 			success:function(data){
				if(data.code == 1){
			    	$.ajax({
			    		type:"get",
						url:"/index.php/admin/Dishes/deskInfo2/food_category_id/"+food_category_id+"/page/"+page,
						success:function(data){
							$("#all").html(data);
						},
						error:function(){
							alert("出错了");
						}
					});	
		 		}
 			}
 		});
 	}
  
  	//点击页码的跳转ajax分页操作
	$("#detail-page").children().children("a").click(function(){
		var page = parseInt($(this).data("page"));
		var food_category_id = $("#food_category_id").val();
		$.ajax({
			url:"/index.php/admin/Dishes/deskInfo2/page/"+page+"/food_category_id/"+food_category_id,
			type:"get",
			success:function(data){
				$("#all").html(data);
			},
			error:function(){
				alert("出错了");
			}
		});	
	});
</script>