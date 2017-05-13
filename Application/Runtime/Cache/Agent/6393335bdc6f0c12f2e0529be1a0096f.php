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
            <div class="radio-form">
                <input type="radio" name="if_open" id="prepaid-on" value="1" onchange="to_db(this.value,'/index.php/Agent/Members/prepaid_set')">
                <label for="prepaid-on">开启</label>
                <input type="radio" name="if_open" id="prepaid-off" value="0" onchange="to_db(this.value,'/index.php/Agent/Members/prepaid_set')">
                <label for="prepaid-off">关闭</label>
            </div>
            <div id="memberList">
                <?php if(is_array($prepaid_rules)): foreach($prepaid_rules as $key=>$v): ?><div class="member-tab-item1" id="delPrepaid">
                        <span class="index1"><?php echo ++$key;?></span>.充
                        <input type="text" name="account" value="<?php echo ($v[account]); ?>">元，送
                        <input type="text" name="benefit" value="<?php echo ($v[benefit]); ?>">元=<?php echo ($v['account']+$v['benefit']); ?>元
                        <input type="hidden" name="id" value="<?php echo ($v['id']); ?>"/>
                        <div class="tab-item-right">
                            <button class="btn btn-primary" onclick="return save_prepaid(this)">保存</button>
                            <button class="btn btn-danger" onclick="return shanchu_prepaid(this,'/index.php/Agent/Members/del_prepaid')">删除</button>
                        </div>
                    </div><?php endforeach; endif; ?>
            </div>
        </form>
        <button class="btn btn-black" data-toggle="modal" data-target="#addModal">新增</button>
	</div>
    <div class="modal fade add-content" id="addModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">预充值</h4>
                </div>
                <div class="modal-body">
                    <form class="form-inline">
                        <div class="form-group">
                            充
                            <input type="text" name="account" class="form-control" id="man">元，送
                            <input type="text" name="benefit" class="form-control" id="zhe">元
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                    <button type="button" class="btn btn-primary" onclick="return add_prepaid(this,'/index.php/Agent/Members/add_prepaid')">新增</button>
                </div>
            </div>
        </div>
    </div>

    <script src="/Public/js/vip.js"></script>
    <script src="/Public/js/layer.js"></script>
    <script>
        $('[name="if_open"]').val([<?php echo ($if_open); ?>]);

        // 将各类型的设置传递到数据库
        function to_db(b,url){
            // 发送ajax
            $.post(url,{"if_open":b},function(data){
                if(data.info == 0){
                    alert(data.info);
                }
            });
        }

        // 模态框添加预充值信息
        function add_prepaid(){
            var account = $("#man").val();
            var benefit = $("#zhe").val();
            if(account == "" || benefit == ""){
                alert("预充值信息不能为空");
            }else{
                // ajax提交
                $.post('/index.php/Agent/Members/add_prepaid',{"account":account,"benefit":benefit},function(data){
                    if(data.status == 0){
                        // 不成功
                        alert(data.info);
                    }else{
                        // 成功添加了就实时获取
                        $("#memberList").html(data);
                    }
                    $("#addModal").modal("hide");
                });
            }
        }

        //模态框消失后清空表单
        $('#addModal').on('hidden.bs.modal', function (){
            // 执行一些动作...
            $("#man").val("");
            $("#zhe").val("");
        })

        // 每条记录后面的保存处理
        function save_prepaid(obj){
            var account = $(obj).parent().siblings('[name="account"]').val();
            var benefit = $(obj).parent().siblings('[name="benefit"]').val();
            var id = $(obj).parent().siblings('[name="id"]').val();

            if(account == "" || benefit == "" || id == ""){
                alert("预充值信息不能为空");
            } else{
                // ajax提交
                $.post('/index.php/Agent/Members/save_prepaid',{"account": account, "benefit": benefit, "id":id},function(data){
                    alert(data.info);
                    $.post('/index.php/Agent/Members/get_prepaid',"",function(data){
                        // 成功添加了就实时获取
                        $("#memberList").html(data);
                    });
                });
            }
            return false;
        }

        // 预充值删除
        function shanchu_prepaid(obj,url){
            layer.confirm('您确定要删除吗？', {icon:3}, function(index){
                // 获取到它的ID，然后删除掉即可
                var hid = $(obj).parent().siblings("[name='id']").val();
                // ajax提交
                $.post(url,{"id":hid},function(data){
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