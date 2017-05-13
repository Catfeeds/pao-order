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
	<div class="container-fluid">
        <form>
            <div id="memberList">
                <div class="member-tab-item2" id="delScore">
                    消费金额
                    <input type="text" name="account" value="<?php echo ($prepaid_rules[account]); ?>" id="man">元，积分
                    <input type="text" name="benefit" value="<?php echo ($score); ?>" id="zhe">分
                    <input type="hidden" name="id" value="<?php echo ($prepaid_rules[id]); ?>"/>
                    <div class="tab-item-right">
                        <button class="btn btn-primary" onclick="return save_point_set(this)">保存</button>
                        <button class="btn btn-danger" onclick="return shanchu_point_set(this,'/index.php/Agent/Members/del_point_set')">删除</button>
                    </div>
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
        // 积分设置后面的保存
        function save_point_set(obj){
            var account = $(obj).parent().siblings('[name="account"]').val();
            var benefit = $(obj).parent().siblings('[name="benefit"]').val();
            var id = $(obj).parent().siblings('[name="id"]').val();
            if(account == "" || benefit == ""){
                alert("积分设置信息不能为空");
            } else{
                // ajax提交
                $.post('/index.php/Agent/Members/save_point_set',{"account": account, "benefit": benefit, "id":id},function(data){
                    // console.log(data);
                    alert(data.info);
                    $.post('/index.php/Agent/Members/get_point_set',"",function(data){
                        // 成功添加了就实时获取
                        $("#memberList").html(data);
                    });
                });
            }
            return false;
        }

        // 积分设置删除
        function shanchu_point_set(obj,url){
            layer.confirm('您确定要删除吗？', {icon:3}, function(index){
                // 获取到它的ID，然后删除掉即可
                var hid = $(obj).parent().siblings("[name='id']").val();
                // ajax提交
                $.post(url,{"id":hid},function(data){
                    // console.log(data);
                    if(data.status == 0){
                        // 不成功
                        alert(data.info);
                    }else{
                        // 成功添加了就实时获取
                        $("#memberList").html(data);
                    }
                });
                layer.close(index);
            });
            return false;
        }
    </script>
</body>
</html>