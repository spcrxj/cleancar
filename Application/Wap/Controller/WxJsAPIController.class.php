<?php

namespace Home\Controller;

use Think\Controller;

//微信支付 demo
class WxJsAPIController extends Controller {

    /**
     * 初始化
     */
    public function _initialize() {
        //引入WxpayAPI
        vendor('WxpayAPI.WxPayJsApiPay');
    }

    //获取用户信息
    function test() {
        $jsApi = new \JsApiPay();
        //$userinfo = $jsApi->GetUserinfo();
        //dump($userinfo);
        //获取带参数二维码
        $fileurl = $jsApi->sceneqrcode("QR_SCENE", "1111");
        dump($fileurl);

        //合成特定二维码
        $pathinfo = pathinfo($fileurl);
        $basename = $pathinfo['basename'];
        if (is_file(THINK_PATH . '../uploadfile/qrcode/' . $basename)) {
            $newfile = format_qrcode($basename, 'qrcode_background.png', 220, 70, 40);
            dump($newfile);
        }
    }

    //
    function index() {
        echo C('WxPayConf.NOTIFY_URL');
    }

    //支付选择页面
    public function pay() {
        //此页面选择选取客户要买的商品，然后生成自身系统的订单传给jsApiCall订单号
    }

    //支付中转页面
    public function jsApiCall() {
        //①、获取用户openid
        $jsApi = new \JsApiPay();
        $openId = $jsApi->GetOpenid();

        //②、统一下单
        //获取客户订单号，微信下单
        $orderid = I("orderid");
        $input = new WxPayUnifiedOrder();
        $input->SetBody("贡献一分钱"); //商品描述
        $input->SetAttach("一分钱"); //附加数据
        //自定义订单号
        $timeStamp = time();
        $out_trade_no = C('WxPayConf.APPID') . $timeStamp;
        $input->SetOut_trade_no($out_trade_no); //商户系统内部订单号，要求32个字符内、且在同一个商户号下唯一
        $input->SetTotal_fee("1"); //订单总金额，单位为分
        $input->SetTime_start(date("YmdHis")); //交易起始时间
        $input->SetTime_expire(date("YmdHis", time() + 600)); //交易结束时间
        $input->SetGoods_tag("test"); //商品标记
        $input->SetNotify_url(C('WxPayConf.NOTIFY_URL')); //通知地址
        $input->SetTrade_type("JSAPI"); //交易类型 取值如下：JSAPI，NATIVE，APP等
        $input->SetOpenid($openId);
        $order = WxPayApi::unifiedOrder($input);
        echo '<font color="#f00"><b>统一下单支付单信息</b></font><br/>';
        printf_info($order);
        $jsApiParameters = $jsApi->GetJsApiParameters($order);

        //获取共享收货地址js函数参数
        //$editAddress = $jsApi->GetEditAddressParameters();

        $this->assign('jsApiParameters', $jsApiParameters);
        $this->assign('SuccessUrl', U('WxJsAPI/SuccessUrl', array("orderid" => $orderid))); //支付成功跳转页面
        $this->assign('FailUrl', U('WxJsAPI/FailUrl', array("orderid" => $orderid))); //支付失败跳转页面
        //echo $jsApiParameters;
        $this->display("jsApipay");
    }

    //支付成功页面
    public function SuccessUrl() {
        $orderid = I("orderid");
        echo "支付成功:" . $orderid;
    }

    //支付失败页面
    public function FailUrl() {
        $orderid = I("orderid");
        echo "支付失败:" . $orderid;
    }

    //支付通知页面
    public function notify() {
        //引入WxpayAPI
        vendor('WxpayAPI.WxPayNotify');
        //使用通用通知接口
        $notify = new \PayNotify();
        $notify->Handle(false);
    }

}
