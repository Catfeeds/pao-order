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
<!-- 餐桌二维码 -->
<body>
	<div class="container-fluid">
		<div class="table-header">
			<span>前端点餐标题 : <input type="text" name="wx_order_title" value="<?php echo ($wx_order_title); ?>" style="width: 200px;" id="wx_order_title"/>
			<input type="button" value="编 辑" style="padding-left: 20px; padding-right: 20px;" onclick="update_title()" />
			</span><br />	
			<?php if($qrc_order == 1): ?><span>到期时间：2018-07-20</span>
			<button class="btn-none add-table-num admin-btn" onclick="addDesk()">新增餐桌号</button>
			<?php else: ?>
			<span>到期时间：<span style="color: red;">未开通</span></span><?php endif; ?>
			
		</div>
		<?php if($qrc_order == 1): ?><div id="comment_list">
			<table class="table-code">
				<tr>
					<td>序号</td>
					<td>餐桌号</td>
					<td>机器码</td>
					<td></td>
					<td></td>
				</tr>
				<?php if(is_array($deskInfo)): $i = 0; $__LIST__ = $deskInfo;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
						<td><?php echo ($i); ?></td>
						<td><?php echo ($vo["desk_code"]); ?></td>
						<td>
							<img src="<?php echo ($vo["code_img"]); ?>"></td>
						<td>
							<button class="btn btn-info" data-img_path="<?php echo ($vo["code_img"]); ?>" onclick="downloadImg(this)">下载图片</button>
						</td>
						<td>
							<button class="btn btn-primary" data-desk_id="<?php echo ($vo["desk_id"]); ?>" data-desk_code="<?php echo ($vo["desk_code"]); ?>" onclick="editDesk(this)">编辑</button>
							<button class="btn btn-default ml-10" data-desk_id="<?php echo ($vo["desk_id"]); ?>" onclick="delDesk(this)">删除</button>
						</td>
					</tr><?php endforeach; endif; else: echo "" ;endif; ?>
			</table>
			<div class="table-page text-center">
				<ul class="pagination" id="detail-page"><?php echo ($page); ?></ul>
			</div>
		</div>
		<?php else: endif; ?>
	</div>
	<!--模态框-->
	<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title" id="myModalLabel">新增餐桌</h4>
				</div>
				<div class="modal-body">
					<form action="javascript:void(0)" id="desk_form">
						<div class="form-group">
							<label for="table">餐桌号:</label>
							<input type="text" id="table" name="desk_code" placeholder="例：A01-1"><span style="color: red;"> 建议使用字母开头</span>
							<input type="hidden"  name="type" value="add">
							<input type="hidden"  name="desk_id" value="">
						</div>
					</form>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
					<button type="button" class="btn btn-primary" onclick="submit_deskForm()">提交更改</button>
				</div>
			</div><!-- /.modal-content -->
		</div><!-- /.modal -->
	</div>
</body>
<script>
//	var totalnum = $("#detail-page").attr("data-totalnum"); //分页数量
	$("#detail-page").children().children("a").click(function() {
		var page = parseInt($(this).data("page"));
		console.log(page);
		$.ajax({
			url:"/index.php/admin/device/deskInfo",
			data:{"page":page},
			type:"get",
			success:function(data){
				$("#comment_list").html(data);
			},
			error:function(){
				alert("出错了");
			}
		});
	});

	function downloadImg(obj){
		var img_path = $(obj).data('img_path');
		location.href = "/index.php/admin/device/downloadImg?imgPath="+img_path;
	}

	function submit_deskForm(){
		var form = $('#desk_form')[0];
		var formData = new FormData(form);
		var url="";
		var type1 = $('#desk_form input').eq(1).val();

		var type2 = $('#desk_form input').eq(1).val();

		if(type1 == "add"){
			url="/index.php/admin/device/createDesk";
		}else if(type2 == "edit"){
			url="/index.php/admin/device/editDesk";
		}
		console.log(url);
		$.ajax({
			url:url,
			dataType:"json",
			type:"post",
			data:formData,
			cache: false,
			contentType: false,
			processData: false,
			success:function(msg){
				if(msg.code == 1){
//					alert("成功");
					self.location.href = "/index.php/admin/device/deskInfo";
				}else{
					alert("新增失败");
				}
			},
			error:function(){
				alert("出错了");
			}
		});
	}

	function editDesk(obj){
		var desk_code = $(obj).data("desk_code");
		var desk_id = $(obj).data("desk_id");
		$("#desk_form input").eq(0).val(desk_code);
		$("#desk_form input").eq(1).val("edit");
		$("#desk_form input").eq(2).val(desk_id);
		$("#myModal").modal("show");
		$('#myModal').on('hidden.bs.modal', function () {
			$("#desk_form input").eq(0).val("");
		});
	}

	function addDesk(){
		$("#desk_form input").eq(1).val("add");
		$("#myModal").modal("show");
	}

	function delDesk(obj){
		var desk_id = $(obj).data("desk_id");
		$.ajax({
			url:"/index.php/admin/device/delDesk",
			data:{"desk_id":desk_id},
			dataType:'json',
			type:"post",
			success:function(msg){
				if(msg.code == 1){
//					alert(msg.msg);
					self.location.href = "/index.php/admin/device/deskInfo";
				}else{
//					alert(msg.msg);
					self.location.href = "/index.php/admin/device/deskInfo";
				}
			},
			error:function(){
				alert("出错了");
			}
		});
	}
	
	//编辑微信order标题
	function update_title(){
		var wx_order_title = $("#wx_order_title").val();
		$.ajax({
			type:"post",
			url:"/index.php/Admin/Device/update_title",
			data:{"wx_order_title":wx_order_title},
			dataType:"json",
			async:true,
			success:function(data){
				layer.msg(data.msg);
			},
			error:function(){
				layer.msg("网络错误");
			}
		});
	}
</script>
</html>