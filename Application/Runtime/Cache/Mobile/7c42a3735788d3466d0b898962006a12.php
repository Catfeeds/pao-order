<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

    <!-- Bootstrap 核心 CSS 文件 -->
    <link rel="stylesheet" href="/Public/bootstrap/css/bootstrap.min.css">

    <link rel="stylesheet" type="text/css" href="/Public/css/member.css">

    <!-- HTML5 Shim 和 Respond.js 用于让 IE8 支持 HTML5元素和媒体查询 -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->

    <!-- jQuery文件。务必在bootstrap.min.js 之前引入 -->
    <script src="/Public/js/jquery-3.1.0.min.js"></script>
    <!-- 最新的 Bootstrap 核心 JavaScript 文件 -->
    <script src="/Public/bootstrap/js/bootstrap.min.js"></script>

    <title>余额</title>
</head>

<body>
    <header class="common-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xs-4 text-left">
                    <a href="/index.php/Mobile/Member/remainder" class="return">
                        <img src="/Public/images/lt.png">
                    </a>
                </div>
                <div class="col-xs-4 text-center">
                    余额明细
                </div>
            </div>
        </div>
    </header>
    <div class="touchBalance_list">

        <?php if(is_array($consume_detail)): foreach($consume_detail as $k=>$v): if(is_array($v)): foreach($v as $ke=>$val): if(!empty($val)): ?>
                        <div class="touchBalance_header"><?php echo ($k); ?>年<?php echo ($ke); ?>月：</div>
                            <?php if(is_array($val)): foreach($val as $key=>$value): ?><div class="touchBalance_item">
                                    <div class="row">
                                        <div class="col-xs-6"><?php echo date('Y-m-d H:i:s',$value['pay_time']);?></div>
                                        <div class="col-xs-5 text-right">-<?php echo ($value['total_amount']); ?>元</div>
                                    </div>
                                </div><?php endforeach; endif; ?>
                    <?php endif; endforeach; endif; endforeach; endif; ?>

    </div>

</body>

</html>