<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh-CN">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

	<!-- Bootstrap 核心 CSS 文件 -->
	<link rel="stylesheet" href="/Public/bootstrap/css/bootstrap.min.css">

	<!-- admin CSS 文件 -->
	<link rel="stylesheet" href="/Public/css/agent.css">
	<!-- HTML5 Shim 和 Respond.js 用于让 IE8 支持 HTML5元素和媒体查询 -->	
	<!--[if lt IE 9]>	
		<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
		<script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
	<![endif]-->

	<!-- jQuery文件。务必在bootstrap.min.js 之前引入 -->
	<script src="/Public/js/jquery-3.1.0.min.js"></script>
	<!-- 最新的 Bootstrap 核心 JavaScript 文件 -->
	<script src="/Public/bootstrap/js/bootstrap.min.js"></script>

	<!-- layer CSS 文件 -->
	<link rel="stylesheet" href="/Public/css/layer.css">
	<script src="/Public/js/layer.js"></script>
	<title>方雅点餐系统代理后台</title>
</head>

<body class="members">

    <div id="public_number_set">
        <div class="container-fluid">
            <form class="form-horizontal" method="post" onSubmit="return save_public_number_set(this)">
                <div class="form-group">
                    <label for="appid" class="col-sm-3 control-label">appid:</label>
                    <div class="col-sm-7 col-lg-5">
                        <input type="text" name="appid" value="<?php echo ($public_number_set['appid']); ?>" id="appid" class="form-control" dataType="Require" placeholder="请输入公众号appid">
                    </div>
                </div>
                <div class="form-group">
                    <label for="appsecret" class="col-sm-3 control-label">appsecret:</label>
                    <div class="col-sm-7 col-lg-5">
                        <input type="text" name="appsecret" value="<?php echo ($public_number_set['appsecret']); ?>" id="appsecret" class="form-control" dataType="Require" placeholder="请输入公众号appsecret">
                    </div>
                </div>
                <div class="form-group">
                    <label for="public_number_url" class="col-sm-3 control-label">会员通过公众号注册的链接入口:</label>
                    <div class="col-sm-7 col-lg-6">
                        <input type="text" name="public_number_url" id="public_number_url" value="http://shop.founya.com/index.php/Mobile/weixin/getUserDetail?business_id=<?php echo ($business_id); ?>" class="form-control">
                        <font color="#f00">（请勿填写或者更改链接入口地址，只需复制粘贴至微信公众号设置即可）</font>
                        <input type="hidden" name="business_id" value="<?php echo ($business_id); ?>"/>
                        <input type="hidden" name="id" value="<?php echo ($public_number_set['id']); ?>"/>
                    </div>
                </div>
                <div class="col-sm-11 text-center">
                    <button class="btn btn-black" type="submit">保存</button>
                </div>
            </form>
        </div>
    </div>
    <script>
        function save_public_number_set(obj){
            // 利用“我佛山人”插件进行合法的验证
            if( Validator.Validate(obj, 3))
            {
                $.post("/index.php/agent/members/add_public_number_set", $(obj).serialize(), function(data){
                    alert(data.info);
                    $.get("/index.php/agent/members/get_public_number_set", function (data) {
                        $("#public_number_set").html(data);
                    });
                });
            }
            return false;
        }
    </script>
    <script src="/Public/js/validator.js"></script>
    <script src="/Public/js/lamson.js"></script>
</body>
</html>