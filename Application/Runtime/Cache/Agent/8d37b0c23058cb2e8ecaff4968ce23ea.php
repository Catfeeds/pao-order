<?php if (!defined('THINK_PATH')) exit();?><table class="table table-responsive">
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
    <th>所属会员组</th>
    <th>操作</th>
</tr>
</thead>
<tbody>
<?php if(is_array($vips1)): foreach($vips1 as $key=>$v): ?><tr>
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
        <td>
            <?php if($v['group_id'] == 0): ?>
            默认会员组
            <?php else: ?>
            <?php if(is_array($vip_group1)): foreach($vip_group1 as $key=>$val): if($v['group_id'] == $val['group_id']):?>
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

<script>
//点击页码执行动作
$("#detail-page").children().children("a").click(function(){
var page = parseInt($(this).data("page"));
// console.log(page);
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