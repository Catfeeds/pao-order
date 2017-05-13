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
<link rel="stylesheet" type="text/css" href="/Public/bootstrap-datetimepicker-master/bootstrap-datetimepicker.min.css">
<script src="/Public/bootstrap-datetimepicker-master/bootstrap-datetimepicker.min.js"></script>
<script src="/Public/bootstrap-datetimepicker-master/bootstrap-datetimepicker.zh-CN.js"></script>
<style>
	.redcolor{
		color: red;
	}
</style>

<!-- 编辑菜品信息 -->
<body>
<form action="javascript:void(0)" id="food_info">
    <div class="edit-dishes">
        <p class="edit-dishes-title">菜品基本信息：</p>
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-3 col-md-4">
                    <div id="preview" class="img-preview">
                    </div>
                    <p>
                        <div class="attr-upload-btn">
                            <button class="btn" type="button">上传</button>
                            <input type="file" name="food_pic" onchange="preview(this)"/>
                        </div>
                        <p class="edit-dishes-tips">建议分辨率：500*300</p>
                    </p>
                </div>
                <div class="col-sm-9 col-md-8">
                    <div class="row">
                        <div class="col-xs-6">
                            <table>
                                <tr>
                                    <td><span class="redcolor"> * </span>菜品名称：</td>
                                    <td>
                                        <input type="text" name="food_name" placeholder="菜品的名称"></td>
                                </tr>
                                <tr>
                                    <td><span class="redcolor"> * </span>所属分类：</td>
                                    <td>
                                        <?php if(is_array($data)): $i = 0; $__LIST__ = $data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><input class="menu_input" type="checkbox" name="sort1[]" value="<?php echo ($v["food_category_id"]); ?>"><?php echo ($v["food_category_name"]); endforeach; endif; else: echo "" ;endif; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td><span class="redcolor"> * </span>打印机：</td>
                                    <td>
                                        <select name="print_id">
                                            <?php if(is_array($printerList)): $i = 0; $__LIST__ = $printerList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$prt_vo): $mod = ($i % 2 );++$i; if($prt_vo['print_type'] == 0): ?><option value="<?php echo ($prt_vo["printer_id"]); ?>"><?php echo ($prt_vo["printer_name"]); ?></option><?php endif; endforeach; endif; else: echo "" ;endif; ?>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        菜品分区：
                                    </td>
                                    <td>
                                        <select name="district" id="district">
                                            <?php if(is_array($district_list)): $i = 0; $__LIST__ = $district_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$district_vo): $mod = ($i % 2 );++$i; if($district_vo['district_id'] == 0): ?><option value="<?php echo ($district_vo['district_id']); ?>" selected>
                                                        <?php echo ($district_vo["district_name"]); ?>
                                                    </option>
                                                    <?php else: ?>
                                                    <option value="<?php echo ($district_vo['district_id']); ?>">
                                                        <?php echo ($district_vo["district_name"]); ?>
                                                    </option><?php endif; endforeach; endif; else: echo "" ;endif; ?>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td><span class="redcolor"> * </span>价格：</td>
                                    <td>
                                        <input type="text" name="food_price" placeholder="菜品的价格"></td>
                                </tr>
<!--                                <tr>
                                    <td><span class="redcolor"> * </span>第二份起：</td>
                                    <td>
                                        <input type="text" name="discount" value="0.00" placeholder="菜品第二份起的价格"></td>
                                </tr>-->
                                <tr>
                                    <td><span class="redcolor"> * </span>每日份数：</td>
                                    <td>
                                        <input type="text" name="foods_num_day" value="10000"></td>
                                </tr>
                                <tr>
                                    <td><span class="redcolor"> * </span>推荐指数：</td>
                                    <td>
                                        <div class="star">
                                            <input type="radio" name="star_level" value="1"/>
                                            <span>★</span>
                                            <input type="radio" name="star_level" value="2"/>
                                            <span>★</span>
                                            <input type="radio" name="star_level" value="3"/>
                                            <span>★</span>
                                            <input type="radio" name="star_level" value="4"/>
                                            <span>★</span>
                                            <input type="radio" name="star_level" value="5" checked="checked"/>
                                            <span>★</span>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td><span class="redcolor"> * </span>辣味选择：</td>
                                    <td>
                                        <div class="cayenne">
                                            <input type="radio" name="cayenne" value="0" checked="checked"/>不辣
                                            <input type="radio" name="cayenne" value="1"/>微辣
                                            <input type="radio" name="cayenne" value="2"/>中辣
                                            <input type="radio" name="cayenne" value="3"/>大辣
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>描述：</td>
                                    <td>
                                        <textarea name="food_desc" cols="30" rows="4" placeholder="菜品的描述"></textarea>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-xs-6 discount">
                            <p>
                                <span class="dishes-discount">时价</span>
                                <input type="radio" name="is_prom" value="0" checked="checked">关闭
                                <input type="radio" name="is_prom" value="1">开启
                                
                            </p>
                            <div id = "showdiscount" style="display: none;">
                            <p>
         &nbsp;&nbsp;&nbsp;&nbsp;<span class="redcolor"> * </span>价格：
                                <input type="text" name="prom_price"></p>

 <!--                           <p>
                              <span class="redcolor"> * </span> 第二份起：
                                <input type="text" name="prom_discount" value="0.00">
                            </p>-->

                            <p>
                               <span class="redcolor"> * </span> 每日份数：
                                <input type="text" name="prom_goods_num" value="99"></p>

                            <p>
                               <span class="redcolor"> * </span> 开始时间：
                                <input type="text" name="prom_start_time" id="discount_startDate" value="<?php echo date('Y-m-d H:i:s',time()) ?>"></p>

                            <p>
                               <span class="redcolor"> * </span> 结束时间：
                                <input type="text" name="prom_end_time" id="discount_endtDate" value="<?php echo date('Y-m-d H:i:s',time()+60*60*24) ?>"></p>
                            </div>
                            <div class="mt-10 text-center">
                                <button class="admin-btn" id="save_food">保存</button>
                                <input type="hidden" name="save_status" id="save_status">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

    <div class="edit-dishes-attr">
        <p class="edit-dishes-title">菜品类别与属性：</p>
        <div class="container-fluid">
            <table class="pre100 table-condensed mt-10">
                <tbody id="dishesAttrList">
                    <tr>
                        <th>类别</th>
                        <th>属性</th>
                        <th class="text-right">
                            <button class="btn btn-sm btn-info" data-toggle="modal" onclick="add_food_type()">新增菜品类别</button>
                        </th>
                    </tr>

                </tbody>
            </table>
        </div>
    </div>

    <!-- 新增分类Modal -->
    <div class="modal fade" id="add-dishes-sort" tabindex="-1" role="dialog">
        <div class="modal-dialog">
            <div class="attr-modal-content">
                <div class="attr-content">
                    <form action="javascript:void(0)" id="addDishesAttrType">
                        <input type="hidden" name="food_id" id="type_form">
                        <div class="modal-head">新增菜品类别</div>
                        <table>
                            <tr>
                                <td>名称：</td>
                                <td>
                                    <input type="text" name="type_name" placeholder="例：饮料">
                                </td>
                            </tr>
                            <tr>
                                <td>打印机：</td>
                                <td>
                                    <select name="print_id" id="print_id">
                                        <?php if(is_array($printerList)): $i = 0; $__LIST__ = $printerList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$prt_vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($prt_vo["printer_id"]); ?>"><?php echo ($prt_vo["printer_name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>类型：</td>
                                <td>
                                    <input type="radio" name="select_type" value="0" checked>单选
                                    <input type="radio" name="select_type" value="1">多选
                                </td>
                            </tr>
							<tr>
                                <td>统计：</td>
                                <td>
                                    <input type="radio" name="count_type" value="0" checked>否
                                    <input type="radio" name="count_type" value="1">是
                                    <span style="color: red;">(是否列入数据统计)</span>
                                </td>
                            </tr>
                        </table>     
                    <div class="text-center">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">关闭</button>
                        <button type="button" class="btn btn-primary" onclick="addDishesAttrType()">添加</button>
                        <input  type="reset" name="reset1" id="reset1" style="display:none;"/>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<!-- 新增修改分类Modal -->
<div class="modal fade" id="edit-dishes-sort" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="attr-modal-content">
            <div class="attr-content" id="attr_content_byId">

            </div>
        </div>
    </div>
</div>

<!-- 编辑属性Modal -->
<div class="modal fade" id="edit-attr" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="attr-modal-content">
            <div class="attr-content">
                <div class="modal-head">属性操作</div>
                <form action="javascript:void(0)" id="add_attr">
                    <input type="hidden" name="attribute_type_id" id="attribute_type_id">
                    <input type="hidden" name="food_attribute_id" id="food_attribute_id">
                    <input type="hidden" name="type" id="type" value="add">
                    <table>
                        <tr>
                            <td>属性名：</td>
                            <td>
                                <input type="text" name="attribute_name" placeholder="例：可乐">
                            </td>
                        </tr>
                      <!--  <tr>
                            <td>属性图片：</td>
                            <td>
                                <div class="attr-upload">
                                    <img src="/Public/images/dishes01.png" class="upload-attr-img" id="attrimg">
                                </div>
                                <div class="attr-upload-btn">
                                    <button class="btn btn-info">上传</button>
                                    <input type="file" name="attribute_img" onchange="mypreview(this)">
                                </div>
                            </td>
                        </tr>-->
                        <tr>
                            <td>叠加：</td>
                            <td>
                                <input type="text" name="attribute_price" value="0.00">
                            </td>
                        </tr>
                    </table>
                <div class="text-center">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">关闭</button>
                    <button type="button" class="btn btn-primary" onclick="addDishesAttr()">增加/修改</button>
                    <input  type="reset" id="reset2" name="reset2" style="display:none;"/>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="/Public/js/dateSelect.js"></script>
<script src="/Public/js/addDishes.js"></script>
<script>
	$("#save_food").click(function(){
		var img_src = $("input[name='food_pic']").val();
		var food_name = $("input[name='food_name']").val();
		var food_price = $("input[name='food_price']").val();
		//var discount  = $("input[name='discount']").val();
		var foods_num_day = $("input[name='foods_num_day']").val();
		var sort1 = $("input:checkbox[name='sort1[]']:checked").length;
		var print_id = $("#print_id").children('option').length;
		var save_status = $("#save_status").val();
		var is_prom = $("input[name='is_prom']:checked").val();
		var prom_price = $("input[name='prom_price']").val();
		//var prom_discount = $("input[name='prom_discount']").val();
		var prom_goods_num = $("input[name='prom_goods_num']").val();
		var prom_start_time = $("input[name='prom_start_time']").val();
		var prom_end_time = $("input[name='prom_end_time']").val();
		console.log(prom_start_time);
		if(save_status != 1){
			if(is_prom != 0){
				if(!(prom_price && prom_goods_num && prom_start_time && prom_end_time)){
					layer.msg("星号项不能为空");
					return false;
				}
			}
			if(!(food_name && food_price && foods_num_day)){
				layer.msg("星号项不能为空");
			}else if(!img_src){
				layer.msg("没有上传菜品图片");
			}else if(!sort1 > 0){
				layer.msg("没有选择菜品分类");
			}else if(print_id==0){
				layer.msg("没有打印机，请选对接打印机!");
			}else{
				var formData = new FormData($("#food_info")[0]);
		        $.ajax({
		            url:"/index.php/admin/dishes/createfoodinfo",
		            type:"post",
		            data:formData,
		            async: false,
		            cache: false,
		            contentType: false,
		            processData: false,
		            dataType:"json",
		            success:function(data){
		            	$("#save_status").val(1);
		                $("#type_form").data('id',data.food_id);
		                var msg = confirm('菜品新增成功，要继续添加菜品类别及属性？');
		                if(msg != true){			
		                		location.href = '/index.php/admin/Dishes/index/page/'+data.page_Num;
		            	}   
		            }
		        });
			}
		}else{
			layer.msg("菜品已添加！");
		}
	});

	
</script>
</body>
</html>