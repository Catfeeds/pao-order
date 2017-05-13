<?php
namespace AllAgent\Controller;
use Think\Controller;
class SystemsetController extends Controller{
	public function __construct(){
        Controller::__construct();
        if(!session("manager_id")){
            $this->redirect("login");
        }
    }
	
	//系统设置，设备时间年限显示
	public function show_renew(){
		$renew = D('renew');
		$renewArr = $renew->where("id=1")->find();
		$this->assign("renewArr",$renewArr);
		$this->display('renew');
	}
	
	//系统设置，设备时间年限修改
	public function update_renew(){
		if($_POST){
			$renew = D('renew');
			$data['renew_time1'] = I('post.renew_time1');
			$data['renew_time2'] = I('post.renew_time2');
			$data['renew_time3'] = I('post.renew_time3');
			$r = $renew->where("id=1")->save($data);
			if($r){
				$renewArr = $renew->where("id=1")->find();
				$this->assign("renewArr",$renewArr);
				$this->display('renew');
			}
		}
	}
}
