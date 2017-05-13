<?php
namespace Admin\Controller;
use Think\Controller;
class DataDockController extends Controller {

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

    /**
     * 获取支付信息
     */
    public function dataForPay(){
        $configModel = D("config");
        $condition['config_type'] = "wxpay";
        $condition['restaurant_id'] = session('restaurant_id');
        $wx_config = $configModel->where($condition)->select();
        $wx_config_list = dealConfigKeyForValue($wx_config);
        $this->assign("wx_config",$wx_config_list);

        $condition['config_type'] = "alipay";
        $alipay_config = $configModel->where($condition)->select();
        $alipay_config_list = dealConfigKeyForValue($alipay_config);
        $this->assign("alipay_config",$alipay_config_list);

        $pay_select_model = D('pay_select');
        $ps_condition['restaurant_id'] = session('restaurant_id');
        $pay_select_config = $pay_select_model->where($ps_condition)->select();

        $this->assign("pay_select",$pay_select_config);

        $restaurant_other_info = D("restaurant_other_info");
        $roi_where['restaurant_id'] = session("restaurant_id");
//        $roi_where['restaurant_id'] = 111;
        $rel = $restaurant_other_info->where($roi_where)->find();
        $pid = $rel['pay_number'];
        if(empty($pid)){
            $pid = 0;
        }
        $this->assign("pid",$pid);

        $this->display();
    }

    /**
     * 增加修改支付信息
     */
    public function editAddPayInfo(){
        $type = I("get.type");
        $configModel = D('config');
        $configModel->startTrans();
        $pay_data = I('post.');
        $data['restaurant_id'] = session("restaurant_id");
        $data['config_type'] = $type;
        foreach($pay_data as $key => $val){
            $data['config_name'] = $key;
            $data['config_value'] = $val;
            $condition['config_name'] = $key;
            $condition['restaurant_id'] = $data['restaurant_id'];
            $tempRel = $configModel->field("config_id")->where($condition)->find();

            if($tempRel){
                $data2['config_id'] = $tempRel['config_id'];
                $rel = $configModel->where($data2)->save($data);
            }else{
                $rel = $configModel->add($data);
            }
            if($rel === false){
                $configModel->rollback();
            }
        }
        $configModel->commit();
    }

    /**
     * 增加/修改打印机
     */
    public function addEditPrinter(){
        $type = I("post.type");
        $printerModel = D("printer");
        $printerInfo = $printerModel->create();
        $printerInfo['restaurant_id'] = session('restaurant_id');
        if($type == "add"){
            $rel = $printerModel->add($printerInfo);
        }
        if($type == "edit"){
//            dump($printerInfo);
            $rel = $printerModel->save($printerInfo);
        }

        if($rel !== false){
            $returnMsg['code'] = 1;
            $returnMsg['msg'] = "操作成功";
            exit(json_encode($returnMsg));
        }
    }

    /**
     * 打印机显示页面
     */
    public function printer(){
        $printerModel = D("printer");
        $p_condition['restaurant_id'] = session("restaurant_id");
//        dump($p_condition);
        $printList = $printerModel->where($p_condition)->select();
//        dump($printList);
        $this->assign('printList',$printList);
        $this->display();
    }

    /**
     * 删除打印机
     */
    public function deletePrinter(){
        $printer_id = I("post.printer_id");
//        dump($printer_id);
        $condition['printer_id'] = $printer_id;
        $printerModel = D('printer');
        $rel = $printerModel->where($condition)->delete();
        if($rel !== false){
            $returnMsg['code'] = 1;
            $returnMsg['msg'] = "操作成功";
            exit(json_encode($returnMsg));
        }
    }

    /**
     * 获取当前拥有的打印机（返回json数据）
     */
    public function getPrinter(){
        $printerModel = D('printer');
        $condition['restaurant_id'] = session("restaurant_id");
        $printerList = $printerModel->where($condition)->select();
        exit(json_encode($printerList));
    }

    public function selectPay(){
        $pay_select = D('pay_select');
        $data = $pay_select->create();
        $condition['restaurant_id'] = session("restaurant_id");
        $condition['config_name'] = $data['config_name'];
        $pay_select->where($condition)->save($data);
    }

    //获取支付宝授权
    public function setAppAuthToken(){
        $restaurant_id = session("restaurant_id");
        $app_auth_token = I("app_auth_token");
        $user_id = I("user_id");

        $restaurant_other_info = D('restaurant_other_info');

        $data2['restaurant_id'] = $restaurant_id;
        $data['restaurant_id'] = $restaurant_id;
        $data['app_auth_token'] = $app_auth_token;
        $data['pay_number'] = $user_id;

        $find_result = $restaurant_other_info->where($data2)->find();

        if($find_result){
            $add_rel = $restaurant_other_info->where($data2)->save($data);
            if($add_rel){
                echo "授权成功";
            }else{
                echo "授权失败";
            }
        }else{
            $add_rel = $restaurant_other_info->add($data);
            if($add_rel){
                echo "授权成功";
            }else{
                echo "授权失败";
            }
        }
    }

    //支付宝创建门店信息
    public function createShop(){
//        $post_data = I("");
//        if($post_data){
            $app_auth_token = $this->getAppAuthToken();
//            $app_auth_token = "";
            $restaurant_other_info = D('restaurant_other_info');
            vendor("alipayGrant.AopClient");
            $al = new \AopClient();

            $request2 = new \AlipayOfflineMarketShopCreateRequest();

            $content2['store_id'] = "hz009";    // 外部门店编号
            $content2['category_id'] = "2015050700000018";  // 类目ID
            $content2['brand_name'] = "YUNNIU";        // 品牌名
//            $content2['brand_logo'] = "1T8Pp00AT7eo9NoAJkMR3AAAACMAAQEC";   // 品牌LOGO; 图片ID，不填写则默认为门店首图main_image。
            $content2['main_shop_name'] = "爱尚咖啡厅";        // 主门店名
            $content2['branch_shop_name'] = "东圃1011号店";     // 分店名称
            $content2['province_code'] = "440000";          // 省份编码
            $content2['city_code'] = "440100";              // 城市编码
            $content2['district_code'] = "440106";          // 区县编码
            $content2['address'] = "东圃阳光桃源";  //  门店详细地址
            $content2['longitude'] = "113.420738";          // 经度
            $content2['latitude'] = "23.118558";          // 纬度
            $content2['contact_number'] = "13612344321,021-12336754";   // 门店电话号码
            $content2['notify_mobile'] = "13867498729";         // 门店店长电话号码
            $content2['main_image'] = "cH6qfIzsT1iJmAa3GESTswAAACMAAQED";   // 门店首图
            // 门店审核时需要的图片；至少包含一张门头照片，两张内景照片
            $content2['audit_images'] = "cH6qfIzsT1iJmAa3GESTswAAACMAAQED,cH6qfIzsT1iJmAa3GESTswAAACMAAQED,cH6qfIzsT1iJmAa3GESTswAAACMAAQED";    // 门店审核时需要的图片
            $content2['business_time'] = "周一-周五 09:00-20:00,周六-周日 10:00-22:00";
            $content2['wifi'] = "T";
            $content2['parking'] = "F";
            $content2['value_added'] = "免费茶水、免费糖果";
            $content2['avg_price'] = "35";
            $content2['isv_uid'] = "2088421780481061";  // ISV返佣id
            $content2['licence'] = "1T8Pp00AT7eo9NoAJkMR3AAAACMAAQEC";
            $content2['licence_code'] = "H001232";
            $content2['licence_name'] = "广州云牛网络科技有限公司";
//            $content2['business_certificate'] = "cH6qfIzsT1iJmAa3GESTswAAACMAAQED";
//            $content2['business_certificate_expires'] = "2020-03-20";
//            $content2['auth_letter'] = "cH6qfIzsT1iJmAa3GESTswAAACMAAQED";
            $content2['is_operating_online'] = "T";
//            $content2['online_url'] = "http://shop.founya.com";
            $content2['operate_notify_url'] = "http://shop.founya.com/component/test/notifyInfo";
            // $content2['implement_id'] = "HU002,HT002";
            $content2['no_smoking'] = "T";
            $content2['box'] = "T";
            $content2['request_id'] = "2015123235324536";
//            $content2['other_authorization'] = "cH6qfIzsT1iJmAa3GESTswAAACMAAQED";
//            $content2['licence_expires'] = "2020-10-20";
            $content2['op_role'] = "ISV";
            $content2['biz_version'] = "2.0";

            $content2 = json_encode($content2);
            $request2->setBizContent($content2);
            $result2 = $al->execute ( $request2,null,$app_auth_token);

            $responseNode = str_replace(".", "_", $request2->getApiMethodName()) . "_response";

            $resultCode = $result2->$responseNode->code;

            dump($result2);
            if(!empty($resultCode)&&$resultCode == 10000){
                $response = $result2->alipay_offline_market_shop_create_response;
                $shop_id = $response->apply_id;
                $data2['shop_id'] = $shop_id;
                $data['restaurant_id'] = session('restaurant_id');
                $restaurant_other_info->where($data)->save($data2);
                echo "创建成功";
            } else {
                echo "创建失败",$resultCode;
            }
//        }else{
//            $this->display();
//        }
    }

    //支付宝上传门店照片和视频接口
    public function aliUploadImg(){
        vendor("alipayGrant.AopClient");
        vendor("alipayGrant.AlipayOfflineMaterialImageUploadRequest");
        $al = new \AopClient();
        $app_auth_token = $this->getAppAuthToken();
        $request = new \AlipayOfflineMaterialImageUploadRequest();
        $request->setImageType("jpg");
        $request->setImageName("测试图片");
        $request->setImageContent("@"."/www/web/founya/xiaomianmendian.jpg");
        $request->setImagePid("2088021822217233");
        $result = $al->execute ( $request,null,$app_auth_token);

        $responseNode = str_replace(".", "_", $request->getApiMethodName()) . "_response";
        $resultCode = $result->$responseNode->code;
        dump($result);
        if(!empty($resultCode)&&$resultCode == 10000){
            echo "成功";
        } else {
            echo "失败";
        }
    }

    //获取当前店铺的$app_auth_token
    public function getAppAuthToken(){
        $restaurant_id = session("restaurant_id");
        $restaurant_other_info = D('restaurant_other_info');
        $data['restaurant_id'] = $restaurant_id;
        $find_result = $restaurant_other_info->where($data)->find();

        $app_auth_token = $find_result['app_auth_token'];

        return $app_auth_token;
    }
}
