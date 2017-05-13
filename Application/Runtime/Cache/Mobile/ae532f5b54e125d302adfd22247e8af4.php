<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh-CN">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

		<!-- Bootstrap 核心 CSS 文件 -->
		<link rel="stylesheet" href="/Public/bootstrap/css/bootstrap.min.css">
		
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

		<title>积分兑换</title>
	</head>

	<body>
		<section class="goods">
			<header class="goods-header">
				<div class="btn-group">
					<button class="dropdown-toggle" type="button" data-toggle="dropdown">
						全部分类
						<span class="caret"></span>
					</button>
					<ul class="dropdown-menu" role="menu">
						<li><a href="/index.php/mobile/member/goods_list">全部分类</a></li>
					</ul>
				</div>
				<div class="btn-group">
					<button class="dropdown-toggle" type="button" data-toggle="dropdown">
						智能筛选
						<span class="caret"></span>
					</button>
					<ul class="dropdown-menu" role="menu">
						<li><a href="/index.php/mobile/member/saleNum">按人气</a></li>
						<!--<li>按好评</li>-->
					</ul>
				</div>
				<div class="btn-group">
					<button type="button" onclick="location='<?php echo U('member/search');?>'">
						<span class="glyphicon glyphicon-search"></span>
						<span>搜索</span>
					</button>
				</div>
			</header>

			<div class="goods-list container-fluid" id="goods_table">

                <?php if(!empty($data)): ?>
                    <div class="row">
                        <?php if(is_array($data)): foreach($data as $key=>$v): ?><div class="col-xs-6">
                                <a class="goods-item" href="<?php echo U('member/goods',"id=$v[id]");?>")}">
                                    <div class="img-box">
                                        <img src="/Public/Uploads/Goods/<?php echo ($v['goods_img']); ?>">
                                    </div>
                                    <div class="goods-name"><?php echo ($v['goods_name']); ?></div>
                                    <div class="goods-price">
                                        <span class="red"><?php echo ($v['score']); ?></span>
                                        <span>积分</span>
                                    </div>
                                </a>
                            </div><?php endforeach; endif; ?>

                        <?php if(is_array($info)): foreach($info as $key=>$val): ?><div class="col-xs-6">
                                <a class="goods-item" href="<?php echo U('member/goods',"id=$val[id]");?>")}">
                                    <div class="img-box">
                                        <img src="/Public/Uploads/Goods/<?php echo ($val['goods_img']); ?>">
                                    </div>
                                    <div class="goods-name"><?php echo ($val['goods_name']); ?></div>
                                    <div class="goods-price">
                                        <span class="red"><?php echo ($val['score']); ?></span>
                                        <span>积分</span>
                                    </div>
                                </a>
                            </div><?php endforeach; endif; ?>


                    </div>

                    <?php else: ?>
                        <div class="row">
                            对不起，您搜索的商品不存在<br/>
                            <a href="/index.php/mobile/member/goods_list">返回积分商品列表页</a>
                        </div>

                <?php endif; ?>

			</div>

		</section>
	</body>
</html>