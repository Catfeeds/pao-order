<?php
namespace Api\Controller;
class ClientController extends BaseController
{
    /**
     * 获取该店铺是否开启餐桌号，是否开启会员折扣、余额的数据
     * 方式：post
     * device_code
     * cookie('device_code')横竖屏
     */
    public function getIfOpenInfo(){
        $device_code = I("device_code") ? :cookie("device_code");
        $this->isLogin($device_code);
        if($this->is_security){
            $restaurant_process = D("restaurant_process");
            $restaurant_id = session("restaurant_id");
            $pr_condition['process_id'] = 4;
            $pr_condition['restaurant_id'] = $restaurant_id;
            $status = $restaurant_process->where($pr_condition)->getField("process_status");
            // 是否开启餐桌号
            $arr['table_status'] = $status;   // 0关闭，1开启

            // 是否开启折扣
            $discount_where['restaurant_id'] = $restaurant_id;
            $discount_where['type'] = 0;
            $discount_open = D("set")->where($discount_where)->getField("if_open");
            if(empty($discount_open)){
                $discount_open = 0;
            }
            // 是否开启折扣
            $arr['discount'] = $discount_open;  // 0关闭，1开启

            $returnData['code'] = 1;
            $returnData['msg'] = "获取数据成功";
            $returnData['data'] = $arr;
            exit(json_encode($returnData));
        }else{
            $returnData['code'] = 0;
            $returnData['msg'] = "该设备已过期，没有权限拿数据";
            $returnData['data'] = "";
            exit(json_encode($returnData));
        }
    }

    // 是否开启积分物品
    public function if_cancel()
    {
        $device_code = I("device_code") ?: cookie("device_code");
        $this->isLogin($device_code);
        if ($this->is_security) {
            $score_where['restaurant_id'] = session("restaurant_id");
            $score_where['type'] = 4;
            $if_open = D("set")->where($score_where)->getField("if_open");
            if(empty($if_open)) {
                $if_open = 0;
            }
            // 0关闭，1开启
            $returnData['code'] = 1;
            $returnData['msg'] = "获取数据成功";
            $returnData['score'] = $if_open;
            exit(json_encode($returnData));
        }else{
            $returnData['code'] = 0;
            $returnData['msg'] = "该设备已过期，没有权限拿数据";
            exit(json_encode($returnData));
        }
    }

    // 公众号入口链接
    public function public_num_url()
    {
        $device_code = I("device_code") ?: cookie("device_code");
        $this->isLogin($device_code);
        if ($this->is_security) {
            $business_where['restaurant_id'] = session("restaurant_id");
            $business_id = D("restaurant")->where($business_where)->getField("business_id");
            $public_where["business_id"] = $business_id;
            $public_number_url = D("public_number_set")->where($public_where)->getField("public_number_url");
            $returnData['code'] = 1;
            $returnData['msg'] = "获取数据成功";
            $returnData['url'] = $public_number_url;
            exit(json_encode($returnData));
        }else{
            $returnData['code'] = 0;
            $returnData['msg'] = "该设备已过期，没有权限拿数据";
            exit(json_encode($returnData));
        }
    }

    // 要显示哪些支付类型
    public function pay_type()
    {
         $device_code = I("device_code") ?: cookie("device_code");
         $this->isLogin($device_code);
         if ($this->is_security) {
             $pay_select_model = D('pay_select');
             $ps_condition['restaurant_id'] = session('restaurant_id');
             $pay_select_config = $pay_select_model->where($ps_condition)->select();
             foreach($pay_select_config as $ps_va){
                 if($ps_va['s_num'] == "1"){
                     // 微信支付
                     $arr['wx'] = $ps_va['value'];
                 }elseif($ps_va['s_num'] == "2"){
                    // 银联或者现金
                     $arr['cash'] = $ps_va['value'];
                 }elseif($ps_va['s_num'] == "3"){
                    // 微信刷卡支付
                     $arr['wechat'] = $ps_va['value'];
                 }else{
                    // 支付宝支付
                     $arr['ali_code'] = $ps_va['value'];
                 }

             }
             $returnData['code'] = 1;
             $returnData['msg'] = "获取数据成功";
             $returnData['data'] = $arr;
             exit(json_encode($returnData));
         }else{
             $returnData['code'] = 0;
             $returnData['msg'] = "该设备已过期，没有权限拿数据";
             exit(json_encode($returnData));
         }
    }



}
