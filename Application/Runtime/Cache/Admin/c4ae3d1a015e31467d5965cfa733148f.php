<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title></title>
</head>
<body>
<div class="modal-head">菜品类别修改</div>
<form action="javascript:void(0)" id="editDishesType">
    <input type="hidden" id="attribute_type_id" name="attribute_type_id" value="<?php echo ($attr_type["attribute_type_id"]); ?>">
    <table>
        <tr>
            <td>名称：</td>
            <td>
                <input type="text" name="type_name" value="<?php echo ($attr_type["type_name"]); ?>">
            </td>
        </tr>
        <tr>
            <td>打印机：</td>
            <td>
                <select name="print_id">
                    <?php if(is_array($printerList)): $i = 0; $__LIST__ = $printerList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$prt_vo): $mod = ($i % 2 );++$i; if($prt_vo['printer_id'] == $attr_type['print_id']): ?><option value="<?php echo ($prt_vo["printer_id"]); ?>" selected><?php echo ($prt_vo["printer_name"]); ?></option>
                            <?php else: ?>
                            <option value="<?php echo ($prt_vo["printer_id"]); ?>"><?php echo ($prt_vo["printer_name"]); ?></option><?php endif; endforeach; endif; else: echo "" ;endif; ?>
                </select>
            </td>
        </tr>
        <tr>
            <td>类型：</td>
            <td>
                <?php if($attr_type['select_type'] == 0): ?><input type="radio" name="select_type" value="0" checked>单选
                    <input type="radio" name="select_type" value="1">多选
                    <?php else: ?>
                    <input type="radio" name="select_type" value="0" >单选
                    <input type="radio" name="select_type" value="1" checked>多选<?php endif; ?>

            </td>
        </tr>
         <tr>
            <td>统计：</td>
            <td>
                <?php if($attr_type['count_type'] == 0): ?><input type="radio" name="count_type" value="0" checked>否
                    <input type="radio" name="count_type" value="1">是
                    <?php else: ?>
                    <input type="radio" name="count_type" value="0" >否
                    <input type="radio" name="count_type" value="1" checked>是<?php endif; ?>

            </td>
        </tr>
        <tr>
            <td>属性：</td>
            <td>
                <ul class="attr-list clearfix">
                    <?php if(is_array($attr_type["attrs"])): $i = 0; $__LIST__ = $attr_type["attrs"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li class="attr-item">
                            <span><?php echo ($vo["attribute_name"]); ?></span>
                            <button class="attr-item-del" data-attr_id="<?php echo ($vo["food_attribute_id"]); ?>" onclick="deleteAttr(this)">
                                <span>&times;</span>
                            </button>
                        </li><?php endforeach; endif; else: echo "" ;endif; ?>
                </ul>
            </td>
        </tr>
    </table>
</form>
<div class="text-center">
    <button type="button" class="btn btn-danger" data-dismiss="modal">关闭</button>
    <button type="button" class="btn btn-primary" onclick="editDishesType()">修改</button>
</div>
</body>
</html>