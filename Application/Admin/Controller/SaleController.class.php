<?php
namespace Admin\Controller;
use Think\Controller;

class SaleController extends Controller {

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

	//销售统计的总查询页面
    public function index(){
        $beginThisMonth=mktime(0,0,0,date('m'),date('d'),date('Y'));		//开始日期（当前年当前月的日期）
        $endThisMonth=mktime(23,59,59,date('m'),date('t'),date('Y'));		//结束日期（当前年当前月的日期）

        $startDate = date("Y-m-d",$beginThisMonth);					
        $this->assign("startDate",$startDate);

        $endDate = date("Y-m-d",$endThisMonth);
        $this->assign("endDate",$endDate);

        $startTime = "00:00:00";
        $endTime = "23:59:59";

        $this->assign("startTime",$startTime);
        $this->assign("endTime",$endTime);

        $condition = array();
        //判断是否有时间，有则添加到查询寻条件
        if(!empty($startDate) && !empty($startTime) && !empty($endDate) && !empty($endTime)){
            $startTimeStr = strtotime($startDate." ".$startTime);
            $endTimeStr = strtotime($endDate." ".$endTime);
            $condition['pay_time'] = array("between",array($startTimeStr,$endTimeStr));
        }
		
		$condition['pay_type'] = array("in",'0,1,2');
		$condition['order_type'] = array("in",'1,2,3');
        $condition["restaurant_id"] = session('restaurant_id');
		$condition['order_status'] = array("neq",0);
        $orderModel = D("order");
        $all_total_amount = 0;

        $total_amount = $orderModel->where($condition)->field("total_amount")->select();

        foreach($total_amount as $v){
            $all_total_amount += $v["total_amount"];
        }

        $all_total_amount = number_format($all_total_amount,2);
        $this->assign("total_amount",$all_total_amount);

        $this->display();
    }

    //分页获取订单列表
    public function orderInfo(){
        /**
         * 搜索条件
         */
        $startDate = I("post.startDate");
        $startTime = I("post.startTime");
        $endDate = I("post.endtDate");
        $endTime = I("post.endTime");

        $condition = array();
        //判断是否有时间，有则添加到查询寻条件
        if(!empty($startDate) && !empty($startTime) && !empty($endDate) && !empty($endTime)){
            $startTimeStr = strtotime($startDate." ".$startTime);
            $endTimeStr = strtotime($endDate." ".$endTime);
            $condition['pay_time'] = array("between",array($startTimeStr,$endTimeStr));
        }

        //支付类型
        $pay_type = I("post.pay_type");
        if(!empty($pay_type)){
            $condition['pay_type'] = array("in",$pay_type);
        }

        // $pay_type = array(0,1,2,4);  // 3代表未支付，所以中文名用空字符串隔开

        $pay_type_str = array(
            "现金","支付宝","微信","","余额"
        );
        $pay_str = "";
        foreach($pay_type as $vp){
            $pay_str .= $pay_type_str[$vp]."、";
        }

        $this->assign("pay_str",$pay_str);

        //就餐方式
        $order_type = I("post.order_type");
		//array_push($order_type,3);
		//dump($order_type);
        if(!empty($order_type)){
            $condition['order_type'] = array("in",'1,2,3');
        }

        $order_type_str = array(
            "店内点餐","打包带走"
        );

        $order_str = "";
        foreach($order_type as $vod){
            $order_str .= $order_type_str[$vod-1]."、";
        }
        $this->assign("order_str",$order_str);


        $orderModel = D("order");

        /**
         * 计算总金额
         */
        $condition["restaurant_id"] = session('restaurant_id');
		$condition['order_status'] = array("neq",0);
		
        $all_total_amount = 0;
        $total_amount = $orderModel->where($condition)->field("total_amount")->select();

        foreach($total_amount as $v){
            $all_total_amount += $v["total_amount"];
        }

        $all_total_amount = number_format($all_total_amount,2);
        $this->assign("total_amount",$all_total_amount);

        /**
         * 分页查询订单数据
         */
        $page = I("get.page") ? I("get.page") : 1;

        $page_num = 50;
        $condition["restaurant_id"] = session('restaurant_id');
		$condition['order_status'] = array("neq",0);
		
        $count = $orderModel->where($condition)->count();
        $order_list = $orderModel->where($condition)->page($page,$page_num)->order("order_id desc")->select();
        $Page = new \Think\PageAjax($count,$page_num);
        $show = $Page->show();

        $this->assign("page",$show);

        /**
         * 查询订单每个订单关联的商品信息
         */
        $order_food_model = D("order_food");
        $food_model = D("food");
		$order_food_attributeModel = D('order_food_attribute');
        foreach($order_list as $key => $val){
            $condition['order_id'] = $val['order_id'];
            $order_list[$key]["pay_time"] = date("Y-m-d H:i:s",$val['pay_time']);
            $food_list = $order_food_model->where($condition)->field("food_id,food_price2,food_num,food_name,order_food_id")->select();
		
			foreach($food_list as $key1=>$value1){
				$condition1['order_food_id'] = $value1['order_food_id'];
				$attribute_Arr = $order_food_attributeModel->where($condition1)->field('food_attribute_name,food_attribute_price,count_type')->select();
				$attribute_Arr1 = array();
				foreach($attribute_Arr as $abA_key=>$abA_value){
					if($abA_value['count_type'] == 1){
						$attribute_Arr1[$abA_key] = $abA_value;
					}
				}
				$food_list[$key1]['attribute_list'] = $attribute_Arr1;	//每个食品下的属性列表
			}
            $order_list[$key]['food_info'] = $food_list;	
        }
		//dump($order_list,TRUE,'',FALSE);
        $this->assign("orderInfo",$order_list);

        unset($orderModel);

        $this->display("ajaxOrderInfo");
    }

    /**
     * 统计某菜品的销售情况
     */
    public function countFoodSale(){
        /**
         * 获取查询的条件，查询相关订单信息
         */
        $startDate = I("post.startDate");
        $startTime = I("post.startTime");
        $endDate = I("post.endtDate");
        $endTime = I("post.endTime");

        $condition = array();
        //判断是否有时间，有则添加到查询寻条件
        if(!empty($startDate) && !empty($startTime) && !empty($endDate) && !empty($endTime)){
            $startTimeStr = strtotime($startDate." ".$startTime);
            $endTimeStr = strtotime($endDate." ".$endTime);
            $condition['pay_time'] = array("between",array($startTimeStr,$endTimeStr));
//            $condition['add_time'] = array("between",array($startTimeStr,$endTimeStr));
        }

        //支付类型
        $pay_type = I("post.pay_type");
        if(!empty($pay_type)){
            $condition['pay_type'] = array("in",$pay_type);
        }

        $pay_type_str = array(
            "现金","支付宝","微信","","余额"
        );

        $pay_str = "";
        foreach($pay_type as $vp){
            $pay_str .= $pay_type_str[$vp]."、";
        }

        $this->assign("pay_str",$pay_str);

        //就餐方式
        $order_type = I("post.order_type");
        if(!empty($order_type)){
            $condition['order_type'] = array("in",$order_type);
        }

        $order_type_str = array(
            "店内点餐","打包带走"
        );

        $order_str = "";
        foreach($order_type as $vod){
            $order_str .= $order_type_str[$vod-1]."、";
        }
        $this->assign("order_str",$order_str);

        $condition['restaurant_id'] = session("restaurant_id");
		$condition['order_status'] = array("neq",0);

        $order_model = D("order");
        $order_list = $order_model->where($condition)->field("order_id")->select();
        $orders2 = array();
        foreach($order_list as $order_key => $order_val){
            $orders2[] = $order_val["order_id"];
        }

        if(empty($orders2)){
            exit;
        }

        /**
         * 计算搜索菜品的销售情况
         */
        $food_name = I("post.food_name");

        //获取菜品的id
        $f_condition['food_name'] = array("like","%".$food_name."%");
        $f_condition['order_id'] = array("in",$orders2);
        $food_model = D("order_food");
        $order_list2 = $food_model->where($f_condition)->field("order_id,food_name,food_price2,food_num")->select();




        //计算销售总额
        $all_total_amount = 0;
        foreach($order_list2 as $kt => $vt){
            $lso_condition['order_id'] = $vt['order_id'];
            $order = $order_model->where($lso_condition)->find();
            $all_total_amount+=$vt["food_price2"];
            $order_list2[$kt]['pay_time'] = $order['pay_time'];
			$order_list2[$kt]['pay_type'] = $order['pay_type'];
            $order_list2[$kt]['order_sn'] = $order['order_sn'];
            $order_list2[$kt]['total_amount'] = number_format($vt["food_price2"]*$vt["food_num"],2);
			$order_list2[$kt]['f_type'] = 1;
        }
		//dump($order_list2);
		
		//------------------------------------属性数组-------------------------------------
		$order_food_attributeModel = D('order_food_attribute');
		$attr_all_orderfoodId = array();
		foreach($orders2 as $os2_key=>$os2_value){
			$os2_condition['order_id'] = $os2_value;
			$attr_one_orderfoodId = $food_model->where($os2_condition)->field('order_food_id')->select();
			$attr_orderfoodIdArr = array();
			foreach($attr_one_orderfoodId as $aoof_key=>$aoof_value){
				$attr_orderfoodIdArr[$aoof_key] = $aoof_value['order_food_id'];
			}
			$attr_all_orderfoodId[] = $attr_orderfoodIdArr;
		}
		
		$attr_all_orderfoodId1 = arrayChange($attr_all_orderfoodId);
		//dump($attr_all_orderfoodId1);
		$f_condition1['food_attribute_name'] = array("like","%".$food_name."%");
        $f_condition1['order_food_id'] = array("in",$attr_all_orderfoodId1);
		$all_attrArr = $order_food_attributeModel->where($f_condition1)->field("order_food_id,food_attribute_name,food_attribute_price,count_type")->select();
		//dump($all_attrArr);
		$order_list3 = array();
		foreach($all_attrArr as $aaA_key=>$aaA_value){
			if($aaA_value['count_type'] == 1){
				$orl3_condition['order_food_id'] = $aaA_value['order_food_id'];
				$attr_order_id = $food_model->where($orl3_condition)->field('order_id')->find()['order_id'];
				$order_list3[$aaA_key]['order_id'] = $attr_order_id;
				$order_list3[$aaA_key]['food_name'] = $aaA_value['food_attribute_name'];
				$order_list3[$aaA_key]['food_price2'] = $aaA_value['food_attribute_price'];
				$order_list3[$aaA_key]['food_num'] = 1;
				$order_list3[$aaA_key]['pay_time'] = $order_model->where("order_id=$attr_order_id")->field("pay_time")->find()['pay_time'];
				$order_list3[$aaA_key]['pay_type'] = $order_model->where("order_id=$attr_order_id")->field("pay_type")->find()['pay_type'];
				$order_list3[$aaA_key]['order_sn'] = $order_model->where("order_id=$attr_order_id")->field('order_sn')->find()['order_sn'];
				$order_list3[$aaA_key]['total_amount'] = $aaA_value['food_attribute_price'];
				$order_list3[$aaA_key]['f_type'] = 2;		
			}
		}
		//dump($order_list3);
		$all_countInfoArr = array();				//合并菜品与菜品属性数组(两数组格式相同，只是把查出来的第二个数组加在第一个数组尾部使其连贯)
		foreach($order_list2 as $ol2_value){
			$all_countInfoArr[] = $ol2_value;
		}
		foreach($order_list3 as $ol3_value){
			$all_countInfoArr[] = $ol3_value;
		}
		//dump($all_countInfoArr);
		
        $all_total_amount = number_format($all_total_amount,2);
        $this->assign("total_amount",$all_total_amount);

        $this->assign("order_list",$all_countInfoArr);
        $this->display();
    }

    /**
     * 获取某个月份的销售,每一天的销售情况和当月的销售总额
     * @param $month
     * @return array()
     */

    public function monthlySales($year,$month,$restaurant_id){
        $order_model = D("order");
        $day_list = dayForMonth($year,$month);//条件月内的每一天的开始时间与结束时间
        $sales_for_month = array();
        $month_sales = 0;
		$month_cash  = 0;
        $month_alipay  = 0;
        $month_wechat  = 0;
        $month_remainder  = 0;
        $m_condition['restaurant_id'] = $restaurant_id;
        foreach($day_list as $dk => $dv){
        	$m_condition['order_status'] = array("neq",0);
//			$m_condition['pay_type'] = array("in","0,1,2");
			$m_condition['pay_type'] = array("in","0,1,2,4");
			$m_condition['order_type'] = array("in",'1,2,3');
            $m_condition['pay_time'] = array("between",array($dv['day_start'],$dv['day_end']));
            $sales = $order_model->where($m_condition)->sum("total_amount");//条件店铺在条件月内的每一天营业额
            $month_sales += $sales;
            if($sales){
                $sales_for_month[] = $sales;
            }else{
                $sales_for_month[] = 0;
            }
			$m_condition['pay_type'] = 0;
			$cash = $order_model->where($m_condition)->sum("total_amount");//条件店铺在条件月内的每一天营业额
            $month_cash += $cash;
            if($cash){
                $cash_for_month[] = $cash;
            }else{
                $cash_for_month[] = 0;
            }
			$m_condition['pay_type'] = 1;
			$alipay = $order_model->where($m_condition)->sum("total_amount");//条件店铺在条件月内的每一天营业额
            $month_alipay += $alipay;
            if($alipay){
                $alipay_for_month[] = $alipay;
            }else{
                $alipay_for_month[] = 0;
            }
            $m_condition['pay_type'] = 2;
			$wechat = $order_model->where($m_condition)->sum("total_amount");//条件店铺在条件月内的每一天营业额
            $month_wechat += $wechat;
            if($wechat){
                $wechat_for_month[] = $wechat;
            }else{
                $wechat_for_month[] = 0;
            }

            // 新增一个余额
            $m_condition['pay_type'] = 4;
            $remainder = $order_model->where($m_condition)->sum("total_amount");//条件店铺在条件月内的每一天营业额
            $month_remainder += $remainder;
            if($remainder){
                $remainder_for_month[] = $remainder;
            }else{
                $remainder_for_month[] = 0;
            }
        }
       	
		$data["cash_for_month"]  = $cash_for_month;
		$data["alipay_for_month"] = $alipay_for_month;
		$data["wechat_for_month"] = $wechat_for_month;
        $data["sales_for_month"] = $sales_for_month;
        $data["remainder_for_month"] = $remainder_for_month;    // 新增一个余额
        $data["month_sales"] = $month_sales;				//条件月内的营业总额
        return $data;
    }

    /**
     * 获取某一年的销售情况
     * @param $year
     * @return array();
     */
    public function annualSales($year,$restaurant_id){
        $order_model = D("order");
        $month_list = monthForYear($year);	//返回当前年份的12个月，形如2016-1,2016-2的时间戳
        $sales_for_year = array();
        $m_condition['restaurant_id'] = $restaurant_id;
        foreach($month_list as $k => $v){
        	$m_condition['order_status'] = array("neq",0);
            $m_condition['pay_time'] = array("between",array($v['month_start'],$v['month_end']));//支付时间在每个月内
//            $m_condition['pay_type'] = array("in",'0,1,2');
            $m_condition['pay_type'] = array("in",'0,1,2,4');   // 增加了一个余额
			$m_condition['order_type'] = array("in",'1,2,3');
            $sales = $order_model->where($m_condition)->sum("total_amount");	 //每个月内的订单总营业额	
            if($sales){
                $sales_for_year[] = $sales;				//一年内的订单总营业额
            }else{
                $sales_for_year[] = 0;
            }
			$m_condition['pay_type'] = 0;
			$cash = $order_model->where($m_condition)->sum("total_amount");	 //每个月内的订单类型为现金总营业额	
			if($cash){
				$cash_for_year[] = $cash;
			}else{
				$cash_for_year[] = 0;
			}
			$m_condition['pay_type'] = 1;
			$alipay = $order_model->where($m_condition)->sum("total_amount");	 //每个月内的订单类型为支付宝总营业额	
			if($alipay){
				$alipay_for_year[] = $alipay;
			}else{
				$alipay_for_year[] = 0;
			}
			$m_condition['pay_type'] = 2;
			$wechat = $order_model->where($m_condition)->sum("total_amount");	 //每个月内的订单类型为微信总营业额	
			if($wechat){
				$wechat_for_year[] = $wechat;
			}else{
				$wechat_for_year[] = 0;
			}

            // 新增一个余额:每个月内的订单类型为余额总营业额
            $m_condition['pay_type'] = 4;
            $remainder = $order_model->where($m_condition)->sum("total_amount");	 //每个月内的订单类型为现金总营业额
            if($remainder){
                $remainder_for_year[] = $remainder;
            }else{
                $remainder_for_year[] = 0;
            }

        }
		$data['wechat_for_year'] = $wechat_for_year;
		$data['alipay_for_year'] = $alipay_for_year;
		$data['cash_for_year'] = $cash_for_year;
        $data["sales_for_year"] = $sales_for_year;
        $data["remainder_for_year"] = $remainder_for_year;
        return $data;
    }

    /**
     * 数据统计data页数据渲染
     */
    public function data(){
        $restaurant_id = session("restaurant_id");
        //查询该店开店的年份

        $order_model = D("order");
        $condition['pay_time'] = array("neq",0);
//		$condition['pay_type'] = array("in",'0,1,2');
		$condition['pay_type'] = array("in",'0,1,2,4');     // 多了余额(4)
		$condition['order_type'] = array("in",'1,2,3');
		$condition['restaurant_id'] = $restaurant_id;
		$condition['order_status'] = array("neq",0);
        $years = $order_model->where($condition)->field("pay_time")->select();
        $year_list = array();

		if(empty($years)){
			$when_year = date("Y");
			$year_list[] = $when_year;
		}

        foreach($years as $key => $val){
            /*if(in_array($year_list,$val['pay_time']) || empty($year_list)){
                $year_list[] = date("Y",$val['pay_time']);
            }*/
            $yearss = date("Y",$val['pay_time']);
         	$year_list[] = $yearss;	
        }


		$unique_arr = array_unique ( $year_list );
        $this->assign("year_list",$unique_arr);

        //查询该店今年的销售情况，分月份查询
        $year = date("Y");
        $month = date("m");

        $this->assign("year",$year);
        $this->assign("month",$month);
        $this->assign("restaurant_id",$restaurant_id);
        $yearData = $this->annualSales($year,$restaurant_id);	//获取某一年的销售情况
        $sales_for_year = $yearData["sales_for_year"];
        //获取当月的销售每一天的销售情况和当月的销售总额
        $monthData = $this->monthlySales($year,$month,$restaurant_id);
        $month_sales = $monthData['month_sales'];			//条件月的营业额
        $sales_for_month = $monthData['sales_for_month'];
        //dump($sales_for_month);
        //获取上个月的销售总量计算销售波动百分比
        if($month-1>0){//$month不等于1月时
            $monthData2 = $this->monthlySales($year,$month-1,$restaurant_id);
        }else{//month等于1月时
            $monthData2 = $this->monthlySales($year-1,12,$restaurant_id);
        }

        $month_sales2 = $monthData2['month_sales'];			//条件月的上一个月营业额
        if($month_sales2 == 0 && $month_sales != 0){		//条件月的营业额
            $salesPercent = 1;								//上一个月无营业额，而条件月营业额不为0，波动比为1
        }elseif($month_sales2 == 0 && $month_sales == 0){
            $salesPercent = 0;								//条件月和上个月都无营业额，波动比为0
        }else{
            $salesPercent = ($month_sales-$month_sales2)/$month_sales2;		//(条件月-上个月)/上个月
        }
        if($salesPercent < 0){
            $salesPercent = (0-$salesPercent)*100;
            $status = "下降";
        }else{
            $salesPercent = $salesPercent*100;
            $status = "上升";
        }
        $salesInfo = $month."月共销售：".number_format($month_sales,2)."元，同比上月".$status.number_format($salesPercent,2)."%";
		$cash_for_year = $yearData['cash_for_year'];
		$alipay_for_year = $yearData['alipay_for_year'];
		$wechat_for_year = $yearData['wechat_for_year'];
		$remainder_for_year = $yearData['remainder_for_year'];    // 新增一个余额

		$cash_for_month = $monthData['cash_for_month'];
		$alipay_for_month = $monthData['alipay_for_month'];
		$wechat_for_month = $monthData['wechat_for_month'];
		$remainder_for_month = $monthData['remainder_for_month'];     // 新增一个余额

		$day_count = get_days_by_year($year,$month);
		$this->assign("day_count",$day_count);
        $this->assign("salesInfo",$salesInfo);
        $this->assign("month_sales",$month_sales);						//条件月的营业额
        $this->assign("sales_for_year",json_encode($sales_for_year));	//条件年内每个月的营业额情况
        $this->assign("cash_for_year",json_encode($cash_for_year));		//年——现金
        $this->assign("alipay_for_year",json_encode($alipay_for_year));	//年——支付宝
        $this->assign("wechat_for_year",json_encode($wechat_for_year));	//年——微信
        $this->assign("remainder_for_year",json_encode($remainder_for_year));	// 新增：年——余额

        $this->assign("cash_for_month",json_encode($cash_for_month));		//月——现金
        $this->assign("alipay_for_month",json_encode($alipay_for_month));	//月——支付宝
        $this->assign("wechat_for_month",json_encode($wechat_for_month));	//月——微信
        $this->assign("remainder_for_month",json_encode($remainder_for_month));	//新增：月——余额
        $this->assign("sales_for_month",json_encode($sales_for_month));	//条件月内每天的营业额情况
        $this->display();
    }

	//年变化后的，图表变化
    public function ajax_sales_for_year(){
        $year = I("post.year");
        $restaurant_id = I("post.restaurant_id");
        $data = $this->annualSales($year,$restaurant_id);
        exit(json_encode($data));
    }

    public function ajax_sales_for_month(){
        $year = I("post.year");
        $month = I("post.month");
        $restaurant_id = I("post.restaurant_id");
        $data = $this->monthlySales($year,$month,$restaurant_id);

        //获取上个月的销售总量计算销售波动百分比
        if($month-1>0){
            $monthData2 = $this->monthlySales($year,$month-1,$restaurant_id);
        }else{
            $monthData2 = $this->monthlySales($year-1,12,$restaurant_id);
        }

        $month_sales = $data['month_sales'];

        $month_sales2 = $monthData2['month_sales'];
        if($month_sales2 == 0 && $month_sales != 0){
            $salesPercent = 1;
        }elseif($month_sales2 == 0 && $month_sales == 0){
            $salesPercent = 0;
        }else{
            $salesPercent = ($month_sales-$month_sales2)/$month_sales2;
        }

        if($salesPercent < 0){
            $salesPercent = (0-$salesPercent)*100;
            $status = "下降";
        }else{
            $salesPercent = $salesPercent*100;
            $status = "上升";
        }
        $salesInfo = $month."月共销售：".number_format($month_sales,2)."元，同比上月".$status.number_format($salesPercent,2)."%";
        $data['salesInfo'] = $salesInfo;
        exit(json_encode($data));
    }

	public function exportExcel(){			//导出Excel表
		 /**
         * 搜索条件
         */
        $startDate = I("post.startDate");				//条件时间范围查询
        $startTime = I("post.startTime");
        $endDate = I("post.endtDate");
        $endTime = I("post.endTime");
	    $condition = array();			//声明条件数组
						
	    //判断是否有时间，有则添加到查询寻条件
	    if(!empty($startDate) && !empty($startTime) && !empty($endDate) && !empty($endTime)){
	        $startTimeStr = strtotime($startDate." ".$startTime);
	        $endTimeStr = strtotime($endDate." ".$endTime);
	        $condition['pay_time'] = array("between",array($startTimeStr,$endTimeStr));
	    }
        //支付类型
        $pay_type = I("post.pay_type");					
        if(!empty($pay_type)){
            $condition['pay_type'] = array("in",$pay_type);
        }

        $pay_type_str = array(
            "现金","支付宝","微信","","余额"				//(0,1,2,4)
        );
		
        $pay_str = "";
        foreach($pay_type as $vp){
            $pay_str .= $pay_type_str[$vp]."、";
        }
        $this->assign("pay_str",$pay_str);

        //就餐方式
        $order_type = I("post.order_type");
        if(!empty($order_type)){
            $condition['order_type'] = array("in",$order_type);
        }

        $order_type_str = array(
            "店内点餐","打包带走"
        );

        $order_str = "";
        foreach($order_type as $vod){
            $order_str .= $order_type_str[$vod-1]."、";
        }
		
        $this->assign("order_str",$order_str);

        $orderModel = D("order");						//查询当前店铺条件范围下的订单集
		$condition['restaurant_id'] = session('restaurant_id');

		$orderArr = $orderModel->where($condition)->field('order_id,order_sn,order_type,pay_type,pay_time')->select();
		//dump($orderArr);
		$order_food = D('order_food');

		$order_type = array(
			1 => "店吃",
			2 => "打包带走",
			3 => "微信外卖",
		);

		$pay_type = array(
			0 => "现金",
			1 => "支付宝",
			2 => "微信",
			3 => "未支付",
			4 => "余额支付",
		);

        $o_condition['pay_time'] = array("between",array($startTime,$endTime));
        $orderInfo = $orderModel->field("order_sn,total_amount,pay_time")->where($o_condition)->select();

        $title = array(
            "订单号","总价","支付时间"
        );


        $order_str = "";
        foreach($order_type as $vod){
            $order_str .= $order_type_str[$vod-1]."、";
        }
        $this->assign("order_str",$order_str);

        $orderModel = D("order");						//查询当前店铺条件范围下的订单集
		$condition['restaurant_id'] = session('restaurant_id');
		
		$orderArr = $orderModel->where($condition)->field('order_id,order_sn,order_type,pay_type,pay_time')->select();
		//dump($orderArr);
		$order_food = D('order_food');
			
		$orderList = array();
		foreach($orderArr as $key=>$value){		
			$value['order_type'] = $order_type[$value['order_type']];
			$value['pay_type'] = $pay_type[$value['pay_type']];
			$value['pay_time'] = date("Y-m-d h:i:s",$value['pay_time']);
			$where['order_id'] = $value['order_id'];
			$food_info = $order_food->where($where)->field('food_name,food_num,food_price2')->select();	
			foreach($food_info as $key1=>$value1){
				$food_info[$key1]['total_price'] = number_format($value1["food_price2"]*$value1["food_num"],2);
				//$orderList[] = array_merge($food_info[$key1],$value);
				$obj = array_merge($food_info[$key1],$value);
				$obj1['order_sn'] = $obj['order_sn'];
				$obj1['food_name'] = $obj['food_name'];
				$obj1['pay_time'] = $obj['pay_time'];
				$obj1['order_type'] = $obj['order_type'];
				$obj1['pay_type'] = $obj['pay_type'];
				$obj1['food_price2'] = $obj['food_price2'];
				$obj1['food_num'] = $obj['food_num'];
				$obj1['total_price'] = $obj['total_price'];
				$orderList[] = $obj1;
			}
		}
		$xlsName  = "营业额报表、导出时间(".date("Y-m-d",time()).")";
        $xlsCell  = array(
        array('order_sn','订单号'),
        array('food_name','菜品'),
        array('pay_time','日期时间'),
        array('order_type','就餐方式'),
        array('pay_type','支付方式'),       
        array('food_price2','单价'),
        array('food_num','数量'),
        array('total_price','总价')
        );
        exportExcel($xlsName,$xlsCell,$orderList);
	}


	 public function exportExcel1(){
        /**
         * 获取查询的条件，查询相关订单信息
         */
        $startDate = I("post.startDate");
        $startTime = I("post.startTime");
        $endDate = I("post.endtDate");
        $endTime = I("post.endTime");

        $condition = array();
        //判断是否有时间，有则添加到查询寻条件
        if(!empty($startDate) && !empty($startTime) && !empty($endDate) && !empty($endTime)){
            $startTimeStr = strtotime($startDate." ".$startTime);
            $endTimeStr = strtotime($endDate." ".$endTime);
            $condition['pay_time'] = array("between",array($startTimeStr,$endTimeStr));
        }

        //支付类型
        $pay_type = I("post.pay_type");
        if(!empty($pay_type)){
            $condition['pay_type'] = array("in",$pay_type);
        }

        $pay_type_str = array(
            "现金","支付宝","微信","","余额"
        );
        $pay_str = "";
        foreach($pay_type as $vp){
            $pay_str .= $pay_type_str[$vp]."、";
        }

        $this->assign("pay_str",$pay_str);

        //就餐方式
        $order_type = I("post.order_type");
        if(!empty($order_type)){
            $condition['order_type'] = array("in",$order_type);
        }

        $order_type_str = array(
            "店内点餐","打包带走"
        );

        $order_str = "";
        foreach($order_type as $vod){
            $order_str .= $order_type_str[$vod-1]."、";
        }
        $this->assign("order_str",$order_str);

        $condition['restaurant_id'] = session("restaurant_id");

        $order_model = D("order");
        $order_list = $order_model->where($condition)->field("order_id")->select();
        $orders2 = array();
        foreach($order_list as $order_key => $order_val){
            $orders2[] = $order_val["order_id"];
        }

        if(empty($orders2)){
            exit;
        }

        /**
         * 计算搜索菜品的销售情况
         */
        $food_name = I("post.food_name");

        //获取菜品的id
        $f_condition['food_name'] = array("like","%".$food_name."%");
        $f_condition['order_id'] = array("in",$orders2);
        $food_model = D("order_food");
        $order_list2 = $food_model->where($f_condition)->field("order_id,food_name,food_price2,food_num")->select();


		$order_type2 = array(
//		（1店吃，2打包带走，3微信外卖）
			1 => "店吃",
			2 => "打包带走",
			3 => "微信外卖",
		);
		
		$pay_type2 = array(
//		（0现金，1支付宝，2微信，3未支付）
			0 => "现金",
			1 => "支付宝",
			2 => "微信",
			3 => "未支付",
			4 => "余额",
		);

        //计算销售总额
        $all_total_amount = 0;
        foreach($order_list2 as $kt => $vt){
            $lso_condition['order_id'] = $vt['order_id'];
            $order = $order_model->where($lso_condition)->find();
            $all_total_amount+=$vt["food_price2"];
            $order_list2[$kt]['pay_time'] = date("Y-m-d H:i:s",$order['pay_time']);
           	$order_list2[$kt]['pay_type'] = $pay_type2[$order['pay_type']];
			$order_list2[$kt]['order_sn'] = $order['order_sn'];
			$order_list2[$kt]['total_amount'] = number_format($vt["food_price2"]*$vt["food_num"],2);	
			$order_list2[$kt]['order_type'] = $order_type2[$order['order_type']];
			$order_list2[$kt]['f_type'] = 1;   
        }
		
		$order_list3 = array();
		foreach($order_list2 as $key=>$value){
			$order_list3[$key]['order_sn'] = $value['order_sn'];
			$order_list3[$key]['food_name'] = $value['food_name'];
			$order_list3[$key]['pay_time'] = $value['pay_time'];
			$order_list3[$key]['order_type'] = $value['order_type'];
			$order_list3[$key]['pay_type'] = $value['pay_type'];
			$order_list3[$key]['food_price2'] = $value['food_price2'];
			$order_list3[$key]['food_num'] = $value['food_num'];
			$order_list3[$key]['total_amount'] = $value['total_amount'];	
		}
		
		$order_food_attributeModel = D('order_food_attribute');
		$attr_all_orderfoodId = array();
		foreach($orders2 as $os2_key=>$os2_value){
			$os2_condition['order_id'] = $os2_value;
			$attr_one_orderfoodId = $food_model->where($os2_condition)->field('order_food_id')->select();
			$attr_orderfoodIdArr = array();
			foreach($attr_one_orderfoodId as $aoof_key=>$aoof_value){
				$attr_orderfoodIdArr[$aoof_key] = $aoof_value['order_food_id'];
			}
			$attr_all_orderfoodId[] = $attr_orderfoodIdArr;
		}
		
		$attr_all_orderfoodId1 = arrayChange($attr_all_orderfoodId);
		//dump($attr_all_orderfoodId1);
		$f_condition1['food_attribute_name'] = array("like","%".$food_name."%");
        $f_condition1['order_food_id'] = array("in",$attr_all_orderfoodId1);
		$all_attrArr = $order_food_attributeModel->where($f_condition1)->field("order_food_id,food_attribute_name,food_attribute_price,count_type")->select();
		//dump($all_attrArr);
		$order_list4 = array();
		foreach($all_attrArr as $aaA_key=>$aaA_value){
			if($aaA_value['count_type'] == 1){
				$orl3_condition['order_food_id'] = $aaA_value['order_food_id'];
				$attr_order_id = $food_model->where($orl3_condition)->field('order_id')->find()['order_id'];
				//$order_list4[$aaA_key]['order_id'] = $attr_order_id;
				$order_list4[$aaA_key]['order_sn'] = $order_model->where("order_id=$attr_order_id")->field('order_sn')->find()['order_sn'];
				$order_list4[$aaA_key]['food_name'] = $aaA_value['food_attribute_name'];
				$order_list4[$aaA_key]['pay_time'] = date('Y-m-d H:i:s',$order_model->where("order_id=$attr_order_id")->field("pay_time")->find()['pay_time']);
				$order_list4[$aaA_key]['order_type'] = $order_type2[$order_model->where("order_id=$attr_order_id")->field("order_type")->find()['order_type']];
				$order_list4[$aaA_key]['pay_type'] = $pay_type2[$order_model->where("order_id=$attr_order_id")->field("pay_type")->find()['pay_type']];
				$order_list4[$aaA_key]['food_price2'] = $aaA_value['food_attribute_price'];
				$order_list4[$aaA_key]['food_num'] = 1;
				$order_list4[$aaA_key]['total_amount'] = $aaA_value['food_attribute_price'];		
			}
		}
		$all_countInfoArr = array();				//合并菜品与菜品属性数组(两数组格式相同，只是把查出来的第二个数组加在第一个数组尾部使其连贯)
		foreach($order_list3 as $ol2_value){
			$all_countInfoArr[] = $ol2_value;
		}
		foreach($order_list4 as $ol3_value){
			$all_countInfoArr[] = $ol3_value;
		}
		
       	$xlsName  = "营业额报表、导出时间(".date("Y-m-d",time()).")";
        $xlsCell  = array(
        array('order_sn','订单号'),
        array('food_name','菜品'),
        array('pay_time','日期时间'),
        array('order_type','就餐方式'),
        array('pay_type','支付方式'),       
        array('food_price2','单价'),
        array('food_num','数量'),
        array('total_amount','总价')
        );
        exportExcel($xlsName,$xlsCell,$all_countInfoArr);
    }

	//菜品图表
	public function food_chart(){	
		if(I('commit_type') != ""){
			$startDate = I('startDate');		
			$endDate = I('endtDate');
			$startTime =I('startTime');	
			$endTime = I('endTime');
		}else{
			$beginThisMonth=mktime(0,0,0,date('m'),date('d'),date('Y'));		//开始日期（当前年当前月的日期）
	        $endThisMonth=mktime(23,59,59,date('m'),date('t'),date('Y'));		//结束日期（当前年当前月的日期）
	        $startDate = date("Y-m-d",$beginThisMonth);					
	        $endDate = date("Y-m-d",$endThisMonth);
	        $startTime = "00:00:00";
	        $endTime = "23:59:59";
		}	
		$this->assign("startDate",$startDate);
		$this->assign("endDate",$endDate);
		$this->assign("startTime",$startTime);
	    $this->assign("endTime",$endTime);	
			
		$condition = array();
        //判断是否有时间，有则添加到查询寻条件
        if(!empty($startDate) && !empty($startTime) && !empty($endDate) && !empty($endTime)){
            $startTimeStr = strtotime($startDate." ".$startTime);
            $endTimeStr = strtotime($endDate." ".$endTime);
            $condition['pay_time'] = array("between",array($startTimeStr,$endTimeStr));			
        }
		

        $condition["restaurant_id"] = session('restaurant_id');
		$condition['order_status'] = array("neq",0);				//订单状态为已支付
        $order = D("order");
		$whenResturant_OrderArr = $order->where($condition)->field('order_id')->select();		//符合条件的订单
	
		
		if(!empty($whenResturant_OrderArr)){
			$OrderArr = array();						//符合时间条件下的所有订单ID数组
			foreach($whenResturant_OrderArr as $key=>$value){
				$OrderArr[] = $value['order_id'];		//把订单ID拼成索引数组
			}
			
			$order_food = D('order_food');
			$condition1['order_id'] = array("in",$OrderArr);
			$p = I('page')?I('page'):1;
			$count = count($order_food->where($condition1)->distinct(true)->field('food_id')->select());
			$pageNum = 100;		
			$Page = new \Think\Page($count,$pageNum);
			$show = $Page->show();
			$food_idArr = $order_food->where($condition1)->distinct(true)->field('food_id')->page($p,$pageNum)->select();	//查找出不同菜品(条件内)
			
			$all_foodinfo = array();
			$order_food_attribute = D('order_food_attribute');
			$allAttribute_Arr1 = array();
			foreach($food_idArr as $key1=>$value1){		//符合条件内的所有order_food表记录
			//菜品名(foreach循环内的每个菜品)
				$condition2['food_id'] = $value1['food_id'];
				$all_foodinfo[$key1]['food_name'] = $order_food->where($condition2)->field('food_name')->find()['food_name'];
			//菜品份数(foreach循环内的每个菜品)
				$condition2['order_id'] = array("in",$OrderArr);		
				$food_numArr = $order_food->where($condition2)->field('food_num')->select();		
				foreach($food_numArr as $kn=>$vn){
					$all_foodinfo[$key1]['food_num'] += $vn['food_num']; 	
				}
			//order_food_id集合(foreach循环内的每个菜品)
				$order_food_idArr = $order_food->where($condition2)->field('order_food_id,food_num')->select();
			//属性集合(foreach循环内的每个菜品)
				$allAttribute_Arr = array();		
				foreach($order_food_idArr as $ofir_key => $ofir_val){			
					$of_condition['order_food_id'] = $ofir_val['order_food_id'];
					$count_typeArr = $order_food_attribute->where($of_condition)->field('food_attribute_name,count_type')->select();
					if($count_typeArr){
			//属性集合(该菜品下的每个order_food_id)			
					$count_typeArr1 = array();			
					foreach($count_typeArr as $ctrkey=>$ctrvalue){				//每个菜品里的所有属性，统计属性的数组
						if($ctrvalue['count_type'] == 1){
							$count_typeArr1[$ctrvalue['food_attribute_name']] = $ofir_val['food_num'];
						}
					}
					
					$allAttribute_Arr[$ofir_key] = $count_typeArr1;			//每一个菜品下的属性列表
					}
				}
				//dump($allAttribute_Arr);
				
				
				
				
				foreach($allAttribute_Arr as $aAbA_key =>$aAbA_value){		//总的菜品属性列表
					foreach($aAbA_value as $bA_key=>$bA_value){
						if (array_key_exists($bA_key,$allAttribute_Arr1)){
							$allAttribute_Arr1[$bA_key] = $allAttribute_Arr1[$bA_key]+$bA_value;
						}else{
							$allAttribute_Arr1[$bA_key] = $bA_value;
						}		
					}
				}
				
				
				//-------------------------------去年该菜品在12个月中每个月的份数-----------------------
				$last_year = date('Y',strtotime("-1 year")); 
				$lastyear_monthArr = monthForYear($last_year);
				$lastyear_allOrderNum = array();	
				foreach($lastyear_monthArr as $key2=>$value2){	
					$condition['pay_time'] = array('between',array($value2['month_start'],$value2['month_end']));
					$whenResturant_OrderArr1 = $order->where($condition)->field('order_id')->select();
					$lastyear_OrderIdArr = array();						
					foreach($whenResturant_OrderArr1 as $key3=>$value3){
						$lastyear_OrderIdArr[] = $value3['order_id'];		//去年、符合条件的每个月订单ID集
					}
					if(!empty($lastyear_OrderIdArr)){
						$condition3['order_id'] = array("in",$lastyear_OrderIdArr);
						$condition3['food_id'] = $value1['food_id'];		
						$food_numArr1 = $order_food->where($condition3)->field('food_num')->select();		
						foreach($food_numArr1 as $kn1=>$vn1){
							$lastyear_allOrderNum[$key2] += $vn1['food_num'];	//去年，符合条件的每个月该菜品的份数
						}
					}else{
						$lastyear_allOrderNum[$key2] = 0;
					}	
				}
				$all_foodinfo[$key1]['year'] = $last_year;								//去年年份
				$all_foodinfo[$key1]['lastyear_allOrderNum'] = $lastyear_allOrderNum;	//去年的12个月该菜品份数的数组
				$all_foodinfo[$key1]['Num_sum'] = array_sum($lastyear_allOrderNum);		
						
				//-------------------------------前年该菜品在12个月中每个月的份数-----------------------		
				$previous_year = date('Y',strtotime("-2 year"));
				$lastyear_monthArr1 = monthForYear($previous_year);
				$lastyear_allOrderNum1 = array();	
				foreach($lastyear_monthArr1 as $key3=>$value3){							//将一年分为12个月
					$condition['pay_time'] = array('between',array($value3['month_start'],$value3['month_end']));
					$whenResturant_OrderArr2 = $order->where($condition)->field('order_id')->select(); //每月的订单集
					$lastyear_OrderIdArr1 = array();						
					foreach($whenResturant_OrderArr2 as $key4=>$value4){
						$lastyear_OrderIdArr1[] = $value4['order_id'];
					}
					if(!empty($lastyear_OrderIdArr1)){
						$condition4['order_id'] = array("in",$lastyear_OrderIdArr1);
						$condition4['food_id'] = $value1['food_id'];
						
						$food_numArr2 = $order_food->where($condition4)->field('food_num')->select();		//当前条年的菜品份数
						foreach($food_numArr2 as $kn2=>$vn2){
							$lastyear_allOrderNum1[$key3] += $vn2['food_num'];		
						}
					}else{
						$lastyear_allOrderNum1[$key3] = 0;
					}	
				}	
				$all_foodinfo[$key1]['year1'] = $previous_year;
				$all_foodinfo[$key1]['lastyear_allOrderNum1'] = $lastyear_allOrderNum1;
				$all_foodinfo[$key1]['Num_sum1'] = array_sum($lastyear_allOrderNum1);
			}
			//dump($allAttribute_Arr1);	
			$this->assign("page",$show);
			$this->assign("all_foodinfo",$all_foodinfo);
			$this->assign("all_attributeArr",$allAttribute_Arr1);
			
			$num_arr = array();
			foreach($all_foodinfo as $key5=>$value5){
				$num_arr[] = $value5['food_num'];
			}
			
			foreach($allAttribute_Arr1 as $aAA_value){
				$num_arr[] = $aAA_value;
			}
			
			$step_length = 500/max($num_arr);
			$this->assign("step_length",round($step_length ,2));
		}
		$this->display();
	}

	public function exportExcal_num(){
		$startDate = I('startDate');		
		$endDate = I('endtDate');
		$startTime =I('startTime');	
		$endTime = I('endTime');	
		$condition = array();
        //判断是否有时间，有则添加到查询寻条件
        if(!empty($startDate) && !empty($startTime) && !empty($endDate) && !empty($endTime)){
            $startTimeStr = strtotime($startDate." ".$startTime);
            $endTimeStr = strtotime($endDate." ".$endTime);
            $condition['pay_time'] = array("between",array($startTimeStr,$endTimeStr));		
        }

        $condition["restaurant_id"] = session('restaurant_id');
		$condition['order_status'] = array("neq",0);
        $order = D("order");
		
		$whenResturant_OrderArr = $order->where($condition)->field('order_id')->select();		//符合条件的订单
		
		if(!empty($whenResturant_OrderArr)){
			$OrderArr = array();
			foreach($whenResturant_OrderArr as $key=>$value){
				$OrderArr[] = $value['order_id'];												//把订单ID拼成索引数组
			}
			
			$order_food = D('order_food');
			$condition1['order_id'] = array("in",$OrderArr);
			$food_idArr = $order_food->where($condition1)->distinct(true)->field('food_id')->select();	//查找出不同菜品(条件内)
			
			$all_foodinfo = array();
			foreach($food_idArr as $key1=>$value1){
				$condition2['food_id'] = $value1['food_id'];
				$all_foodinfo[$key1]['food_name'] = $order_food->where($condition2)->field('food_name')->find()['food_name'];		//菜品名
				$condition2['order_id'] = array("in",$OrderArr);
				$food_numArr = $order_food->where($condition2)->field('food_num')->select();		//当前条年的菜品份数
				foreach($food_numArr as $kn=>$vn){
					$all_foodinfo[$key1]['food_num'] += $vn['food_num']; 
				}
				$last_year = date('Y',strtotime("-1 year")); //去年
				$lastyear_monthArr = monthForYear($last_year);
				$lastyear_allOrderNum = array();	
				foreach($lastyear_monthArr as $key2=>$value2){	
					$condition['pay_time'] = array('between',array($value2['month_start'],$value2['month_end']));
					$whenResturant_OrderArr1 = $order->where($condition)->field('order_id')->select();
					$lastyear_OrderIdArr = array();						//当月的订单
					foreach($whenResturant_OrderArr1 as $key3=>$value3){
						$lastyear_OrderIdArr[] = $value3['order_id'];
					}
					if(!empty($lastyear_OrderIdArr)){
						$condition3['order_id'] = array("in",$lastyear_OrderIdArr);
						$condition3['food_id'] = $value1['food_id'];
						$food_numArr1 = $order_food->where($condition3)->field('food_num')->select();		//当前条年的菜品份数
						foreach($food_numArr1 as $kn1=>$vn1){
							$lastyear_allOrderNum[$key2] += $vn1['food_num'];		
						}
					}else{
						$lastyear_allOrderNum[$key2] = 0;
					}	
				}
				$all_foodinfo[$key1]['year'] = $last_year;								//去年年份
				$all_foodinfo[$key1]['lastyear_allOrderNum'] = $lastyear_allOrderNum;	//去年的每月该菜品份数
				
				
				$previous_year = date('Y',strtotime("-2 year"));//前年
				$lastyear_monthArr1 = monthForYear($previous_year);
				$lastyear_allOrderNum1 = array();	
				foreach($lastyear_monthArr1 as $key3=>$value3){							//将一年分为12个月
					$condition['pay_time'] = array('between',array($value3['month_start'],$value3['month_end']));
					$whenResturant_OrderArr2 = $order->where($condition)->field('order_id')->select(); //每月的订单集
					$lastyear_OrderIdArr1 = array();						
					foreach($whenResturant_OrderArr2 as $key4=>$value4){
						$lastyear_OrderIdArr1[] = $value4['order_id'];
					}
					if(!empty($lastyear_OrderIdArr1)){
						$condition4['order_id'] = array("in",$lastyear_OrderIdArr1);
						$condition4['food_id'] = $value1['food_id'];
						$food_numArr2 = $order_food->where($condition4)->field('food_num')->select();		//当前条年的菜品份数
						foreach($food_numArr2 as $kn2=>$vn2){
							$lastyear_allOrderNum1[$key3] += $vn2['food_num'];		
						}
					}else{
						$lastyear_allOrderNum1[$key3] = 0;
					}	
				}	
				$all_foodinfo[$key1]['year1'] = $previous_year;
				$all_foodinfo[$key1]['lastyear_allOrderNum1'] = $lastyear_allOrderNum1;
				$all_foodinfo[$key1]['sort'] = $key1+1;
			}
		}
			//dump($all_foodinfo);
			$xlsName  = "菜品图表、导出时间(".date("Y-m-d",time()).")";
	        $xlsSearchDate = "日期：".date("Y-m-d h:i:s",$startTimeStr)." 至 ".date("Y-m-d h:i:s",$endTimeStr);; 
	       	exportExcel1($xlsName,$xlsSearchDate,$all_foodinfo);
	}



	
}