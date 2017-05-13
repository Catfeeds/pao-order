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
<style>
	.redcolor{
		color: red;
	}
</style>
<link rel="stylesheet" type="text/css"
      href="/Public/bootstrap-datetimepicker-master/bootstrap-datetimepicker.min.css">
<!-- 编辑菜品信息 -->
<body>
    <input type="hidden" id="food_id" value="<?php echo ($food_id); ?>">
    <input type="hidden" id="food_category_id" value="<?php echo ($_GET['food_category_id']); ?>">  
    <input type="hidden" id="page" value="<?php echo ($_GET['page']); ?>">  
    <form action="javascript:void(0)" id="food_info">
        <div class="edit-dishes">
            <p class="edit-dishes-title">菜品基本信息：</p>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-3 col-md-4">
                        <div id="preview" class="img-preview">
                            <img src="/<?php echo ($info["food_img"]); ?>" alt=""></div>
                        <p>
                            <div class="attr-upload-btn">
                                <button class="btn" type="button">上传</button>
                                <input type="file" name="img_pic" onchange="preview(this)"/>    
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
                                            <input type="text" name="food_name" value="<?php echo ($info["food_name"]); ?>" placeholder="菜品的名称"></td>
                                    </tr>
                                    <tr>
                                        <td><span class="redcolor"> * </span>所属分类：</td>
                                        <td>
                                            <?php if(is_array($data)): $i = 0; $__LIST__ = $data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i; if($v[is_select] == 1): ?><input type="checkbox" name="sort1[]" value="<?php echo ($v["food_category_id"]); ?>" checked>    
                                                    <?php echo ($v["food_category_name"]); ?>
                                                    <?php else: ?>    
                                                    <input type="checkbox" name="sort1[]" value="<?php echo ($v["food_category_id"]); ?>"><?php echo ($v["food_category_name"]); endif; endforeach; endif; else: echo "" ;endif; ?>
                                        </td>
                                    </tr>
                                    <td><span class="redcolor"> * </span>打印机：</td>
                                    <td>
                                        <select name="print_id">
                                            <?php if($info['print_id'] == 0): ?><option value="0">暂无</option><?php endif; ?>
                                            <?php if(is_array($printerList)): $i = 0; $__LIST__ = $printerList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$prt_vo): $mod = ($i % 2 );++$i; if($prt_vo['print_type'] == 0): if($prt_vo['printer_id'] == $info['print_id']): ?><option value="<?php echo ($prt_vo["printer_id"]); ?>" selected><?php echo ($prt_vo["printer_name"]); ?></option>
                                                        <?php else: ?>
                                                        <option value="<?php echo ($prt_vo["printer_id"]); ?>"><?php echo ($prt_vo["printer_name"]); ?></option><?php endif; endif; endforeach; endif; else: echo "" ;endif; ?>
                                        </select>
                                    </td>
                                    <tr>
                                        <td>
                                            菜品分区：
                                        </td>
                                        <td>
                                            <select name="district" id="district">
                                                <?php if(is_array($district_list)): $i = 0; $__LIST__ = $district_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$district_vo): $mod = ($i % 2 );++$i; if($info['district_id'] == $district_vo['district_id']): ?><option value="<?php echo ($district_vo['district_id']); ?>" selected>
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
                                            <input type="text" name="food_price" value="<?php echo ($info["food_price"]); ?>" placeholder="菜品的价格"></td>
                                    </tr>
                                    <!--<tr>
                                        <td><span class="redcolor"> * </span>第二份起：</td>
                                        <td>
                                            <input type="text" name="discount" value="<?php echo ($info["discount"]); ?>" placeholder="菜品第二份起的价格"></td>
                                    </tr>-->
                                    <tr>
                                        <td><span class="redcolor"> * </span>每日份数：</td>
                                        <td>
                                            <input type="text" name="food_num_day" value="<?php echo ($info["foods_num_day"]); ?>"></td>
                                    </tr>
                                    <tr>
                                        <td><span class="redcolor"> * </span>推荐指数：</td>
                                        <td>
                                            <div class="star">
                                                <input type="radio" name="star_level" value="1" id="star_level1" />
                                                <span>★</span>
                                                <input type="radio" name="star_level" value="2" id="star_level2" />
                                                <span>★</span>
                                                <input type="radio" name="star_level" value="3" id="star_level3"/>
                                                <span>★</span>
                                                <input type="radio" name="star_level" value="4" id="star_level4"/>
                                                <span>★</span>
                                                <input type="radio" name="star_level" value="5" id="star_level5"/>
                                                <span>★</span>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><span class="redcolor"> * </span>辣味选择：</td>
                                        <td>
                                            <div class="cayenne">
                                            	 <?php if($info["hot_level"] == 0): ?><input type="radio" name="cayenne" value="0" checked="checked"/>                                    
                                                不辣<?php else: ?><input type="radio" name="cayenne" value="0">不辣<?php endif; ?> 
                                                <?php if($info["hot_level"] == 1): ?><input type="radio" name="cayenne" value="1" checked="checked"/>                                    
                                                微辣<?php else: ?><input type="radio" name="cayenne" value="1">微辣<?php endif; ?> 
                                                 <?php if($info["hot_level"] == 2): ?><input type="radio" name="cayenne" value="2" checked="checked"/>                                    
                                                中辣<?php else: ?><input type="radio" name="cayenne" value="2">中辣<?php endif; ?> 
                                                 <?php if($info["hot_level"] == 3): ?><input type="radio" name="cayenne" value="3" checked="checked"/>                                    
                                                大辣<?php else: ?><input type="radio" name="cayenne" value="3">大辣<?php endif; ?>    
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>描述：</td>
                                        <td>
                                            <textarea name="food_desc" cols="30" rows="4" placeholder="菜品的详细描述"><?php echo ($info["food_desc"]); ?></textarea>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-xs-6 discount">
                                <p>
                                    <span class="dishes-discount">时价</span>
                                    <input type="radio" name="is_prom" value="0">关闭
                                		<input type="radio" name="is_prom" value="1">开启
                               	<div id = "showdiscount" style="display: none;">
                                <p>
                   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;价格：
                                    <input type="text" name="prom_price" value="<?php echo ($info1["prom_price"]); ?>"></p>

<!--                                <p>
                                    第二份起：
                                    <?php if(($info1["prom_goods_num"]) == ""): ?><input type="text" name="prom_discount" value="0.00">
                                    <?php else: ?>
                                    <input type="text" name="prom_discount" value="<?php echo ($info1["discount"]); ?>"><?php endif; ?>
                                </p>-->

                                <p>
                                    每日份数：
                                    <?php if(($info1["prom_goods_num"]) == ""): ?><input type="text" name="prom_goods_num" value="99">
                                    <?php else: ?>
                                    <input type="text" name="prom_goods_num" value="<?php echo ($info1["prom_goods_num"]); ?>"><?php endif; ?>
                                </p>

                                <p>
                                    开始时间：						
                                    <?php if(($info1["prom_start_time"]) == ""): ?><input type="text" name="prom_start_time" value="<?php echo date('Y-m-d H:i:s',time())?>" id="discount_startDate">
                                    <?php else: ?>
                                    <input type="text" name="prom_start_time" value="<?php echo (date('Y-m-d H:i:s',$info1["prom_start_time"])); ?>" id="discount_startDate"><?php endif; ?>
																</p>
                                <p>
                                    结束时间：
                                <?php if(($info1["prom_end_time"]) == ""): ?><input type="text" name="prom_end_time" value="<?php echo date('Y-m-d H:i:s',time()+60*60*24)?>" id="discount_endtDate">
                                <?php else: ?>
                                <input type="text" name="prom_end_time" value="<?php echo (date('Y-m-d H:i:s',$info1["prom_end_time"])); ?>" id="discount_endtDate"><?php endif; ?>
                                </p>
                                </div>
                                <div class="text-center mt-10">
                                    <button class="admin-btn" onclick="save_food()">保存</button>
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
                            <button class="btn btn-sm btn-info" data-toggle="modal" onclick="show_food_type()">新增菜品类别</button>
                        </th>
                    </tr>
                    <?php if(is_array($attr_type_list)): $i = 0; $__LIST__ = $attr_type_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$at_vo): $mod = ($i % 2 );++$i;?><tr>
                            <td> <b><?php echo ($at_vo["type_name"]); ?></b>
                            </td>
                            <td id="attrType<?php echo ($at_vo["attribute_type_id"]); ?>">
                                <?php if(is_array($at_vo['attr_list'])): $i = 0; $__LIST__ = $at_vo['attr_list'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo2): $mod = ($i % 2 );++$i;?><button class="btn btn-sm btn-default" data-toggle="modal" data-target="#edit-attr" data-attr_id="<?php echo ($vo2["food_attribute_id"]); ?>" onclick="editAttr(this)"><?php echo ($vo2["attribute_name"]); ?></button><?php endforeach; endif; else: echo "" ;endif; ?>
                            </td>
                            <td>
                                <button class="btn btn-sm btn-info" data-toggle="modal" data-target="#edit-attr" data-type_id="<?php echo ($at_vo["attribute_type_id"]); ?>" onclick="addDishesAttr1(this)">新增属性</button>
                                <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#edit-dishes-sort" data-type_id="<?php echo ($at_vo["attribute_type_id"]); ?>" onclick="editType(this)">编辑</button>
                                <button class="btn btn-sm btn-danger" data-type_id="<?php echo ($at_vo["attribute_type_id"]); ?>" onclick="deleteType(this)">删除</button>
                            </td>
                        </tr><?php endforeach; endif; else: echo "" ;endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- 新增分类Modal -->    
    <div class="modal fade" id="add-dishes-sort" tabindex="-1" role="dialog">
        <div class="modal-dialog">
            <div class="attr-modal-content">
                <div class="attr-content">
                    <div class="modal-head">新增菜品类别</div>
                    <form action="javascript:void(0)" id="addDishesAttrType">
                        <table>
                            <tr>
                                <td>名称：</td>
                                <td>
                                    <input type="text" name="type_name" placeholder="例：饮料"></td>
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
                                    <input type="radio" name="select_type" value="0" checked>    
                                    单选
                                    <input type="radio" name="select_type" value="1" >多选</td>
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
                        <button type="button" class="btn btn-primary" onclick="addDishesAttrType(this)" data-food_id="<?php echo ($food_id); ?>">添加</button>
                        <input type="reset" name="reset" style="display: none;"/>
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
                <div class="attr-content" id="attr_content_byId"></div>
            </div>
        </div>
    </div>

    <!-- 新增修改属性Modal -->    
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
                                    <input type="text" name="attribute_name" placeholder="例:可乐"></td>
                            </tr>
                         <!--   <tr>
                                <td>属性图片：</td>
                                <td>
                                    <div class="attr-upload">
                                        <img src="/Public/images/dishes01.png" class="upload-attr-img"></div>
                                    <div class="attr-upload-btn">
                                        <button class="btn btn-info">上传</button>
                                        <input type="file" name="attribute_img" onchange="mypreview(this)"></div>
                                </td>
                            </tr>-->
                            <tr>
                                <td>属性价格：</td>
                                <td>
                                    <input type="text" name="attribute_price" value="0.00"></td>
                            </tr>
                        </table> 
		                    <div class="text-center">
		                        <button type="button" class="btn btn-danger" data-dismiss="modal">关闭</button>
		                        <button type="button" class="btn btn-primary" onclick="addDishesAttr()">增加/修改</button>
		                        <input  type="reset" id="reset" name="reset" style="display:none;"/>
		                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
<script src="/Public/bootstrap-datetimepicker-master/bootstrap-datetimepicker.min.js"></script>
<script src="/Public/bootstrap-datetimepicker-master/bootstrap-datetimepicker.zh-CN.js"></script>
<script src="/Public/js/dateSelect.js"></script>


<script type="text/javascript">
		$(function(){
			var is_prom = <?php echo ($info["is_prom"]); ?>;
			if(is_prom == 0){
				$("input[name='is_prom']:eq(0)").prop("checked",true);
			}else{
				$("input[name='is_prom']:eq(1)").prop("checked",true);
				$("#showdiscount").show();
			}
		});
		
		$("input[name='is_prom']").change(function(){
    	var value = $(this).val();
    	if(value == 1){
    		$("#showdiscount").show();
    	}else{
    		$("#showdiscount").hide();
    	}
    });	
		
   function preview(file){
        var prevDiv = document.getElementById('preview');
        if (file.files && file.files[0]) {
            var reader = new FileReader();
            reader.onload = function (evt) {
                prevDiv.innerHTML = '<img src="' + evt.target.result + '"/>';                
            }
            reader.readAsDataURL(file.files[0]);
        }
        else {
            prevDiv.innerHTML = '<div class="img"  style="filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(sizingMethod=scale,src=\'' + file.value + '\'"></div>';
        }
    }

    function select_all(obj){
        var tt = $(obj).val();
        if (tt == 0) {
            $(".menu_input").prop("checked", true);
            $(obj).val(1);
        } else if (tt == 1) {
            $(".menu_input").prop("checked", false);
            $(obj).val(0)
        }
    }

    function save_food(){
			var food_name = $("input[name='food_name']").val();
			var food_price = $("input[name='food_price']").val();
			//var discount  = $("input[name='discount']").val();
			var foods_num_day = $("input[name='food_num_day']").val();
			var sort1 = $("input:checkbox[name='sort1[]']:checked").length;
			var print_id = $("#print_id").children('option').length;
			var is_prom = $("input[name='is_prom']:checked").val();
			var prom_price = $("input[name='prom_price']").val();
			//var prom_discount = $("input[name='prom_discount']").val();
			var prom_goods_num = $("input[name='prom_goods_num']").val();
			var prom_start_time = $("input[name='prom_start_time']").val();
			var prom_end_time = $("input[name='prom_end_time']").val();
			
    	if(!(food_name && food_price && foods_num_day)){
				layer.msg("星号项不能为空");
			}else if(!sort1 > 0){
				layer.msg("没有选择菜品分类");
			}else if(print_id==0){
				layer.msg("没有打印机，请选对接打印机!");
			}else{
				if(is_prom != 0){
					if(!(prom_price && prom_goods_num && prom_start_time && prom_end_time)){
						layer.msg("星号项不能为空");
						return false;
					}
				}
				var formData = new FormData($("#food_info")[0]);
        $.ajax({
            url: "/index.php/Admin/Dishes/modifyfoodinfo/food_id/<?php echo ($food_id); ?>",
            type: "post",
            data: formData,
            async: false,
            cache: false,
            contentType: false,
            processData: false,
            dataType: "json",
            success: function (data){
                $("#type_form").data('id', data.food_id);
                var msg = confirm('菜品新增成功，要继续添加菜品类别及属性？');
                if(msg != true){
                		var food_category_id = $("#food_category_id").val();
                		var page = $("#page").val();
    								console.log(food_category_id);	
                		if(food_category_id != 0){							//菜品记录的编辑
                				location.href = '/index.php/admin/Dishes/index/';
                		}else{
                				location.href = '/index.php/admin/Dishes/index/page/'+page;
                		}
                }  
            },
            /*error: function () {
                alert("出错了");
            }*/
        });
			}   
    }

    function mypreview(file){
        var prevDiv = $(file).parent().prev();
        console.log();
        prevDiv = prevDiv[0];
        console.log(prevDiv);
        if (file.files && file.files[0]) {
            var reader = new FileReader();
            reader.onload = function (evt) {
                prevDiv.innerHTML = "";
                prevDiv.innerHTML = '<img src="' + evt.target.result + '" class="pre100 center-block" style="width:100%;height:100%;" />';
            }
            reader.readAsDataURL(file.files[0]);
        }
        else {
            prevDiv.innerHTML = "";
            prevDiv.innerHTML = '<div style="width:100%;height:100%;" class="img" style="filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(sizingMethod=scale,src=\'' + file.value + '\'"></div>';
        }
    }
		
		//新增菜品类别的模态框
		function show_food_type(){
			$("#add-dishes-sort").modal('show');
			$("input[type='reset']").trigger('click');
		}
		
    function addDishesAttrType(obj){
        $("#add-dishes-sort").modal("hide");
        var form = $("#addDishesAttrType")[0];
        var formData = new FormData(form);
        var food_id = $(obj).data("food_id");
        formData.append("food_id",food_id);
        $.ajax({
            url:'/index.php/admin/dishes/addDishesAttrType',
            data:formData,
            type:"post",
            dataType:'json',
            contentType:false,
            processData:false,
            cache:false,
            success:function(msg){
                console.log(msg);
                if(msg.code == 1){
                    console.log("操作成功");
                    var data = msg.data;
                    var str = '<tr><td> <b>'+data['type_name']+'</b>'
                            +'</td>'
                            +'<td id="attrType'+data["attribute_type_id"]+'">'
                            +'</td>'
                            +'<td>'
                            +'<button class="btn btn-sm btn-info" data-toggle="modal" data-target="#edit-attr" data-type_id="'+data["attribute_type_id"]+'"onclick="addDishesAttr1(this)">新增属性</button> '
                            +'<button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#edit-dishes-sort" data-type_id="'+data["attribute_type_id"]+'" onclick="editType(this)">编辑</button> '
                            +'<button class="btn btn-sm btn-danger" data-type_id="'+data["attribute_type_id"]+'" onclick="deleteType(this)">删除</button>'
                            +'</td>'
                            +'</tr>';
                    $("#dishesAttrList").append(str);
                }
            },
            error:function(){
                console.log("访问出错了");
            }
        });
    }

    function editAttr(obj){
        var food_attribute_id = $(obj).data("attr_id");
        $("#food_attribute_id").val(food_attribute_id);
        $("#type").val("edit");
        $.ajax({
        	type:"get",
        	url:"/index.php/admin/dishes/getDishesAttr/food_attribute_id/"+food_attribute_id+"",
        	async:true,
        	success:function(data){
        		$("input[name='attribute_name']").val(data.attribute_name);    		
        		$("input[name='attribute_price']").val(data.attribute_price);
        		$("input[name='food_attribute_id']").val(data.food_attribute_id);
        	}
        });
    }


    function addDishesAttr1(obj){
        var attribute_type_id = $(obj).data("type_id");
        console.log("类别id:"+attribute_type_id);
        $("#attribute_type_id").val(attribute_type_id);
        $("#type").val("add");
        $("input[type='reset']").trigger('click');
    }

    function addDishesAttr(obj){
        $("#edit-attr").modal("hide");
        var type = $("#type").val();
        var form = $("#add_attr")[0];
        var formData = new FormData(form);
        var url;
//        console.log(url);
        if(type == "add"){
            url = '/index.php/admin/dishes/addDishesAttr';
            $.ajax({
                url:url,
                type:'post',
                data:formData,
                dataType:'json',
                contentType:false,
                processData:false,
                cache:false,
                async:false,
                success:function(msg){
                    console.log(msg);
                    if(msg.code == 1){
                        var data = msg.data;
                        var str = '<button class="btn btn-sm btn-default" data-toggle="modal" data-target="#edit-attr" data-attr_id="'+data['food_attribute_id']+'" onclick="editAttr(this)">'+data['attribute_name']+'</button>';
                        $("#attrType"+data['attribute_type_id']).append(str);
                    }
                },
                error:function(){
                    console.log("访问出错了");
                }
            });
        }else if(type == "edit"){
            var food_id = $("#food_id").val();
            url = '/index.php/admin/dishes/editDishesAttr';
            $.ajax({
                url:url,
                type:'post',
                data:formData,
                dataType:'json',
                contentType:false,
                processData:false,
                cache:false,
                async:false,
                success:function(msg){
                    console.log(msg);
                    if(msg.code == 1){
                        self.location.href = "/index.php/admin/Dishes/edit/food_id/"+food_id;
                    }
                },
                error:function(){
                    console.log("访问出错了");
                }
            });
        }

    }

    function editType(obj){
        var type_id = $(obj).data('type_id');
        $.ajax({
            url:"/index.php/admin/Dishes/getTypeAttrs",
            type:"post",
            data:{"type_id":type_id},
//            dataType:"json",
            success:function(data){
                $("#attr_content_byId").html(data);
            },
            error:function(){
                console.log("访问出错");
            }
        });
    }

    function editDishesType(){
        var food_id = $("#food_id").val();
        var form = $("#editDishesType")[0];
        var formData = new FormData(form);
        formData.append("food_id",food_id);
        $.ajax({
            url:"/index.php/admin/dishes/editDishesType",
            type:"post",
            data:formData,
            dataType:"json",
            contentType:false,
            processData:false,
            cache:false,
            success:function(msg){
                if(msg.code == 1){
                    self.location.href = "/index.php/admin/Dishes/edit/food_id/"+food_id;
                }
            },
            error:function(){
                console.log("访问出错");
            }
        });
    }

    function deleteAttr(obj){
        var attr_id = $(obj).data("attr_id");
        $.ajax({
            url:"/index.php/admin/dishes/deleteAttr",
            data:{"attr_id":attr_id},
            type:"post",
            dataType:"json",
            success:function(msg){
                if(msg.code == 1){
                    $(obj).parent().remove();
                }
            },
            error:function(){
                console.log();
            }
        });
    }

    function deleteType(obj){
        var type_id = $(obj).data("type_id");
        $.ajax({
            url:"/index.php/admin/dishes/deleteType",
            data:{"type_id":type_id},
            type:"post",
            dataType:"json",
            success:function(msg){
                if(msg.code == 1){
                    $(obj).parent().parent().remove();
                }
            },
            error:function(){
                console.log();
            }
        });
    }
    
    var level_num=<?php echo ($info["star_level"]); ?>;
    var level_id=($('#star_level'+level_num));
    if(level_id.val()==level_num){
        $('#star_level0').removeAttr('checked');
        console.log(level_num);
        level_id.attr('checked','checked');
    }
</script>
</html>