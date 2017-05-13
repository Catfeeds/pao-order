<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/11/1
 * Time: 10:04
 */
namespace Component\Controller;
use Think\Controller;
use Think\jpush;

class LoginController extends Controller
{
    /**
     * 如果cookie不存在设置为其添加cookie，
     * cookie的到期时间为：当前时间+机器绑定验证码的剩余有效时间；
     */
    public function login(){
        $device_code = I('device_code');

        if($device_code == ""){
            exit("请给我提交机器码");
        }
        $condition['device_code'] = $device_code;
        $deviceModel = D('device');
        $deviceInfo = $deviceModel->where($condition)->field("code_id,device_status")->find();
        $code_id = $deviceInfo['code_id'];
        if(!$code_id){
            //注册码过期或者已经删除;
            exit("注册码过期或者已经删除");
        }

        $device_status = $deviceInfo['device_status'];
        if(!$device_status){
            //该机器已经被禁用;
            exit("该机器已经被禁用");
        }

        $codeModel = D("code");
        $rest_timestamp = $codeModel->where("code_id = $code_id")->field("rest_timestamp")->find()['rest_timestamp'];

        if($rest_timestamp > 0){
            cookie("device_code",$device_code,time()+$rest_timestamp);
            $restaurant_id = $codeModel->where("code_id = $code_id")->field("restaurant_id")->find()['restaurant_id'];
            session("restaurant_id",$restaurant_id);
//            dump(session("restaurant_id",$restaurant_id));
            $this->redirect("/home/index/index");
            //$this->redirect("/home/checkstand/index");
        }else{
            //提示注册码已经过期
            $this->display("overdue");
            exit;
        }
    }

    public function checkStandLogin(){
        $device_code = I('device_code');

        if($device_code == ""){
            exit("请给我提交机器码");
        }
        $condition['device_code'] = $device_code;
        $deviceModel = D('device');
        $deviceInfo = $deviceModel->where($condition)->field("code_id,device_status")->find();
        $code_id = $deviceInfo['code_id'];
        if(!$code_id){
            //注册码过期或者已经删除;
            exit("注册码过期或者已经删除");
        }

        $device_status = $deviceInfo['device_status'];
        if(!$device_status){
            //该机器已经被禁用;
            exit("该机器已经被禁用");
        }

        $codeModel = D("code");
        $rest_timestamp = $codeModel->where("code_id = $code_id")->field("rest_timestamp")->find()['rest_timestamp'];

        if($rest_timestamp > 0){
            unset($deviceModel);
            cookie("device_code",$device_code,time()+$rest_timestamp);
            $restaurant_id = $codeModel->where("code_id = $code_id")->field("restaurant_id")->find()['restaurant_id'];
            session('restaurant_id',$restaurant_id);
            $this->redirect("/home/checkstand/login");
        }else{
            //提示注册码已经过期
            $this->display("overdue");
            exit;
        }
    }

    public function showNum(){
        $device_code = I("device_code");
        $deviceModel = D("device");
        $condition['device_code'] = $device_code;
        $codeInfo = $deviceModel->where($condition)->find();
        $code_id = $codeInfo['code_id'];
        if($code_id){
            $codeModel = D("code");
            $c_condition['code_id'] = $code_id;
            $codeInfo = $codeModel->where($c_condition)->find();
            $restaurant_id = $codeInfo['restaurant_id'];
            if($restaurant_id == 0){
                $msg = "请为该注册码先绑定店铺，谢谢！";
                exit($msg);
            }
            $restaurantModel = D("Restaurant");
            $data['show_num_d'] = time();
            $restaurantModel->where("restaurant_id = $restaurant_id")->save($data);
            if($restaurant_id) {
                cookie("restaurant_id",$restaurant_id,259000);
                $this->redirect("/home/staff/index");//成功则跳转
            }
        }
        //不成功则推送信息到设备app
    }

    public function clerk(){
        $device_code = I("device_code");
        $deviceModel = D("device");
        $condition['device_code'] = $device_code;
        $codeInfo = $deviceModel->where($condition)->find();
        $code_id = $codeInfo['code_id'];
        if($code_id){
            $codeModel = D("code");
            $c_condition['code_id'] = $code_id;
            $codeInfo = $codeModel->where($c_condition)->find();
            $restaurant_id = $codeInfo['restaurant_id'];
            if($restaurant_id == 0){
                $msg = "请为该注册码先绑定店铺，谢谢！";
                exit($msg);
            }
            $c_condition['code_id'] = $code_id;
            $restaurant_id = $codeModel->where($c_condition)->field("restaurant_id")->find()['restaurant_id'];
            if($restaurant_id){
                cookie("restaurant_id",$restaurant_id,259000);
                $this->redirect("/home/staff/clerk");//成功则跳转
            }
        }
        //不成功则推送信息到设备app
    }

    public function vertical_login(){
        $device_code = I('device_code');

        if($device_code == ""){
            exit("请给我提交机器码");
        }
        $condition['device_code'] = $device_code;
        $deviceModel = D('device');
        $code_id = $deviceModel->where($condition)->field("code_id")->find()['code_id'];
        if(!$code_id){
            //注册码过期或者已经删除;
            exit("注册码过期或者已经删除");
        }
        $codeModel = D("code");
        $rest_timestamp = $codeModel->where("code_id = $code_id")->field("rest_timestamp")->find()['rest_timestamp'];

        if($rest_timestamp > 0){
            cookie("device_code",$device_code,time()+$rest_timestamp);
            $restaurant_id = $codeModel->where("code_id = $code_id")->field("restaurant_id")->find()['restaurant_id'];
            session("restaurant_id",$restaurant_id);

            $restaurant_page_group_model = D("restaurant_page_group");
            $page_group_data['restaurant_id'] = session("restaurant_id");
            $page_group_data['status'] = 1;
            $page_group_data['page_screen'] = 2;
            $page_group_info = $restaurant_page_group_model->where($page_group_data)->find();
            $group_id = $page_group_info['group_id'];
            session("group_id",$group_id);
            if($group_id != 2){
                $this->redirect("/vertical/template/serviceRoute");
            }elseif($group_id == 2){
                $this->redirect("/vertical/index/index");
            }
        }else{
            //提示注册码已经过期
            $this->display("overdue");
            exit;
        }
    }

    /**
     * 清除点餐机的激活记录
     */
    public function clearDeviceRecord(){
        $device_code = I("post.device_code");

        $deviceModel = D("device");

        $de_where['device_code'] = $device_code;

        //判断注册码是否过期，过期就删除。
        $device_info = $deviceModel->where($de_where)->find();
        $device_info['start_time'] = date("Y-m-d H:i:s",$device_info['start_time']);
        $device_info['end_time'] = date("Y-m-d H:i:s",$device_info['end_time']);

        $code_id = $device_info['code_id'];
        $c_where['code_id'] = $code_id;
        $code_model = D("code");
        $code_info = $code_model->where($c_where)->field("rest_timestamp")->find();

        if($code_info['rest_timestamp'] > 0){
            $data["code_status"] = 1;
            $code_model->where($c_where)->save($data);
        }else{
            $code_model->delete($c_where);
        }

        $rel = $deviceModel->where($de_where)->delete();
        file_put_contents(__DIR__."/log.txt",var_export($device_info,true)."\r\n",FILE_APPEND);
        exit($rel);
    }

    /**
     * 清除二维码点餐的激活记录
     */
    public function clearQrcDeviceRecord(){
        $device_code = I("device_code");
//        $device_code = I("device_code");

        $deviceModel = D("qrc_device");

        $de_where['qrc_device_code'] = $device_code;
        $code_id = $deviceModel->where($de_where)->field("qrc_code_id")->find();
        $rel = $deviceModel->where($de_where)->delete();

        $qrc_code_model = D("qrc_code");
        $condition['qrc_code_id'] = $code_id['qrc_code_id'];
        $code_info = $qrc_code_model->where($condition)->find();

        if($code_info['rest_timestamp'] > 0){
            $data["code_status"] = 1;
            $rel2 = $qrc_code_model->where($condition)->save($data);
        }else{
            $rel2 = $qrc_code_model->delete($condition);
        }

        $restaurant_id = $code_info['restaurant_id'];

        exit($rel&&$rel2);
    }

}