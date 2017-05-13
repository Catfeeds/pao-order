<?php if (!defined('THINK_PATH')) exit();?><div class="dishes-head">
    		菜品分类设置
</div>
<table class="dishes-sort-table">
    <?php if(is_array($data)): $i = 0; $__LIST__ = $data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><tr>
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
        
<script type="text/javascript" src="/Public/js/Dishes_index.js"></script>