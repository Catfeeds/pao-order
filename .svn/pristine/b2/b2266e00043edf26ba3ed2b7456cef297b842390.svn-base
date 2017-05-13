<?php
namespace Mobile\Controller;
use Think\Controller;
use Think\Verify;

class IndexController extends Controller {
	private $is_security = false;
	//显示菜品分类列表
	public function index(){
		session("restaurant_id",I("get.restaurant_id"));
		session("desk_code",I("get.desk_code"));
		$restaurant_id = session("restaurant_id");

		$food_category = D('food_category');
		$category_time = D('category_time');
		$condition['restaurant_id'] = $restaurant_id;
		$condition['is_timing'] = 0;
		$arr = $food_category->where($condition)->order('sort asc')->select();	//首先查詢未設置定時的菜品分類
		//然後查詢有定時，且時間段符合當前時間的分類ID
		$where['restaurant_id'] = session('restaurant_id');
		$where['is_timing'] = 1;
		$food_categoryIdList =  $food_category->where($where)->field('food_category_id')->select();//所有所有开启定时的分类ID
		if($food_categoryIdList){                          //如果存在有分类开启了定时	
		$food_categoryNewIdList = array();                 //当前店铺开启了定时的菜品分类ID集合，array
		foreach($food_categoryIdList as $foodvv){
			$food_categoryNewIdList[] = $foodvv['food_category_id'];
		}
		
		//第一种时间段的查询
		$current_time = time();
		$t_condition['time1'] = array("lt",$current_time);
		$t_condition['time2'] = array("gt",$current_time);
		$t_condition['category_id'] = array("in",$food_categoryNewIdList);
		$category_ids = $category_time->where($t_condition)->distinct("category_id")->field("category_id")->select();   //查询当前时间符合时间段的分类ID
		if($category_ids){                  //如果存在，执行
			$category_id_list = array();
			foreach ($category_ids as $k => $v) {
				$index = "cid" . $v['category_id'];
				$category_id_list[$index] = $v['category_id'];
			}
		}
		//dump($category_id_list);

		//第二种星期段的查询
		$current_week = date("w");         
		$ftg_condition['timing_day'] = array("like", "%" . $current_week . "%");
		$ftg_condition['food_category_id'] = array("in",$food_categoryNewIdList);
		$category_timing_model = D("food_category_timing");
		$category_ids2 = $category_timing_model->where($ftg_condition)->distinct("food_category_id")->field("food_category_id,start_time,end_time")->select();
//
		$category_id_list2 = array();
		if ($category_ids2) {
			foreach ($category_ids2 as $kk => $vv) {
				$start_time = strtotime($vv['start_time']);
				$end_time = strtotime($vv['end_time']);
				if ($start_time < $current_time && $end_time > $current_time) {
					$index = "cid" . $vv["food_category_id"];
					$category_id_list2[$index] = $vv["food_category_id"];
				}
			}
		}
		//dump($category_id_list2);
		
		//合并两种情况下的分类ID
		if($category_id_list == null){
			$categoryIdsList = $category_id_list2;
		}else if($category_id_list2 == null){
			$categoryIdsList = $category_id_list;
		}else{
			$categoryIdsList = array_merge($category_id_list, $category_id_list2);
		}
		//dump($categoryIdsList);

		$lastCategoryIdsList = array();
		foreach ($categoryIdsList as $vvv) {
			$lastCategoryIdsList[] = $vvv;
		}
		//dump($lastCategoryIdsList);

		if($lastCategoryIdsList){    //如果存在分类ID，执行
			$l_condition['food_category_id'] = array("in", $lastCategoryIdsList);
			$arr2 = $food_category->where($l_condition)->select();
			//dump($arr2);
			$arr = array_merge($arr, $arr2);
		}
		}

		//dump($arr);
		$this->assign("info", $arr);

		$food = D('food');
			$food_category_relative = D('food_category_relative');
			if($arr){
			$foodIdArr = array();
			foreach($arr as $vinfo){
				$where1['food_category_id'] = $vinfo['food_category_id'];
				$foodIdList = $food_category_relative->where($where1)->field('food_id')->select();		
				foreach($foodIdList as $fil){
                    // 先判断关于该食物ID的订单在今天内所对应的份数是否已经超过额定的份数
                    $start=mktime(0,0,0,date("m"),date("d"),date("Y"));       //当天开启时间
                    $end=mktime(0,0,0,date('m'),date('d')+1,date('Y'))-1;     //当天结束时间

                    $Model = M(); // 实例化一个model对象 没有对应任何数据表
                    $num = $Model->query(" select t1.food_num as num from order_food t1 inner join
                        `order` t2 on t1.order_id = t2.order_id and t1.food_id = $fil[food_id] and t2.order_status in ('3','11','12')
                        and t2.pay_time between $start and $end");

                    if($num){
//                            dump($fil['food_id']);
                        $sum = 0;
                        foreach($num as $n){
                            $sum += $n['num'];
                        }
//                            dump($sum);

                        // 查询出该food_id对应多少限额
                        $fit_num = D("food")->where(array("food_id"=>$fil['food_id']))->getField("foods_num_day");
                        // dump($fit_num);
                        if($sum < $fit_num){
                            $foodIdArr[] = $fil['food_id'];     # 将食物ID放到一个数组里面
                        }
                        //  dump($num);
                    }else{
                        $foodIdArr[] = $fil['food_id'];     # 将食物ID放到一个数组里面
                    }
 				}
			}
			//dump($foodIdArr);
			
			//$f_condition['restaurant_id'] = session('restaurant_id');
			$f_condition['is_sale'] = 1;
			$f_condition['food_id'] = array("in",$foodIdArr);
			$arr1 = $food->where($f_condition)->select();
			//dump($arr1);
			$prom = D('prom');
			foreach($arr1 as $k1=>$v1){
				if($v1['is_prom'] == 1){
					$where2['prom_id'] = $v1['food_id'];
					/*$prom_start_time = $prom->where($where2)->field('prom_start_time')->find()['prom_start_time'];
					$prom_end_time = $prom->where($where2)->field('prom_end_time')->find()['prom_end_time'];*/
					$when_time = time();
					//dump($when_time);
					$where2['prom_start_time'] = array("lt",$when_time); 
					$where2['prom_end_time'] = array("gt",$when_time);//   prom_start_time<when_time<prom_end_time
					$prom_price = $prom->where($where2)->field('prom_price')->find()['prom_price'];
					if($prom_price){
						$prom_price = $prom_price;
					}else{
						$prom_price = $v1['food_price'];
					}
					//dump($prom_price);
				}else{
					$prom_price = $v1['food_price'];
				}
				$arr1[$k1]['food_price'] = $prom_price;
			}
			
			}
		//dump($arr1);
		$this->assign("info1", $arr1);

		$restaurant = D('Restaurant');
		$condition['restaurant_id'] = session("restaurant_id");
		$result = $restaurant->where($condition)->field('tplcolor2_id')->find();
		$wx_order_title = $restaurant->where($condition)->field('wx_order_title')->find()['wx_order_title'];
		$this->assign("wx_order_title",$wx_order_title);
		$this->assign("tpl",$result);
		

		$this->display();
	}

	//显示分类菜品信息
	public function showtypefood($type = 0){
		$food_category_relative = D('food_category_relative');
		$food = D('food');
		$condition['food_category_id'] = $type;
		$arr = $food_category_relative->where($condition)->select();
		//dump($arr);
		$food = D('food');
		$arrlist = array();
		//dump($arr);
		foreach ($arr as $v){
            // 先判断关于该食物ID的订单在今天内所对应的份数是否已经超过额定的份数
            $start=mktime(0,0,0,date("m"),date("d"),date("Y"));       //当天开启时间
            $end=mktime(0,0,0,date('m'),date('d')+1,date('Y'))-1;     //当天结束时间

            $Model = M(); // 实例化一个model对象 没有对应任何数据表
            $num = $Model->query(" select t1.food_num as num from order_food t1 inner join
                        `order` t2 on t1.order_id = t2.order_id and t1.food_id = $v[food_id] and t2.order_status in ('3','11','12')
                        and t2.pay_time between $start and $end");

            if($num) {
                // 当天到目前为止消费数量
                $sum = 0;
                foreach ($num as $n) {
                    $sum += $n['num'];
                }
                // 查询出该food_id对应多少限额
                $fit_num = D("food")->where(array("food_id" => $v['food_id']))->getField("foods_num_day");
                if($sum >= $fit_num){
                    continue;
                }
            }

			$condition1['food_id'] = $v['food_id'];
			$condition1['restaurant_id'] = session("restaurant_id");
			$condition1['is_sale'] = 1;
			$result = $food->where($condition1)->find();
			if($result){
				if($result['is_prom'] == 1){
					$prom = D('prom');
					$where2['prom_id'] = $v['food_id'];
					$when_time = time();
					$where2['prom_start_time'] = array("lt",$when_time); 
					$where2['prom_end_time'] = array("gt",$when_time);//   prom_start_time<when_time<prom_end_time
					$prom_price = $prom->where($where2)->field('prom_price')->find()['prom_price'];
					if($prom_price){
						$result['food_price'] = $prom_price;
					}else{
						$result['food_price'] = $result['food_price'];
					}
				}else{
					$result['food_price'] = $result['food_price'];
				}
				$arrlist[] = $result;
			}
		}
		//dump($arrlist);
		$this->assign("info2", $arrlist);
		$this->display('orderAjax');
	}

	//加载模态框
	public function findfoodinfo(){
		$food = D('food');
		$condition['food_id'] = I('get.food_id');
		$is_prom = $food->where($condition)->field('is_prom')->find()['is_prom'];
		$food_price = $food->where($condition)->field('food_price')->find()['food_price'];
		$prom = D('prom');
		if($is_prom == 1){
			$where2['prom_id'] = I('get.food_id');
			$when_time = time();
			$where2['prom_start_time'] = array("lt",$when_time); 
			$where2['prom_end_time'] = array("gt",$when_time);//   prom_start_time<when_time<prom_end_time
			$prom_price = $prom->where($where2)->field('prom_price')->find()['prom_price'];
			if($prom_price){
				$prom_price = $prom_price;
			}else{
				$prom_price = $food_price;
			}
		}else{
			$prom_price = $food_price;
		}
		
		$this->assign("food_price",$prom_price);
		
		
		//$arr = $food->where($condition)->field("food_id,food_name,food_img,food_price,food_desc")->find();
		$arr = $food->where($condition)->field("food_id,food_name,food_img,food_desc")->find();
		$this->assign("info3", $arr);
//		dump($arr);

		$attribute_type = D('attribute_type');
		$at_condition['food_id'] = $arr['food_id'];
		$at_list = $attribute_type->where($at_condition)->field('attribute_type_id,type_name,select_type')->select();
		$food_attribute = D('food_attribute');

		foreach ($at_list as $k => $v) {
			$fa_condition['attribute_type_id'] = $v['attribute_type_id'];
			$f_attr = $food_attribute->where($fa_condition)->field("food_attribute_id,attribute_name,attribute_price")->select();

			foreach($f_attr as $fok => $fov){
				$length = strlen($fov["attribute_name"]);
				if($length <= 12){
					$f_attr[$fok]['length_type'] = "attr-sm";
				}elseif($length > 12){
					$f_attr[$fok]['length_type'] = "attr-lg";
				}
			}

			$at_list[$k]["attrs"] = $f_attr;
		}
//		dump($at_list);
		$this->assign("at_list",$at_list);
//		exit;
		$this->display('orderPopup');
	}

	public function PlaceOrder(){
		$order = D('order');
		$order->startTrans();//开启事务
		$e_arr = I('post.');          //拿到右边记录列表数组

		$arr = array();
		foreach($e_arr as $e_k => $e_v){
			$temp['food_id'] = $e_v[0];
			$temp['food_num'] = $e_v[1];
			$temp['food_attr'] = str_replace("-","|",$e_v[2]);
			$temp['order_type'] = I("get.order_type");
			$arr[] = $temp;
		}

//		print_r($arr);
		$arraylist = array();       //单价数组
		$totallist = array();		//属性价数组
		$numberlist = array();		//份数数组

		$food = D('food');
		$food_attribute = D('food_attribute');

		foreach ($arr as $v) {//$arr右边多条记录，一条一条遍历
			$attlist = array();    //储存属性价格（一维数组）
			$food_attr_string = $v['food_attr'];
			$arr1 = explode('|', $food_attr_string, -1);//将属性以|分割成PHP一维数组

			foreach ($arr1 as $v1) {    //将属性一维数组遍历查询对应属性的价格
				$condition['food_attribute_id'] = (int)$v1;//
				//var_dump($condition);
				$att = $food_attribute->where($condition)->field('attribute_price')->find();
				$att = $att['attribute_price'];
				$attlist[] = $att;//将查询出的对应价格存进数组
			}
			$atttotal = array_sum($attlist);    //php、array_sum()可以将一维数组的值相加得到属性总价
			//unset($attlist);       //释放内存

			$totallist[] = $atttotal;     //购物车每条菜品记录的属性总和
			$condition['food_id'] = $v['food_id'];
			$is_prom = $food->where($condition)->field('is_prom')->find()['is_prom'];
			$foodlist = $food->where($condition)->field('food_price')->find()['food_price'];
			if($is_prom == 1){
				$prom = D('prom');
				$where2['prom_id'] = $v['food_id'];
				$when_time = time();
				$where2['prom_start_time'] = array("lt",$when_time); 
				$where2['prom_end_time'] = array("gt",$when_time);//   prom_start_time<when_time<prom_end_time
				$prom_price = $prom->where($where2)->field('prom_price')->find()['prom_price'];
				$foodlist = $prom_price;
			}else{
				$foodlist = $foodlist;
			}
			$foodlist = $foodlist;
			//var_dump($foodlist);
			$arraylist[] = (float)$foodlist;   //购物车每条菜品记录的单价
			$numberlist[] = (int)$v['food_num'];   //购物车每条菜品记录的份数
		}
		//var_dump($totallist);
		//var_dump($arraylist);
		//var_dump($numberlist);
		//单价一维数组与属性总价一维数组相加（对于坐标相加）
		$aLen = count($totallist);
		$bLen = count($arraylist);
		if ($aLen > $bLen) {
			$len = $aLen;
		} else {
			$len = $bLen;
		}
		$c = array();
		for ($i = 0; $i < $len; $i++) {
			$c[] = $totallist[$i] + $arraylist[$i];
		}
		//var_dump($c);
		//单价与属性相加后的价格一维数组与数目相乘（对于坐标相乘）
		$dLen = count($c);
		$eLen = count($numberlist);
		if ($dLen > $eLen) {
			$len = $dLen;
		} else {
			$len = $eLen;
		}
		$f = array();
		for ($i = 0; $i < $len; $i++) {
			$f[] = $c[$i] * $numberlist[$i];
		}
		//var_dump($f);
		$foodtotal = array_sum($f);
		//var_dump($foodtotal);
		//将查出来的对像Object，依次添加进数组里，形成二维数组
		//var_dump($arraylist);
		$start=mktime(0,0,0,date("m"),date("d"),date("Y"));       //当天开启时间
		$end=mktime(0,0,0,date('m'),date('d')+1,date('Y'))-1;     //当天结束时间
		$condition1['add_time'] = array("between",array($start,$end));     //开启时间与结束时间之间
		$condition1['restaurant_id'] = session("restaurant_id");     //店铺id

		$num = $order->where($condition1)->count();        //两时间之间的订单数
		$order_sn = "DC".str_pad(session('restaurant_id'),5,"0",STR_PAD_LEFT).date("ymdHis",time()).str_pad($num+1,5,"0",STR_PAD_LEFT);//订单号，$num+1表示最新一订单

		$add_time = time();            //下单时间
		$total_amount = $foodtotal;         //订单总价
		$condition2['order_sn'] = $order_sn; //订单号
		$condition2['add_time'] = $add_time; //下单时间
		$condition2['total_amount'] = $total_amount;  //订单总价
		$condition2['table_num'] = $arr[0]['table_num'] ? $arr[0]['table_num'] : 000;  //餐桌号
		$condition2['desk_code'] = session("desk_code");
		//$condition2['restaurant_id'] = session('restaurant_id');
		$condition2['restaurant_id'] = session("restaurant_id");
		if($arr[0]['order_type']){
			$condition2['order_type'] = $arr[0]['order_type']; //用餐方式
		}else{
			$condition2['order_type'] = 1;
		}
		$condition2['terminal_order'] = 3; //点餐方式，终端区别
		//dump($condition2);
		$result = $order->data($condition2)->add();//增加一条订单
		if(!$result){
			$order->rollback();
			exit;
		}
		$order_food = D('order_food');
		$food = D('food');
		$condition3['order_id'] = $result;
		//$result1list = array();
		$order_food_attribute = D('order_food_attribute');
		foreach($arr as $v2){
			$attlist1 = array();    //储存属性价格（一维数组）
			$condition3['food_id'] = $v2['food_id'];
			$food1 = $food->where("food_id=".$v2['food_id'])->find();
			$condition3['food_name'] = $food1['food_name'];
			$condition3['food_num']	= $v2['food_num'];
			$food_attr_string1 = $v2['food_attr'];
			$arrz = explode('|', $food_attr_string1, -1);//将属性以|分割成PHP一维数组
			foreach ($arrz as $v1){    //将属性一维数组遍历查询对应属性的价格
				$condition7['food_attribute_id'] = (int)$v1;//
				//var_dump($condition);
				$att1 = $food_attribute->where($condition7)->field('attribute_price')->find();
				$att1 = $att1['attribute_price'];
				$attlist1[] = $att1;//将查询出的对应价格存进数组
			}
			$atttotal1 = array_sum($attlist1);
			$condition3['food_price2']	= (float)$atttotal1+$food1['food_price'];
			$result1 = $order_food->add($condition3);
			if(!$result1){
				$order->rollback();
				exit;
			}
			$food_attr_string1 = $v2['food_attr'];
			$arr2 = explode('|', $food_attr_string1, -1);
//			var_dump($arr2);
			if($arr2[0] != 0){
				foreach($arr2 as $v3){
					//var_dump($v3);
					if($v3 == 0){
						$att1 = 0;
						$att2 = 0;
					}else{
						$condition4['food_attribute_id'] = (int)$v3;//
						$att1 = $food_attribute->where($condition4)->field('attribute_name')->find();
						$att1 = $att1['attribute_name'];
						$att2 = $food_attribute->where($condition4)->field('attribute_price')->find();
						$att2 = $att2['attribute_price'];
					}
					$p_condition5['food_attribute_id'] = (int)$v3;
					$attr_id = $food_attribute->where($p_condition5)->field('attribute_type_id')->find()['attribute_type_id'];
					if($attr_id){
						$attribute_type_model = D("attribute_type");
						$print_id = $attribute_type_model->where("attribute_type_id = $attr_id")->field("print_id")->find()['print_id'];
						$count_type = $attribute_type_model->where("attribute_type_id = $attr_id")->field('count_type')->find()['count_type'];
					}
					$condition5['food_attribute_name'] = $att1;
					$condition5['food_attribute_price'] = $att2;
					$condition5['print_id'] = $print_id;
					$condition5['count_type'] = $count_type;
					$condition5['order_food_id'] = $result1;
					$result2 = $order_food_attribute->add($condition5);
					if(!$result2){
						$order->rollback();
						exit;
					}
				}
			}

		}
		//var_dump($result);
		//var_dump($result1);
		//var_dump($result2);
		$rel = $order->commit();
		if($rel){
			$r_data["order_sn"] = $order_sn;
			$returnData["code"] = 1;
			$returnData["msg"] = "下单成功";
			$returnData['data'] = $r_data;
			exit(json_encode($returnData));
		}
	}

	public function pay()
	{
		$restaurant = D('Restaurant');
		$condition['restaurant_id'] = session("restaurant_id");
		$result = $restaurant->field('tplcolor_id')->find();
		$this->assign("tpl",$result);

		$orderModel = D("order");
		$o_condition['order_sn'] = I("get.order_sn");
		$rel = $orderModel->where($o_condition)->field("total_amount,order_sn,desk_code")->find();
//			dump($rel);
		$this->assign("order",$rel);
		$this->display("pay");

	}

	//联动、省
	public function address_edit(){
		$region = D('region');
		$condition['level'] = 1;
		$arr = $region->where($condition)->select();
		$this->assign('info',$arr);
		$this->display();
	}
	//联动、市、区
	public function selectaddress(){
		$region = D('region');
		$condition1['parent_id'] = I('get.parent_id');
		$arr2 = $region->where($condition1)->select();
		$this->ajaxReturn($arr2);
	}

	//发送验证码
	public function sendsms($phone=0){
		$num=rand(1000,9999); //生成4位随机数验证码
		$_SESSION['Verify_Code'] = $num;   //将4位验证码保存在session里
		sendTemplateSMS($phone,array($num,3),"1");
	}

	//测试
	public function test(){
		print_r($_SESSION);
		$ses =  $_SESSION['Verify_Code'];
		echo $ses;

	}

	/*public function verifyImg(){
		$verify = new \Think\Verify();
		$verify->entry();
	}*/

	//手机端用户注册
	public function userRegister(){
		$ses =  $_SESSION['Verify_Code'];
		//echo $ses;
		$phone_code = I('post.phone_code');
		//	dump(I('post.phone_code'));
		if((int)$ses == (int)$phone_code){
			$user = D('user');
			$data['phone'] = I('post.phone');
			$arr = $user->where($data)->select();
			if(!$arr){
				$condition['phone'] = I('post.phone');
				$condition['password'] = I('post.password');
				$r = $user->add($condition);
				if($r){
					$msg['msg'] = "注册成功！";
					$msg['data'] = 1;
				}else{
					$msg['msg'] = "注册失败！";
					$msg['data'] = 0;
				}
			}else{
				$msg['msg'] = "此手机号已被注册！";
			}
		}else{
			$msg['msg'] = "验证码错误！";

		}
		exit(json_encode($msg));
	}

	//手机端用户登录
	public function userlogin(){
		$condition['phone'] = I('get.phone');
		$condition['password'] = I('get.pwd');
		$user = D('user');
		$r = $user->where($condition)->select();
		//dump($r);
		if($r){
			$msg['msg'] = "登录成功!";
			$msg['data'] = 1;
			$_SESSION['phone'] = $r[0]['phone'];
			$_SESSION['id'] = $r[0]['id'];
		}else{
			$msg['msg'] = "登录失败!";
			$msg['data'] = 0;
		}
		exit(json_encode($msg));
	}

	//个人中心
	public function user(){
		$phone = $_SESSION['phone'];
		$this->assign("sessionphone",$phone);
		//dump($phone);
		$user_address = D('user_address');
		$region = D('region');
		$arr = $user_address->order('id desc')->limit(1)->select();
		foreach($arr as $a){
			$condition['id'] = $a['city1'];
			$condition2['id'] = $a['city2'];
			$condition3['id'] = $a['city3'];
			$city1 = $region->where($condition)->find();
			$city2 = $region->where($condition2)->find();
			$city3 = $region->where($condition3)->find();
			$address = $city1['name'].$city2['name'].$city3['name'].$a['address'];
		}
		//dump($address);
		$this->assign("address",$address);
		$this->display();
	}

	//新增地址
	public function addAddress(){
		$user_address = D('user_address');
		$data['addressee'] = I('post.username');
		$data['addnumber'] = I('post.phone');
		$data['address'] = I('post.address');
		$data['user_id'] = $_SESSION['id'];
		$data['city1'] = I('post.city');
		$data['city2'] = I('post.city2');
		$data['city3'] = I('post.city3');
		$r = $user_address->add($data);
		if($r){
			$msg['msg'] = "新增地址成功!";
			$msg['data'] = 1;
		}else{
			$msg['msg'] = "新增地址失败!";
			$msg['data'] = 0;
		}
		exit(json_encode($msg));
	}

	//删除地址
	public function deladdress(){
		$user_address = D('user_address');
		$condition['id'] = I('get.addrid');
		$r = $user_address->where($condition)->delete();
		if($r){
			$msg['msg'] = "删除成功";
			$msg['data'] = 1;
		}else{
			$msg['msg'] = "删除失败";
			$msg['data'] = 0;
		}
		exit(json_encode($msg));
	}

	//地址列表
	public function address(){
		$user_address = D('user_address');
		$arr = $user_address->select();
		$region = D('region');
		$arrlist = array();
		$arrlist1 = array();
		foreach($arr as $a){
			//dump($a['city1']);
			$condition['id'] = $a['city1'];
			$condition2['id'] = $a['city2'];
			$condition3['id'] = $a['city3'];
			$city1 = $region->where($condition)->find();
			$city2 = $region->where($condition2)->find();
			$city3 = $region->where($condition3)->find();
			$arrlist['address'] = $city1['name'].$city2['name'].$city3['name'].$a['address'];
			$arrlist['name'] = $a['addressee'];
			$arrlist['phone'] = $a['addnumber'];
			$arrlist['id'] = $a['id'];
			$arrlist1[] = $arrlist;
		}
		//dump($arrlist1);
		$this->assign("info",$arrlist1);
		$this->display();
	}

	//编辑地址前的填充
	public function modifyaddr(){
		$user_address = D('user_address');
		$condition['id'] = I('post.addrid');
		$arr = $user_address->where($condition)->find();
		//dump($arr);
		if($arr){
			exit(json_encode($arr));
		}

	}

	//编辑地址
	public function updateaddr(){
		$user_address = D('user_address');
		$condition['id'] = I('post.id');
		$condition['addressee'] = I('post.username');
		$condition['addnumber'] = I('post.phone');
		$condition['city1'] = I('post.city');
		$condition['city2'] = I('post.city2');
		$condition['city3'] = I('post.city3');
		$condition['address'] = I('post.address');
		$r = $user_address->save($condition);
		if($r){
			$msg['msg'] = '编辑成功！';
			$msg['data'] = 1;
		}else{
			$msg['msg'] = '编辑失败！';
			$msg['data'] = 0;
		}
		exit(json_encode($msg));
	}

	//重置密码
	public function resetpwd(){
		$ses =  $_SESSION['Verify_Code'];
		$phone_code = I('post.phone_code');
		//	dump(I('post.phone_code'));
		if((int)$ses == (int)$phone_code){
			$user = D('user');
			$condition['phone'] = I('post.phone');
			$info = $user->where($condition)->find();
			$condition1['id'] = $info['id'];
			$condition1['password'] = I('post.password');
			$r = $user->save($condition1);
			if($r){
				$msg['msg'] = "密码重置成功！";
				$msg['data'] = 1;
			}else{
				$msg['msg'] = "密码重置失败！";
				$msg['data'] = 0;
			}
		}else{
			$msg['msg'] = "验证码错误！";

		}
		exit(json_encode($msg));
	}

//获取订单状态
	public function getOrderStatus(){
		$order_sn = I("post.order_sn");
//		dump($order_sn);
		$orderModel = D("order");
		$o_condition['order_sn'] = $order_sn;
		$order = $orderModel->where($o_condition)->find();
		$order_status = $order['order_status'];
//		dump($order_status);
		if($order_status == 3){
			$data['code'] = 1;
			$data['msg'] ='支付成功';
			exit(json_encode($data));
		}
	}

	//判断当前客户端是微信还是支付宝
	//1：微信   2：支付宝   0：既不是支付宝也不是微信
	public function IsWeixinOrAlipay(){
		//判断是不是微信
		if (strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false ) {
			$returnMsg['returnMsg'] = "weixin";
			exit(json_encode($returnMsg));
		}
		//判断是不是支付宝
		if (strpos($_SERVER['HTTP_USER_AGENT'], 'AlipayClient') !== false) {
			$returnMsg['returnMsg'] = "ali";
			exit(json_encode($returnMsg));
		}
		//哪个都不是
		$returnMsg['returnMsg'] = "other";
		exit(json_encode($returnMsg));
	}

	public function finish(){
		$restaurant_id = I("restaurant_id");
		$restaurant_model = D("restaurant");
		$condition['restaurant_id'] = $restaurant_id;

		$rel = $restaurant_model->where($condition)->field("restaurant_name")->find();
		$restaurant_name = $rel['restaurant_name'];

		$this->assign("restaurant_name",$restaurant_name);

		$this->display();
	}
}