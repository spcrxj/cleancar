<?php
if (!defined("WxPayConf_Token")) {
	define('WxPayConf_Token', C('WxPayConf.Token'));//Token
}
if (!defined("WxPayConf_APPID")) {
	define('WxPayConf_APPID', C('WxPayConf.APPID'));//绑定支付的APPID
}
if (!defined("WxPayConf_MCHID")) {
	define('WxPayConf_MCHID', C('WxPayConf.MCHID'));//MCHID：商户号
}
if (!defined("WxPayConf_KEY")) {
	define('WxPayConf_KEY', C('WxPayConf.KEY'));//商户支付密钥
}
if (!defined("WxPayConf_APPSECRET")) {
	define('WxPayConf_APPSECRET', C('WxPayConf.APPSECRET'));//公众帐号secert
}
if (!defined("WxPayConf_SSLCERT_PATH")) {
	define('WxPayConf_SSLCERT_PATH', C('WxPayConf.SSLCERT_PATH'));//商户证书路径
}
if (!defined("WxPayConf_SSLKEY_PATH")) {
	define('WxPayConf_SSLKEY_PATH', C('WxPayConf.SSLKEY_PATH'));//商户证书路径
}

if (!defined("WxPayConf_JS_API_CALL_URL")) {
	define('WxPayConf_JS_API_CALL_URL', C('WxPayConf.JS_API_CALL_URL'));
}
if (!defined("WxPayConf_NOTIFY_URL")) {
	define('WxPayConf_NOTIFY_URL', C('WxPayConf.NOTIFY_URL'));
}