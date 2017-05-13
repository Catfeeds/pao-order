<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <title></title>
</head>
<body>
    <?php if(is_array($img_rules)): foreach($img_rules as $key=>$v): ?><div class="pull-left point-exchange-item">
        <div class="pic-thumbnail">
            <img src="/Public/Uploads/Goods/<?php echo ($v[goods_img]); ?>">
            <input type="hidden" name="id" value="<?php echo ($v['id']); ?>"/>
        </div>
        <p>积分：<?php echo ($v[score]); ?></p>
            <input type="hidden"/>
        <div class="text-center">
            <button class="btn btn-primary" data-toggle="modal" data-target="#edit-goods" data-goods_id = "<?php echo ($v['id']); ?>" onclick="editInfo(this)">编辑</button>
            <button class="btn btn-danger" onclick="return del_img(this,'/index.php/Agent/Members/del_point_img')">删除</button>
        </div>
        </div><?php endforeach; endif; ?>
</body>
</html>