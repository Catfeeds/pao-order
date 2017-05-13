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
                <input type="radio" name="if_open" id="discount-on" value="1" onchange="to_db(this.name,this.value,'/index.php/Admin/Member/discount_set')">
                <label for="discount-on">开启</label>
                <input type="radio" name="if_open" id="discount-off" value="0" onchange="to_db(this.name,this.value,'/index.php/Admin/Member/discount_set')">
                <label for="discount-off">关闭</label>
                <input type="hidden" id="or_open" value="<?php echo ($if_open); ?>"/>
            </div>
            <div class="radio-form">
                <input type="radio" name="if_vip" id="discount-account" value="1" onchange="to_db(this.name,this.value,'/index.php/Admin/Member/discount_set')">
                <label for="discount-account">全部</label>
                <input type="radio" name="if_vip" id="discount-member" value="0" onchange="to_db(this.name,this.value,'/index.php/Admin/Member/discount_set')">
                <label for="discount-member">仅会员</label>
                <input type="hidden" id="or_vip" value="<?php echo ($if_vip); ?>"/>
            </div>
            <div id="memberList">
                <?php if(is_array($discount_rules)): foreach($discount_rules as $key=>$v): ?><div class="member-tab-item" id="delDiscount">
                        <span class="index"><?php echo ++$key;?></span>.满
                        <input type="text" name="account" value="<?php echo ($v['money']); ?>">元，
                        打<input type="text" name="benefit" value="<?php echo ($v['discount']); ?>">折
                        <input type="hidden" name="id" value="<?php echo ($v['id']); ?>"/>
                        所属会员组
                        <select name="group_id">
                            <option value="0">默认会员组</option>
                            <?php if(is_array($group_info)): foreach($group_info as $key=>$val): ?><option value="<?php echo ($val['group_id']); ?>" <?php if($v['group_id'] == $val['group_id']):?>selected<?php endif;?>><?php echo ($val['group_name']); ?></option><?php endforeach; endif; ?>
                        </select>
                        <div class="tab-item-right">
                            <button class="btn btn-primary" onclick="return save_discount(this)">保存</button>
                            <button class="btn btn-danger" onclick="return shanchu_discount(this,'/index.php/Admin/Member/del_discount')">删除</button>
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
                    <h4 class="modal-title">新增消费折扣</h4>
                </div>
                <div class="modal-body">
                    <form class="form-inline">
                        <div class="form-group">
                            满
                            <input type="text" class="form-control" name="account" id="man" placeholder="消费额">元，
                            打<input type="text" class="form-control"  name="benefit" id="zhe" placeholder="折扣">折<br/>
                            例如：8折：填8；8.5折：填8.5
                        </div>
                        <div class="form-group">
                            <label>所属会员组:</label>
                            <select name="group_id" class="form-control" id="belong_to">
                                <option value="0">默认会员组</option>
                                <?php if(is_array($group_info)): foreach($group_info as $key=>$v): ?><option value="<?php echo ($v['group_id']); ?>"><?php echo ($v['group_name']); ?></option><?php endforeach; endif; ?>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                    <button type="button" class="btn btn-primary" onclick="return add_discount()">新增</button>
                </div>
            </div>
        </div>
    </div>

    <script src="/Public/js/vip.js"></script>
    <script src="/Public/js/layer.js"></script>
    <script>

        $('[name="if_open"]').val([$("#or_open").val()]);
        $('[name="if_vip"]').val([$("#or_vip").val()]);


        // 模态框添加折扣信息
        function add_discount(){
            var account = $("#man").val();
            var benefit = $("#zhe").val();
            var group_id = $("#belong_to").val();
            if(account == "" || benefit == ""){
                alert("折扣信息不能为空");
            }else{
                // ajax提交
                $.post('/index.php/Admin/Member/add_discount',{"account":account,"benefit":benefit,"group_id":group_id},function(data){
                    if(data.status == 0){
                        // 不成功
                       alert(data.info);
                    }else{
                        // 成功添加了就实时获取
                        $("#memberList").html(data);
                    }
                });
                $("#addModal").modal("hide");
            }
        }

        //模态框消失后清空表单
        $('#addModal').on('hidden.bs.modal', function (){
            // 执行一些动作...
            $("#man").val("");
            $("#zhe").val("");
            $("#belong_to").val(0);
        })

        // 每条记录后的保存处理
        function save_discount(obj) {
            var account = $(obj).parent().siblings('[name="account"]').val();
            var benefit = $(obj).parent().siblings('[name="benefit"]').val();
            var id = $(obj).parent().siblings('[name="id"]').val();
            var group_id = $(obj).parent().siblings('[name="group_id"]').val();

            if(account == "" || benefit == "" || id == "" || group_id == ""){
                alert("折扣信息不能为空");
            } else{
                // ajax提交
                $.post('/index.php/Admin/Member/save_discount',{"money": account, "discount": benefit, "id":id,"group_id": group_id},function(data){
                    // console.log(data);
                    alert(data.info);
                    $.post('/index.php/Admin/Member/get_discount',"",function(data){
                        // 成功添加了就实时获取
                        $("#memberList").html(data);
                    });
                });
            }
            return false;
        }

        // 折扣删除
        function shanchu_discount(obj,url){
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