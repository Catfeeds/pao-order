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

    <title>余额</title>
</head>

<body>
    <header class="common-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xs-4 text-left">
                    <a href="/index.php/Mobile/Member/index" class="return">
                        <img src="/Public/images/lt.png">
                    </a>
                </div>
                <div class="col-xs-4 text-center">
                    我的余额
                </div>
                <div class="col-xs-4 text-right">
                    <a href="/index.php/Mobile/Member/touchBalance/total_money/<?php echo ($remainder); ?>">余额明细</a>
                </div>
            </div>
        </div>
    </header>
    <div class="fund-info">
        <div>当前余额（元）</div>
        <div class="fund-num"><?php echo ($remainder); ?></div>
    </div>
    <div class="container-fluid fund-content">
        <div class="fund-content-header text-center">余额充值</div>
        <div class="row">
            <?php if($prepaid[0] != ""): ?>
            <?php if(is_array($prepaid)): foreach($prepaid as $key=>$v): ?><div class="col-xs-6">
                    <button class="fund-btn" onclick="return prepaid(this)"><?php echo ($v['account']); ?>元</button>
                </div><?php endforeach; endif; ?>
            <?php else: ?>
                <div class="col-xs-6">
                    <button class="fund-btn" onclick="return prepaid(this)">50元</button>
                </div>
                <div class="col-xs-6">
                    <button class="fund-btn" onclick="return prepaid(this)">100元</button>
                </div>
                <div class="col-xs-6">
                    <button class="fund-btn" onclick="return prepaid(this)">200元</button>
                </div>
                <div class="col-xs-6">
                    <button class="fund-btn" onclick="return prepaid(this)">300元</button>
                </div>               
            <?php endif;?>
		</div>
        <div class="fund-warn">
            <input type="checkbox" checked="checked" value="off" id="read" onchange="select_read(this)">
            <span>我已阅读并理解</span>
            <a href="/index.php/Mobile/Member/agreement">《充值服务协议》</a>
        </div>
	</body>
    <script>
        function select_read(obj){
            var value = $(obj).val();
            if(value == "off"){
                $(obj).val("on");       
            }else{
                $(obj).val("off");
            }
        }

       function prepaid(obj){
           if($("#read").val() == "on"){
               alert("请勾选“我已阅读并理解”");
           }else{
               var value = obj.innerHTML.split("元")[0];

               var list = {};
               list['account'] = value;
               $.ajax({
                   type: "post",
                   url: "/index.php/Mobile/Member/pre_pay/",
                   data: list,
                   dataType: 'json',
                   success: function (data) {
                       if (data.code == 1) {
                           var order_sn = data.data['order_sn'];
                           var total_amount = data.data['total_amount'];
                           self.location.href = "/index.php/mobile/WxPay/wxPrepaid/order_sn/"+order_sn+"/wx_prepaid_flag/weixin";
                       }
                   },
                   error: function (data) {
                       // console.log(data.responseText);
                       alert("there is a error!");
                   }
               });
           }
        }
</script>
</html>