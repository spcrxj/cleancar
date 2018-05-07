<?php
if (!defined('DS')) {
    define('DS', DIRECTORY_SEPARATOR);
}
if (!defined('WxpayAPI_DIR')) {
    define('WxpayAPI_DIR', dirname(__FILE__) . DS);
}
if (!defined('WxpayAPI_lib_DIR')) {
    define('WxpayAPI_lib_DIR', WxpayAPI_DIR . 'lib' . DS);
}

require_once WxpayAPI_DIR."WxPayConfig.php";
require_once WxpayAPI_lib_DIR."WxPay.Api.php";
require_once WxpayAPI_lib_DIR.'WxPay.Notify.php';

//初始化日志
//$logHandler= new CLogFileHandler(__ROOT__."/Public/WxPaylogs/".date('Y-m-d').'.log');
//$log = Log::Init($logHandler, 15);

class PayNotify extends WxPayNotify
{
	//查询订单 by transaction_id 微信订单号
	public function Queryorder($transaction_id)
	{
		$input = new WxPayOrderQuery();
		$input->SetTransaction_id($transaction_id);
		$result = WxPayApi::orderQuery($input);
		//Log::DEBUG("query:" . json_encode($result));
		if(array_key_exists("return_code", $result)
			&& array_key_exists("result_code", $result)
			&& $result["return_code"] == "SUCCESS"
			&& $result["result_code"] == "SUCCESS")
		{
			return true;
		}
		return false;
	}

	//查询订单 by out_trade_no 商户订单号
	public function Queryorder_out_trade_no($out_trade_no)
	{
		$input = new WxPayOrderQuery();
		$input->SetOut_trade_no($out_trade_no);
		$result = WxPayApi::orderQuery($input);
		//Log::DEBUG("query:" . json_encode($result));
		if(array_key_exists("return_code", $result)
			&& array_key_exists("result_code", $result)
			&& $result["return_code"] == "SUCCESS"
			&& $result["result_code"] == "SUCCESS")
		{
			return true;
		}
		return false;
	}
	
	//重写回调处理函数
	public function NotifyProcess($data, &$msg)
	{
		//Log::DEBUG("call back:" . json_encode($data));
		$notfiyOutput = array();
		
		if(!array_key_exists("transaction_id", $data)){
			$msg = "输入参数不正确";
			return false;
		}
		//查询订单，判断订单真实性
		if(!$this->Queryorder($data["transaction_id"])){
			$msg = "订单查询失败";
			return false;
		}
		return true;
	}
}