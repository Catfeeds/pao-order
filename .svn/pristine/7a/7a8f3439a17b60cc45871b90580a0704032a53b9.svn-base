<?php
namespace Mobile\Controller;
use Think\Controller;
class WeixinController extends Controller {
        #　会员同意授权，如果用户同意授权，页面将跳转至 redirect_uri/?code=CODE&state=STATE。
    public function getUserDetail(){
        // 1、获取到code
        $appid = "wxa9be3598671d1982";  // 云牛appid
        $redirect_uri = urlencode("http://shop.founya.com/index.php/Mobile/member/receiver_weixin");    // 获取到授权后要跳转到的地址
        $url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=".$appid."&redirect_uri=".$redirect_uri."&response_type=code&scope=snsapi_userinfo&state=123#wechat_redirect";
        header("location:".$url);
    }
}