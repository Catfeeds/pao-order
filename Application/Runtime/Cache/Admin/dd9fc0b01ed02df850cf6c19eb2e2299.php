<?php if (!defined('THINK_PATH')) exit();?><div class="ad-left">
	<p>横屏广告：</p>
	<div class="ad-tips">分辨率：<br>1920*1080</div>
	<div class="ad-tips">大小：<br>1M以下</div>
</div>
<div class="clearfix">
	<?php if(is_array($info)): $i = 0; $__LIST__ = array_slice($info,0,1,true);if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><div class="showimg pull-left">
			<div class="ad-imgBox" id="<?php echo ($v["advertisement_id"]); ?>">
				<img src="/<?php echo ($v["advertisement_image_url"]); ?>">
			</div>
			<div class="text-right mt-5">
				<form name="form1" id="form1">
					<a href="javascript:;" class="a-upload">
						上传
						<input type="file" name="default" onchange="preview1(this)">
					</a>
				</form>
			</div>
		</div><?php endforeach; endif; else: echo "" ;endif; ?>
	<?php if(is_array($info)): $i = 0; $__LIST__ = array_slice($info,1,null,true);if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><div class="showimg pull-left">
			<div class="ad-imgBox" id="<?php echo ($v["advertisement_id"]); ?>">
				<img src="/<?php echo ($v["advertisement_image_url"]); ?>">
				<button class="delete-btn" onclick="deladver(<?php echo ($v["advertisement_id"]); ?>)">
					<img src="/Public/images/delete.png">
				</button>
			</div>
			<div class="text-right mt-5">
				<form name="form1" id="form1">
					<a href="javascript:;" class="a-upload">
						上传
						<input type="file" name="change" onchange="preview1(this)">
					</a>
				</form>
			</div>
		</div><?php endforeach; endif; else: echo "" ;endif; ?>
	<div class="showimg pull-left">
		<div class="ad-imgBox">
			<img src="">
		</div>
		<div class="text-right mt-5">
			<form name="form1" id="form1">
				<a href="javascript:;" class="a-upload">
					上传
					<input type="file" name="change" onchange="preview1(this)">
				</a>
			</form>
		</div>
	</div>
</div>