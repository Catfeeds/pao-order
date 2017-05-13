<?php
namespace Admin\Controller;
use Think\Controller;
class IndexController extends Controller {
	public function index(){
		if (!session("re_admin_id")) {
			$controller_name = CONTROLLER_NAME;
			$active_name = ACTION_NAME;
			echo $controller_name;
			echo $active_name;
			if($controller_name == "Index" && $active_name == "index"){
				redirect("admin/index/login");
				exit;
			}
			redirect("index/login");
		}

		$restaurant_model = D("restaurant");
		$r_where['restaurant_id'] = session("restaurant_id");
		$rel = $restaurant_model->where($r_where)->field("logo")->find();
		$logo = $rel['logo'];
		$this->assign("logo",$logo);

		//判断该餐厅是否有开通餐桌二维码点餐
		$restaurant_id = session("restaurant_id");
		$condition['restaurant_id'] = $restaurant_id;
		$qrcModel = D("qrc_code");
		$qrc_code_info = $qrcModel->where($condition)->find();
		if($qrc_code_info){
			$qrc_condition['qrc_code_id'] = $qrc_code_info['qrc_code_id'];
			$qrc_device_model = D("qrc_device");
			$rel = $qrc_device_model->where($qrc_condition)->find();
			if($rel){
				$this->assign("qrc_order",1);
			}
		}

		$this->display();
	}

	public function verifyImg(){
		$config = array( 
			'imageW' => 160,
			'imageH' => 41,
			'fontSize'    =>    20,    // 验证码字体大小 
			'length'      =>    4,     // 验证码位数 
			'useNoise'    =>    false, // 关闭验证码杂点
			'fontttf' => '4.ttf', 
		);
		$Verify = new \Think\Verify($config);
		ob_clean();
		$Verify->entry();
	}
	
	public function login(){
		$re_admin_id = cookie("re_admin_id");
		if($re_admin_id){
			$this->assign("login_account",cookie("login_account"));
			$this->assign("password",cookie("password"));
			$this->assign("autoFlag",1);
		}
		$this->display();
	}
	
	//登录校验
	public function checklogin(){
		$verify = new \Think\Verify();
		$Vresult = $verify->check(I('code'));
		if($Vresult){
			$restaurant_manager = D('restaurant_manager');
			$condition['login_account'] = I('login_account');
			$result = $restaurant_manager->where($condition)->find();
			if($result){
				if($result['password'] == I('password')){
					if(I('autoFlag') == 1){
						cookie("re_admin_id",$result['id'],7*24*3600);
						cookie("login_account",$result['login_account'],7*24*3600);
						cookie("password",$result['password'],7*24*3600);
					}
					session("login_account",$result['login_account']);
					session('re_admin_id',$result['id']);
					session("restaurant_id",$result['restaurant_id']);
					session("login_way",I('login_way'));
					$msg['code'] = 1;
				}else{
					$msg['msg'] = "密码有误!";
					$msg['code'] = 0;
				}
			}else{
				$msg['msg'] = "用户不存在!";
				$msg['code'] = 0;
			}
		}else{
			$msg['msg'] = "验证码有错误!";
			$msg['code'] = 0;
		}
		exit(json_encode($msg));
	}
	
	//退出登录
	public function loginout(){
		session('re_admin_id',null);
		cookie('re_admin_id',null);
		cookie('login_account',null);
		cookie('password',null);
		$msg['msg'] = "退出成功";
		if(session("login_way") == 0){
			$msg['code'] = 0;
		}else{
			$msg['code'] = 1;
		}
		session("login_way",null);
		exit(json_encode($msg));
	}
	
	//帐号编辑前填充
	public function account_edit(){
		$restaurant_manager = D('restaurant_manager');
		$condition['id'] = I('get.id');
		$object = $restaurant_manager->where($condition)->find();
		$this->ajaxReturn($object);	
	}

//帐号编辑
	public function update_account(){
		$restaurant_manager = D('restaurant_manager');
		$data['id'] = I('post.manager_id');
		$data['login_account'] = I('post.manager_account');
		$data['password'] = I('post.manager_password');
		$r = $restaurant_manager->save($data);
		if($r){
			session('login_account',I('post.manager_account'));
			$msg['msg'] = "编辑成功";
			$msg['code'] = 1;
			$msg['data'] = I('post.manager_account');
		}else{
			$msg['msg'] = "编辑失败";
			$msg['code'] = 0;
		}	
		$this->ajaxReturn($msg);
	}
	
}