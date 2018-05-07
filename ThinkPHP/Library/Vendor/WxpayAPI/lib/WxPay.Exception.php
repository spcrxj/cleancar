<?php
/**
 * 
 * 微信支付API异常类
 * @author widyhu
 * 
 */
class WxPayException extends Exception{
	public function __construct()
    {
		echo "<span style='font-size:1.8rem;line-height:2.5rem;padding:4rem 1.25rem 0;'>参数异常，请稍后重新提交。<a href='".WEB_HOST."'>返回</a></span>";
		exit();
	}
	public function errorMessage()
	{
		return $this->getMessage();
	}
}
