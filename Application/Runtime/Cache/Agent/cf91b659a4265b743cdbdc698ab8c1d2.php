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

<body>
    <div class="modal-head">编辑会员信息</div>
    <div class="modal-wrapper">
        <form action="/index.php/agent/members/vip_info" onsubmit="return keep(this)">
            <table class="table-condensed">
                <tr>
                    <td>姓名：</td>
                    <td>
                        <input type="text" name="username" value="<?php echo ($vipinfo['username']); ?>">
                        <input type="hidden" name="id" value="<?php echo ($vipinfo['id']); ?>"/>
                    </td>
                </tr>
                <tr>
                    <td>性别：</td>
                    <td>
                        <div class="radio-form">
                            <input type="radio" name="sex" value="1" id="male">
                            <label for="man">男</label>
                            <input type="radio" name="sex" value="0" id="female">
                            <label for="sex-off">女</label>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>电话：</td>
                    <td>
                        <input type="text" name="phone" value="<?php echo ($vipinfo['phone']); ?>">
                    </td>
                </tr>
                <tr>
                    <td>生日：</td>
                    <td>
                        <input type="text" readonly="readonly" id="select_date" name="birthday" value="<?php echo ($vipinfo['birthday']); ?>">
                    </td>
                </tr>
                <tr>
                    <td> 所属会员组：</td>
                    <td>
                        <select name="group_id">
                            <option value="0">默认会员组</option>
                            <?php if(is_array($vip_group1)): foreach($vip_group1 as $key=>$val): ?><option value="<?php echo ($val['group_id']); ?>" <?php if($vipinfo['group_id'] == $val['group_id']):?>selected<?php endif;?>><?php echo ($val['group_name']); ?></option><?php endforeach; endif; ?>
                        </select>
                    </td>
                </tr>
            </table>
            <div class="text-center">
                <button class="btn btn-black">保存</button>
                <button class="btn btn-default" data-dismiss="modal">关闭</button>
            </div>
        </form>
    </div>
    
    <script src="/Public/bootstrap-datetimepicker-master/bootstrap-datetimepicker.min.js"></script>
    <script src="/Public/bootstrap-datetimepicker-master/bootstrap-datetimepicker.zh-CN.js"></script>
    <script>
        $('[name="sex"]').val([<?php echo ($vipinfo['sex']); ?>])
        function keep(obj){
            $.post(obj.action,$(obj).serialize(),function(data){
                if(data.status == 0){
                    alert(data.info);
                }
                $("#editmembers").modal("hide");
//                location.href = "/index.php/agent/members/members/page/<?php echo ($page); ?>";
            });
            return false;
        }

        $("#select_date").datetimepicker({
            format:'yyyy-mm-dd',
            todayBtn: true,
            autoclose: true,
            todayHighlight: true,
            minView: "month", //选择日期后，不会再跳转去选择时分秒 
            language:  'zh-CN'
        });

    </script>

</body>
</html>