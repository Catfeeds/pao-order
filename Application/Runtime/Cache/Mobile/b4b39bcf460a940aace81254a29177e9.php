<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh-CN">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

		<!-- Bootstrap 核心 CSS 文件 -->
		<link rel="stylesheet" href="/Public/bootstrap/css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="/Public/css/swiper.min.css">

		<link rel="stylesheet" type="text/css" href="/Public/css/member.css">

		<!-- HTML5 Shim 和 Respond.js 用于让 IE8 支持 HTML5元素和媒体查询 -->
		<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
		<script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
		<![endif]-->

		<!-- jQuery文件。务必在bootstrap.min.js 之前引入 -->
		<script src="/Public/js/jquery-3.1.0.min.js"></script>
		<!-- 最新的 Bootstrap 核心 JavaScript 文件 -->
		<script src="/Public/bootstrap/js/bootstrap.min.js"></script>

		<title>商品详情</title>
	</head>

	<body>
		<div class="goods-info">
			<div class="goods-info-top">
				<div class="swiper-container">
                    <div class="swiper-slide">
                        <img src="/Public/Uploads/Goods/<?php echo ($data['goods_img']); ?>">
                    </div>
				</div>
				<div class="goods-info-head">
					<div class="goods-title"><?php echo ($data['goods_name']); ?></div>
					<div class="red"><?php echo ($data['score']); ?>积分</div>
				</div>
			</div>

			<section class="container-fluid goods-details">
				<header class="goods-details-header">商品介绍</header>
				<div class="goods-detail-content">
                    <?php echo ($data['goods_desc']); ?>
				</div>
			</section>
		</div>

		<footer class="goods-info-footer">

            <?php if($vip_score>=$data['score']):?>
                <button class="btn btn-success"  onclick="score_order(this)" data-goods_name="<?php echo ($data['goods_name']); ?>" data-score="<?php echo ($data['score']); ?>">下单</button>
                <?php else: ?>
                    <button class="btn btn-disabled">积分不足</button>
            <?php endif; ?>

        </footer>

        <div class="modal code-modal" id="member-code">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="clearfix">
                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        </div>
                        <div class="text-center" id="image">

                        </div>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->

		<script src="/Public/js/swiper.jquery.min.js"></script>
		<script src="/Public/js/members_goods.js"></script>
        <script>
            function score_order(obj){
                var goods_name = $(obj).data("goods_name");
                var score = $(obj).data("score");
                var goods_id = <?php echo ($data['id']); ?>;
                $.post("/index.php/mobile/member/placeorder",{"goods_name":goods_name,"score":score,"goods_id":goods_id},function(data){
                    if(data){
                        $("#image").empty();
                        var str = '<img src="/index.php/mobile/member/orderQrc/order_sn/'+data+'" class="member-code">';
                        $("#image").append(str);
                        $("#member-code").modal("show");
                    }else{
                        $("#image").html("下单失败");
                        $("#member-code").modal("show");
                    }
                });
            }
        </script>

	</body>