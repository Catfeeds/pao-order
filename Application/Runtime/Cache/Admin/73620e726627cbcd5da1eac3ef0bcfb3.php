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
<link rel="stylesheet" type="text/css" href="/Public/wangEditor/css/wangEditor.min.css">
<body>
	<div class="container-fluid">
        <form>
            <div class="radio-form">
                <span>积分兑换现金设置：</span>
                <input type="radio" name="if_open" id="point-cash-on" value="1" onchange="to_db(this.name,this.value,'/index.php/Admin/Member/cash_set')">
                <label for="point-cash-on">开启</label>
                <input type="radio" name="if_open" id="point-cash-off" value="0" onchange="to_db(this.name,this.value,'/index.php/Admin/Member/cash_set')">
                <label for="point-cash-off">关闭</label>
                <input type="hidden" id="cash_open" value="<?php echo ($cash_open); ?>"/>
            </div>
            <div id="memberList">
                <div class="member-tab-item2 form-inline" id="delCash">
                    积分：
                    <input class="form-control" type="text" name="account" value="<?php echo ($point_cash_rules[account]); ?>" id="man" disabled>分=现金：
                    <input class="form-control" type="text" name="benefit" value="<?php echo ($score); ?>" id="zhe" disabled>元

                    <input type="hidden" name="id" value="<?php echo ($point_cash_rules[id]); ?>"/>
                </div>
            </div>
        </form>
        <div class="point-exchange">
            <p class="radio-form">
                <span>积分兑换物品设置：</span>
                <input type="radio" class="point_goods" name="if_open" id="point-goods-on" value="1" onchange="to_db(this.name,this.value,'/index.php/Admin/Member/goods_set')">
                <label for="point-goods-on">开启</label>
                <input type="radio" class="point_goods" name="if_open" id="point-goods-off" value="0" onchange="to_db(this.name,this.value,'/index.php/Admin/Member/goods_set')">
                <label for="point-goods-off">关闭</label>
                <input type="hidden" id="goods_open" value="<?php echo ($goods_open); ?>"/>
            </p>
            <div class="clearfix">

                <div id="photo">
                    <?php if(is_array($img_rules)): foreach($img_rules as $key=>$v): ?><div class="pull-left point-exchange-item">
                            <div class="pic-thumbnail">
                                <img src="/Public/Uploads/Goods/<?php echo ($v[goods_img]); ?>">
                                <input type="hidden" name="id" value="<?php echo ($v['id']); ?>"/>
                                <input type="hidden" name="goods_name" value="<?php echo ($v['goods_name']); ?>"/>
                                <input type="hidden" name="score" value="<?php echo ($v['score']); ?>"/>
                                <input type="hidden" name="money" value="<?php echo ($v['money']); ?>"/>
                                <input type="hidden" name="goods_desc" value="<?php echo ($v['goods_desc']); ?>"/>
                            </div>
                            <p>积分：<?php echo ($v[score]); ?></p>
                        </div><?php endforeach; endif; ?>
                </div>
            </div>
        </div>

        <div>
            <p>积分模板：（微信公众号积分公示）</p>
            <div>
                <img src="/Public/images/screenshot.png">
                <span>请将下面的链接地址加入到公众号菜单中</span>
                <span>URL:http://shop.fouya.com/id...</span>
            </div>
        </div>
	</div>

    <script src="/Public/js/vip.js"></script>

    <script>
        $('[name="if_open"]').val([$("#cash_open").val()]);
        $('.point_goods').val([$("#goods_open").val()]);

    </script>


</body>
</html>