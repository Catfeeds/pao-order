<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
	<title>方雅总后台登录</title>
	<link rel="stylesheet" type="text/css" href="/Public/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="/Public/css/agent.css">
	<script type="application/javascript" src="/Public/js/jquery-3.1.0.min.js"></script>
</head>
<body class="login-bg">
	<div class="login">
		<div class="login-content">
			<h1 class="login-head">
				<img src="/Public/images/admin_logo.png">
				<span>方雅店铺后台</span>
			</h1>

			<form id="myform">
			<div class="login-main">
				<h3 class="main-head">欢迎登录</h3>
				<input type="text" name="login_account" value="<?php echo ($login_account); ?>" class="form-control login-input" placeholder="用户名">
				<input type="password" name="password" value="<?php echo ($password); ?>" class="form-control login-input" placeholder="密码">
				<?php if($autoFlag == 1): ?><input type="checkbox" value="1" name="autoFlag" checked="checked"/>&nbsp;记住密码
				<?php else: ?>
					<input type="checkbox" value="1" name="autoFlag"/>&nbsp;记住密码<?php endif; ?>	
				<div class="code-content">
					<input type="text" name="code" class="form-control login-input" placeholder="验证码">
					<div class="code-box">
						<img src="/index.php/Admin/Index/verifyImg" class="code-img" onclick="this.src='/index.php/Admin/Index/verifyImg/'+Math.random()">
					</div>
				</div>				
				<button class="form-control login-btn" type="button" id="loginBtn" onclick="commit()">登录</button>
				<input type="reset" id="reset" style="display: none;"/>
			</div>
			</form>
		</div>
	</div>
</body>
<script>

	var cloud = sessionStorage.getItem("cloud");
	if (cloud==1) {
		$('body').css('height',$(window).height()/2);
	}

	function loginHeight(){
		if($('.login').height()>$('body').height()){
			$('body').css('overflow', 'auto');
		}
		else{
			$('body').css('overflow', 'hidden');
		}
	}
	loginHeight();
	$(window).resize(function(event) {		
		loginHeight();
	});
	$(document).keyup(function(event){
		if(event.keyCode ==13){
			commit();
		}
	});

	function commit(){
		var login_account = $("input[name='login_account']").val();
		var password = $("input[name='password']").val();
		var code =  $("input[name='code']").val();
		var autoFlag = $("input[type='checkbox']").is(':checked');		
		var login_way = 0;     //登录入口(0:从后台路径登录，1：从收银端登录)
		if(autoFlag == true){
			autoFlag = 1;
		}else{
			autoFlag = 0;
		}
		if(login_account && password){
			$.ajax({
				type:"POST",
				url:"/index.php/admin/index/checklogin",
				async:true,
				data:{"login_account":login_account,"password":password,"code":code,"autoFlag":autoFlag,"login_way":login_way},
				dataType:"json",
				success:function(data){
					if(data.code != 1){
						alert(data.msg);
						$(".code-img").trigger('click');
						$("#reset").trigger('click');
					}else{
						sessionStorage.setItem("id",data.id);
						top.location.href = "/index.php/admin/index";	
					}
				}
			});
		}else{
			alert("用户名和密码不能为空！");
		}
	}





</script>
</html>