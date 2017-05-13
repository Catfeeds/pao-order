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
        <form>
            <div class="radio-form">
                <input type="radio" name="if_open" id="point-set-on" value="1" onchange="to_db(this.name,this.value,'/index.php/Admin/Member/score_set')">
                <label for="point-set-on">开启</label>
                <input type="radio" name="if_open" id="point-set-off" value="0" onchange="to_db(this.name,this.value,'/index.php/Admin/Member/score_set')">
                <label for="point-set-off">关闭</label>
                <input type="hidden" id="or_open" value="<?php echo ($if_open); ?>"/>
            </div>

            <div id="memberList">
                <div class="member-tab-item2 form-inline" id="delScore">
                    消费金额
                    <input class="form-control" type="text" name="account" value="<?php echo ($prepaid_rules[account]); ?>" id="man" disabled>元，积分
                    <input class="form-control" type="text" name="benefit" value="<?php echo ($score); ?>" id="zhe" disabled>分
                    <input class="form-control" type="hidden" name="id" value="<?php echo ($prepaid_rules[id]); ?>"/>
                </div>
            </div>
        </form>
        <div class="modal fade add-content" id="addModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">新增消费折扣</h4>
                </div>
                <div class="modal-body">
                    <form class="form-inline">
                        <div class="form-group">
                            消费金额：
                            <input type="text" class="form-control">元，积分
                            <input type="text" class="form-control">元
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                    <button type="button" class="btn btn-primary">新增</button>
                </div>
            </div>
        </div>
    </div>
	</div>
    <script src="/Public/js/vip.js"></script>

    <script>
        // 页面加载完就判断店铺填的公众号支付信息跟代理的是否一致，不一致则让其处于关闭且不可选
        $(function(){
            $.post("/index.php/admin/member/if_same","",function(data){
                if(data == 0){
                    // 1、让其处于不可选状态
                    $('[name="if_open"]').val([0]);
                    $('[name="if_open"]').attr("disabled","disabled");
                    // 2、关闭数据库中的积分设置开关值(那边返回0的同时直接让它关闭)
                    // alert("店铺与代理的微信支付对接信息不一致，请统一");
                }
            });
        });

        $('[name="if_open"]').val([$("#or_open").val()]);
    </script>
</body>
</html>