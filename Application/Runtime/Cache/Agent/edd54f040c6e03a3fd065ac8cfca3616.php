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

<div id="sms_docking">
    <div class="container-fluid">
        <form class="form-horizontal" method="post" onSubmit="return save_sms_docking(this)">
            <div class="form-group">
                <label class="col-sm-3 control-label">appkey:</label>
                <div class="col-sm-6 col-lg-5">
                    <input type="text" name="appkey" id="" class="form-control" value="<?php echo ($sms_vip_info['appkey']); ?>" dataType="Require" placeholder="请输入appkey">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">secret:</label>
                <div class="col-sm-6 col-lg-5">
                    <input type="text" name="secret" id="" class="form-control" value="<?php echo ($sms_vip_info['secret']); ?>" dataType="Require" placeholder="请输入secret">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">短信签名:</label>
                <div class="col-sm-6 col-lg-5">
                    <input type="text" name="sign" id="" class="form-control" value="<?php echo ($sms_vip_info['sign']); ?>" dataType="Require" placeholder="请输入短信签名">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">短信模板ID:</label>
                <div class="col-sm-6 col-lg-5">
                    <input type="text" name="temp_id" id="" class="form-control" value="<?php echo ($sms_vip_info['temp_id']); ?>" dataType="Require" placeholder="请输入申请到的模板短信id">
                    <input type="hidden" name="id" value="<?php echo ($sms_vip_info['id']); ?>"/>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">阿里短信的链接入口:</label>
                <div class="col-sm-9 col-lg-5">
                    <font color="#f00">（如果已经做好了阿里短信相关业务工作，则可以忽略以下“点击这里进入阿里短信”步骤，直接填以上参数即可）<br/>
                        (注意：短信模板填写参考：<span style="color: darkgreen">“尊敬的客户，您的验证码是${msgcode}”</span>)<br/></font>
                    <a href="https://www.alidayu.com/?channel=baidu&spm=a1z15.973.4467.17133&ad_id=1001319817aad41eae59&campaign_id=547194&b=9447&jlogid=a1614284735f6d" target="_blank" style="font-size: larger">点击这里进入阿里短信</a>
                </div>
            </div>
            <div class="col-sm-10 text-center">
                <button class="btn btn-black" type="submit">保存</button>
            </div>
        </form>
    </div>
</div>

<script>
    function save_sms_docking(obj){
        // 利用“我佛山人”插件进行合法的验证
        if( Validator.Validate(obj, 3))
        {
            $.post("/index.php/agent/members/add_sms_docking", $(obj).serialize(), function(data){
                alert(data.info);
                $.get("/index.php/agent/members/get_sms_docking", function (data) {
                    $("#sms_docking").html(data);
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