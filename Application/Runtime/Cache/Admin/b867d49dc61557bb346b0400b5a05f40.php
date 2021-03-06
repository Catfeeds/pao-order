<?php if (!defined('THINK_PATH')) exit();?>  			 <table id="mytr" class="dishes-table">
            <tr class="text-center">
                <th></th>
                <th>排序</th>
                <th>名称</th>
                <th>图片</th>
                <th>价格</th>
               <!-- <th>类别</th>-->
                <th>星级</th>
                <th>时价</th>
                <th>状态</th>
                <th><button class="btn btn-primary" onclick="location.href = '/index.php/admin/Dishes/add'">新增菜品</button></th>
            </tr>
           
            <?php if(is_array($info)): $i = 0; $__LIST__ = $info;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><tr >
            	<td><?php echo ($key+1); ?></td>
        			<td><button class="btn-none" data-sort = "<?php echo ($v["sort"]); ?>" data-food_id = "<?php echo ($v["food_id"]); ?>" onclick="moveup(this)"><img src="/Public/images/up.png" ></button>
            	<button class="btn-none movedown" data-sort = "<?php echo ($v["sort"]); ?>" data-food_id = "<?php echo ($v["food_id"]); ?>" onclick="movedown(this)"><img src="/Public/images/down.png"></button>
        			</td>
        			<td><?php echo ($v["food_name"]); ?></td>
        			<td><img src = "/<?php echo ($v["food_img"]); ?>" class="dishes-img" style="width: 70px; height: 47px;"></td>
        			<td><?php echo ($v["food_price"]); ?>元</td>
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
      					<button class="btn btn-primary" onclick="modify_food(this)" data-food_id = "<?php echo ($v["food_id"]); ?>">编辑</button>
        				<button class="btn btn-info" onclick="changestatu(<?php echo ($v["food_id"]); ?>)"><?php if(($v["is_sale"]) == "1"): ?>下架<?php else: ?>上架<?php endif; ?></button>
        				<button class="btn btn-default" onclick = "delfoodinfo(<?php echo ($v["food_id"]); ?>)">删除</button>
      				</td>
            </tr><?php endforeach; endif; else: echo "" ;endif; ?>
        </table>
        <div class="text-center">
            <ul class="pagination" id="detail-page"><?php echo ($page); ?></ul>
        </div>
                    
<script>
 //点击页码执行动作
	$("#detail-page").children().children("a").click(function(){
			var page = parseInt($(this).data("page"));
			console.log(page);
			$.ajax({
				url:"/index.php/admin/Dishes/deskInfo/page/"+page+"",
				type:"get",
				success:function(data){
					$("#all").html(data);
				},
				error:function(){
					alert("出错了");
				}
			});
		
		});

	
	//数据上移
	function moveup(obj){
		var sort = $(obj).data('sort');			//排序ID
		var food_id = $(obj).data('food_id');	//菜品自增ID
		var page = parseInt($(".current").data('page'));	//当前页数
		var when_tr = parseInt($(obj).parent().prev().text());
		var pageArr = new Array();
		$(".pagination").children().children('a').each(function(index,element){
			var when_page = parseInt($(element).data('page'));		
			pageArr[index]= when_page;
		});
		var max=pageArr[0]
		for(var i=1;i<pageArr.length;i++){
		  if(pageArr[i]>max){
		    max=pageArr[i];
		  }
		}
		console.log(max);
		
		var last_tr = $("#mytr").children().children('tr:last').children('td:first').text();
		console.log(last_tr);
		if(page==1 && when_tr==1){
			return false;
		}
		$.ajax({
   			 type:"post",
   			 url:"/index.php/admin/dishes/moveup",
  			 data:{"sort":sort,"food_id":food_id},
  			 dataType:"json",
    		 success:function(data){
    		 	if(data.code == 1){
			    	$.ajax({
						url:"/index.php/admin/Dishes/deskInfo/page/"+page,
						type:"get",
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
	
	//数据下移
	function movedown(obj){
		var sort = $(obj).data('sort');
		var food_id = $(obj).data('food_id');
		var page = parseInt($(".current").html());
		var pageArr = new Array();
		$(".pagination").children().children('a').each(function(index,element){
			var when_page = parseInt($(element).data('page'));		
			pageArr[index]= when_page;
		});
		var max=pageArr[0]
		for(var i=1;i<pageArr.length;i++){
		  if(pageArr[i]>max){
		    max=pageArr[i];														//获取最大页数
		  }
		}
		var last_tr = $("#mytr").children().children('tr:last');				//获取最后一个tr
		var downObj = $(obj).parent();											//获取点击时的tr
		if(page == max && last_tr == downObj){									//如果当前页是最后一页且所点击的tr是最后一个tr，则中止操作
			return false;
		}
	    $.ajax({
   			 type:"post",
   			 url:"/index.php/admin/dishes/movedown",
  			 data:{"sort":sort,"food_id":food_id},
  			 dataType:"json",
    		 success:function(data){
    		 	if(data.code == 1){
			    	$.ajax({
						url:"/index.php/admin/Dishes/deskInfo/page/"+page,
						type:"get",
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
		

</script>