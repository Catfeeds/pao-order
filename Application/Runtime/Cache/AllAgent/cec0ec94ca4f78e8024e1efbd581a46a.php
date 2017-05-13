<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="/Public/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="/Public/bootstrap-datetimepicker-master/bootstrap-datetimepicker.min.css">
    <link rel="stylesheet" href="/Public/css/layer.css">
    <!-- jQuery文件。务必在bootstrap.min.js 之前引入 -->
    <script src="/Public/js/jquery-3.1.0.min.js"></script>
    <!-- 最新的 Bootstrap 核心 JavaScript 文件 -->
    <script src="/Public/bootstrap/js/bootstrap.min.js"></script>
    <script src="/Public/bootstrap-datetimepicker-master/bootstrap-datetimepicker.min.js"></script>
    <script src="/Public/bootstrap-datetimepicker-master/bootstrap-datetimepicker.zh-CN.js"></script>
    <script src="/Public/js/AllAgent/device-qrc_code.js"></script>
	<script src="/Public/js/layer.js"></script>
    <title></title>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-2">
                <h2>注册码列表</h2>
            </div>
            <div class="col-md-8"><?php echo ($page); ?></div>
        </div>
        <table class="table table-hover">
            <thead>
                <tr>
                	<td><input type="checkbox" name="checkbox10" id="all" onclick="swapCheck()"></td>
                    <th>序号</th>
                    <th>注册码</th>
                    <th>所属商家</th>
                    <th>状态</th>
                   <!-- <th>开始时间</th>
                    <th>结束时间</th>-->
                    <th>操作</th>
                </tr>
            </thead>
            <tbody>
                <?php if(is_array($codeList)): $k = 0; $__LIST__ = $codeList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo1): $mod = ($k % 2 );++$k;?><tr> 
                    	<td><input type="checkbox" name="check_code"  value="<?php echo ($vo1["qrc_code_id"]); ?>"></td>
                        <td><?php echo ($k); ?></td>
                        <td><?php echo ($vo1["qrc_code"]); ?></td>
                        <td>
                            <select name="" id="" onchange="isChange(this)" data-code_id="<?php echo ($vo1["qrc_code_id"]); ?>">
                                <option value="0">暂没分配</option>
                                <?php if(is_array($businessList)): $i = 0; $__LIST__ = $businessList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo2): $mod = ($i % 2 );++$i; if($vo1[business_id] == $vo2[business_id]): ?><option value="<?php echo ($vo2["business_id"]); ?>" selected><?php echo ($vo2["business_name"]); ?></option>
                                        <?php else: ?>
                                        <option value="<?php echo ($vo2["business_id"]); ?>"><?php echo ($vo2["business_name"]); ?></option><?php endif; endforeach; endif; else: echo "" ;endif; ?>
                            </select>
                        </td>
                        <td>
                            <?php if($vo1['qrc_code_status'] == 0): ?>已使用
                                <?php else: ?>
                                未使用<?php endif; ?>
                        </td>
                       <!-- <td>
                            <input type="text" value="<?php echo ($vo1["qrc_code_timestamp"]); ?>"  data-code_id="<?php echo ($vo1["qrc_code_id"]); ?>" id="start_time" onchange="changeCodeTime(this)">
                        </td>
                        <td>
                            <input type="text" value="<?php echo ($vo1["qrc_rest_timestamp"]); ?>" data-code_id="<?php echo ($vo1["qrc_code_id"]); ?>" id="end_time" onchange="changeCodeTime(this)">
                        </td>-->
                        <td>
                            <button data-code_id="<?php echo ($vo1["qrc_code_id"]); ?>" onclick="deleteCode(this)">删除</button>
                            <!--<button data-code_id="<?php echo ($vo1["code_id"]); ?>" onclick="findInfo(this)">查看关联</button>-->
                        </td>
                    </tr><?php endforeach; endif; else: echo "" ;endif; ?>
                <button onclick="batch_delete()">批量删除</button>
            </tbody>
        </table>
    </div>
    <div class="col-md-4">
        <form action="javascript:void(0)" id="code_num" style="margin-top: 20px">
            <button onclick="create_code()">生成注册码</button>
            <input type="radio" name="code_num" id="code_num1" value="1" checked>
            <label for="code_num1">1个</label>
            <input type="radio" name="code_num" id="code_num2" value="10">
            <label for="code_num2">10个</label>
            <select name="business_id" id="business_id">
                <option value="0">请选择商家</option>
                <?php if(is_array($businessList)): $i = 0; $__LIST__ = $businessList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vo["business_id"]); ?>"><?php echo ($vo["business_name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
            </select>
        </form>
    </div>
</body>

</html>