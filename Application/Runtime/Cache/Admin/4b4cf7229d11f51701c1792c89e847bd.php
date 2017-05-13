<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh-CN">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

	<!-- Bootstrap 核心 CSS 文件 -->
	<link rel="stylesheet" href="/Public/bootstrap/css/bootstrap.min.css">

	<!-- admin CSS 文件 -->
	<link rel="stylesheet" href="/Public/css/admin.css">
	<link rel="stylesheet" href="/Public/css/layer.css">
	<!-- HTML5 Shim 和 Respond.js 用于让 IE8 支持 HTML5元素和媒体查询 -->	
	<!--[if lt IE 9]>	
		<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
		<script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
	<![endif]-->

	<!-- jQuery文件。务必在bootstrap.min.js 之前引入 -->
	<script src="/Public/js/jquery-3.1.0.min.js"></script>
	<!-- 最新的 Bootstrap 核心 JavaScript 文件 -->
	<script src="/Public/bootstrap/js/bootstrap.min.js"></script>
	<script src="/Public/js/common.js"></script>
	<script src="/Public/js/layer.js"></script>


	<title>方雅点餐系统 | 店铺后台</title>
</head>
<!-- 菜品设置 -->
<body class="dishes">
<link rel="stylesheet" type="text/css"
      href="/Public/bootstrap-datetimepicker-master/bootstrap-datetimepicker.min.css">
<script src="/Public/bootstrap-datetimepicker-master/bootstrap-datetimepicker.min.js"></script>
<script src="/Public/bootstrap-datetimepicker-master/bootstrap-datetimepicker.zh-CN.js"></script>

    <!-- 菜品分类 start -->
    <div id="leftcategory" class="dishes-sort">
    		<div id="mytype">
        <div class="dishes-head">
            		菜品分类设置
        </div>
        <table class="dishes-sort-table">
            <?php if(is_array($data)): $i = 0; $__LIST__ = $data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><tr data-food_category_id = "<?php echo ($v["food_category_id"]); ?>">
                    <td class="text-left"><?php echo ($key+1); ?></td>
                    <td>
                        <button class="btn-none" data-sort = "<?php echo ($v["sort"]); ?>" data-food_category_id = "<?php echo ($v["food_category_id"]); ?>" onclick="moveup1(this)">
                            <img src="/Public/images/up.png">
                        </button>
                        <button class="btn-none movedown" data-sort = "<?php echo ($v["sort"]); ?>" data-food_category_id = "<?php echo ($v["food_category_id"]); ?>" onclick="movedown1(this)">
                            <img src="/Public/images/down.png" >
                        </button>
                    </td>
                    <td class="text-left">
                        <a href="javascirpt:void(0)" data-id="<?php echo ($v["food_category_id"]); ?>"
                           onclick="showinfo(this)" data-toggle="tab"><?php echo ($v['food_category_name']); ?></a>
                    </td>
                    <td class="text-right">
                        <button class="btn btn-sm" data-toggle="modal" data-target="#addSort"
                                onclick="modify1(<?php echo ($v["food_category_id"]); ?>)" id="modify">编辑
                        </button>
                      <button class="btn btn-sm"  onclick="deltype(<?php echo ($v["food_category_id"]); ?>)">删除 </button>
                    </td>
                </tr><?php endforeach; endif; else: echo "" ;endif; ?>
        </table>     
        <div class="text-right mt-30">
            <button class="btn btn-primary" data-toggle="modal" onclick="show_addSort()">增加</button>
        </div>
        </div>
    </div>
    <!-- 菜品分类 end -->

    <!-- 菜品列表 start -->
    <div class="dishes-list">
        
        <div class="tab-content">
            <!-- 所有菜品 start -->
            <div class="tab-pane fade in active" id="all">
                <table id="mytr" class="dishes-table">
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
               
            </div>
            <!-- 所有菜品 end -->
        </div>
    </div>
    <!-- 菜品列表 end -->

    <!-- 新增分类模态框（Modal） -->    
    <div class="modal fade" id="addSort" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="myform" action="javascript:void(0)" >
                    <div class="modal-header">分类信息</div>
                    <div class="modal-body">
                        <input type="hidden" name="way" id="way" />    
                        <input type="hidden" name="food_category_id" id="food_category_id" />    
                        <input type="hidden" name="restaurant_id" id="restaurant_id"/>
                        <p>
                            <span>分类名称：</span>
                            <input type="text" name="food_category_name" id="food_category_name">
                        </p>
                        <!-- <div class="upload-sortImg">
                            <div>
                                <span>图标:</span>
                            </div>
                            <div class="upload-box" id="upload-box2">
                                <img style="width: 100%;height: 100%" src="" id="edit_upload_box" alt=""></div>
                            <div>
                                <input type="file" class="btn-none ml-10" name="img_pic" onchange="preview(this)" id = "commitfile"/>    
                            </div>
                            <div>
                                <span class="ml-10">建议分辨率：300*300</span>
                            </div>
                        </div> -->
                        <p>
                            定时：
                            <input type="radio" name="is_timing" value="0" onclick="hiddentime2()" checked="checked">    
                            关闭
                            <input type="radio" name="is_timing" value="1" onclick="showtime2()">开启</p>

                        <div class="container-fluid" style="display: none;" id="show2">
                            <div>
                                <ul id="myTab" class="nav nav-tabs">
                                    <li class="active">
                                        <a href="#day" data-toggle="tab" onclick="changeType(0)">星期</a>
                                    </li>
                                    <li>
                                        <a href="#time" data-toggle="tab" onclick="changeType(1)">时段</a>
                                    </li>
                                </ul>
                                <div id="myTabContent" class="tab-content">
                                    <div class="tab-pane fade in active" id="day"></div>
                                    <div class="tab-pane fade" id="time"></div>
                                </div>
                                <button class="btn btn-sm btn-default" style="margin-top: 10px" id="add-btn" onclick="addTiming(this)" data-type="0">新增</button>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="admin-btn closecommit" data-dismiss="modal" >关闭</button>
                    <input type="reset" name="reset" style="display: none;" >    
                    <button type="button" class="admin-btn"  data-dismiss="modal" onclick="commit()">提交更改</button>
                </div>
                <!--</form>--></form>
        </div>
        <!-- /.modal-content --> </div>
    <!-- /.modal --> </div>
<script src="/Public/js/dateSelect.js"></script>
<script type="text/javascript" src="/Public/js/Dishes_index.js"></script>

</body>
</html>