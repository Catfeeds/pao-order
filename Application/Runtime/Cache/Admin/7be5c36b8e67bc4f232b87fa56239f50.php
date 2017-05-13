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
<link rel="stylesheet" href="/element-ui@1.1.6/lib/theme-default/element.css">
<link rel="stylesheet" href="/Public/css/billboard.css">
<script src="/Public/js/vue.js"></script>
<script src="/element-ui@1.1.6/lib/index.js"></script>
<script src="/Public/js/vue-axios.js"></script>
<script src="/Public/js/vue-router.js"></script>
<body>
    <div id="bill">
        <div class="container-fluid" id="bill_list">
            <table class="table table-bordered">
                <tr><th></th><th>终端名称</th><th>MAC</th><th>使用期限</th><th></th><th></th></tr>
                <tr v-for="(billBoard, index) in billBoards" :class="{'text-center':textCenter}">
                    <td v-html="index+1"></td><td v-html="billBoard.bill_board_name"></td>
                    <td v-html="billBoard.bill_board_code"></td><td v-html="myDate(billBoard.bb_end_time)"></td>
                    <td><button :class="btnFee">续费</button></td>
                    <td><button :class="btnEdit" @click="editBill(billBoard.bill_board_id)">编辑</button></td>
                    <td><button :class="btnDel" @click="deleteBill(billBoard.bill_board_id,index)">删除</button></td>
                </tr>
            </table>
        </div>

        <div class="container-fluid" id="bill_board_info" style="display: none">
            <div class="row">
                <div class="col-xs-12">
                    <div class="container-fluid div-border">
                        <div class="row" style="margin-bottom: 5px">
                            <span >MAC：<span v-text="mac"></span></span>
                        </div>
                        <div class="row">
                            <div >
                                <span>设备名称：</span>
                                <input v-model="current_bill_board_name">
                                <button class="btn btn-primary btn-sm" @click="editBillBoardName">保存</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12">
                    <div class="container-fluid div-border">
                        <div class="row">
                            <span>开机时间：</span>
                        </div>
                        <div class="row">
                            <table class="table table-bordered">
                                <tr><th>开机时间</th><th>关机时间</th><th>全选</th><th>周一</th><th>周二</th><th>周三</th>
                                    <th>周四</th><th>周五</th><th>周六</th><th>周日</th><th>可用</th><th></th>
                                </tr>
                                <tr class="text-center" v-for="(item,index) in timers">
                                    <td>
                                        <el-input v-model="item.starting_time" placeholder="请输入开机时间(14:00)"></el-input>
                                    </td>
                                    <td>
                                        <el-input v-model="item.ending_time" placeholder="请输入关机时间(14:50)"></el-input>
                                    </td>
                                    <td><el-checkbox v-model="item.all" @change="is_select_all(index)"></el-checkbox></td><td><el-checkbox v-model="item.oc_week[0]" @change="is_change($event,0,index)"></el-checkbox></td>
                                    <td><el-checkbox v-model="item.oc_week[1]" @change="is_change($event,1,index)"></el-checkbox></td><td><el-checkbox v-model="item.oc_week[2]" @change="is_change($event,2,index)"></el-checkbox></td><td><el-checkbox v-model="item.oc_week[3]" @change="is_change($event,3,index)"></el-checkbox></td>
                                    <td><el-checkbox v-model="item.oc_week[4]" @change="is_change($event,4,index)"></el-checkbox></td><td><el-checkbox v-model="item.oc_week[5]" @change="is_change($event,5,index)"></el-checkbox></td><td><el-checkbox v-model="item.oc_week[6]" @change="is_change($event,6,index)"></el-checkbox></td>
                                    <td><el-checkbox v-model="item.is_use"></el-checkbox></td><td><button class="btn-time-delete" @click="deleteBillBoardTimer(index)"><span class="glyphicon glyphicon-minus-sign"></span></button></td>
                                </tr>
                            </table>
                        </div>
                        <div class="row">
                            <div class="pull-right">
                                <button class="btn btn-primary btn-right" @click="addBillBoardTimer">
                                    添加
                                </button>
                                <button class="btn btn-primary btn-right" @click="saveBillBoardTimer">
                                    保存
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12">
                    <div class="row">
                        <div class="col-xs-4">
                            <span>电子餐牌：</span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="container-fluid">
                            <div class="row row-margin-top">
                                <div class="container-fluid">
                                    <div class="col-xs-1">

                                    </div>
                                    <div class="col-xs-10">
                                        <div class="col-xs-2">
                                            <span>开始日期</span>
                                        </div>
                                        <div class="col-xs-2">
                                            <span>结束日期</span>
                                        </div>
                                        <div class="col-xs-2">
                                            <span>星期</span>
                                        </div>
                                        <div class="col-xs-2">
                                            <span>开始时间</span>
                                        </div>
                                        <div class="col-xs-2">
                                            <span>结束时间</span>
                                        </div>
                                        <div class="col-xs-2">
                                            <span>轮播时间(s)</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row" v-for="(img_group,index_g) in op_img_groups">
                        <div class="container-fluid">
                            <div class="row row-margin-top">
                                <div class="col-xs-1 text-center">
                                    <span>{{index_g+1}}、</span>
                                    <span class="glyphicon glyphicon-arrow-up"></span>
                                    <span class="glyphicon glyphicon-arrow-down"></span>
                                </div>
                                <div class="col-xs-10">
                                    <div class="col-xs-2">
                                        <el-date-picker v-model="img_group.starting_date" :clearable="false" :editable="false" type="date" placeholder="选择日期" :format="'yyyy-MM-dd'"></el-date-picker>
                                    </div>
                                    <div class="col-xs-2">
                                        <el-date-picker v-model="img_group.ending_date" :clearable="false" :editable="false" type="date" placeholder="选择日期" :format="'yyyy-MM-dd'"></el-date-picker>
                                    </div>
                                    <div class="col-xs-2">
                                        <el-select v-model="img_group.value" :size="'mini'" placeholder="请选择" multiple placeholder="请选择">
                                            <el-option
                                                    v-for="item2 in img_group.week"
                                                    :label="item2.label"
                                                    :value="item2.value">
                                            </el-option>
                                        </el-select>
                                    </div>
                                    <div class="col-xs-2">
                                        <el-input v-model="img_group.starting_time" placeholder="请输入开始时间(14:50)"></el-input>
                                    </div>
                                    <div class="col-xs-2">
                                        <el-input v-model="img_group.ending_time" placeholder="请输入结束时间(14:50)"></el-input>
                                    </div>
                                    <div class="col-xs-2">
                                        <input type="text" class="form-control" v-model="img_group.carousel_time">
                                    </div>
                                </div>
                                <div class="col-xs-1">
                                    <button class="btn btn-danger btn-sm" @click="deleteImgGroup(img_group.bb_group_id,index_g)">删除</button>
                                </div>
                            </div>
                            <div class="row row-margin-top">
                                <div class="col-xs-1">

                                </div>
                                <div class="col-xs-10">
                                    <div class="col-xs-2" v-for="(img,index) in img_group.bb_group_imgs">
                                        <div class="img-div">
                                            <img class="bill-img" :src="img.img_url" alt="" >
                                            <button class="btn-close" @click="deleteImg(img.id,index,index_g)"><img src="/Public/images/delete.png" ></button>
                                        </div>
                                    </div>
                                    <div class="col-xs-2">
                                        <div class="img-div">
                                            <a href="javascript:;" class="a-upload">
                                                <img class="bill-img" src="/Public/images/add.png" alt="">
                                                <input type="file" name="img" @change="uploadImg($event,index_g)">
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="container-fluid row-margin-top">
                            <button class="btn btn-primary" @click="addBillBoardImgGroup">增加</button>
                            <button class="btn btn-primary" @click="saveBillBoardImgGroup">保存</button>
                            <span>备注：当同一时间内，同时有多条信息时，显示靠前的为准</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<script src="/Public/js/billboard.js"></script>
</html>