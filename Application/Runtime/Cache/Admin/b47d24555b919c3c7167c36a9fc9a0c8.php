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
<!-- 商家信息 -->
<body>
<div class="container-fluid">
    <div class="row">
        <div class="col-xs-3 receipt-left">
            <section class="receipt">
                <input style="display: none" id="restaurant_id" name="restaurant_id" value="<?php echo ($restaurant_id); ?>" type="hidden" >
                <h4 class="text-center" id="restaurant_name"><?php echo ($restaurant["restaurant_name"]); ?></h4>
                <span>时间：2016-09-20-12:30:20</span><br>
                <span>订单号：20160920-000001</span><br>

                <div class="receipt-content">

                    <table class="pre100">
                        <thead>
                        <tr class="text-center">
                            <td class="text-left">菜名</td>
                            <td class="">份</td>
                            <td class="text-right">小计</td>
                        </tr>
                        </thead>
                        <tfoot>
                        <tr class="text-right">
                            <td colspan="3">总计：&yen;36.00</td>
                        </tr>
                        </tfoot>
                        <tbody class="receipt-table-content">
                        <tr>
                            <td>牛肉面</td>
                            <td class="text-center">1</td>
                            <td class="text-right">&yen;12.00</td>
                        </tr>
                        <tr>
                            <td>牛肉面</td>
                            <td class="text-center">2</td>
                            <td class="text-right">&yen;24.00</td>
                        </tr>
                        </tbody>
                    </table>
                    <div class="text-right" style="border-bottom: 1px dashed black" ><b>支付类型：微信</b></div>
                    <div class="text-center" style="border-bottom: 1px dashed black;font-size: 15px" id="order_type" ><b>订单类型：堂吃</b></div>
                    <div class="take-number text-center" id="take_num"><?php echo ($restaurant["take_num"]); ?>:888</div>
                    <div class="text-center" id="pay_prompt" style="border-bottom: 1px dashed black"><b><?php echo ($restaurant["pay_prompt"]); ?></b></div>
                    <div class="take-number text-center" id="pay_num"><?php echo ($restaurant["pay_num"]); ?>:888</div>
                    <div class="text-center" id="pay_prompt2" style="border-bottom: 1px dashed black"><b><?php echo ($restaurant["pay_prompt2"]); ?></b></div>
                    <div class="take-number text-center" id="desk_num"><?php echo ($restaurant["desk_num"]); ?>:666</div>
                    <div class="text-center" id="forward_prompt"><b><?php echo ($restaurant["forward_prompt"]); ?></b></div>
                </div>
                <!--<div></div>-->
                <?php if($restaurant_bill["address"] == 1): ?><p id="address">地址:<?php echo ($restaurant["address"]); ?></p><?php endif; ?>
                <p id="restaurant_phone">电话:<?php echo ($restaurant["telephone1"]); ?></p>
                <p id="take_out_phone">外卖电话:<?php echo ($restaurant["telephone2"]); ?></p>
                <p id="subscription">公众号点餐:<?php echo ($restaurant["subscription"]); ?></p>
                <div class="text-center" id="down_prompt"><b><?php echo ($restaurant["down_prompt"]); ?></b></div>
            </section>
            <p class="mt-10">送餐地址:陈远银,13711151026,广州市番禺区大石镇,南大路鸿图工业园A6栋</p>
        </div>
        <div class="col-xs-9 receipt-right container-fluid">
            <form action="javascript:void(0)" id="restaurant_form2">
                <table> 
                    <tr>
                        <td>餐厅名称:</td>
                        <td>
                            <?php if($restaurant_bill["restaurant_name"] == 1): ?><label><input type="radio" name="name" value="1" checked onchange="is_open('restaurant_name',this)">
                                    开启</label>
                                <label><input type="radio" name="name" value="0" onchange="is_open('restaurant_name',this)">
                                    关闭</label>
                                <?php else: ?>
                                <label><input type="radio" name="name" value="1" onchange="is_open('restaurant_name',this)">
                                    开启</label>
                                <label><input type="radio" name="name" value="0" checked onchange="is_open('restaurant_name',this)">
                                    关闭</label><?php endif; ?>                            
                        </td>
                        <td>
                            <input type="text" name="restaurant_name" value="<?php echo ($restaurant["restaurant_name"]); ?>">
                        </td>
                    </tr>
                    <tr>
                        <td>取餐号:</td>
                        <td>
                            <?php if($restaurant_bill["take_num"] == 1): ?><label><input type="radio" name="take_num" value="1"  checked onchange="is_open('take_num',this)">
                                    开启</label>
                                <label><input type="radio" name="take_num" value="0" onchange="is_open('take_num',this)">
                                    关闭</label>
                                <?php else: ?>
                                <label><input type="radio" name="take_num" value="1" onchange="is_open('take_num',this)" >
                                    开启</label>
                                <label><input type="radio" name="take_num" value="0" onchange="is_open('take_num',this)" checked>
                                    关闭</label><?php endif; ?>
                        </td>
                        <td>
                            <input type="text" name="take_num" value="<?php echo ($restaurant["take_num"]); ?>" placeholder="标题名称，例：取餐号">
                            <span>注：取餐流程关闭餐牌号时，建议开启</span>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td class="text-right">
                            <span>提示语：</span>                            
                        </td>
                        <td>
                            <input type="text" name="pay_prompt" value="<?php echo ($restaurant["pay_prompt"]); ?>" class="input-lager">
                        </td>
                    </tr>
                    <tr>
                        <td>餐牌号：</td>
                        <td>
                            <?php if($restaurant_bill["qrcode"] == 1): ?><label><input type="radio" name="take" value="1" checked onchange="is_open('qrcode',this)">
                                    开启</label>
                                <label><input type="radio" name="take" value="0" onchange="is_open('qrcode',this)">
                                    关闭</label>
                                <?php else: ?>
                                <label><input type="radio" name="take" value="1" onchange="is_open('qrcode',this)" >
                                    开启</label>
                                <label><input type="radio" name="take" value="0" checked onchange="is_open('qrcode',this)">
                                    关闭</label><?php endif; ?>
                        </td>
                        <td>
                            <input type="text" name="desk_num" value="<?php echo ($restaurant["desk_num"]); ?>" placeholder="标题名称，例：餐桌号">
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td class="text-right">提示语:</td>
                        <td>
                            <input type="text" name="forward_prompt" value="<?php echo ($restaurant["forward_prompt"]); ?>">
                            <span>注：点餐流程，开启餐牌号时，必须开启</span>
                        </td>   
                    </tr>
                    <tr>
                        <td>支付号:</td>
                        <td>
                            <?php if($restaurant_bill["pay_num"] == 1): ?><label><input type="radio" name="pay_num" value="1"  checked onchange="is_open('pay_num',this)">
                                    开启</label>
                                <label><input type="radio" name="pay_num" value="0" onchange="is_open('pay_num',this)">
                                    关闭</label>
                                <?php else: ?>
                                <label><input type="radio" name="pay_num" value="1" onchange="is_open('pay_num',this)" >
                                    开启</label>
                                <label><input type="radio" name="pay_num" value="0" onchange="is_open('pay_num',this)" checked>
                                    关闭</label><?php endif; ?>
                        </td>
                        <td>
                            <input type="text" name="pay_num" value="<?php echo ($restaurant["pay_num"]); ?>" placeholder="标题名称，例：支付号">
                            <span>注：支付对接》开启现金支付时，建议开启</span>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td class="text-right">提示语：</td>
                        <td>
                            <input type="text" name="pay_prompt2" value="<?php echo ($restaurant["pay_prompt2"]); ?>">
                        </td>
                    </tr>
                    <tr>
                        <td>订单类型:</td>
                        <td>
                            <?php if($restaurant_bill["order_type"] == 1): ?><label><input type="radio" name="order_type" value="1" onchange="is_open('order_type',this)" checked>
                                    开启</label>
                                <label><input type="radio" name="order_type" value="0" onchange="is_open('order_type',this)">
                                    关闭</label>
                                <?php else: ?>
                                <label><input type="radio" name="order_type" value="1" onchange="is_open('order_type',this)" >
                                    开启</label>
                                <label><input type="radio" name="order_type" value="0" onchange="is_open('order_type',this)" checked>
                                    关闭</label><?php endif; ?>
                        </td>
                        <td>
                            <span style="margin-left:200px;">注：点餐流程，开启堂吃/打包时，必须开启。</span>
                        </td>
                    </tr>
                    <tr>
                        <td>地址:</td>
                        <td>
                            <?php if($restaurant_bill["address"] == 1): ?><label><input type="radio" name="address" value="1" onchange="is_open('address',this)" checked>
                                    开启</label>
                                <label><input type="radio" name="address" value="0" onchange="is_open('address',this)">
                                    关闭</label>
                                <?php else: ?>
                                <label><input type="radio" name="address" value="1" onchange="is_open('address',this)" >
                                    开启</label>
                                <label><input type="radio" name="address" value="0" onchange="is_open('address',this)" checked>
                                    关闭</label><?php endif; ?>
                        </td>
                        <td>
                            <input type="text" name="address" value="<?php echo ($restaurant["address"]); ?>">
                        </td>
                    </tr>
                    <tr>
                        <td>电话:</td>
                        <td>
                            <?php if($restaurant_bill["restaurant_phone"] == 1): ?><label><input type="radio" name="restaurant_phone" value="1" onchange="is_open('restaurant_phone',this)" checked>
                                    开启</label>
                                <label><input type="radio" name="restaurant_phone" value="0" onchange="is_open('restaurant_phone',this)">
                                    关闭</label>
                                <?php else: ?>
                                <label><input type="radio" name="restaurant_phone" value="1" onchange="is_open('restaurant_phone',this)" >
                                    开启</label>
                                <label><input type="radio" name="restaurant_phone" value="0" onchange="is_open('restaurant_phone',this)" checked>
                                    关闭</label><?php endif; ?>
                        </td>
                        <td>
                            <input type="text" name="telephone1" value="<?php echo ($restaurant["telephone1"]); ?>">
                        </td>
                    </tr>
                    <tr>
                        <td>外卖电话:</td>
                        <td>
                            <?php if($restaurant_bill["take_out_phone"] == 1): ?><label><input type="radio" name="take_out_phone" value="1" onchange="is_open('take_out_phone',this)" checked>
                                    开启</label>
                                <label><input type="radio" name="take_out_phone" value="0"  onchange="is_open('take_out_phone',this)">
                                    关闭</label>
                                <?php else: ?>
                                <label><input type="radio" name="take_out_phone" value="1" onchange="is_open('take_out_phone',this)">
                                    开启</label>
                                <label><input type="radio" name="take_out_phone" value="0" onchange="is_open('take_out_phone',this)" checked>关闭</label><?php endif; ?>
                        </td>
                        <td>
                            <input type="text" name="telephone2" value="<?php echo ($restaurant["telephone2"]); ?>">
                        </td>
                    </tr>
                    <tr>
                        <td>公众号:</td>
                        <td>
                            <?php if($restaurant_bill["subscription"] == 1): ?><label><input type="radio" name="subscription" value="1" checked onchange="is_open('subscription',this)">
                                    开启</label>
                                <label><input type="radio" name="subscription" value="0" onchange="is_open('subscription',this)">
                                    关闭</label>
                                <?php else: ?>
                                <label><input type="radio" name="subscription" value="1"  onchange="is_open('subscription',this)">
                                    开启</label>
                                <label><input type="radio" name="subscription" value="0" checked onchange="is_open('subscription',this)">
                                    关闭</label><?php endif; ?>
                        </td>
                        <td>
                            <input type="text" name="subscription" value="<?php echo ($restaurant["subscription"]); ?>">
                        </td>
                    </tr>
                    <tr>
                        <td>底部广告语:</td>
                        <td>
                            <?php if($restaurant_bill["down_prompt"] == 1): ?><label><input type="radio" name="down_prompt" value="1" onchange="is_open('down_prompt',this)" checked>
                                    开启</label>
                                <label><input type="radio" name="down_prompt" value="0" onchange="is_open('down_prompt',this)">
                                    关闭</label>
                                <?php else: ?>
                                <label><input type="radio" name="down_prompt" value="1" onchange="is_open('down_prompt',this)" >
                                    开启</label>
                                <label><input type="radio" name="down_prompt" value="0" onchange="is_open('down_prompt',this)" checked>
                                    关闭</label><?php endif; ?>
                        </td>
                        <td>
                            <input type="text" name="down_prompt" value="<?php echo ($restaurant["down_prompt"]); ?>">
                        </td>
                    </tr>
                </table>
                <p class="mt-30">
                    <button class="admin-btn" onclick="submit_form()">保存</button>
                </p>
                <input type="hidden" value="<?php echo ($restaurant["restaurant_id"]); ?>" name="restaurant_id">
            </form>
        </div>           
    </div>
</div>
</body>
<script>
    function is_open(name,obj) {
        var id = "#" + name;
        var status = $(obj).val();
//        console.log(status);
        var restaurant_id = $("#restaurant_id").val();
        $.ajax({
            url:"/index.php/admin/restaurant/changeBillStatus",
            data:{"name":name,"status":status,"restaurant_id":restaurant_id},
            type:'post',
            dataType:"json",
            success:function(msg){
                if(msg.code == 1){
                    if(status == 1){
                        if(name == "take_num"){
                            $("#pay_prompt").show();
                        }
                        if(name == "pay_num"){
                            $("#pay_prompt2").show();
                        }
                        if(name == "qrcode"){

                            $("#forward_prompt").show();
                            $("#desk_num").show();
                        }
                        $(id).show();
                    }else{
                        if(name == "take_num"){
                            $("#pay_prompt").hide();
                        }
                        if(name == "pay_num"){
                            $("#pay_prompt2").hide();
                        }
                        if(name == "qrcode"){
                            $("#forward_prompt").hide();
                            $("#desk_num").hide();
                        }
                        $(id).hide();
                    }
                }else{
                    alert(msg.msg);
                }
            },
            error:function(){
                alert("出错了");
            }
        });
    }

    function submit_form() {
        var form = $("#restaurant_form2")[0];
        var formData = new FormData(form);
        $.ajax({
            url: "/index.php/admin/restaurant/receipt",
            data: formData,
            dataType: 'json',
            type: 'post',
//			async: false,
            cache: false,
            contentType: false,
            processData: false,
            success: function (msg) {
                if (msg.code == 1) {
                    alert("成功");
                    self.location.href = "/index.php/admin/restaurant/receipt";
                } else {
                    alert("失败");
                }
            },
            error: function () {
                alert("网络出错了");
            }
        });
    }

    $(function(){
        var restaurant_id = $("#restaurant_id").val();
        console.log(restaurant_id);
        $.ajax({
            url:"/index.php/admin/restaurant/getBillStatus",
            data:{"restaurant_id":restaurant_id},
            type:'post',
            dataType:"json",
            success:function(msg){
                $.each(msg,function(k,v){
                    console.log(k);
                    console.log(v);
                    if(v == 0){
                        if(k == "take_num"){
                            $("#pay_prompt").hide();
                        }
                        if(k == "pay_num"){
                            $("#pay_prompt2").hide();
                        }
                        if(k == "qrcode"){
                            $("#desk_num").hide();
                            $("#forward_prompt").hide();
                        }
                        $("#"+k).hide();
                    }
                });
            },
            error:function(){
                alert("出错了");
            }
        });
    });
</script>
</html>