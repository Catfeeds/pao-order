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
<!-- 打印机对接 -->
<body>
	<div class="container-fluid">
		<P>厨房打印机：
			<button class="btn btn-primary" onclick="addPrinter()">新增</button>
		</P>
		<table class="print-table">
			<tr>
				<td>名称</td>
				<td class="text-center">IP地址</td>
				<td>品牌</td>
				<td>型号</td>
				<td>端口</td>
				<td>打印类型</td>
			</tr>
			<?php if(is_array($printList)): $i = 0; $__LIST__ = $printList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
					<td><?php echo ($vo["printer_name"]); ?></td>
					<td><?php echo ($vo["printer_ip"]); ?></td>
					<td><?php echo ($vo["printer_brand"]); ?></td>
					<td><?php echo ($vo["printer_version"]); ?></td>
					<td><?php echo ($vo["printer_port"]); ?></td>
					<td>
						<?php if($vo["print_type"] == 0): ?>主厨房
							<?php else: ?>
							副厨房<?php endif; ?>
					</td>
					<td>
						<button class="btn btn-default ml-10" data-printer_id="<?php echo ($vo["printer_id"]); ?>" onclick="deletePrinter(this)">删除</button>
						<button class="btn btn-default ml-10" onclick="editPrinter(this)" data-printer_id="<?php echo ($vo["printer_id"]); ?>"
								data-printer_name="<?php echo ($vo["printer_name"]); ?>"
								data-printer_ip="<?php echo ($vo["printer_ip"]); ?>"
								data-printer_brand="<?php echo ($vo["printer_brand"]); ?>"
								data-printer_version="<?php echo ($vo["printer_version"]); ?>"
								data-printer_port="<?php echo ($vo["printer_port"]); ?>"
								data-print_type="<?php echo ($vo["print_type"]); ?>"
								>编辑</button>
					</td>
				</tr><?php endforeach; endif; else: echo "" ;endif; ?>
		</table>
	</div>
	<!-- 模态框（Modal） -->
	<div class="modal fade" id="printModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title" id="myModalLabel">添加打印机</h4>
				</div>
				<div class="modal-body">
					<form action="javascript:void(0)" id="printerInfo">
						<input type="hidden" name="type" id="type" value="add">
						<div class="form-group">
							<label class="col-md-3" for="printer_name">打印机名称：</label>
							<input type="text" value="" name="printer_name" id="printer_name" placeholder="请输入打印机名称">
						</div>
						<div class="form-group">
							<label class="col-md-3" for="printer_ip">打印机IP：</label>
							<input type="text" value="" name="printer_ip" id="printer_ip" placeholder="请输入打印机IP">
						</div>
						<div class="form-group">
							<label class="col-md-3" for="printer_port">打印机端口：</label>
							<input type="text" value="9100" name="printer_port" id="printer_port" readonly>
						</div>
						<div class="form-group">
							<label class="col-md-3" for="printer_brand">打印机品牌：</label>
							<input type="text" value="" name="printer_brand" placeholder="打印机品牌" id="printer_brand">
						</div>
						<div class="form-group">
							<label class="col-md-3" for="printer_version">打印机型号：</label>
							<input type="text" value="" name="printer_version" id="printer_version" placeholder="打印机型号">
						</div>
						<div class="form-group">
							<label class="col-md-3" for="printer_version">打印模板：</label>
							<div class="col-md-4" style="margin-left: -18px"><img src="/Public/images/receipt1.png" alt="" style="width: 150px"><br>
								<label for="print_type1"><input type="radio" name="print_type" value="0" checked id="print_type1">
									模板一</label>
							</div>

							<div  class="col-md-5"><img src="/Public/images/receipt2.png" style="width: 150px" alt=""><br>
								<label for="print_type2"> <input type="radio" name="print_type" value="1" id="print_type2" >
									模板二</label>
							</div>

						</div>
					</form>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
					<button type="button" class="btn btn-primary" onclick="submit_printer()">提交更改</button>
				</div>
			</div><!-- /.modal-content -->
		</div><!-- /.modal -->
	</div>
</body>
<script>
	function addPrinter(){
		$("#printModal").modal("show");
		$("#printerInfo input").val("");
		$("#printer_port").val("9100");
		$("#type").val("add");
	}

	function editPrinter(obj){
		$("#type").val("edit");
		var data = $(obj).data();
		$("#printerInfo").append('<input type="hidden" name="printer_id" id="type" value="'+data['printer_id']+'">');
		$("#printer_name").val(data['printer_name']);
		$("#printer_ip").val(data['printer_ip']);
		$("#printer_port").val(data['printer_port']);
		$("#printer_brand").val(data['printer_brand']);
		$("#printer_version").val(data['printer_version']);
		$("input[name=print_type]").each(function(){
			if($(this).val() == data['print_type']){
				console.log($(this));
				$(this).prop("checked",true);
			}
		});


		$("#printModal").modal("show");
	}

	function submit_printer(){
		var form = $("#printerInfo")[0];
		var formData = new FormData(form);
		$.ajax({
			url:'/index.php/admin/DataDock/addeditprinter',
			data:formData,
			type:'post',
			dataType:'json',
			cache:false,
			processData:false,
			contentType:false,
			success:function(msg){
				if(msg.code == 1){
					self.location.href = "/index.php/admin/DataDock/printer";
				}
			},
			error:function(){
				console.log('访问出错');
			}
		});
	}

	function deletePrinter(obj){
		var printer_id = $(obj).data("printer_id");
		console.log(printer_id);
		$.ajax({
			url:"/index.php/admin/DataDock/deletePrinter",
			data:{'printer_id':printer_id},
			type:'post',
			dataType:'json',
			success:function(msg){
				if(msg.code == 1){
					self.location.href = "/index.php/admin/DataDock/printer";
				}
			},
			error:function(){
				console.log("访问出错了");
			}
		});
	}
</script>
</html>