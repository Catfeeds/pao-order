<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

		<!-- 引入样式 -->
<!-- 		<link rel="stylesheet" href="/Public/element-ui/lib/theme-default/index.css"> -->
		<link rel="stylesheet" href="/Public/css/vertical_template.css">
	</head>
	<body>
		<header class="select-header">
			<button class="return-btn" onclick="location='/index.php/Vertical/Template/serviceRoute'">
				<img src="/Public/images/return.png">
				<span>重新点餐</span>
			</button>
		</header>
		<div class="select-bd" id="app">
			<div class="select-content">
				<button class="select-item" @click="skipNext(1)">
					<img src="/Public/images/fork.png">
					<span>餐厅用餐</span>
				</button>
				<button class="select-item" @click="skipNext(2)">
					<img src="/Public/images/fork.png">
					<span>打包带走</span>
				</button>
			</div>
		</div>
	</body>
	 <!-- 先引入 Vue -->
	 <script src="/Public/js/vue.js"></script>
	 <!-- 引入组件库 -->
	 <script src="/Public/element-ui/lib/index.js"></script>
	 <script src="/Public/js/jquery-3.1.0.min.js"></script>
	<script src="/Public/js/prevent.js"></script>
	 <script>
		 new Vue({
			 el:"#app",
			 mounted:function(){
				$('iframe').hide();
			},
			 methods:{
				skipNext:function(order_type){
					localStorage.setItem("order_type",order_type);
					location.href='/index.php/Vertical/Template/serviceRoute/current_action/select'
				},
				orderAgain:function(){
					localStorage.removeItem("order_type");
					location.href='/index.php/Vertical/Template/serviceRoute';
				}
			 }
		 });
	 </script>
</html>