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
<body>
<div class="container-fluid">
    <form class="form-inline">
        <div>
            默认会员组
            <input type="text" name="account" value="默认会员组" disabled class="form-control">
        </div>
        <div id="group">
            <?php if(is_array($group_info)): foreach($group_info as $key=>$v): ?><div class="member-tab-item" id="delGroup">
                    <span class="index"><?php echo ++$key;?></span>会员组
                    <input type="text" name="group_name1" value="<?php echo ($v[group_name]); ?>" disabled id="gm" class="form-control">
                    <input type="hidden" name="group_id" value="<?php echo ($v[group_id]); ?>" id='hid'/>
                </div><?php endforeach; endif; ?>
        </div>
    </form>
</div>


<script src="/Public/js/vip.js,/Public/js/layer.js"></script>


</body>
</html>