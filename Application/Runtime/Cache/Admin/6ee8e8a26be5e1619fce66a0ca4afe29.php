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
<!-- 商家信息 -->
<style>
	#preview{
		padding: 1.4rem 1.4rem;
		text-align: center;
		background-color: #2C3C51;
	}

	#preview img{
		max-width: 100%;
		max-height: 60px;
	}
</style>
<body>
	<div class="restaurant-info">
		<form action="javascript:void(0)" id="restaurant_form">
			<input type="hidden" value="<?php echo ($Restaurant["restaurant_id"]); ?>" name="restaurant_id">
			<div class="form-group">
				<label for="restaurant_name">店铺名称：</label>
				<input type="text" class="form-control" value="<?php echo ($Restaurant["restaurant_name"]); ?>" id="restaurant_name" name="restaurant_name" placeholder="请输入店铺名称">
			</div>
			<div class="form-group">
				<div id="addCommodityIndex">
					<!--input-group start-->
					<div class="input-group row">
						<div class="col-sm-6">
							<label>logo图片</label>
						</div>
						<div class="col-sm-9 big-photo">
							<div id="preview">
								<img id="imghead" border="0" src="<?php echo ($Restaurant["logo"]); ?>" onclick="$('#previewImg').click();">
							</div>
							<input type="file" onchange="previewImage(this)" style="display: none;" id="previewImg">
							<!--<input id="uploaderInput" class="uploader__input" style="display: none;" type="file" accept="" multiple="">-->
						</div>
					</div>
					<!--input-group end-->

				</div>
			</div>
			<div class="form-group">
				<label for="telephone1">外卖电话1：</label>
				<input type="text" class="form-control" value="<?php echo ($Restaurant["telephone1"]); ?>" id="telephone1" name="telephone1" placeholder="请输入外卖电话1">
			</div>
			<div class="form-group">
				<label for="telephone2">外卖电话2：</label>
				<input type="text" class="form-control" value="<?php echo ($Restaurant["telephone2"]); ?>" id="telephone2" name="telephone2" placeholder="请输入外卖电话2">
			</div>
			<div class="form-group">
				<label for="address">地址：</label>
				<input type="text" class="form-control" value="<?php echo ($Restaurant["address"]); ?>" id="address" name="address" placeholder="请输入地址">
			</div>
			<div class="form-group">
				<label for="address">帐号：</label>
				<input type="text" class="form-control" value="<?php echo ($object["login_account"]); ?>" name="login_account" disabled="disabled">
			</div>
			<div class="form-group">
				<label for="address">修改密码：</label>
				<input type="password" class="form-control" value="<?php echo ($object["password"]); ?>"  name="password">
			</div>
			<div class="form-group">
				<label for="address">完成密码：</label>
				<input type="password" class="form-control" value="<?php echo ($object["password"]); ?>"  name="passwords">
			</div>
			<!--<div class="form-group">
				<label for="address">店铺网址：</label>
				<input type="text" class="form-control" value="<?php echo ($Restaurant["restaurant_url"]); ?>" id="inter_address" name="inter_address" disabled>
				<span><?php echo ($Restaurant["restaurant_url"]); ?></span>
			</div>-->
		</form>
		<button class="btn btn-sm btn-primary align-right" onclick="submit_form()">修改/输入</button>
	</div>
</body>
<script>
	function submit_form(){
		var password = $("input[name='password']").val();
		var passwords = $("input[name='passwords']").val();
		if(password === passwords){
			var form = $("#restaurant_form")[0];
			var formData = new FormData(form);
			$.ajax({
				url:"/index.php/admin/restaurant/index",
				data:formData,
				dataType:'json',
				type:'post',
	//			async: false,
				cache: false,
				contentType: false,
				processData: false,
				success:function(msg){
					if(msg.code == 1){
						layer.msg('操作成功');
					}else{
						layer.msg('操作失败');
					}
				},
				error:function(){
					layer.msg('网络出错了');
				}
			});
		}else{
			layer.msg("两次密码不一致");
		}
	}


	//图片上传预览    IE是用了滤镜。
	function previewImage(file)
	{
		var div = document.getElementById('preview');
		var MAXWIDTH  = div.width;
		var MAXHEIGHT = div.height;
//		var div = document.getElementById('preview');
		if (file.files && file.files[0])
		{
			div.innerHTML ='<img id=imghead onclick=$("#previewImg").click()>';
			var img = document.getElementById('imghead');
			img.onload = function(){
				var rect = clacImgZoomParam(MAXWIDTH, MAXHEIGHT, img.offsetWidth, img.offsetHeight);
				img.width  =  rect.width;
				img.height =  rect.height;
				img.style.marginTop = rect.top+'px';
			}
			var reader = new FileReader();
			reader.onload = function(evt){img.src = evt.target.result;}
			reader.readAsDataURL(file.files[0]);
		}
		else //兼容IE
		{
			var sFilter='filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(sizingMethod=scale,src="';
			file.select();
			var src = document.selection.createRange().text;
			div.innerHTML = '<img id=imghead>';
			var img = document.getElementById('imghead');
			img.filters.item('DXImageTransform.Microsoft.AlphaImageLoader').src = src;
			var rect = clacImgZoomParam(MAXWIDTH, MAXHEIGHT, img.offsetWidth, img.offsetHeight);
			status =('rect:'+rect.top+','+rect.left+','+rect.width+','+rect.height);
			div.innerHTML = "<div id=divhead style='width:"+rect.width+"px;height:"+rect.height+"px;margin-top:"+rect.top+"px;"+sFilter+src+"\"'></div>";
		}

		var formData = new FormData();
		formData.append("file",file.files[0]);
		$.ajax({
			url:"/index.php/admin/restaurant/changeRestaurantLogo/",
			data:formData,
			type:'post',
			dataType:"json",
			contentType:false,
			processData:false,
			async:false,
			cache:false,
			success:function(msg){
				console.log(msg);
				if(msg.code == 1){
					layer.alert("logo替换成功，刷新页面即可生效")
				}
			}
		});
	}
	function clacImgZoomParam( maxWidth, maxHeight, width, height ){
		var param = {top:0, left:0, width:width, height:height};
		if( width>maxWidth || height>maxHeight ){
			rateWidth = width / maxWidth;
			rateHeight = height / maxHeight;

			if( rateWidth > rateHeight ){
				param.width =  maxWidth;
				param.height = Math.round(height / rateWidth);
			}else{
				param.width = Math.round(width / rateHeight);
				param.height = maxHeight;
			}
		}
		param.left = Math.round((maxWidth - param.width) / 2);
		param.top = Math.round((maxHeight - param.height) / 2);
		return param;
	}
</script>
</html>