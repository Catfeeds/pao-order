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
    <form class="form-inline">
        <div>
            默认会员组（不可修改）
            <input type="text" name="account" value="默认会员组" disabled class="form-control">
        </div>
        <div id="group">
            <?php if(is_array($group_info)): foreach($group_info as $key=>$v): ?><div class="member-tab-item" id="delGroup">
                    <span class="index"><?php echo ++$key;?></span>会员组
                    <input type="text" name="group_name1" value="<?php echo ($v[group_name]); ?>"  placeholder="请在此输入会员组" id="gm">
                    <input type="hidden" name="group_id" value="<?php echo ($v[group_id]); ?>" id='hid'/>
                    <div class="tab-item-right">
                        <button class="btn btn-primary" onclick="return save_group(this,'/index.php/Agent/Members/save_group')">保存</button>
                        <button class="btn btn-danger" onclick="return shanchu_group(this,'/index.php/Agent/Members/del_group')">删除</button>
                    </div>
                </div><?php endforeach; endif; ?>
        </div>
    </form>
    <button class="btn btn-black"  data-toggle="modal" data-target="#addModal">新增</button>
</div>
<div class="modal fade add-content" id="addModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">新增会员组</h4>
                </div>
                <div class="modal-body">
                    <form class="form-inline">
                        <div class="form-group">
                            <label>会员组:</label>
                            <input type="text" class="form-control" name="group_name" value=""  placeholder="请在此输入会员组">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                    <button type="button" class="btn btn-primary" onclick="return group_set('/index.php/Agent/Members/add_group')">新增</button>
                </div>
            </div>
        </div>
    </div>

<script src="/Public/js/vip.js,/Public/js/layer.js"></script>
<script>
    // 模态框会员组添加
    function group_set(url){
        var gm = $('[name="group_name"]').val();
        if(gm == ""){
            alert("会员组不能为空");
        }else{
            // ajax提交
            $.post(url,{"group_name":gm},function(data){
                // console.log(data)
                if(data.status == 0){
                    // 不成功
                    alert(data.info);
                }else{
                    // 成功添加了就实时获取
                    $("#group").html(data);
                }
            });
            $("#addModal").modal("hide");
        }
    }

    //模态框消失后清空表单
    $('#addModal').on('hidden.bs.modal', function (){
        // 执行一些动作...
        $('[name="group_name"]').val("");
    })

    // 会员组编辑后保存
    function save_group(obj,url){
        var str = $(obj).parent().siblings("#gm").val();
        var hid = $(obj).parent().siblings("#hid").val();
        if(str == ""){
            alert("会员组不能为空");
            $.post("/index.php/agent/members/get_group","",function(data){
                $("#group").html(data);
            });
        }else{
            // ajax提交
            $.post(url,{"group_name":str,"group_id":hid},function(data){
                alert(data.info);
                $.post("/index.php/agent/members/get_group","",function(data){
                    $("#group").html(data);
                });
            });
        }
        return false;
    }

    // 会员组删除
    function shanchu_group(obj,url){
        layer.confirm('您确定要删除吗？', {icon:3}, function(index){
            // 获取到它的ID，然后删除掉即可
            var hid = $(obj).parent().siblings("#hid").val();
            // ajax提交
            $.post(url,{"group_id":hid},function(data){
                // console.log(data);
                if(data.status == 0){
                    // 不成功
                    alert(data.info);
                }else{
                    // 成功添加了就实时获取
                    $("#group").html(data);
                }
            });
            layer.close(index);
        });
        return false;
    }
</script>

</body>
</html>