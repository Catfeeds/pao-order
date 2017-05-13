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
<!-- 点餐流程 -->
<style>
	.a-upload{
   padding: 1em 1.5em;
   height: 20px;
   line-height: 3px;
   position: relative;
   cursor: pointer;
   color: #888;
   background: #fafafa;
   border: 1px solid #ddd;
   overflow: hidden;
   display: inline-block;
   *display: inline;
   *zoom: 1;
    background-color: #414040;
	color: #fff;
}

.a-upload  input {
   position: absolute;
   font-size: 100px;
   right: 0;
   top: 0;
   opacity: 0;
   filter: alpha(opacity=0);
   cursor: pointer
}

	
</style>
<body>
	<div class="container-fluid">
		<!-- 点餐流程 start -->
		<div class="orderProcess">
			<h4 class="blue">
				<b>请正确选择用户的点餐流程：</b>
			</h4>
			<!-- 点餐流程选择 start -->
			<div class="row" id="diancan">
				<?php if(is_array($info2)): $i = 0; $__LIST__ = $info2;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v2): $mod = ($i % 2 );++$i;?><div class="col-xs-4 col-sm-2 process-item">
					<p class="text-center"><?php echo ($v2["process_name"]); ?></p>
					<img src="<?php echo ($v2["process_img"]); ?>">
					<p>
						<?php if($v2['process_id'] == 3): ?><input type="radio" name="adPage<?php echo ($v2["process_id"]); ?>" value="0" checked="checked" onchange="changestatu(this,<?php echo ($v2["process_id"]); ?>)">
							<span class="mr-20">开启</span>
						<?php elseif($v2['process_id'] == 5): ?>
							<input type="radio" name="adPage<?php echo ($v2["process_id"]); ?>" value="0" checked="checked" onchange="changestatu(this,<?php echo ($v2["process_id"]); ?>)">
							<span class="mr-20">开启</span>
						<?php else: ?>
							<?php if($v2["process_status"] == 1): ?><input type="radio" name="adPage<?php echo ($v2["process_id"]); ?>" value="1" checked="checked" onchange="changestatu(this,<?php echo ($v2["process_id"]); ?>)">						
							<span class="mr-20">开启</span>
							<input type="radio" name="adPage<?php echo ($v2["process_id"]); ?>" value="0" onchange="changestatu(this,<?php echo ($v2["process_id"]); ?>)">
							<span>关闭</span>
							<?php else: ?>
							<input type="radio" name="adPage<?php echo ($v2["process_id"]); ?>" value="1" onchange="changestatu(this,<?php echo ($v2["process_id"]); ?>)">							
							<span class="mr-20">开启</span>
							<input type="radio" name="adPage<?php echo ($v2["process_id"]); ?>" value="0" checked="checked" onchange="changestatu(this,<?php echo ($v2["process_id"]); ?>)">
							<span>关闭</span><?php endif; endif; ?>
					</p>
				</div><?php endforeach; endif; else: echo "" ;endif; ?>
			</div><!-- 点餐流程选择 end -->

			<div class="adWord">
				<h4 class="blue">
					<b>下单成功提示语：</b>
				</h4>
				<p>
					<input type="text" name = "advlang" value="<?php echo ($info4); ?>" onchange="changeadvlang()" class="form-control">
				</p>
			</div>
		</div><!-- 点餐流程 end -->

	
		<!-- 广告设置 start-->
		<div class="adSet">			
			<h4 class="blue">
				<b>广告设置：</b>
			</h4>
			<p>
				每张图片间隔时间：<input type="text" value="<?php echo ($info3); ?>" size="2" onchange="changetime()" id="interval">秒
			</p>
			<!-- 横屏广告 start -->			
			<div class="ad-horizontal"  id="mytr">
				<!--id = row-->			
				<div class="ad-left">
					<p>横屏广告：</p>
					<div class="ad-tips">分辨率：<br>1920*1080</div>
					<div class="ad-tips">大小：<br>1M以下</div>
				</div>
				<div class="clearfix">
					<?php if(is_array($info)): $i = 0; $__LIST__ = array_slice($info,0,1,true);if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><div class="showimg pull-left">
							<div class="ad-imgBox" id="<?php echo ($v["advertisement_id"]); ?>">
								<img src="/<?php echo ($v["advertisement_image_url"]); ?>"></div>
							<div class="text-right mt-5">
								<form name="form1">
									<a href="javascript:;" class="a-upload">
										上传
										<input type="file" name="default" onchange="preview1(this)"></a>
								</form>
							</div>
						</div><?php endforeach; endif; else: echo "" ;endif; ?>
					<?php if(is_array($info)): $i = 0; $__LIST__ = array_slice($info,1,null,true);if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><div class="showimg pull-left">
							<div class="ad-imgBox" id="<?php echo ($v["advertisement_id"]); ?>">
								<img src="/<?php echo ($v["advertisement_image_url"]); ?>">			
								<button class="delete-btn" onclick="deladver(<?php echo ($v["advertisement_id"]); ?>)">
									<img src="/Public/images/delete.png"></button>
							</div>
							<div class="text-right mt-5">
								<form name="form1">
									<a href="javascript:;" class="a-upload">
										上传
										<input type="file" name="change" onchange="preview1(this)"></a>
								</form>
							</div>
						</div><?php endforeach; endif; else: echo "" ;endif; ?>
					<div class="showimg pull-left">
						<div class="ad-imgBox">
							<img src=""></div>
						<div class="text-right mt-5">
							<form name="form1">
								<a href="javascript:;" class="a-upload">
									上传
									<input type="file" name="change" onchange="preview1(this)"></a>
							</form>
						</div>
					</div>
				</div>			
			</div>
			<!-- 横屏广告 end -->			

			<!-- 竖屏广告 start -->
			<div class="ad-vertical" id="mytr1">
				<div class="ad-left">
					<p>竖屏广告：</p>
					<div class="ad-tips">分辨率：<br>1080*1920</div>
					<div class="ad-tips">大小：<br>1M以下</div>
				</div>
				<div class="clearfix">
					<?php if(is_array($info1)): $i = 0; $__LIST__ = array_slice($info1,0,1,true);if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v1): $mod = ($i % 2 );++$i;?><div class="showimg1 pull-left">
							<div class="ad-imgBox"  id="<?php echo ($v1["advertisement_id"]); ?>">
								<img src="/<?php echo ($v1["advertisement_image_url"]); ?>">
							</div>

							<div class="text-center mt-5">
								<form name="form1">
									<a href="javascript:;" class="a-upload">
										上传
										<input type="file" name="default" onchange="preview(this)">
									</a>
								</form>
							</div>
						</div><?php endforeach; endif; else: echo "" ;endif; ?>
					<?php if(is_array($info1)): $i = 0; $__LIST__ = array_slice($info1,1,null,true);if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v1): $mod = ($i % 2 );++$i;?><div class="showimg1 pull-left">
							<div class="ad-imgBox"  id="<?php echo ($v1["advertisement_id"]); ?>">
								<img src="/<?php echo ($v1["advertisement_image_url"]); ?>">					
								<button class="delete-btn" onclick="deladver1(<?php echo ($v1["advertisement_id"]); ?>)">
									<img src="/Public/images/delete.png"></button>
							</div>

							<div class="text-center mt-5">
								<form name="form1" >
									<a href="javascript:;" class="a-upload">
										上传
										<input type="file" name="change" onchange="preview(this)"></a>
								</form>
							</div>
						</div><?php endforeach; endif; else: echo "" ;endif; ?>
					<div class="showimg1 pull-left">
						<div class="ad-imgBox">
							<img src="">
						</div>

						<div class="text-center mt-5">
							<form name="form1">
								<a href="javascript:;" class="a-upload">
									上传
									<input type="file" name="change" onchange="preview(this)"></a>
							</form>
						</div>
					</div>
				</div>
			</div><!-- 竖屏广告 start -->
			
			<!-- showNumber广告start -->
			<div class="ad-showNum" id="mytr1">
				<div class="ad-left">
					<p>叫号屏广告：</p>
				</div>
				<div class="clearfix">
					<?php if(is_array($info5)): $i = 0; $__LIST__ = array_slice($info5,0,1,true);if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v5): $mod = ($i % 2 );++$i;?><div class="showimg1 pull-left">
							<div class="ad-imgBox">
								<img src="/<?php echo ($v5["advertisement_image_url"]); ?>">
							</div>
							<div class="text-center mt-5">
								<form name="form1">
									<a href="javascript:;" class="a-upload">
										上传
										<input type="file" name="default" onchange="preview2(this)" id="<?php echo ($v5["advertisement_id"]); ?>"></a>
								</form>
							</div>
						</div><?php endforeach; endif; else: echo "" ;endif; ?>
				</div>
			</div><!-- showNumber广告start -->

		</div><!-- 广告设置 end-->
		
	</div>
</body>
<script type="text/javascript" src="/Public/js/Moudle_index.js"></script>
</html>