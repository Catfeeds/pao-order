<?php
$config = array (	
		//支付宝公钥
		'alipay_public_key' => "MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQDDI6d306Q8fIfCOaTXyiUeJHkrIvYISRcc73s3vF1ZT7XN8RNPwJxo8pWaJMmvyTn9N4HQ632qJBVHf8sxHi/fEsraprwCtzvzQETrNRwVxLO5jVmRGi60j8Ue1efIlzPXV9je9mkjzOmdssymZkh2QhUrCmZYI/FCEa3/cNMW0QIDAQAB",
		//商户私钥
		'merchant_private_key' => "MIICXgIBAAKBgQCzIrjgaSaKDaqBCgWNdfXYkB171GxaJ8YX+tGCytu/pTgR9BH3E1X02pcbgUW2kqGi+2BVoWX/PexgFR4cUiPDtGZtyowj4IrMeT0bx6uXbHJ4YVKbAbGylR/ySfYzltnE5iexYHBbOg0e4E/5gaf03YNUyHR8TvzoUrChrmiotwIDAQABAoGBAIqFUR0HcqvSgYSjMUQAcYlzd7knvFnC4+XrKFPRdjguFLudVr8Ojqt21N6KClRx8tfLNuVAl1TWl5B9A/m2crw5z6nOSwC2ad+8UEBc8XG5HxbemlG2YURrcZknAMbMlcQ4WvIZ+0163YLj7wsjYUKePPezjMwiR2PpsbksSRvxAkEA3JFIbVk9ZOjNuID6+ftUnH5FLT4nZln8B/+KidJ4QSyJY89SB+6xmDWiXOpA3FB3yQnISNQrviZitybr1xayawJBAM/pk39DFyHA5kMiaFOilpf6qn28ISmrNdsKdWL1vnCEe6R1CEiRJKVAZa7r4jzf62hFbX/6MU/OrlZf5lNK7eUCQG81JRJVAzpkkoyrI19009VPaOuFwfG9/u+9bQlOP+mEXgUf25k6RPqcWC+GwIsUW0DWmM/3gdKOogj8K763p98CQQDF2+MiGRbKaGi5OuVNskzeFQ5q2b41iVmXOjy8EGFLcsi3mSho5reZC8+4x4JlrDK66FdskwyahnYifOEUIxqBAkEApfIxzq0wn5K03AJDa3oZQKdepvLRjINkqzJePSDIERqOQBconw+j0ibDjH0aYhPZtbg515wnQmFvzDEbQupR7Q==",

		//编码格式
		'charset' => "UTF-8",

		//支付宝网关
		'gatewayUrl' => "https://openapi.alipay.com/gateway.do",

		//应用ID
//		'app_id' => "2016111402814279",
		'app_id' => "2016121604351905",

		//异步通知地址,只有扫码支付预下单可用
		'notify_url' => "",

		//最大查询重试次数
		'MaxQueryRetry' => "10",

		//查询间隔
		'QueryDuration' => "3"
);