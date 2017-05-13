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
	<!-- 会员信息 -->
	<div class="container-fluid">
		<form class="form-inline" method="get" action="?">
			<div class="form-group">
				<input type="text" placeholder="请输入手机号" class="form-control" name="keyword" value="<?php echo ($_GET['keyword']); ?>">
				<button class="btn btn-black" type="submit">搜索</button>
			</div>
		</form>
        <div id="all">
		    <table class="table table-responsive">
			<thead>
				<tr>
					<th></th>
					<th>手机号</th>
					<th>姓名</th>
					<th>年龄</th>
					<th>生日</th>
					<th>性别</th>
					<th>余额</th>
					<th>积分</th>
					<th>消费总计</th>
					<th>所属会员组</th>
					<th>操作</th>
				</tr>
			</thead>
			<tbody>

				<?php if(is_array($vips)): foreach($vips as $key=>$v): ?><tr>
						<td><?php echo ++$key;?></td>
						<td><?php echo ($v['phone']); ?></td>
						<td><?php echo ($v['username']); ?></td>
						<td><?php echo ($v['age']); ?></td>
						<td><?php echo ($v['birthday']); ?></td>
						<td> <?php if($v['sex'] == 1):?>
	                        男
	                        <?php else: ?>
	                        女
	                    </td>
	                    <?php endif; ?>

						<td><?php echo ($v['remainder']); ?>元</td>
						<td><?php echo ($v['score']); ?>分</td>
						<td><?php echo ($v['total_consume']); ?>元</td>
						<td>
	                        <?php if($v['group_id'] == 0): ?>
	                            默认会员组
	                            <?php else: ?>
	                                <?php if(is_array($vip_group)): foreach($vip_group as $key=>$val): if($v['group_id'] == $val['group_id']):?>
	                                        <?php echo ($val['group_name']); ?>
	                                    <?php endif; endforeach; endif; ?>
	                        <?php endif;?>
	                    </td>
						<td>
							<button class="btn btn-black" data-toggle="modal" data-target="#editmembers" data-vip_id = "<?php echo ($v['id']); ?>" onclick="editInfo(this,<?php echo ($now_page); ?>)">编辑</button>
						</td>
					</tr><?php endforeach; endif; ?>
			</tbody>
		    </table>

            <div class="text-center">
                <ul class="pagination" id="detail-page"><?php echo ($page); ?></ul>
            </div>

        </div>
	</div><!-- /会员信息 -->		

	<!-- 编辑会员信息 -->
	<div class="modal fade" id="editmembers">
		<div class="modal-dialog">
			<div class="modal-content" id="edit_vip">

			</div>
		</div>
	</div>

	<script src="/Public/bootstrap-datetimepicker-master/bootstrap-datetimepicker.min.js"></script>
	<script src="/Public/bootstrap-datetimepicker-master/bootstrap-datetimepicker.zh-CN.js"></script>
	<script src="/Public/js/membersManage.js"></script>
	<script src="/Public/js/jquery.pagination.js"></script>


    <script>
        function editInfo(obj,page){
            var id = $(obj).data('vip_id');
            $.ajax({
                url:"/index.php/agent/members/getVipInfos",
                type:"post",
                data:{"id":id,"page":page},
//            dataType:"json",
                success:function(data){
                    $("#edit_vip").html(data);
                },
                error:function(){
                    console.log("访问出错");
                }
            });
        }

        //点击页码执行动作
        $("#detail-page").children().children("a").click(function(){
            var page = parseInt($(this).data("page"));
            $.ajax({
                url:"/index.php/agent/members/vipPage/page/"+page+"/keyword/<?php echo ($_GET['keyword']); ?>",
                type:"get",
                success:function(data){
                    // console.log(data);
                    $("#all").html(data);
                },
                error:function(){
                    alert("出错了");
                }
            });
        });
    </script>



</body>
</html>