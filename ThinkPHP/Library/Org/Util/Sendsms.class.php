<?php
namespace Org\Util;
//发送短信
class Sendsms {

	//发送短信
	public function send($phone="",$content="",$user_id=0){
		if(!$content) return false;
		if($phone){
			if (!$this->is_phone($phone)) return false;
		}else{
			if(!$user_id) return false;
			$userinfo=M("User")->field('mobile')->where("user_id=".$user_id)->find();
			$phone=$userinfo['mobile'];
		}
		$flag=$this->sendmsg($phone,$content);
		return $flag;
	}
	/**
	 * 发送短信
	 * @param $phone
	 * @param $content
	 */
	public function sendmsg($phone,$content) {	
		//以下信息自己填以下
		$mobile=$tel;       //'15593103532';//手机号
		$argv = array( 
			'name'=>'1361289017',     //必填参数。用户账号
			'pwd'=>'612BBE9188CAA9B16220139D263E',     //必填参数。（web平台：基本资料中的接口密码）
			'content'=>$content,   //必填参数。发送内容（1-500 个汉字）UTF-8编码
			'mobile'=>$phone,   //必填参数。手机号码。多个以英文逗号隔开
			'stime'=>'',   //可选参数。发送时间，填写时已填写的时间发送，不填时为当前时间发送
			'sign'=>'千度众家',    //必填参数。用户签名。振泽公司
			'type'=>'pt',  //必填参数。固定值 pt
			'extno'=>''    //可选参数，扩展码，用户定义扩展码，只能为数字
		);
		$flag = 0; 
		foreach ($argv as $key=>$value) { 
			if ($flag!=0) { 
				$params .= "&"; 
				$flag = 1; 
			} 
			$params.= $key."="; $params.= urlencode($value);// urlencode($value); 
			$flag = 1; 
		} 
		$url = "http://sms.1xinxi.cn/asmx/smsservice.aspx?".$params; //提交的url地址
		$con = substr( file_get_contents($url), 0, 1 );  //获取信息发送后的状态
		if($con==0){
			//发送短信操作
			return true;
		}else{
			return false;
		}
	}
	/**
	 * 判断手机号码格式是否正确
	 * @param $phone
	 */
	public function is_phone($phone) {
		return strlen($phone) ==11 && preg_match("/^1[0-9]{10}$/", $phone);
	}
}