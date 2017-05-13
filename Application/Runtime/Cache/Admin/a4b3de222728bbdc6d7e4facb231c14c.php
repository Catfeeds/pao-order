<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title></title>
</head>
<body>
    <div class="sale-table-content">
        <table class="sale-table">
            <tbody>
                <tr class="text-center">
                    <td></td>
                    <td>订单号</td>
                    <td>日期时间</td>
                    <td>就餐方式</td>
                    <td>支付方式</td>
                    <td>总价</td>
                </tr>
                <?php if(is_array($orderInfo)): $k = 0; $__LIST__ = $orderInfo;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($k % 2 );++$k;?><tr>
                        <td>
                            <?php echo ($k); ?>
                            <a class="btn" onclick="open_close(<?php echo ($k); ?>)">+</a>
                        </td>
                        <td><?php echo ($vo["order_sn"]); ?></td>
                        <td><?php echo ($vo["pay_time"]); ?></td>
                        <td>
                            <?php if($vo["order_type"] == 1): ?>堂吃
                                <?php else: ?>        
                                外带<?php endif; ?>
                        </td>
                        <td class="text-center">
                            <?php if($vo["pay_type"] == 2): ?>微信
                                <?php elseif($vo["pay_type"] == 1): ?>        
                                支付宝
                                <?php elseif($vo["pay_type"] == 4): ?>
                                余额
                                <?php else: ?>        
                                现金<?php endif; ?>
                        </td>
                        <td><?php echo ($vo["total_amount"]); ?></td>
                    </tr>
                    <tr>
                        <td colspan="6">
                            <table class="sale-table" id="order_food<?php echo ($k); ?>" data-value="0" style="display: none;">
                                <?php if(is_array($vo["food_info"])): $i = 0; $__LIST__ = $vo["food_info"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo2): $mod = ($i % 2 );++$i;?><tr>
                                        <td></td>
                                        <td></td>
                                        <td><?php echo ($vo2["food_name"]); ?></td>
                                        <td></td>
                                        <td><?php echo ($vo2["food_num"]); ?></td>
                                        <td></td>
                                        <td></td>
                                        <td><?php echo ($vo2["food_price2"]); ?></td>
                                    </tr>
                                    <?php if(is_array($vo2['attribute_list'])): $i = 0; $__LIST__ = $vo2['attribute_list'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$al): $mod = ($i % 2 );++$i;?><tr>
                                    	<td></td>
                                        <td></td>
                                        <td>--<?php echo ($al['food_attribute_name']); ?><span style="color: red;">(属性)</span></td>
                                        <td></td>
                                        <td><?php echo ($vo2["food_num"]); ?></td>
                                        <td></td>
                                        <td></td>
                                        <td><?php echo ($al['food_attribute_price']*$vo2['food_num']); ?></td>
                                    </tr><?php endforeach; endif; else: echo "" ;endif; endforeach; endif; else: echo "" ;endif; ?>
                            </table>
                        </td>
                    </tr><?php endforeach; endif; else: echo "" ;endif; ?>
            </tbody>
        </table>
    </div>    
    <div class="text-center sale-table-page" >
        <ul class="pagination" id="detail-page">
            <?php echo ($page); ?>
        </ul>
    </div>
    <input type="hidden" id="total_amount" value="<?php echo ($total_amount); ?>">
    <input type="hidden" id="pay_str" value="<?php echo ($pay_str); ?>">
    <input type="hidden" id="order_str" value="<?php echo ($order_str); ?>">
</body>
<script>
    $("#detail-page").children().children("a").click(function() {
        var page = parseInt($(this).data("page"));
        var form = $("#search_form")[0];
        var formDate = new FormData(form);
        $.ajax({
            url:"/index.php/admin/sale/orderInfo/page/"+page,
            data:formDate,
            type:"post",
            cache:false,
            contentType:false,
            processData:false,
            success:function(data){
                $("#orderInfo").html(data);

                //修改统计结果
                var startDate = $("#startDate").val();
                var endDate = $("#endtDate").val();
                $("#search_data").html(startDate+" - "+endDate);

                var food_name = $("#food_name").val();
                if(food_name){
                    $("#search_food").html("菜品:"+food_name);
                }else{
                    $("#search_food").val("所有");
                }

                var pay_type = $("#pay_str").val();
                if(pay_type == ""){
                    $("#search_pay_type").html("支付方式：所有");
                }else{
                    $("#search_pay_type").html("支付方式："+pay_type);
                }

                var order_type = $("#order_str").val();
                if(order_type == ""){
                    $("#search_order_type").html("就餐方式：所有");
                }else{
                    $("#search_order_type").html("就餐方式："+order_type);
                }

                var search_total_amount = $("#total_amount").val();
                $("#search_total_amount").html(search_total_amount+"元");
            },
            error:function(){
                alert("出错了");
            }
        });
    });

    function open_close(i){
        var tid = "#order_food"+i;
        var value = $(tid).data("value");
        console.log(value);
        if(value == 1){
            $(tid).hide();
            $(tid).data("value",0);
        }else if(value == 0){
            $(tid).show();
            $(tid).data("value",1)
        }
    }
</script>
</html>