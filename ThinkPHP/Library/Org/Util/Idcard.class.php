<?php
namespace Org\Util;
/*
	1、第l一6位数为行政区划代码；
	2、第7—12位数为出生日期代码；
	3、第13---15位数为分配顺序代码；
	(1)、行政区划代码，是指公民第一次申领居民身份证时的常住户口所在地的行政地区。
	(2)、出生日期代码，第7—8位数代表年份(年份前面二位数省略)，
	第9—10位数代表月份(月份为l位数的前面加零)。
	第11一12位数代表日期(日期为1位数的前面加零)。
	公民身份证号码按照GB11643—1999《公民身份证号码》国家标准编制，由18位数字组成：前6位为行政区划分代码，
	第7位至14位为出生日期码，
	第15位至17位为顺序码，第18位为校验码。
	第18位号码是校验码，目的在于检测身份证号码的正确性，是由计算机随机产生的，所以不再是男性为单数，女性为双数
*/
class Idcard {

	private $City ;
 
    public function __construct()
    {
        $this->City = array(11=>"北京",12=>"天津",13=>"河北",14=>"山西",15=>"内蒙古",21=>"辽 宁",22=>"吉林",23=>"黑龙江",31=>"上海",32=>"江苏",33=>"浙江",34=>" 安徽",35=>"福建",36=>"江西",37=>"山东",41=>"河南",42=>"湖北",43=>" 湖南",44=>"广东",45=>"广西",46=>"海南",50=>"重庆",51=>"四川",52=>" 贵州",53=>"云南",54=>"西藏",61=>"陕西",62=>"甘肃",63=>"青海",64=>" 宁夏",65=>"新疆",71=>"台湾",81=>"香港",82=>"澳门",91=>"国外");
    }

	//获取身份证号码信息
	public function get_info($idcard){
		$idcard=trim($idcard);
		if (!$this->isIdCard($idcard)) return '';

		$areacode=substr($idcard, 0,6);//行政区划
		$areainfo=M("idcard")->where("idcard_code='".$areacode."'")->find();
		return array(
			'city'=>$this->City[substr($idcard, 0, 2)],//城市
			'areacode'=>$areacode,//行政区划
			'idcard_province'=>$areainfo['idcard_province'],//省
			'idcard_city'=>$areainfo['idcard_city'],//市
			'idcard_area'=>$areainfo['idcard_area'],//县/区
			'birthday'=>$this->get_birthday($idcard),//生日
			'star'=>$this->get_xingzuo($idcard),//星座
			'signs'=>$this->get_shengxiao($idcard),//生肖
			'sex'=>$this->get_xingbie($idcard),//性别
		);
	}
	//从身份证中提取生日,性别,包括15位和18位身份证 
	public function get_birthday($cid){
		$tdate="";
		if(strlen($cid)==18){ 
			$tyear=trim(substr($cid,6,4)); 
			$tmonth=trim(substr($cid,10,2)); 
			$tday=trim(substr($cid,12,2)); 
			$tdate=$tyear."-".$tmonth."-".$tday;
		}elseif(strlen($cid)==15){ 
			$tyear=trim("19".substr($cid,6,2)); 
			$tmonth=trim(substr($cid,8,2)); 
			$tday=trim(substr($cid,10,2));
			$tdate=$tyear."-".$tmonth."-".$tday;
		}
		return $tdate; 
	} 
	//根据身份证号，自动返回对应的星座
	public function get_xingzuo($cid) {
		$bir = substr($cid,10,4);
		$month = (int)substr($bir,0,2);
		$day = (int)substr($bir,2);
		$strValue = '';
		if(($month == 1 && $day <= 21) || ($month == 2 && $day <= 19)) {
			$strValue = "水瓶座";
		}else if(($month == 2 && $day > 20) || ($month == 3 && $day <= 20)) {
			$strValue = "双鱼座";
		}else if (($month == 3 && $day > 20) || ($month == 4 && $day <= 20)) {
			$strValue = "白羊座";
		}else if (($month == 4 && $day > 20) || ($month == 5 && $day <= 21)) {
			$strValue = "金牛座";
		}else if (($month == 5 && $day > 21) || ($month == 6 && $day <= 21)) {
			$strValue = "双子座";
		}else if (($month == 6 && $day > 21) || ($month == 7 && $day <= 22)) {
			$strValue = "巨蟹座";
		}else if (($month == 7 && $day > 22) || ($month == 8 && $day <= 23)) {
			$strValue = "狮子座";
		}else if (($month == 8 && $day > 23) || ($month == 9 && $day <= 23)) {
			$strValue = "处女座";
		}else if (($month == 9 && $day > 23) || ($month == 10 && $day <= 23)) {
			$strValue = "天秤座";
		}else if (($month == 10 && $day > 23) || ($month == 11 && $day <= 22)) {
			$strValue = "天蝎座";
		}else if (($month == 11 && $day > 22) || ($month == 12 && $day <= 21)) {
			$strValue = "射手座";
		}else if (($month == 12 && $day > 21) || ($month == 1 && $day <= 20)) {
			$strValue = "魔羯座";
		}  
		return $strValue;
	}
	//根据身份证号，自动返回对应的生肖
	public function get_shengxiao($cid) {
		$start = 1901;
		$end = $end = (int)substr($cid,6,4);
		$x = ($start - $end) % 12;
		$value = "";
		if($x == 1 || $x == -11){$value = "鼠";}
		if($x == 0) {$value = "牛";} 
		if($x == 11 || $x == -1){$value = "虎";}
		if($x == 10 || $x == -2){$value = "兔";}
		if($x == 9 || $x == -3){$value = "龙";}
		if($x == 8 || $x == -4){$value = "蛇";}
		if($x == 7 || $x == -5){$value = "马";}
		if($x == 6 || $x == -6){$value = "羊";}
		if($x == 5 || $x == -7){$value = "猴";}
		if($x == 4 || $x == -8){$value = "鸡";}
		if($x == 3 || $x == -9){$value = "狗";}
		if($x == 2 || $x == -10){$value = "猪";}
		return $value;
	}
	//根据身份证号，自动返回性别
	public function get_xingbie($cid) {
		$sexint = (int)substr($cid,16,1);
		return $sexint % 2 === 0 ? '女' : '男';
	}
	/**
	 * 验证身份证号
	 * @param $vStr
	 * @return bool
	 */
	function isIdCard($vStr)
	{
		$vCity = array(
			'11','12','13','14','15','21','22',
			'23','31','32','33','34','35','36',
			'37','41','42','43','44','45','46',
			'50','51','52','53','54','61','62',
			'63','64','65','71','81','82','91'
		);
	 
		if (!preg_match('/^([\d]{17}[xX\d]|[\d]{15})$/', $vStr)) return false;
	 
		if (!in_array(substr($vStr, 0, 2), $vCity)) return false;
	 
		$vStr = preg_replace('/[xX]$/i', 'a', $vStr);
		$vLength = strlen($vStr);
	 
		if ($vLength == 18)
		{
			$vBirthday = substr($vStr, 6, 4) . '-' . substr($vStr, 10, 2) . '-' . substr($vStr, 12, 2);
		} else {
			$vBirthday = '19' . substr($vStr, 6, 2) . '-' . substr($vStr, 8, 2) . '-' . substr($vStr, 10, 2);
		}
	 
		if (date('Y-m-d', strtotime($vBirthday)) != $vBirthday) return false;
		if ($vLength == 18)
		{
			$vSum = 0;
	 
			for ($i = 17 ; $i >= 0 ; $i--)
			{
				$vSubStr = substr($vStr, 17 - $i, 1);
				$vSum += (pow(2, $i) % 11) * (($vSubStr == 'a') ? 10 : intval($vSubStr , 11));
			}
	 
			if($vSum % 11 != 1) return false;
		}
	 
		return true;
	}
}