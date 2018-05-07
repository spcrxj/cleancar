<?php
namespace Org\Util;
/*
//举例
$amap = new \Org\Util\Amapserver;
$a = $amap->ip("114.247.50.2");//IP定位
dump($a);
*/
//高德地图restapi地图服务
class Amapserver {

    private $Key = "";
 
    public function __construct()
    {
        $this->key = C("Amap_Webserver_Key");
    }
	
	//坐标转换service
	/*
	* $locations 坐标点		116.481499,39.990475
	* $coordsys  原坐标系	gps
	* $output	 返回数据类型	json
	*/
	/*
	完全免费，无限次
	*/
	public function convert($locations,$coordsys='gps',$output="json"){
		$url="http://restapi.amap.com/v3/assistant/coordinate/convert?locations=".$locations."&coordsys=".$coordsys."&output=".$output."&key=".$this->key;
		$data=$this->urlget($url);
		return $this->json2array($data);
	}
	//////////////////////////////////////////////
	/*
	企业用户：单个Key支持400万次/天，6万次/分钟调用。
	普通用户：单个Key支持2000次/天调用
	*/
	//地理编码
	/*
	* $address	结构化地址信息		规则： 省+市+区+街道+门牌号
	* $city		查询城市	可选值：城市中文、中文全拼、citycode、adcode
	* $output	 返回数据类型	json
	*/
	public function geo($address,$coordsys='gps',$output="json"){
		$url="http://restapi.amap.com/v3/geocode/geo?address=".$address."&city=".$city."&output=".$output."&key=".$this->key;
		$data=$this->urlget($url);
		return $this->json2array($data);
	}
	//逆地理编码
	/*
	* $location	经纬度坐标
	* $output	 返回数据类型	json
	*/
	public function regeo($location,$coordsys='gps',$output="json"){
		$url="http://restapi.amap.com/v3/geocode/regeo?location=".$location."&output=".$output."&key=".$this->key;
		$data=$this->urlget($url);
		return $this->json2array($data);
	}
	////////////////////////////////////////////////////
	/*
	企业用户：单个Key支持20万次/天，1万次/分钟调用。
	普通用户：单个Key支持1000次/天调用
	*/
	//步行路径规划
	/*
	* $origin	出发点经纬度坐标	规则： lon，lat（经度，纬度）， “,”分割，如117.500244, 40.417801 
	* $destination	目的地经纬度坐标	规则： lon，lat（经度，纬度）， “,”分割，如117.500244, 40.417801 
	* $output	 返回数据类型	json
	*/
	public function walking($origin,$destination,$output="json"){
		$url="http://restapi.amap.com/v3/direction/walking?origin=".$origin."&destination=".$destination."&output=".$output."&key=".$this->key;
		$data=$this->urlget($url);
		return $this->json2array($data);
	}
	//公交路径规划
	/*
	* $origin	出发点经纬度坐标	规则： lon，lat（经度，纬度）， “,”分割，如117.500244, 40.417801 
	* $destination	目的地经纬度坐标	规则： lon，lat（经度，纬度）， “,”分割，如117.500244, 40.417801 
	* $city	城市/跨城规划时的起点城市	可选值：城市名称/citycode
	* $output	 返回数据类型	json
	*/
	public function transit($origin,$destination,$city,$output="json"){
		$url="http://restapi.amap.com/v3/direction/transit/integrated?origin=".$origin."&destination=".$destination."&city=".$city."&output=".$output."&key=".$this->key;
		$data=$this->urlget($url);
		return $this->json2array($data);
	}
	//驾车路径规划
	/*
	* $origin	出发点经纬度坐标	规则： lon，lat（经度，纬度）， “,”分割，如117.500244, 40.417801 
	* $destination	目的地经纬度坐标	规则： lon，lat（经度，纬度）， “,”分割，如117.500244, 40.417801 
	* $output	 返回数据类型	json
	*/
	public function driving($origin,$destination,$output="json"){
		$url="http://restapi.amap.com/v3/direction/driving?origin=".$origin."&destination=".$destination."&output=".$output."&key=".$this->key;
		$data=$this->urlget($url);
		return $this->json2array($data);
	}
	//距离测量
	/*
	* $origins	出发点	支持100个坐标对，坐标对见用“| ”分隔；经度和纬度用","分隔
	* $destination	目的地经纬度坐标	规则： lon，lat（经度，纬度）
	* $output	 返回数据类型	json
	*/
	public function distance($origins,$destination,$output="json"){
		$url="http://restapi.amap.com/v3/distance?origins=".$origins."&destination=".$destination."&output=".$output."&key=".$this->key;
		$data=$this->urlget($url);
		return $this->json2array($data);
	}

	//////////////////////////////////////////////////////////
	/*
	企业用户：单个Key支持20万次/天，1.5万次/分钟调用。
	普通用户：单个Key支持1000次/天调用，1000次/分钟调用。
	*/
	//行政区域查询
	/*
	* $keywords	查询关键字	规则：只支持单个关键词语搜索关键词支持：行政区名称、citycode、adcode
	* $subdistrict	子级行政区	可选值：0、1、2、3等数字
	* $output	 返回数据类型	json
	*/
	public function district($keywords,$subdistrict,$output="json"){
		$url="http://restapi.amap.com/v3/config/district?keywords=".$keywords."&subdistrict=".$subdistrict."&output=".$output."&key=".$this->key;
		$data=$this->urlget($url);
		return $this->json2array($data);
	}

	//////////////////////////////////////////////////////////
	/*
	企业用户：单个Key支持40万次/天，1.5万次/分钟调用。
	普通用户：单个Key支持1000次/天调用
	*/
	//关键字搜索
	/*
	* $keywords	查询关键字	规则： 多个关键字用“|”分割	keywords和types两者至少必选其一
	* $types	查询POI类型 多个类型用“|”分割	keywords和types两者至少必选其一
	* $city		查询城市	可选值：城市中文、中文全拼、citycode、adcode
	* $output	 返回数据类型	json
	*/
	public function placetext($keywords,$types,$city="",$output="json"){
		$url="http://restapi.amap.com/v3/place/text?keywords=".$keywords."&types=".$types."&city=".$city."&output=".$output."&key=".$this->key;
		$data=$this->urlget($url);
		return $this->json2array($data);
	}
	//周边搜索
	/*
	* $location	中心点坐标 规则： 经度和纬度用","分割
	* $keywords	查询关键字	规则： 多个关键字用“|”分割
	* $city		查询城市	可选值：城市中文、中文全拼、citycode、adcode
	* $output	 返回数据类型	json
	*/
	public function placearound($location,$keywords="",$city="",$output="json"){
		$url="http://restapi.amap.com/v3/place/around?location=".$location."&keywords=".$keywords."&city=".$city."&output=".$output."&key=".$this->key;
		$data=$this->urlget($url);
		return $this->json2array($data);
	}
	//多边形搜索
	/*
	* $polygon	经纬度坐标对 规则：经度和纬度用","分割，经度在前，纬度在后，坐标对用"|"分割。经纬度小数点后不得超过6位。
	* $keywords	查询关键字	规则： 多个关键字用“|”分割
	* $output	 返回数据类型	json
	*/
	public function placepolygon($polygon,$keywords="",$output="json"){
		$url="http://restapi.amap.com/v3/place/polygon?polygon=".$polygon."&keywords=".$keywords."&output=".$output."&key=".$this->key;
		$data=$this->urlget($url);
		return $this->json2array($data);
	}
	//ID查询
	/*
	* $id	兴趣点id 兴趣点的唯一标识ID
	* $output	 返回数据类型	json
	*/
	public function placedetail($id,$output="json"){
		$url="http://restapi.amap.com/v3/place/detail?id=".$id."&output=".$output."&key=".$this->key;
		$data=$this->urlget($url);
		return $this->json2array($data);
	}

	//////////////////////////////////////////////////////////
	/*
	单个Key支持1万次/分钟调用。日调用次数不限量
	*/
	//IP定位
	/*
	* $ip	ip地址
	* $output	 返回数据类型	json
	*/
	public function ip($ip,$output="json"){
		$url="http://restapi.amap.com/v3/ip?ip=".$ip."&output=".$output."&key=".$this->key;
		$data=$this->urlget($url);
		return $this->json2array($data);
	}

	//////////////////////////////////////////////////////////
	/*
	单个Key支持6万次/分钟调用。日调用次数不限量
	*/
	//天气查询
	/*
	* $city		城市名称  输入adcode
	* $extensions	气象类型	可选值：base/all	base:返回实况天气	all:返回预报天气
	* $output	 返回数据类型	json
	*/
	public function weatherInfo($city,$extensions="base",$output="json"){
		$url="http://restapi.amap.com/v3/weather/weatherInfo?city=".$city."&extensions=".$extensions."&output=".$output."&key=".$this->key;
		$data=$this->urlget($url);
		return $this->json2array($data);
	}

	//////////////////////////////////////////////////////////
	/*
	普通用户：单个Key支持1000次/天调用
	*/
	//矩形区域交通态势
	/*
	* $rectangle	代表此为矩形区域查询	左下右上顶点坐标对。矩形对角线不能超过10公里	两个坐标对之间用”;”间隔
	* $output	 返回数据类型	json
	*/
	public function rectangle($rectangle,$output="json"){
		$url="http://restapi.amap.com/v3/traffic/status/rectangle?rectangle=".$rectangle."&output=".$output."&key=".$this->key;
		$data=$this->urlget($url);
		return $this->json2array($data);
	}
	//圆形区域交通态势
	/*
	* $location	中心点坐标	经度和纬度用","分割
	* $radius	半径	单位：米，最大取值5000米。
	* $output	 返回数据类型	json
	*/
	public function circle($location,$radius="1000",$output="json"){
		$url="http://restapi.amap.com/v3/traffic/status/circle?location=".$location."&radius=".$radius."&output=".$output."&key=".$this->key;
		$data=$this->urlget($url);
		return $this->json2array($data);
	}
	//指定线路交通态势
	/*
	* $name	道路名
	* $city	城市名	非必填（city和adcode必填一个）
	* $adcode 城市编码	非必填（city和adcode必填一个）
	* $output	 返回数据类型	json
	*/
	public function road($name,$city="",$adcode="",$output="json"){
		if($city){
			$url="http://restapi.amap.com/v3/traffic/status/road?name=".$name."&city=".$city."&output=".$output."&key=".$this->key;
		}else{
			$url="http://restapi.amap.com/v3/traffic/status/road?name=".$name."&adcode=".$adcode."&output=".$output."&key=".$this->key;
		}		
		$data=$this->urlget($url);
		return $this->json2array($data);
	}

	//////////////////////////////////////////////////////////
	/*
	企业用户：单个Key支持40万次/天，1.5万次/分钟调用。
	普通用户：单个Key支持1000次/天调用
	*/
	//输入提示
	/*
	* $keywords		查询关键词
	* $city		城市名称  搜索城市	可选值：城市中文、中文全拼、citycode、adcode	如：北京/beijing/010/110000
	* $output	 返回数据类型	json
	*/
	public function inputtips($keywords,$city="",$output="json"){
		$url="http://restapi.amap.com/v3/assistant/inputtips?keywords=".$keywords."&city=".$city."&output=".$output."&key=".$this->key;
		$data=$this->urlget($url);
		return $this->json2array($data);
	}
	
	//////////////////////////////////////////////////////////
	//Curl获取数据
	public function urlget($url){
		$curl = curl_init($url);  
		curl_setopt($curl, CURLOPT_HEADER, false);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		if($response = curl_exec($curl)){
			return $response;
		}else{
			return false;
		}
		curl_close($curl);
	}
	//json数据转数组
	public function json2array($data){
		return json_decode($data,true);
	}
}