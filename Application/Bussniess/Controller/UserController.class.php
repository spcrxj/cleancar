<?php

namespace Bussniess\Controller;

use Think\Controller;

class UserController extends Controller {

    function __construct() {
        //继承父类
        parent::__construct();
		if (!D('Seller')->islogin()) {//未登录
			jump('您尚未登录，请先登录！',C("WEB_URL")."index.php?m=Bussniess&c=login&a=login");
        }
    }

    //会员办理
    public function userinfo() {
		$this->assign('noticeinfo', D('content')->get_notice());
		$this->display();
    } 
	//注册会员
    public function adduser() {
        if (IS_POST) {
            $user = array();
            $user['realname'] = I("realname");
            $user['phone'] = I("phone");
            $user['password'] = md5(I("password"));
            $user['brand'] = I("brand");
			$user['cartype'] = I("cartype");
			$user['user_flag'] = 1;
			$user['userable'] = 1;
			$user['dealwith'] = session("seller.seller_id");
			if(I("sss")!=""){
			$user['carcode'] = I("sss").I("carcode");
			}else{
			$user['carcode'] = "陕".I("carcode");
            }
            $user['addtime'] = time();
            $count=M("User")->where("phone='".$user['phone']."' or carcode='".$user['carcode']."' ")->count();
			if($count){
				jump("注册失败,手机号或车牌号已存在！",U("user/adduser"));
			}else{
				$flag = M('user')->add($user);
				if ($flag) {
					jump("注册成功", U('index/index'));
				} else {
					jump("注册失败", U('user/adduser'));
				}
			}
        } else {
            $this->display();
        }
    }
	//判断账号存在性
	public function existuser(){
		$username=I("username");	
		$count=M("User")->where("phone = '".$username."'")->count();
		if($count){//存在
			$status=1;
		}else{	//不存在
			$status=2;
		}
        echo $status;
	}
	
	 //发短信，获取验证码
    public function smsCode(){
		////////////
		header("Content-Type: text/html; charset=utf-8");
		$msg=I("get.msg");					//生成验证码
        $account="liyongseo";  				//账号
		$password="tgscdhg";  		//接口密码
		$mobile=I('get.tel'); 				//号码tel	
		$content1="您的订单编码：".$msg."。如需帮助请联系客服。"; 
		$content="您的验证码是：".$msg."。请不要把验证码泄露给其他人。如非本人操作，可不用理会！"; 
		//您的订单编码：".$msg."。如需帮助请联系客服。
		$target = "http://sms.106jiekou.com/utf8/sms.aspx";
		//替换成自己的测试账号,参数顺序和wenservice对应
		$post_data = "account=".$account."&password=".$password."&mobile=".$mobile."&content=".rawurlencode($content)."&signName=天果易购";
		echo $gets = $this->sendsms($post_data, $target);
    }
	function sendsms($data, $target) {
		$url_info = parse_url($target);
		$httpheader = "POST " . $url_info['path'] . " HTTP/1.0\r\n";
		$httpheader .= "Host:" . $url_info['host'] . "\r\n";
		$httpheader .= "Content-Type:application/x-www-form-urlencoded\r\n";
		$httpheader .= "Content-Length:" . strlen($data) . "\r\n";
		$httpheader .= "Connection:close\r\n\r\n";
		//$httpheader .= "Connection:Keep-Alive\r\n\r\n";
		$httpheader .= $data;

		$fd = fsockopen($url_info['host'], 80);
		fwrite($fd, $httpheader);
		$gets = "";
		while(!feof($fd)) {
			$gets .= fread($fd, 128);
		}
		fclose($fd);
		return $gets;
	}
    //get取值
    function httpGet($url) {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_TIMEOUT, 500);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, true);
        curl_setopt($curl, CURLOPT_URL, $url);
        $res = curl_exec($curl);
        curl_close($curl);
        return $res;
    }

}
