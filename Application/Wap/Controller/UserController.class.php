<?php

/*
 *  会员中心
 * 
 * 张伟松
 * 
 * 2017年7月18日14:50:57
 */

namespace Wap\Controller;

use Think\Controller;

class UserController extends Controller {

    function __construct() {
        //继承父类
        parent::__construct();
        //判断登录状态

        if (!D('user')->islogin()) { //未登录
            jump('您尚未登录，请先登录！', U('login/login'));
        }
    }

    //空方法，防止报错
    public function _empty() {
        $this->index();
    }

    //个人中心首页
    public function index() {
        $model = M('User');
        $userid = session("user.user_id");
        $result = $model->where('user_id=' . $userid)->select();
        //dump($result);
        $this->assign('result', $result);
        $this->display();
    }

    //缴费
    public function charge() {
        $this->display();
    }
    //退出登录
    public function logout() {
        D("user")->logout();
        jump("登出成功",U('login/login'));
    }

    //个人资料
    public function profile() {
        $userid = session("user.user_id");
        if (IS_POST) {
            $data['avatar'] = $_POST['avatar'];
            M('User')->where("user_id=" . $userid)->save($data);
            jump("修改成功", U("profile"));
        } else {
            $model = M('User');
            $result = $model->where('user_id=' . $userid)->select();
            $this->assign('result', $result);
            $this->display();
        }
    }

    //我的订单
    public function order() {
        $userid = session("user.user_id");
        $model = M('Clearlog');
        $where['user_id'] = $userid;
        $where['is_checked'] = 0;
        $count = $model
                ->where($where)
                ->join("left join ec_seller  on ec_seller.seller_id=ec_clearlog.seller_id")
                ->field("ec_clearlog.*,ec_seller.sellername")
                ->order('ec_clearlog.log_id desc')
                ->count();
        $pagesize = 2;
        $Page = new \Think\Page($count, $pagesize);
        $result = $model
                ->where($where)
                ->join("left join ec_seller  on ec_seller.seller_id=ec_clearlog.seller_id")
                ->field("ec_clearlog.*,ec_seller.sellername")
                ->order('ec_clearlog.log_id desc')
                ->limit($Page->firstRow . ',' . $Page->listRows)
                ->select();
        if (IS_AJAX) {
            $this->ajaxReturn($result);
        } else {
            $this->assign('result', $result);
            $this->display();
        }
    }

    //确认订单
    function confirm() {
        $orderid = I('orderid');
        $data['is_checked'] = 1;
        $flag = M('Clearlog')->where('log_id=' . $orderid)->save($data);
        echo $flag ? 1 : 0;
    }

    //缴费记录
    public function charge_record() {
        $userid = session("user.user_id");
        $model = M('Payinfo');
        $where['user_id'] = $userid;
        $where['pay_flag'] = 1;
        $count = $model
                ->where($where)
                ->field("pay_money,pay_addtime")
                ->order('pay_id desc')
                ->count();
        $pagesize = 2;
        $Page = new \Think\Page($count, $pagesize);
        $result = $model
                ->where($where)
                ->field("pay_money,pay_addtime")
                ->order('pay_id desc')
                ->limit($Page->firstRow . ',' . $Page->listRows)
                //->fetchsql(true)
                ->select();
        //echo $result;
        if (IS_AJAX) {
            $this->ajaxReturn($result);
        } else {
            $this->assign('result', $result);
            $this->display();
        }
    }

    //洗车记录
    public function clean_record() {
        $userid = session("user.user_id");
        $model = M('Clearlog');
        $where['user_id'] = $userid;
        $where['is_checked'] = 1;
        $count = $model
                ->where($where)
                ->join("left join ec_seller  on ec_seller.seller_id=ec_clearlog.seller_id")
                ->field("ec_clearlog.*,ec_seller.sellername")
                ->order('ec_clearlog.log_id desc')
                ->count();
        $pagesize = 2;
        $Page = new \Think\Page($count, $pagesize);
        $result = $model
                ->where($where)
                ->join("left join ec_seller  on ec_seller.seller_id=ec_clearlog.seller_id")
                ->field("ec_clearlog.*,ec_seller.sellername")
                ->order('ec_clearlog.log_id desc')
                ->limit($Page->firstRow . ',' . $Page->listRows)
                ->select();
        if (IS_AJAX) {
            $this->ajaxReturn($result);
        } else {
            $this->assign('result', $result);
            $this->display();
        }
    }

    //修改密码
    public function change_password() {
        if (IS_POST) {
            $phone = session("user.phone");
            $password = I("new_password");
            if (D("user")->set_password_by_phone($phone, $password)) {
                D("user")->logout();
                jump("密码设置成功，请登录！", U("login/login"));
            } else {
                jump("请重试！", U("change_password"));
            }
        } else {
            $this->display();
        }
    }

    //微信支付订单
    public function weixinpayorder() {
        $money = I('get.money');
        if (!$money)
            jump('微信支付参数错误', U("user/charge"));
        $user_id = session("user.user_id");
        //同时给topup表添加数据
        //自定义订单号
        $timeStamp = time();
        $pay_tradeno = C('WxPayConf.APPID') . $timeStamp . random(2);
        $payinfo = M('payinfo');
        $info = array(
            'user_id' => $user_id,
            'pay_money' => $money,
            'pay_type' => 1,
            'pay_addtime' => SYS_TIME,
            'pay_remarks' => '微信充值话费' . $money . '元，实付' . $money . '元，订单号：' . $pay_tradeno,
            'pay_tradeno' => $pay_tradeno,
            'pay_flag' => 1,
        );
        $pay_id = $payinfo->add($info);
        $token = md5($pay_id . "cleancar" . $money);
        $this->redirect('user/weixinpay', array('pay_id' => $pay_id, 'pay_tradeno' => $pay_tradeno, 'money' => $money, "token" => $token), 0, '页面跳转中...');
    }

    //微信支付
    public function weixinpay() {
        $pay_id = I('get.pay_id');
        $pay_tradeno = I('get.pay_tradeno');
        $money = I('get.money');
        $token = I("token");
        if ($token != md5($pay_id . "cleancar" . $money)) {
            jump('非法操作', U('user/charge'));
        }

        session("weixinpay_pay_id", $pay_id);
        session("weixinpay_out_trade_no", $pay_tradeno);

        //引入WxpayAPI
        vendor('WxpayAPI.WxPayJsApiPay');
        //①、获取用户openid
        $jsApi = new \JsApiPay();
        $openId = $jsApi->GetOpenid();

        //②、统一下单
        //获取客户订单号，微信下单
        $input = new \WxPayUnifiedOrder();
        $input->SetBody('微信充值话费' . $money . '元，实付' . $money . '元'); //商品描述
        $input->SetAttach($pay_id); //附加数据-订单id
        $input->SetOut_trade_no($pay_tradeno); //商户系统内部订单号，要求32个字符内、且在同一个商户号下唯一
        //$input->SetTotal_fee("1");//订单总金额，单位为分
        $input->SetTotal_fee($money * 100); //订单总金额，单位为分
        $input->SetTime_start(date("YmdHis")); //交易起始时间
        $input->SetTime_expire(date("YmdHis", time() + 600)); //交易结束时间
        $input->SetGoods_tag("微信充值"); //商品标记
        $input->SetNotify_url(C('WxPayConf.NOTIFY_URL')); //通知地址
        $input->SetTrade_type("JSAPI"); //交易类型 取值如下：JSAPI，NATIVE，APP等
        $input->SetOpenid($openId);
        $order = \WxPayApi::unifiedOrder($input);
        $jsApiParameters = $jsApi->GetJsApiParameters($order);

        //获取共享收货地址js函数参数
        //$editAddress = $jsApi->GetEditAddressParameters();

        $this->assign('jsApiParameters', $jsApiParameters);
        $token = md5($pay_id . "cleancar");
        $this->assign('SuccessUrl', U('index/SuccessUrl', array("pay_id" => $pay_id, "token" => $token))); //支付成功跳转页面
        $this->assign('FailUrl', U('index/FailUrl', array("pay_id" => $pay_id))); //支付失败跳转页面
        //echo $jsApiParameters;
        $this->display();
    }

    //支付成功页面
    public function SuccessUrl() {
        $pay_id = I("pay_id");

        $token = I("token");
        if ($token != md5($pay_id . "cleancar")) {
            jump('非法操作', U('user/charge'));
        }

        //引入WxpayAPI
        vendor('WxpayAPI.WxPayJsApiPay');
        vendor('WxpayAPI.WxPayNotify');
        //使用通用通知接口
        $notify = new \PayNotify();
        $flag = $notify->Queryorder_out_trade_no(session("weixinpay_out_trade_no"));
        if (!$flag) {
            jump('非法操作', U('user/charge'));
        }

        $flag1 = M("payinfo")->where("pay_flag=1 and pay_id=" . $pay_id . " and user_id=" . session("user_id"))->save(array("pay_flag" => 2));
        if ($flag1) {
            jump('微信支付成功', U('user/charge'));
        } else {
            jump('非法操作', U('user/charge'));
        }
    }

    //支付失败页面
    public function FailUrl() {
        $pay_id = I("pay_id");
        jump('微信充值支付失败', U('user/charge'));
    }

    //支付通知页面
    public function notify() {
        //引入WxpayAPI
        vendor('WxpayAPI.WxPayJsApiPay');
        vendor('WxpayAPI.WxPayNotify');

        //使用通用通知接口
        $notify = new \PayNotify();
        $flag = $notify->Queryorder_out_trade_no(session("weixinpay_out_trade_no"));
        if ($flag) {
            M("payinfo")->where("pay_flag=1 and pay_id=" . $pay_id . " and user_id=" . session("user_id"))->save(array("pay_flag" => 2));
            session("weixinpay_pay_id", "");
            session("weixinpay_out_trade_no", "");
        }
        $notify->Handle(false);
    }

}
