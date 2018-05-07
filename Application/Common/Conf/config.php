<?php 
//define('WEB_HOST', 'http://192.168.1.155/cleancar/'); // 默认URL路径
define('WEB_HOST', 'http://192.168.1.164/cleancar/'); // 默认URL路径
return array(
    'DEFAULT_MODULE' => 'wap', // 默认模块
    //'WEB_URL' => 'http://192.168.1.155/cleancar/', // 默认URL路径
    'WEB_URL' => 'http://192.168.1.163/cleancar/', // 默认URL路径
    //数据库配置信息
    'DB_TYPE' => 'mysql', // 数据库类型 
    'DB_HOST' => '127.0.0.1', // 服务器地址
    'DB_NAME' => 'cleancar', // 数据库名
    'DB_USER' => 'root', // 用户名
    'DB_PWD' => 'root', // 密码
    'DB_PORT' => 3306, // 端口
    'DB_PARAMS' => array(), // 数据库连接参数
    'DB_PREFIX' => 'ec_', // 数据库表前缀 
    'DB_CHARSET' => 'utf8', // 字符集
    'DB_DEBUG' => false, // 数据库调试模式 开启后可以记录SQL日志
    //'SHOW_PAGE_TRACE'=>TRUE,//输出页面调试
    'LOG_RECORD' => false, //FALSE,//关闭log输出

    /* 微信支付配置 */
    'WxPayConf' => array(
        'Token' => 'a524460094', //Token
        'APPID' => 'wx34dbd8a6efd44ca2', //绑定支付的APPID
        'MCHID' => '1900009851', //MCHID：商户号
        'KEY' => '8934e7d15453e97507ef794cf7b0519d', //商户支付密钥
        'APPSECRET' => '4cf09fd154ac22903d2b61ac93f547ac', //公众帐号secert
        'SSLCERT_PATH' => WEB_HOST . 'ThinkPHP/Library/Vendor/WxpayAPI/cert/apiclient_cert.pem', //商户证书路径
        'SSLKEY_PATH' => WEB_HOST . 'ThinkPHP/Library/Vendor/WxpayAPI/cert/apiclient_key.pem', //商户证书路径
        'JS_API_CALL_URL' => WEB_HOST . 'index.php/Wap/user/jsApiCall',
        'NOTIFY_URL' => WEB_HOST . 'index.php/Wap/user/notify',
    ),
    //支付宝配置参数
    'alipay_config' => array(
        'partner' => '2088621769779341', //这里是你在成功申请支付宝接口后获取到的PID；
        'seller_id' => '253282168@qq.com',
        'key' => 'h41ddx6xw4tx7i07k24l5j1rtmhcqawb-1', //这里是你在成功申请支付宝接口后获取到的Key
        //这里是异步通知页面url，提交到项目的Pay控制器的notifyurl方法；
        'notify_url' => WEB_HOST . 'index.php/wap/Payzhifubao/notifyurl',
        //这里是页面跳转通知url，提交到项目的Pay控制器的returnurl方法；
        'return_url' => WEB_HOST . 'index.php/wap/Payzhifubao/returnurl',
        'sign_type' => strtoupper('MD5'),
        'input_charset' => strtolower('utf-8'),
        'cacert' => THINK_PATH . 'ThinkPHP/Library/Vendor/Alipay/cacert.pem',
        'transport' => 'http',
        'payment_type' => '1',
        'service' => 'alipay.wap.create.direct.pay.by.user',
        'private_key_path' => THINK_PATH . 'Library/Vendor/Alipay/key/rsa_private_key.pem',
        'ali_public_key_path' => THINK_PATH . 'Library/Vendor/Alipay/key/alipay_public_key.pem',
        //支付成功跳转到的页面
        'successpage' => WEB_HOST . 'index.php/wap/My/index',
        //支付失败跳转到的页面
        'errorpage' => WEB_HOST . 'index.php/wap/My/index',
    ),
    /* 第三方微信支付配置 */
    'ZhongNanConf' => array(
        'posturl' => 'http://api.zhongnanpay.com:3022',
        'merchant_no' => '168666999001242', //商户号
        'merchant_key' => 'dip0xf7w724s4tcz', //商户秘钥
        'notifyurl' => WEB_HOST . 'index.php/wap/Zhongnanpay/notifyurl', //异步通知页面
        'return_url' => WEB_HOST . 'index.php/wap/Zhongnanpay/returnurl', //跳转返回页面
        'dfnotifyurl' => WEB_HOST . 'index.php/wap/Api/dfnotifyurl', //代付异步通知页面
    ),
    'yearday' => 365, //每次充值成功后会员到期时间后延天数
    'backmoney' => 10, //每次洗车给商家的返佣金额
    'sellertel' => "15829503438", //平台客服
);
