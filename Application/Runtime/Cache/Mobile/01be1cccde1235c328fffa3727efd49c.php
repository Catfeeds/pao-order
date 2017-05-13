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

    <title>会员中心</title>
</head>

<body>
<div class="member-center">
    <div class="container-fluid text-center">
        <div class="row">
            <div class="col-xs-4 member-center-col">
                <img src="<?php echo ($data['headimgurl']); ?>" class="img-icon">
                <div><?php echo ($data['username']); ?></div>
            </div>
            <div class="col-xs-4 member-center-col">
                <a href="#member-code" data-toggle="modal" onclick="my_qrcode()">
                    <img src="/Public/images/member_code.png" class="img-icon">
                    <div>我的二维码</div>
                </a>
            </div>
            <div class="col-xs-4 member-center-col">
                <a href="<?php echo U('member/integration');?>">
                    <img src="/Public/images/integration.png" class="img-icon">
                    <div><?php echo ($total_score); ?></div>
                </a>
            </div>
            <div class="col-xs-4 member-center-col">
                <a href="<?php echo U('member/member_info');?>">
                    <img src="/Public/images/member_user.png" class="img-icon">
                    <div>个人信息</div>
                </a>
            </div>
            <div class="col-xs-4 member-center-col">
                <a href="<?php echo U('member/goods_list');?>">
                    <img src="/Public/images/mall.png" class="img-icon">
                    <div>积分商城</div>
                </a>
            </div>
            <div class="col-xs-4 member-center-col">
                <a href="<?php echo U('member/remainder');?>">
                    <img src="/Public/images/fund.png" class="img-icon">
                    <div>我的余额</div>
                </a>
            </div>
        </div>
    </div>
</div>

<div class="modal code-modal" id="member-code1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <div class="clearfix">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                </div>
                <div class="text-center" id="myQrcode">

                </div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


</body>
<script>
    function my_qrcode(){
        $("#myQrcode").empty();
        var str = '<img src="/index.php/mobile/member/vip_code" class="member-code">';
        $("#myQrcode").append(str);
        $("#member-code1").modal("show");
    }
</script>
</html>