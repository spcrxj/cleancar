<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2009 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
namespace Org\Util;
class Weixin {
    //验证
	public function valid(){
        $echoStr = $_GET["echostr"];
        if($this->checkSignature()){
            header('content-type:text');
            echo $echoStr;
            exit;
        }
    }
	//检验Signature
	public function checkSignature(){
        if (!defined("WxPayConf_Token")) {
            echo('TOKEN尚未定义!');exit();
        }
        
        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce = $_GET["nonce"];
        		
		$token = WxPayConf_Token;
		$tmpArr = array($token, $timestamp, $nonce);
		sort($tmpArr, SORT_STRING);
		$tmpStr = implode( $tmpArr );
		$tmpStr = sha1( $tmpStr );
		
		if( $tmpStr == $signature ){
			return true;
		}else{
			return false;
		}
	}

	public function receiveText($object)
    {
        //$contentStr = "你发送的是文本，内容为：".$object->Content;
		$contentStr = "欢迎公众号，<a href='".WEB_HOST."index.php?m=home&c=index&a=index'>点击访问</a>";
        $resultStr = $this->transmitText($object, $contentStr);
        return $resultStr;
    }

    public function receiveImage($object)
    {
        $contentStr = "你发送的是图片，地址为：".$object->PicUrl;
        $resultStr = $this->transmitText($object, $contentStr);
        return $resultStr;
    }

    public function receiveLocation($object)
    {
        $contentStr = "你发送的是位置，纬度为：".$object->Location_X."；经度为：".$object->Location_Y."；缩放级别为：".$object->Scale."；位置为：".$object->Label;
        $resultStr = $this->transmitText($object, $contentStr);
        return $resultStr;
    }

    public function receiveVoice($object)
    {
        $contentStr = "你发送的是语音，媒体ID为：".$object->MediaId;
        $resultStr = $this->transmitText($object, $contentStr);
        return $resultStr;
    }

    public function receiveVideo($object)
    {
        $contentStr = "你发送的是视频，媒体ID为：".$object->MediaId;
        $resultStr = $this->transmitText($object, $contentStr);
        return $resultStr;
    }

    public function receiveLink($object)
    {
        $contentStr = "你发送的是链接，标题为：".$object->Title."；内容为：".$object->Description."；链接地址为：".$object->Url;
        $resultStr = $this->transmitText($object, $contentStr);
        return $resultStr;
    }

    public function receiveEvent($object)
    {
        $contentStr = "";
        switch ($object->Event)
        {
            case "subscribe"://关注
                $contentStr = "欢迎关注公众号，<a href='".WEB_HOST."index.php?m=home&c=index&a=index&referee=".str_replace("qrscene_","",$object->EventKey)."'>点击访问</a>";
				if($object->EventKey){//拿到特殊参数-扫描二维码带参数
					//$contentStr.=str_replace("qrscene_","",$object->EventKey);
				}
                break;
            case "unsubscribe"://取消关注
                $contentStr = "";
                break;
			case "SCAN"://扫描二维码
                $contentStr = "欢迎关注振泽，<a href='".WEB_HOST."index.php?m=home&c=index&a=index&referee=".$object->EventKey."'>点击访问</a>";
				if($object->EventKey){//拿到特殊参数-扫描二维码带参数
					//$contentStr.=$object->EventKey;
				}
                break;
			/*
            case "CLICK"://点击菜单
                switch ($object->EventKey)
                {
                    default:
                        $contentStr = "你点击了: ".$object->EventKey;
                        break;
                }
                break;
            default:
                $contentStr = "接受到一个新事件: ".$object->Event;
                break;
			*/
        }
        $resultStr = $this->transmitText($object, $contentStr);
        return $resultStr;
    }
	//发送文字消息
    public function transmitText($object, $content)
    {
		$content= $content;
		if (!isset($content) || empty($content)){
			return "";
		}
        $textTpl = "<xml>
<ToUserName><![CDATA[%s]]></ToUserName>
<FromUserName><![CDATA[%s]]></FromUserName>
<CreateTime>%s</CreateTime>
<MsgType><![CDATA[text]]></MsgType>
<Content><![CDATA[%s]]></Content>
</xml>";

        $resultStr = sprintf($textTpl, $object->FromUserName, $object->ToUserName, time(), $content);
        return $resultStr;
    }
	//字节转Emoji表情
	public function bytes_to_emoji($cp)
	{
		if ($cp > 0x10000){       # 4 bytes
			return chr(0xF0 | (($cp & 0x1C0000) >> 18)).chr(0x80 | (($cp & 0x3F000) >> 12)).chr(0x80 | (($cp & 0xFC0) >> 6)).chr(0x80 | ($cp & 0x3F));
		}else if ($cp > 0x800){   # 3 bytes
			return chr(0xE0 | (($cp & 0xF000) >> 12)).chr(0x80 | (($cp & 0xFC0) >> 6)).chr(0x80 | ($cp & 0x3F));
		}else if ($cp > 0x80){    # 2 bytes
			return chr(0xC0 | (($cp & 0x7C0) >> 6)).chr(0x80 | ($cp & 0x3F));
		}else{                    # 1 byte
			return chr($cp);
		}
	}

	//日志记录
	public function logger($log_content){
		__mkdirs(THINK_PATH . '../Public/cache/weixin/');
		$statlogfile = THINK_PATH . '../Public/cache/weixin/'.date("YW",SYS_TIME).'.log';//不存在自动生成
		if($fp = @fopen($statlogfile, 'a')) {
			@flock($fp, 2);
			fwrite($fp, $log_content."[".date("Y-m-d H:i:s",SYS_TIME)."]\r\n");
			fclose($fp);
		}
	}

}