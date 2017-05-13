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
	<link rel="stylesheet" type="text/css" href="/Public/bootstrap-datetimepicker-master/bootstrap-datetimepicker.min.css">


    <div class="container-fluid" id="wxpay">
        <form action="javascript:void(0)" id="wxpayForm">
            <div class="form-group" style="margin-top: 12px">
                <label for="wxpay_appid">
                    APPID:
                    <input class="form-control" type="text" value="<?php echo ($wx_config["wxpay_appid"]); ?>" placeholder="绑定支付的APPID" name="wxpay_appid" id="wxpay_appid">
                </label>
            </div>
            <!--<div class="form-group">
                <label for="wxpay_mchid">
                    MCHID:
                    <input class="form-control" type="text" value="<?php echo ($wx_config["wxpay_mchid"]); ?>" placeholder="商户号" name="wxpay_mchid" id="wxpay_mchid">
                </label>
            </div>-->
            <div class="form-group">
                <label for="wxpay_key">
                    KEY:
                    <input class="form-control" type="text" value="<?php echo ($wx_config["wxpay_key"]); ?>" placeholder="商户支付密钥" name="wxpay_key" id="wxpay_key">
                </label>

            </div>
            <div class="form-group">
                <label for="wxpay_appsecret">
                    APPSECRET:
                    <input class="form-control" type="text" value="<?php echo ($wx_config["wxpay_appsecret"]); ?>" placeholder="公众帐号secert" name="wxpay_appsecret" id="wxpay_appsecret">
                </label>
            </div>
            <div class="form-group">
                <label for="wxpay_child_mchid">
                    CHILD_MCHID:
                    <input class="form-control" type="text" value="<?php echo ($wx_config["wxpay_child_mchid"]); ?>" placeholder="子商户号（用于代理）" name="wxpay_child_mchid" id="wxpay_child_mchid">
                </label>
            </div>
        </form>
        <button class="btn btn-primary" data-paytype="wxpay" onclick="submitPayInfo(this)">
            修改/添加
        </button>
    </div>

	<script src="/Public/bootstrap-datetimepicker-master/bootstrap-datetimepicker.min.js"></script>
	<script src="/Public/bootstrap-datetimepicker-master/bootstrap-datetimepicker.zh-CN.js"></script>
	<script src="/Public/js/membersManage.js"></script>

    <script>
        function submitPayInfo(obj){
            var form1 = $("#wxpayForm")[0];
            formData = new FormData(form1);
            // console.log(formData);
            $.ajax({
                url:"/index.php/agent/Members/editAddPayInfo/",
                data:formData,
                type:'post',
                dataType:'json',
                contentType:false,
                cache:false,
                processData:false,
                success:function(data){
                    // console.log(data);
                },
                error:function(){
                    console.log("网络出错了");
                }
            });
        }
    </script>



</body>
</html>