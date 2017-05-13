<?php
return array(
	//'配置项'=>'配置值'
	 /* 数据库设置 */

   	'DB_TYPE'               =>  'mysql',     // 数据库类型
    'DB_HOST'               =>  'localhost', // 服务器地址
    'DB_NAME'               =>  'restaurant',          // 数据库名
    'DB_USER'               =>  'root',      // 用户名
    'DB_PWD'                =>  '123456',          // 密码
    'DB_PORT'               =>  '3306',        // 端口
    'DB_PREFIX'             =>  '',    // 数据库表前缀
    'VAR_PAGE'              =>  'page',



  	/* 'DB_TYPE'               =>  'mysql',     // 数据库类型
     'DB_HOST'               =>  'localhost', // 服务器地址
     'DB_NAME'               =>  'restaurant',          // 数据库名
     'DB_USER'               =>  'root',      // 用户名
     'DB_PWD'                =>  '123456',          // 密码
     'DB_PORT'               =>  '3306',        // 端口
     'DB_PREFIX'             =>  '',    // 数据库表前缀
//   'VAR_PAGE'              =>  'page',*/

    //        $config = array(
//            'token'          => 'mytoken',
//            'appid'          => 'wxbbb6f1681d454e00',                           //绑定支付的APPID
//            'appsecret'      => '7813490da6f1265e4901ffb80afaa36f',             //公众帐号secert（仅JSAPI支付的时候需要配置， 登录公众平台，进入开发者中心可设置）
//            'encodingaeskey' => 'eHSmk5yJN2vSsuYscC8aHIiXnrgXZSKA4MRL9csEwTv',
//            'mch_id'         => '1900009851',                                   //商户号（必须配置，开户邮件中可查看）
//            'partnerkey'     => '8934e7d15453e97507ef794cf7b0519d',             //商户支付密钥，参考开户邮件设置（必须配置，登录商户平台自行设置）
//            'ssl_cer'        => '',
//            'ssl_key'        => '',
//        );

    //微信支付码前缀
    'WX_PAY_PREFIX' => array(
        "10","11","12","13","14","15"
    ),

    //支付宝支付码前缀
    'AL_PAY_PREFIX' => array(
        "28"
    ),

    // by:jcm  2017/1/9
    //'配置项'=>'配置值'
    'TMPL_PARSE_STRING'  =>array(
        '__UP_GOODS__' => '/Public/Uploads/Goods', // 积分兑换物品图片存储路径
    ),


    // 加密规则
    'SECURESTR' => '!yunniu123-',

    //密钥
    "SECRET_KEY" => "A1W9E2R1TD4Y2F6H24F2G2",

    //设备类型
    "EQUIPMENT_TYPE" => ["yell","cancel","summary"],
);



