<?php
namespace Admin\Controller;
use Think\Controller;

class DishesController extends Controller{
    public function __construct(){
        Controller::__construct();
        $admin_id = session("re_admin_id");
        if(!$admin_id){
            redirect("Index/login");
        }

        $restaurant_manager_model = D('restaurant_manager');
        $restaurant_id = $restaurant_manager_model->where("id = $admin_id")->field("restaurant_id")->find()['restaurant_id'];
        session('restaurant_id',$restaurant_id);
    }

    //查看所有菜品分类
    public function index(){
        $dishes = D('food_category');
        $condition['restaurant_id'] = session("restaurant_id");
        $arr = $dishes->where($condition)->order('sort asc')->select();
        $this->assign('data', $arr);
        $food = D('food');
        $count = $food->where($condition)->count();	
        $p = I('page') ? I('page'): 1;
        $pageNum = 8;
        $Page  = new \Think\PageAjax($count,$pageNum);// 实例化分页类 传入总记录数和每页显示的记录数
        $show = $Page->show();// 分页显示输出
        $this->assign('page',$show);// 赋值分页输出
        $food_list = $food->where($condition)->page($p,$pageNum)->order('sort asc')->select();
        $this->assign('info',$food_list);
        $this->display();
    }
	
	//菜品分类操作后的ajax页面刷新
	public function food_category_ajax(){
		 $dishes = D('food_category');
         $ff_condition['restaurant_id'] = session('restaurant_id');
         $arr = $dishes->where($ff_condition)->order('sort asc')->select();
         $this->assign('data', $arr);
         $this->display('showcategory');
	}

	//操作菜品页面后ajax刷新页面
	public function dishes_ajax(){
        $food = D('food');
		$condition['restaurant_id'] = session("restaurant_id");
		$p = I('p') ? I('p'): 1;
        $count = $food->where($condition)->count();	
        $pageNum = 8;
		$page  = new \Think\PageAjax($count,$pageNum);// 实例化分页类 传入总记录数和每页显示的记录数
		$food_list = $food->where($condition)->order('sort asc')->page($p,$pageNum)->select();
		$this->assign('info',$food_list);       
        $page2 = $page->show();// 分页显示输出
        $this->assign('page',$page2);// 赋值分页输出   
        $this->display('showfoodinfo');
	}

	//分页
    public function deskInfo(){
        $food = D('food');
        $condition['restaurant_id'] = session('restaurant_id');
        $pp = I("get.page");
        $p = I("get.page") ? I("get.page") : 1;
        $count = $food->where($condition)->count();
        $page_num = 8;
        $page = new \Think\PageAjax($count,$page_num);
        $food_list = $food->where($condition)->order('sort asc')->page($p,$page_num)->select();//传入当前页数，与每页显示的行数
        $this->assign('info',$food_list);
        $page2 = $page->show();
        $this->assign('page',$page2);
        if($pp == ""){
            $this->display('index');
        }else{
            $this->display('showfoodinfo');
        }
    }
    
    //分页2
    public function deskInfo2(){
    	$relative = D('food_category_relative');
        $map['food_category_id'] = I('get.food_category_id');;
        $count = $relative->where($map)->count();
     	$p = I("page") ? I("page") : 1;
        $pageNum = 8;
        $Page  = new \Think\PageAjax($count,$pageNum);// 实例化分页类 传入总记录数和每页显示的记录数
        $show = $Page->show();// 分页显示输出
        $this->assign('page',$show);// 赋值分页输出
        $arr = $relative->where($map)->page($p,$pageNum)->select();
        $food_list = array();
        $foodModel = D('food');
        $dishes = D('food_category');
        foreach ($arr as $v) {
            $condition['food_id'] = $v['food_id'];
            $food_category_id = $v['food_category_id'];
            $food_info = $foodModel->where($condition)->find(); 
            $food_type = $dishes->where("food_category_id = $food_category_id")->field("food_category_name")->find()['food_category_name'];
            $food_info['id'] = $v['id'];
            $food_info['food_category_id'] = $v['food_category_id'];
            $food_info['food_category_name'] = $food_type;
            $food_list[] = $food_info;
        }
		$sortArr = array();
		foreach($food_list as $v1){
			$sortArr[] = $v1['sort'];
		}
		array_multisort($sortArr, SORT_ASC, $food_list);
      	$this->assign("info",$food_list);
     	$this->display("showfoodinfo1");
    }
    
    
	//新增菜品分类
    public function createDishetype(){
        $dishes = D('food_category');
        $dishes->startTrans();         
	        /*if ($_FILES['file'] != null) {
	            if ($_FILES['file']['error'] != 4) {
	                $upload = new \Think\Upload();// 实例化上传类
	                $upload->maxSize = 3145728;// 设置附件上传大小
	                $upload->exts = array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
	                $upload->savePath = 'upcategory/'; // 设置附件上传目录
	                $upload->autoSub = false;
	                $z = $upload->upload();
	                //dump($z);
	                $picpathname = './Application/Admin/Uploads/' . $z[file]['savepath'] . $z[file]['savename'];
	                //dump($picpathname);
	                $_POST['image'] = $picpathname;
	
	            } else {
	                $_POST['image'] = "./Application/Admin/Uploads/default/a1.jpg";
	            }
	        } else {
	            $_POST['image'] = "./Application/Admin/Uploads/default/a1.jpg";
	        }*/	
        $info = $dishes->create();
		$restaurant_id = session('restaurant_id');
		$category_num = $dishes->where("restaurant_id=$restaurant_id")->max('sort');    # 找出最大的排序号
		$info['sort'] = str_pad($category_num+1,3,"0",STR_PAD_LEFT);   //排序号           #　把字符串填充为新的长度　
        $info['restaurant_id'] = $restaurant_id;
        $line = $dishes->add($info);
        if($line !== false){
            $time = $_POST["time"];
            if($time){
                $categoryTimeModel = D('category_time');
                $time = json_decode($time);
                foreach($time as $t_key => $t_val){
                    if($t_val[0] && $t_val[1]){
//                                echo 111;
                        $t_condition['time1'] = strtotime($t_val[0]);
                        $t_condition['time2'] = strtotime($t_val[1]);
                        $t_condition['category_id'] = $line;
                        $result1 = $categoryTimeModel->add($t_condition);
                    }
                }
            }
            $day = $_POST["day"];      # day从哪里传递过来？
            if($day){
                $day = json_decode($day);
//                        var_dump($day);
                $food_category_Model = D('food_category_timing');
                foreach($day as $d_key => $d_val){
                    $length = count($d_val);
//                            var_dump($length);
                    if($length > 2){
                        $d_data['timing_day'] = '';
                        for($i = 0;$i<$length-2;$i++){
                            if($i == ($length-3) ){
                                $d_data['timing_day'] .= $d_val[$i];
                            }else{
                                $d_data['timing_day'] .= $d_val[$i]."-";
                            }
                        }
                        $d_data['start_time'] = $d_val[$length-2];
                        $d_data['end_time'] = $d_val[$length-1];
                        $d_data['food_category_id'] = $line;
//                                var_dump($d_data);
                        $food_category_Model->add($d_data);
                    }
                }
            }
            $dishes->commit();

            // 删除相关的静态页
            $dianpu_id = session('restaurant_id');
            @ unlink(HTML_PATH . "$dianpu_id/order.html");  // 删除订单页

        	$this->food_category_ajax();
        }else{
            $dishes->rollback();
           // unlink($_POST['image']);
            $this->error('分类添加失败');
        }
    }

    //删除菜品类别
    public function delDishestype(){
        $id = I("get.food_category_id");
		//先判断该菜品分类下是否存在food_category_relative(第三表的关联信息)，如果存在，提示无法删除，不存在再继续下一步
		$food_category_relative = D('food_category_relative');
		$result1 = $food_category_relative->where("food_category_id=$id")->select();
		//dump($result1);
		if(!$result1){						//如果分类下不存在子集（即菜品与分类的关联）
	        $category_time = D("category_time");
	        $arr = $category_time->where("category_id=$id")->select();
			if($arr){
		        foreach($arr as $a){
		        	$condition['id'] = $a['id'];
		        	$category_time->where($condition)->delete();         				//删除关联时间段表的关联
		        }
			}

			$food_category_timing = D('food_category_timing');
			$food_category_timingArr = $food_category_timing->where("food_category_id=$id")->select();
			if($food_category_timingArr){
				foreach($food_category_timingArr as $value){
					$condition1['food_category_timing_id'] = $value['food_category_timing_id'];
					$food_category_timing->where($condition1)->delete();				//删除关联星期段表的关联
				}
			}
			$food_category = D('food_category');
			$food_category->where("food_category_id=$id")->delete();


            // 删除相关的静态页
            $dianpu_id = session('restaurant_id');
            @ unlink(HTML_PATH . "$dianpu_id/order.html");  // 删除订单页

            // 删除菜品分类ID对应的缓存文件
            @ unlink(HTML_PATH . "$dianpu_id/orderAjax".$id.".html");


			$this->food_category_ajax();
		}else{
			$code = 1;
			echo $code;
		}
    }

   //将要修改的菜品分类信息填充表单
    public function updDishestype()
    {
        $id = $_POST['food_category_id'];
        $dishes = D('food_category');
        $di_condition['restaurant_id'] = session("restaurant_id");
        $info = $dishes->where($di_condition)->find($id);

        $food_categoryModel = D("category_time");
        $t_condition['category_id'] = $info['food_category_id'];
        $categoryTimeList = $food_categoryModel->where($t_condition)->select();
        if($categoryTimeList){
            foreach($categoryTimeList as $k => $v){
                $categoryTimeList[$k]['time1'] = date("Y-m-d H:i:s",$v['time1']);
                $categoryTimeList[$k]['time2'] = date("Y-m-d H:i:s",$v['time2']);
            }
            $info['category_time'] = $categoryTimeList;
        }

        $food_category_timing_Model = D('food_category_timing');
        $tim_condition['food_category_id'] = $info['food_category_id'];
        $category_timing = $food_category_timing_Model->where($tim_condition)->select();

        if($category_timing){
            foreach($category_timing as $key => $val){
                $category_timing[$key]['timing_day'] = explode("-",$val['timing_day']);
            }
            $info['category_timing'] = $category_timing;
        }
        $this->ajaxReturn($info);
    }


		//编辑菜品分类
    public function modifyDishestype(){
        $dishes = D('food_category');
        $dishes->startTrans();
       /* if($_FILES['file'] != null){
            if ($_FILES['file']['error'] != 4){
                $temp_image = $dishes->where("food_category_id = $id")->field("image")->select();
                $image_addr = $temp_image[0]['image'];
                if($image_addr != "./Application/Admin/Uploads/default/a1.jpg"){
                    unlink($image_addr);
                }
                $upload = new \Think\Upload();// 实例化上传类
                $upload->maxSize   =     3145728 ;// 设置附件上传大小
                $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
                $upload->savePath  =      'upcategory/'; // 设置附件上传目录
                $upload->autoSub = false;
                $z   =   $upload->upload();
                //dump($z);
                $picpathname = './Application/Admin/Uploads/'.$z[file]['savepath'] . $z[file]['savename'];
                //dump($picpathname);
                $_POST['image'] = $picpathname;

            }else{

                $temp_image = $dishes->where("food_category_id = $id")->field("image")->select();
                $image_addr = $temp_image[0]['image'];
                $_POST['image'] = $image_addr;
            }
        }else{
            $temp_image = $dishes->where("food_category_id = $id")->field("image")->select();
            $image_addr = $temp_image[0]['image'];
            $_POST['image'] = $image_addr;
        }*/
        $food_category_id = I('post.food_category_id');
        $condition['food_category_id'] = I('post.food_category_id');
        $condition['restaturant_id'] = session('restaurant_id');
        $condition['food_category_name'] = I('post.food_category_name');
		$condition['is_timing'] = I('post.is_timing');
        //$condition['image'] = $_POST['image'];
        $line = $dishes->save($condition);
        if($line !== false){
            $time = $_POST["time"];
            if($time){
                $categoryTimeModel = D('category_time');
                $wt_condition['category_id'] = $food_category_id;
                $categoryTimeModel->where($wt_condition)->delete();
                $time = json_decode($time);
                foreach($time as $t_key => $t_val){
                    if($t_val[0] && $t_val[1]){
                        $t_condition['time1'] = strtotime($t_val[0]);
                        $t_condition['time2'] = strtotime($t_val[1]);
                        $t_condition['category_id'] = $food_category_id;
                        $result1 = $categoryTimeModel->add($t_condition);
                    }
                }
            }

            $day = $_POST["day"];
            if($day){
                $day = json_decode($day);
                $food_category_Model = D('food_category_timing');
                $wd_data['food_category_id'] = $food_category_id;
                $food_category_Model->where($wd_data)->delete();
                foreach($day as $d_key => $d_val){
                    $length = count($d_val);
                    if($length > 2){
                        $d_data['timing_day'] = '';
                        for($i = 0;$i<$length-2;$i++){
                            if($i == ($length-3) ){
                                $d_data['timing_day'] .= $d_val[$i];
                            }else{
                                $d_data['timing_day'] .= $d_val[$i]."-";
                            }
                        }
                        $d_data['start_time'] = $d_val[$length-2];
                        $d_data['end_time'] = $d_val[$length-1];
                        $d_data['food_category_id'] = $food_category_id;
                        $food_category_Model->add($d_data);
                    }
                }
            }
            $dishes->commit();

            // 删除相关的静态页
            $dianpu_id = session('restaurant_id');
            @ unlink(HTML_PATH . "$dianpu_id/order.html");  // 删除订单页

            // 删除菜品分类ID对应的缓存文件
            @ unlink(HTML_PATH . "$dianpu_id/orderAjax".$food_category_id.".html");


            $this->food_category_ajax();
        }else{
            $dishes->rollback();

        }
    }


    //通过条件显示相关条件下所有菜单信息
    public function showDisinfoBykey(){
        $relative = D('food_category_relative');       
        $map['food_category_id'] = I('get.food_category_id');
        $count = $relative->where($map)->count();
        $p = I('p') ? I('p'): 1;
        $pageNum = 8;
        $Page  = new \Think\PageAjax($count,$pageNum);// 实例化分页类 传入总记录数和每页显示的记录数  
        $show = $Page->show();// 分页显示输出
        $this->assign('page',$show);// 赋值分页输出
        $arr = $relative->where($map)->page($p,$pageNum)->select();
        $food_list = array();
        $foodModel = D('food');
        $dishes = D('food_category');
        foreach ($arr as $v) {
            $condition['food_id'] = $v['food_id'];
            $food_category_id = $v['food_category_id'];
            $food_info = $foodModel->where($condition)->find(); 
            $food_type = $dishes->where("food_category_id = $food_category_id")->field("food_category_name")->find()['food_category_name'];
            $food_info['id'] = $v['id'];
            $food_info['food_category_id'] = $v['food_category_id'];
            $food_info['food_category_name'] = $food_type;
            $food_list[] = $food_info;
        }
		$sortArr = array();
		foreach($food_list as $v1){
			$sortArr[] = $v1['sort'];
		}
		array_multisort($sortArr, SORT_ASC, $food_list);
		//dump($food_list);	
      	$this->assign("info",$food_list);
     	$this->display("showfoodinfo1");
    }

//-------------------------------------------------菜品--------------------------------------------
    //新增菜品页面
    public function add(){
        //获取店铺分区信息
        $district_model = D("restaurant_district");
        $district_where['restaurant_id'] = session("restaurant_id");
        $district_list = $district_model->where($district_where)->field("district_id,district_name")->select();
        $district_list[] = array(
            "district_id" => 0,
            "district_name" => "不设分区",
        );
        $this->assign("district_list",$district_list);

        $dishes = D('food_category');
        $condition['restaurant_id'] = session('restaurant_id');
        $arr = $dishes->where($condition)->order('sort asc')->select();
        $printerModel = D("printer");
        $p_condition['restaurant_id'] = session("restaurant_id");
        $printList = $printerModel->where($p_condition)->select();
        $this->assign("printerList",$printList);
        $this->assign('data', $arr);
        $this->display("addDishes");
    }
	
	//菜品关联表的ajax刷新
	public function food_ajax1(){
        $relative = D('food_category_relative');       
        $map['food_category_id'] = I('food_category_id');
		//dump(I('food_category_id'));
        $count = $relative->where($map)->count();
        $p = I('p') ? I('p'): 1;
		//dump($p);
        $pageNum = 8;
        $Page  = new \Think\PageAjax($count,$pageNum);// 实例化分页类 传入总记录数和每页显示的记录数  
        $show = $Page->show();// 分页显示输出
        $this->assign('page',$show);// 赋值分页输出
        $arr = $relative->where($map)->page($p,$pageNum)->select();
        $food_list = array();
        $foodModel = D('food');
        $dishes = D('food_category');
        foreach ($arr as $v) {
            $condition['food_id'] = $v['food_id'];
            $food_category_id = $v['food_category_id'];
            $food_info = $foodModel->where($condition)->find();
            $food_type = $dishes->where("food_category_id = $food_category_id")->field("food_category_name")->find()['food_category_name'];
            $food_info['id'] = $v['id'];
            $food_info['food_category_id'] = $v['food_category_id'];
            $food_info['food_category_name'] = $food_type;
            $food_list[] = $food_info;
        }
      	$this->assign("info",$food_list);
     	$this->display("showfoodinfo1");
	}

    //新增菜品
    public function createfoodinfo()
    {
        $food = D('Food');
        if (!empty($_POST)){
            $food->startTrans();
            if($_FILES['food_pic']['error'] != 4){     //图片上传
              	$upload = new \Think\Upload();// 实例化上传类
                $upload->maxSize = 3145728;// 设置附件上传大小
                $upload->exts = array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
                $upload->savePath = 'upfoodimg/'; // 设置附件上传目录
                $upload->autoSub = false;
                $z = $upload->upload();
                $picpathname = './Application/Admin/Uploads/' . $z[food_pic]['savepath'] . $z[food_pic]['savename'];
                $_POST['food_pic'] = $picpathname;
            }
			$restaurant_id = session('restaurant_id');
			//表单数据
			$data['food_name'] = $_POST['food_name'];
            $data['food_img'] = $_POST['food_pic'];
            $data['discount'] = $_POST['discount'];
            $data['food_price'] = $_POST['food_price'];
			$data['star_level'] = $_POST['star_level'];
           	$data['hot_level'] = $_POST['cayenne'];
            $data['foods_num_day'] = $_POST['foods_num_day'];
            $data['food_desc'] = $_POST['food_desc'];
			$data['is_prom'] = $_POST['is_prom'];
            $data['print_id'] = $_POST['print_id'];
            $data['district_id'] = $_POST['district'];
            $data['restaurant_id'] = $restaurant_id;
			$num = $food->where("restaurant_id=$restaurant_id")->max('sort');
			$data['sort'] = str_pad($num+1,3,"0",STR_PAD_LEFT);   //排序号
			//dump($data);
            $r = $food->add($data);
            //如果出现错误，则事务回滚
            if($r != false){
                $relative = D('food_category_relative');
	            $data2['food_id'] = $r;
	            $sort1 = $_POST['sort1'];       # $sort1菜品所属的菜品分类（一个或者多个），是个数组形式
	            foreach ($sort1 as $so){
	                $data2['food_category_id'] = $so;
	                $r2 = $relative->add($data2);
	            }
            }else{
            	$food->rollback();
                $msg['code'] = "0";
                $msg['msg'] = "失败";
                exit(json_encode($msg));
            }
			if($_POST['is_prom'] == 1){
            $prom = D('prom');
            $data1['prom_id'] = $r;
            $data1['prom_price'] = $_POST['prom_price'];
            $data1['discount'] = $_POST['prom_discount'];
            $data1['prom_goods_num'] = $_POST['prom_goods_num'];;
            $data1['prom_start_time'] = strtotime($_POST['prom_start_time']);
            $data1['prom_end_time'] = strtotime($_POST['prom_end_time']);
            $r1 = $prom->add($data1);
           		//如果出现错误，则事务回滚
		        if($r1 === false){
		            $food->rollback();
		            $msg['code'] = "0";
		            $msg['msg'] = "失败";
		            exit(json_encode($msg));
		        }
			}

			$condition['restaurant_id'] = session('restaurant_id');
			$tr_Num = $food->where($condition)->count();
			$page_Num = ceil($tr_Num/8);
            $msg['code'] = "1";
            $msg['msg'] = "菜品新增成功，请在下方添加菜品附属类别";
            $msg['food_id'] = $r;
			$msg['page_Num'] = $page_Num;
			$food->commit();

            // 删除相关的静态页
            $dianpu_id = session('restaurant_id');
            @ unlink(HTML_PATH . "$dianpu_id/order.html");  // 删除订单页
            // 循环删除对应分类ID的分类内容缓存页
            foreach($sort1 as $cat_id){
                @ unlink(HTML_PATH . "$dianpu_id/orderAjax".$cat_id.".html");
            }

            exit(json_encode($msg));
        }
    }

    /**
     * 添加菜品属性类别
     */
    public function addDishesAttrType(){
        $attr_type_model = D("attribute_type");
        $data = $attr_type_model->create();
        $data['restaurant_id'] = session("restaurant_id");
        $rel = $attr_type_model->add($data);
        if($rel !== false){

            $dianpu_id = session("restaurant_id");
            // 删除模态框静态文件
            @ unlink(HTML_PATH .  "$dianpu_id/orderPopup".$data['food_id'].".html");

            $data['attribute_type_id'] = $rel;
            $msg['code'] = 1;
            $msg['msg'] = "操作成功";
            $msg['data'] = $data;
            exit(json_encode($msg));
        }
    }

    public function addDishesAttr(){
        $attrModel = D("food_attribute");
        $data1 = $attrModel->create();
        $data['attribute_type_id'] = $data1['attribute_type_id'];
        $data['attribute_name'] = $data1['attribute_name'];
        $data['attribute_price'] = $data1['attribute_price'];

        /*$data['attribute_img'] = getcwd()."/Public/images/dishes01.png";

        if ($_FILES['attribute_img']['error'] != 4){
            $upload = new \Think\Upload();// 实例化上传类
            $upload->maxSize = 3145728;// 设置附件上传大小
            $upload->exts = array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
            $upload->savePath = 'upfoodattr/'; // 设置附件上传目录
            $upload->autoSub = false;
            $z = $upload->upload();
            //dump($z);	
            $picpathname = './Application/Admin/Uploads/' . $z[attribute_img]['savepath'] . $z[attribute_img]['savename'];
           // dump($picpathname);
            $data['attribute_img'] = $picpathname;

        }*/

        $rel = $attrModel->add($data);
        if($rel !== false){

            $dianpu_id = session("restaurant_id");
            // 删除模态框静态文件
            // 利用attribute_type_id去获取food_id
            $attr_type = D("attribute_type");
            $food_id = $attr_type->where(array("attribute_type_id"=>$data1['attribute_type_id']))->getField("food_id");
            @ unlink(HTML_PATH ."$dianpu_id/orderPopup".$food_id.".html");

            $data['food_attribute_id'] = $rel;
            $msg['code'] = 1;
            $msg['msg'] = "操作成功";
            $msg['data'] = $data;
            exit(json_encode($msg));
        }
    }

	public function getDishesAttr(){
		$attrModel = D("food_attribute");
		$food_attribute_id = I('get.food_attribute_id');
		$attrObject = $attrModel->where("food_attribute_id=$food_attribute_id")->find();
		$this->ajaxReturn($attrObject);
	}

    public function editDishesAttr(){
        $attrModel = D("food_attribute");
        $data1 = $attrModel->create();
        $data['food_attribute_id'] = $data1['food_attribute_id'];
        $data['attribute_name'] = $data1['attribute_name'];
        $data['attribute_price'] = $data1['attribute_price'];

       /* if ($_FILES['attribute_img']['error'] != 4){
            $upload = new \Think\Upload();// 实例化上传类
            $upload->maxSize = 3145728;// 设置附件上传大小
            $upload->exts = array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
            $upload->savePath = 'upfoodimg/'; // 设置附件上传目录
            $upload->autoSub = false;
            $z = $upload->upload();
            //dump($z);
            $picpathname = './Application/Admin/Uploads/' . $z[food_pic]['savepath'] . $z[food_pic]['savename'];
            //dump($picpathname);

            $data['attribute_img'] = $picpathname;

        }
        $data['attribute_img'] = getcwd()."/Public/images/dishes01.png";*/

        $rel = $attrModel->save($data);
        if($rel !== false){

            // 删除对应的模态框静态文件
            $dianpu_id = session("restaurant_id");
            // 利用attribute_type_id去获取food_id
            $attr_type = D("attribute_type");
            // 先通过food_attribute_id去获取attribute_type_id
            $attribute_type_id = $attrModel->where(array("food_attribute_id"=>$data1['food_attribute_id']))->getField("attribute_type_id");
            $food_id = $attr_type->where(array("attribute_type_id"=>$attribute_type_id))->getField("food_id");
            @ unlink(HTML_PATH ."$dianpu_id/orderPopup".$food_id.".html");

//            $data['food_attribute_id'] = $rel;
            $msg['code'] = 1;
            $msg['msg'] = "操作成功";
            $msg['data'] = $data;
            exit(json_encode($msg));
        }
    }

     //删除菜品
    public function delfoodinfo(){
        # 缓存   在还没删除数据库的数据前获取到其分类ID
        $fcr = D("food_category_relative");
        $result = $fcr->where(array("food_id"=>I("get.food_id")))->select();
        # 缓存

       	$food = D('food');
       	$food->startTrans();   //开启事务
       	$food_category_relative = D('food_category_relative');  //菜品表与菜品分类关联第三个表     	
	    $condition['food_id'] = I('get.food_id');
		$result1 =  $food_category_relative->where($condition)->delete(); //先删除菜品表与菜品分类关联的第三个表
		
	    $prom = D('prom');
	    $condition1['prom_id'] = I('get.food_id');
	   	$result2 = $prom->where($condition1)->delete();    //删除菜品定时表
	

        $addr_img = $food->where($condition)->field('food_img')->find()['food_img']; //先找到菜品图片
        if($addr_img != "./Application/Admin/Uploads/default/default_foodimg.jpg"){
        	 unlink($addr_img);						//菜品删除图片
        }
        $result3 = $food->where($condition)->delete(); //再删除菜品记录
       	if($result1 || $result2 || $result3){
       		$attribute_type = D('attribute_type');
   			$addr_list = $attribute_type->where($condition)->select(); //查询菜品类别表，删除关联类别记录
   			$food_attribute = D('food_attribute');
   			foreach($addr_list as $k => $v){
   				$condition2['attribute_type_id'] = $v['attribute_type_id'];		
   				$addr_list1 = $food_attribute->where($condition2)->select(); //查谒菜品属性表，删除关联属性记录
   				foreach($addr_list1 as $k=>$v){			
   					 unlink($addr_list1[$k]['attribute_img']);
   					 $condition3['attribute_type_id']  = $addr_list1[$k]['attribute_type_id'];
   					 $food_attribute->where($condition3)->delete();
   				}		
   			}	
   			$attribute_type->where($condition)->delete();
            $msjm_condition['restaurant_id'] = session('restaurant_id');
	        $count = $food->where($msjm_condition)->count();
	        $p = I("get.page") ? I("get.page") : 1;
	        $pageNum = 8;
	        $Page  = new \Think\PageAjax($count,$pageNum);// 实例化分页类 传入总记录数和每页显示的记录数
	        $show = $Page->show();// 分页显示输出
	        $this->assign('page',$show);// 赋值分页输出
	        $food_list = $food->where($msjm_condition)->page($p,$pageNum)->select();
	        $this->assign('info',$food_list);
			$this->display('showfoodinfo');
			$food->commit(); 						//提交事务

            // 删除相关的静态页
            $dianpu_id = session("restaurant_id");
            @ unlink(HTML_PATH . "$dianpu_id/order.html");  // 删除订单页

            // 删除分类ID对应的内容页
            // 根据food_id 去获取food_category_id
            foreach($result as $val){
                @ unlink(HTML_PATH . "$dianpu_id/orderAjax".$val['food_category_id'].".html");
            }

            // 删除对应的模态框缓存文件
            $food_id = I('get.food_id');
            @ unlink(HTML_PATH ."$dianpu_id/orderPopup".$food_id.".html");


       		}else{
       			$food->rollback();	       		
       		}
       		
    }

	//删除菜品分类关联表
	public function delfoodinfo1(){
		$food_category_relative = D('food_category_relative');
		$where['id'] = I('get.id');
		$r = $food_category_relative->where($where)->delete();
		if($r){
			$this->food_ajax1();
		}	
	}


    //将数据库的数据填充到表单
    public function edit(){
        //获取店铺分区信息
        $district_model = D("restaurant_district");
        $district_where['restaurant_id'] = session("restaurant_id");
        $district_list = $district_model->where($district_where)->field("district_id,district_name")->select();
        $district_list[] = array(
            "district_id" => 0,
            "district_name" => "不设分区",
        );
        $this->assign("district_list",$district_list);

        //获取当前所有的打印机消息
        $printerModel = D("printer");
        $pr_condition['restaurant_id'] = session("restaurant_id");
        $printerList = $printerModel->where($pr_condition)->select();
        $this->assign("printerList",$printerList);
//        dump($printerList);

        $id = $_GET['food_id'];
        $this->assign("food_id",$id);
        $food = D('Food');
        $arr = $food->find($id);
        $arr['food_img'] = $arr['food_img'];

        $this->assign('info', $arr);

        //获取所有的菜品分类
        $dishes = D('food_category');
        $f_condition['restaurant_id'] = session('restaurant_id');
        $arr1 = $dishes->where($f_condition)->select();

        //获取该菜品所属的菜品分类
        $dishes = D('food_category_relative');
        $condition["food_id"] = $id;
        $arr2 = $dishes->where($condition)->select();

        //对对应的菜品分类做标记，以便前端显示
        foreach($arr1 as $key => $val){
            foreach($arr2 as $k =>$v){
                if($val['food_category_id'] == $v['food_category_id']){
                    $arr1[$key]["is_select"] = 1;
                    continue;
                }
            }
        }
        $this->assign("data", $arr1);


        //获取菜品的时价属性
        $prom = D('prom');
        $arr3 = $prom->find($id);
        $this->assign("info1", $arr3);

        //获取菜品的类别和属性
        $type_condition['food_id'] = $id;
        $attr_type_model = D('attribute_type');
        $attr_type_list = $attr_type_model->where($type_condition)->select();
//        var_dump($attr_type_list);
        $food_attr_model = D('food_attribute');
        $attr_list=array();
        foreach($attr_type_list as $kt => $vt){
            $ft_condition['attribute_type_id'] = $vt['attribute_type_id'];
            $temp = $food_attr_model->where($ft_condition)->select();
            $temp2 = $food_attr_model->where($ft_condition)->count();
            $attr_type_list[$kt]['num'] = $temp2;
            $attr_list[$kt+1] = $temp;
        }

        $attr_type_list2 = array(); 
        foreach($attr_type_list as$ky => $vl){
            $attr_type_list2[$ky+1] = $vl;
            $attr_type_list2[$ky+1]['attr_list'] = $attr_list[$ky+1];
        }
		
        $this->assign("attr_type_list",$attr_type_list2);
        $this->display("editDishes");
    }

    public function getTypeAttrs(){
//        $attribute_type_id = 4;
        $attribute_type_id = I("post.type_id");
        $printerModel = D("printer");
        $p_condition['restaurant_id'] = session("restaurant_id");
        $printList = $printerModel->where($p_condition)->select();
//        dump($printList);
        $this->assign("printerList",$printList);
        $attributeTypeModel = D("attribute_type");
        $attr_type = $attributeTypeModel->where("attribute_type_id = $attribute_type_id")->find();

        $food_attribute_model = D("food_attribute");
        $attrs= $food_attribute_model->where("attribute_type_id = $attribute_type_id")->select();
        $attr_type['attrs'] = $attrs;
        $this->assign("attr_type",$attr_type);
        $this->display("editDishesAjax");
    }

    public function editDishesType(){
        $attr_type_model = D("attribute_type");
        $data = $attr_type_model->create();
        $data['restaurant_id'] = session("restaurant_id");
        $rel = $attr_type_model->save($data);
        if($rel !== false){

            // 删除对应的模态框
            $dianpu_id = session("restaurant_id");
            // 根据传递过来的food_id去删除
            @ unlink(HTML_PATH ."$dianpu_id/orderPopup".$data['food_id'].".html");

            $msg['code'] = 1;
            $msg['msg'] = "操作成功";
            $msg['data'] = $data;
            exit(json_encode($msg));
        }
    }

    public function deleteAttr(){
        $attr_id = I('post.attr_id');
        $food_attribute_model = D('food_attribute');
        $condition['food_attribute_id'] = $attr_id;

        // 供缓存使用的attribute_type_id要在这里获取，不然走完下一个delete语句数据库就没有这个记录了
        $attribute_type_id = $food_attribute_model->where($condition)->getField("attribute_type_id");

        $rel = $food_attribute_model->where($condition)->delete();
        if($rel !== false){

            // 删除对应的模态框静态文件
            $attr_type = D("attribute_type");
            $food_id = $attr_type->where(array("attribute_type_id"=>$attribute_type_id))->getField("food_id");
            $dianpu_id = session("restaurant_id");
            @ unlink(HTML_PATH ."$dianpu_id/orderPopup".$food_id.".html");

            $msg['code'] = 1;
            $msg['msg'] = "操作成功";
            exit(json_encode($msg));
        }
    }

    public function deleteType(){
        $type_id = I('post.type_id');
        $attribute_type_model = D('attribute_type');
        $attribute_type_model->startTrans();

        $food_attribute_model = D('food_attribute');
        $condition['attribute_type_id'] = $type_id;

        // 缓存：利用attribute_type_id获取food_id,如果下面执行到了commit就删除掉模态框
        $food_id = $attribute_type_model->where($condition)->getField("food_id");

        $rel1 = $food_attribute_model->where($condition)->delete();
        if($rel1 == false){
            $attribute_type_model->rollback();
        }
        $rel2 = $attribute_type_model->where($condition)->delete();
        if($rel2 == false){
            $attribute_type_model->rollback();
        }
        if($rel2 !== false){
            $attribute_type_model->commit();

            // 删除掉模态框缓存
            $dianpu_id = session("restaurant_id");
            @ unlink(HTML_PATH . "$dianpu_id/orderPopup".$food_id.".html");

            $msg['code'] = 1;
            $msg['msg'] = "操作成功";
            exit(json_encode($msg));
        }
    }


    # 编辑菜品
    public function modifyfoodinfo(){
        $food = D('food');
        if (!empty($_POST)){
            /*--------缓存-------*/
            # 去掉菜品所属分类的时候用（之前有的，现在不勾选了，还没操作数据库前就去获取）
           $fcr = D('food_category_relative');
            $shiwu_id = I("get.food_id");
            $where['food_id'] = $shiwu_id;
            $food_cat = $fcr->where($where)->select();
            $shuzu = array();
            foreach($food_cat as $v){
                $shuzu[] = $v['food_category_id'];
            }
            /*--------缓存-------*/


            $data = array();
            if ($_FILES['img_pic']['error'] != 4){
                $condition['food_id'] = $_GET['food_id'];
                $addr_img = $food->where($condition)->field('food_img')->find()['food_img'];
                unlink($addr_img);
                $up = new \Think\Upload();
                $up->savePath = 'upfoodimg/'; // 设置附件上传目录
                $up->autoSub = false;
                $z = $up->uploadOne($_FILES['img_pic']);
                $picpathname = './Application/Admin/Uploads/' . $z['savepath'] . $z['savename'];
                $_POST['image'] = $picpathname;
                $data['food_img'] = $_POST['image'];
            }
            $food_id = $_GET['food_id'];
            $data['food_name'] = $_POST['food_name'];
            $data['food_price'] = $_POST['food_price'];
            $data['discount'] = $_POST['discount'];
            $data['foods_num_day'] = $_POST['food_num_day'];
            $data['star_level'] = $_POST['star_level'];
			$data['hot_level'] = $_POST['cayenne'];
            $data['food_desc'] = $_POST['food_desc'];
			$data['is_prom'] = $_POST['is_prom'];
            $data['print_id'] = $_POST['print_id'];
            $data['district_id'] = $_POST['district'];
            $data['restaurant_id'] = session('restaurant_id');
            $line = $food->where("food_id = $food_id")->save($data);

			$relative = D('food_category_relative');
	        $data2['food_id'] = $food_id;
	        $sort1 = $_POST['sort1'];
	        //先删除改菜品的分类，然后重新添加关联
	        $relative->where("food_id = $food_id")->delete();
            foreach ($sort1 as $so){
                $data2['food_category_id'] = $so;
                $r2 = $relative->add($data2);
            }
			if($_POST['is_prom'] == 1){//判定编辑时，是否开启了时价
				$prom_id = $_GET['food_id'];
				$prom = D('prom');
				$result = $prom->where("prom_id = $prom_id")->find();
				$data1['prom_id'] = $prom_id;
	            $data1['prom_price'] = $_POST['prom_price'];
	            $data1['discount'] = $_POST['prom_discount'];
	            $data1['prom_goods_num'] = $_POST['prom_goods_num'];
	            $data1['prom_start_time'] = strtotime($_POST['prom_start_time']);
	            $data1['prom_end_time'] = strtotime($_POST['prom_end_time']);
				if($result){//如果开启了时价，判段之前是否存在时价,存在编辑时价表
		            $prom->save($data1);
				}else{//不存在，新增时价表
					$prom->add($data1);
				}
			}

            if ($line !== false) {

               /* ----------------------------缓存开始----------------------------*/
                $dianpu_id = session("restaurant_id");
                @ unlink(HTML_PATH . "$dianpu_id/order.html");  // 删除订单页

                # 此处的删除菜品所属分类ID下的缓存页是综合此方法开头获取到的分类ID和现在这里获取到的分类ID而弄的
                //获取该菜品所属的菜品分类  (此处是当它添加菜品所属分类时用的)
                $fcr1 = D('food_category_relative');
                $shiwu_id1 = I("get.food_id");
                $where1['food_id'] = $shiwu_id1;
                $food_cat1 = $fcr1->where($where1)->select();

                $shuzu1 = array();
                foreach($food_cat1 as $v1){
                     $shuzu1[] = $v1['food_category_id'];
                }

                $total = array_merge($shuzu,$shuzu1);
                $total = array_unique($total);

                //  循环删除分类缓存文件
                foreach($total as $val){
                    @ unlink(HTML_PATH . "$dianpu_id/orderAjax".$val.".html");
                }

                //  删除模态框缓存文件
                @ unlink(HTML_PATH ."$dianpu_id/orderPopup".$food_id.".html");

                /* ----------------------------缓存结束----------------------------*/

                $msg['code'] = "1";
                $msg['msg'] = "成功";
                exit(json_encode($msg));
            }else {
                $msg['code'] = "0";
                $msg['msg'] = "失败";
                exit(json_encode($msg));
            }
        }
    }

    //修改上下架状态
   	public function updstate(){
   		$food = D('food');
   		$condition['food_id'] = I('get.food_id');
   		$info = $food->where($condition)->find();
   		if($info['is_sale'] == 0){
   			$condition['is_sale'] = 1;		
   		}else{
   			$condition['is_sale'] = 0;  			
   		}
   		$r = $food->save($condition);
   		if($r){

            $dianpu_id = session("restaurant_id");
            // 删除订单页的静态页
            @ unlink(HTML_PATH . "$dianpu_id/order.html"); // @是为了抑制因文件不存在而删除失败的错误信息

            // 删除模态框缓存
            $food_id = I('get.food_id');
            @ unlink(HTML_PATH ."$dianpu_id/orderPopup".$food_id.".html");

            // 删除该菜品所属分类的缓存文件
            // 利用food_id去food_category_relative表去获取food_category_id
            $fcr = D("food_category_relative");
            $cat_data = $fcr->where(array("food_id"=>$food_id))->select();
            foreach($cat_data as $food_cat_id){
                @ unlink(HTML_PATH . "$dianpu_id/orderAjax".$food_cat_id['food_category_id'].".html");
            }


   			$key = I('get.food_category_id');
   			if($key == 0){
                $cc_condition['restaurant_id'] = session("restaurant_id");
   				 $count = $food->where($cc_condition)->count();
			     $p = I("get.page") ? I("get.page") : 1;
			     $pageNum = 8;
			     $Page  = new \Think\PageAjax($count,$pageNum);// 实例化分页类 传入总记录数和每页显示的记录数
			     $show = $Page->show();// 分页显示输出
			     $this->assign('page',$show);// 赋值分页输出
			     $food_list = $food->where($cc_condition)->order('sort asc')->page($p,$pageNum)->select();
			     $this->assign('info',$food_list);
	    		 $this->display('showfoodinfo');
   			}else{
   				$relative = D('food_category_relative');
           		$map['food_category_id'] = $key;
            	$count = $relative->where($map)->count();
			    $p = I("get.page") ? I("get.page") : 1;
			    $pageNum = 8;
			    $Page  = new \Think\PageAjax($count,$pageNum);// 实例化分页类 传入总记录数和每页显示的记录数
			    $show = $Page->show();// 分页显示输出
			    $this->assign('page',$show);// 赋值分页输出
			    $arr = $relative->where($map)->page($p,$pageNum)->order('sort asc')->select();
            	$food_list = array();
	            $foodModel = D('food');
	            $dishes = D('food_category');
		            foreach ($arr as $v) {
		                $condition1['food_id'] = $v['food_id'];
		                $food_category_id = $v['food_category_id'];
		                $food_info = $foodModel->where($condition1)->find(); //查出的是个对像
		                $food_type = $dishes->where("food_category_id = $food_category_id")->field("food_category_name")->find()['food_category_name'];
		                $food_info['id'] = $v['id'];
		                $food_info['food_category_id'] = $v['food_category_id'];
		                $food_info['food_category_name'] = $food_type;
		                $food_list[] = $food_info;
	            	}
            	$this->assign("info",$food_list);
   				$this->display("showfoodinfo1");
   				}
   		}	
   	}

    //数据上移
    public function moveup(){
        $food = D('food');
        $when_sort = I('post.sort');				 //当前排序ID
		$food_id = I('post.food_id');
        $map['sort'] = array('lt',I('post.sort'));   	
		$map['restaurant_id'] = session('restaurant_id');
        $last_sort = $food->where($map)->order('sort desc')->field('sort')->limit(1)->find()['sort']; 		//上一个排序ID
        $last_id = $food->where($map)->order('sort desc')->field('food_id')->limit(1)->find()['food_id'];	//上一个自增ID
        if($last_sort>0){
            $newsort = $last_sort;							//新建第三个ID来存储上一个ID
            $last_sort = I('post.sort');					//上一个排序ID被赋值成当前排序ID
            $obj['sort'] = $last_sort;
			$obj['food_id'] = $last_id;
            $r = $food->save($obj);
            $when_sort = $newsort;							//将第三个排序ID值赋于当前ID
            $obj1['sort'] = $when_sort;
			$obj1['food_id'] = I('post.food_id');
            $r1 = $food->save($obj1);
			if($r && $r1){
				//$this->dishes_ajax();

                // 删除订单页缓存
                $dianpu_id = session("restaurant_id");
                @ unlink(HTML_PATH . "$dianpu_id/order.html");

				$msg['msg'] = "成功";
				$msg['code'] = 1;
				exit(json_encode($msg));
			}
        }
    }

	//数据下移
    public function movedown(){
        $food = D('food');
		$when_sort = I('post.sort');					//当前排序ID
		$food_id = I('post.food_id');					//当前自增ID
        $map['sort'] = array('Gt',I('post.sort'));   	//sort	大于传过来的sort		
		$map['restaurant_id'] = session('restaurant_id');
        $next_sort = $food->where($map)->order('sort asc')->field('sort')->limit(1)->find()['sort'];			//下一个排序ID
        $next_id = $food->where($map)->order('sort asc')->field('food_id')->limit(1)->find()['food_id'];		//下一个自增ID
        if($next_sort>0){
            $newsort = $next_sort;							//新建第三个ID来存储下一个排序ID
            $next_sort = I('post.sort');					//下一个排序ID被赋值为当前排序ID
            $obj['sort'] = $next_sort;
			$obj['food_id'] = $next_id;						//修改上一个sort
            $r = $food->save($obj);
            $when_sort = $newsort;							//将第三个ID值赋于当前ID
            $obj1['sort'] = $when_sort;
			$obj1['food_id'] = I('post.food_id');
            $r1 = $food->save($obj1);
			if($r && $r1){

                // 删除订单页缓存
                $dianpu_id = session("restaurant_id");
                @ unlink(HTML_PATH . "$dianpu_id/order.html");

				$msg['msg'] = "成功";
				$msg['code'] = 1;
				exit(json_encode($msg));
			}
        }
	}
	

	//菜品分类数据上移
    public function moveup1(){
    	//dump("进来了");
        $food_category = D('food_category');
        $condition['sort'] = I('post.sort');
		$condition['restaurant_id'] = session('restaurant_id');
        $dataOri = $food_category->where($condition)->order('sort desc')->field('sort')->limit(1)->find()['sort'];
		///dump($dataOri);
		$food_category_id = I('post.food_category_id');
       //id<传过来的ID
        $map['sort'] = array('lt',I('post.sort'));   //sort	小于传过来的sort	
		$map['restaurant_id'] = session('restaurant_id');
		//dump($map);
        $data = $food_category->where($map)->order('sort desc')->field('sort')->limit(1)->find()['sort'];//点击当前上移ID的上一个ID
        //dump($data);
        $last_id = $food_category->where($map)->order('sort desc')->field('food_category_id')->limit(1)->find()['food_category_id'];
        if($data>0){
            $newsort = $data;//新建第三个ID来存储上一个ID
            $data = I('post.sort');
            $obj['sort'] = $data;
			$obj['food_category_id'] = $last_id;//修改上一个sort
            $r = $food_category->save($obj);
            $dataOri = $newsort;//将第三个ID值赋于当前ID
            $obj1['sort'] = $dataOri;
			$obj1['food_category_id'] = I('post.food_category_id');
            $r1 = $food_category->save($obj1);
			if($r && $r1){

                // 菜品分类上移，删除订单页缓存
                $dianpu_id = session("restaurant_id");
                @ unlink(HTML_PATH . "$dianpu_id/order.html");  // 删除订单页

                $where['restaurant_id'] = session("restaurant_id");
        		$arr = $food_category->where($where)->order('sort asc')->select();
				$this->assign("data",$arr);
				$this->display('showcategory');
			}
        }
    }
	

    
		
	 //菜品分类数据下移
    public function movedown1(){
        $food_category = D('food_category');
        $condition['sort'] = I('post.sort');
		$condition['restaurant_id'] = session('restaurant_id');
        $dataOri = $food_category->where($condition)->field('sort')->limit(1)->find()['sort'];
		$food_category_id = I('post.food_category_id');
       //id<传过来的ID
        $map['sort'] = array('Gt',I('post.sort'));   //sort	小于传过来的sort		
		$map['restaurant_id'] = session('restaurant_id');
        $data = $food_category->where($map)->order('sort asc')->field('sort')->limit(1)->find()['sort'];//点击当前上移ID的上一个ID
        $next_id = $food_category->where($map)->order('sort asc')->field('food_category_id')->limit(1)->find()['food_category_id'];
        if($data>0){
            $newsort = $data;//新建第三个ID来存储上一个ID
            $data = I('post.sort');
            $obj['sort'] = $data;
			$obj['food_category_id'] = $next_id;//修改上一个sort
            $r = $food_category->save($obj);
            $dataOri = $newsort;//将第三个ID值赋于当前ID
            $obj1['sort'] = $dataOri;
			$obj1['food_category_id'] = I('post.food_category_id');
            $r1 = $food_category->save($obj1);
			if($r && $r1){

                // 删除订单页缓存
                $dianpu_id = session("restaurant_id");
                @ unlink(HTML_PATH . "$dianpu_id/order.html");

				$where['restaurant_id'] = session("restaurant_id");
        		$arr = $food_category->where($where)->order('sort asc')->select();
				$this->assign("data",$arr);
				$this->display('showcategory');
			}
			//exit(json_encode($msg));
        }
	}

	//菜品第三表数据上移
	public function moveup2(){
		$relative = D('food_category_relative');       
        $map['food_category_id'] = I('get.food_category_id');
		$relativeArr = $relative->where($map)->select();
		$food = D('food');
        $dishes = D('food_category');
		$food_list = array();
        foreach($relativeArr as $v){
            $condition['food_id'] = $v['food_id'];
            $food_category_id = $v['food_category_id'];
            $food_info = $food->where($condition)->find(); 
            $food_type = $dishes->where($map)->field("food_category_name")->find()['food_category_name'];
            $food_info['id'] = $v['id'];
            $food_info['food_category_id'] = $v['food_category_id'];
            $food_info['food_category_name'] = $food_type;
            $food_list[] = $food_info;
        }
		$sortArr = array();
		foreach($food_list as $v1){
			$sortArr[] = $v1['sort'];
		}
		
		array_multisort($sortArr, SORT_ASC, $food_list);
		$foodIdtArr = array();
		foreach($food_list as $v2){
			$foodIdtArr[] = $v2['food_id'];
		}
		sort($sortArr);
        $when_sort = I('get.when_sort');				 //当前排序ID
        $when_food_id = I('get.when_food_id');			 //当前自增ID
        $Key = array_search($when_sort,$sortArr);
		$Key1 = array_search($when_food_id,$foodIdtArr);
		$last_sort = $sortArr[$Key-1];					 //上一个排序ID		
		$last_food_id = $foodIdtArr[$Key1-1];			 //上一个自增ID
        if($last_sort>0){
            $newsort = $last_sort;						 //新建第三个ID来存储上一个ID
            $last_sort = $when_sort;					 //上一个排序ID被赋值成当前排序ID
            $obj['sort'] = $last_sort;
			$obj['food_id'] = $last_food_id;
            $r = $food->save($obj);						 //修改上一条数据排序
            $when_sort = $newsort;						 //将第三个排序ID值赋于当前ID
            $obj1['sort'] = $when_sort;
			$obj1['food_id'] = $when_food_id;
            $r1 = $food->save($obj1);
			if($r && $r1){

                // 删除分类ID缓存页
                $dianpu_id = session("restaurant_id");
                $food_category_id = I('get.food_category_id');
                @ unlink(HTML_PATH . "$dianpu_id/orderAjax".$food_category_id.".html");

				$msg['msg'] = "成功";
				$msg['code'] = 1;
				exit(json_encode($msg));
			}
        }
	}

	//菜品第三表数据下移
	public function movedown2(){
		$relative = D('food_category_relative');       
        $map['food_category_id'] = I('get.food_category_id');
		$relativeArr = $relative->where($map)->select();
		$food = D('food');
        $dishes = D('food_category');
		$food_list = array();
        foreach($relativeArr as $v){
            $condition['food_id'] = $v['food_id'];
            $food_category_id = $v['food_category_id'];
            $food_info = $food->where($condition)->find(); 
            $food_type = $dishes->where($map)->field("food_category_name")->find()['food_category_name'];
            $food_info['id'] = $v['id'];
            $food_info['food_category_id'] = $v['food_category_id'];
            $food_info['food_category_name'] = $food_type;
            $food_list[] = $food_info;
        }
		$sortArr = array();
		foreach($food_list as $v1){
			$sortArr[] = $v1['sort'];
		}
		
		array_multisort($sortArr, SORT_ASC, $food_list);
		$foodIdtArr = array();
		foreach($food_list as $v2){
			$foodIdtArr[] = $v2['food_id'];
		}
		sort($sortArr);
        $when_sort = I('get.when_sort');				 //当前排序ID
        $when_food_id = I('get.when_food_id');			 //当前自增ID
        $Key = array_search($when_sort,$sortArr);
		$Key1 = array_search($when_food_id,$foodIdtArr);
		$next_sort = $sortArr[$Key+1];					 //下一个排序ID		
		$next_food_id = $foodIdtArr[$Key1+1];			 //下一个自增ID
        if($next_sort>0){
            $newsort = $next_sort;						 //新建第三个ID来存储上一个ID
            $next_sort = $when_sort;					 //下一个排序ID被赋值成当前排序ID
            $obj['sort'] = $next_sort;
			$obj['food_id'] = $next_food_id;
            $r = $food->save($obj);						 //修改上一条数据排序
            $when_sort = $newsort;						 //将第三个排序ID值赋于当前ID
            $obj1['sort'] = $when_sort;
			$obj1['food_id'] = $when_food_id;
            $r1 = $food->save($obj1);
			if($r && $r1){

                // 删除分类ID缓存页
                $dianpu_id = session("restaurant_id");
                $food_category_id = I('get.food_category_id');
                @ unlink(HTML_PATH . "$dianpu_id/orderAjax".$food_category_id.".html");

				$msg['msg'] = "成功";
				$msg['code'] = 1;
				exit(json_encode($msg));
			}
        }
	}


}