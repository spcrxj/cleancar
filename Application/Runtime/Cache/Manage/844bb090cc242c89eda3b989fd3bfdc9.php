<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>编辑商家</title>
<link href="/cleancar/Public/manage/css/style.css" rel="stylesheet" type="text/css" />
<script language="JavaScript" src="/cleancar/Public/manage/js/jquery.js" type="text/javascript" ></script> 
<link rel="stylesheet" href="/cleancar/Public/kindeditor/themes/default/default.css" />
<script type="text/javascript" src="/cleancar/Public/kindeditor/kindeditor-min.js"></script>
<script type="text/javascript" src="/cleancar/Public/kindeditor/lang/zh-CN.js"></script>
<script type="text/javascript" src="/cleancar/Public/manage/js/stringOperate.js"></script>
<script type="text/javascript" src="http://webapi.amap.com/maps?v=1.3&key=ff1329a0011c8ef56f6efb30f3ca9b49"></script>
<script type="text/javascript">
var editor;
KindEditor.ready(function(K) {
	editor = K.create('textarea[id="seller_content"]', {
		uploadJson : '<?php echo U('kindeditor/upload_json',array('dir'=>image));?>',
		fileManagerJson : '<?php echo U('kindeditor/file_manager_json');?>',
		allowFileManager : true,
		urlType : 'domain',
		afterCreate : function() {
			this.sync(); 
		},
		afterBlur:function(){ 
			this.sync(); 
		}
	});

	//多图
	var uploadbutton = K.uploadbutton({
		button : K('#uploadbutton')[0],
		fieldName : 'imgFile',
		url : '<?php echo U('kindeditor/upload_json',array('dir'=>image));?>',
		afterUpload : function(data) {
			if (data.error === 0) {
				var url = K.formatUrl(data.url, 'domain');
				K('#imagemore').val(url);
				add_album_img(url);
			} else {
				alert(data.message);
			}
		},
		afterError : function(str) {
			alert('自定义错误信息: ' + str);
		}
	});
	uploadbutton.fileBox.change(function(e) {
		uploadbutton.submit();
		});
	});
      //一张图
		KindEditor.ready(function(K) {
		var uploadbutton1 = K.uploadbutton({
			button : K('#uploadbutton1')[0],
			fieldName : 'imgFile',
			url : '<?php echo U('kindeditor/upload_json',array('dir'=>image));?>',
			afterUpload : function(data) {
				if (data.error === 0) {
					var url = K.formatUrl(data.url, 'domain');
					$("#sellerpaper_image").val(url);
				} else {
					alert(data.message);
				}
			},
			afterError : function(str) {
				alert('自定义错误信息: ' + str);
			}
		});
		uploadbutton1.fileBox.change(function(e) {
			uploadbutton1.submit();
		});
	});


//图片插件
function add_album_img(imgurl) {
	var val = StringOperate.add($("#imagemoreall").val(), imgurl);
	$("#imagemoreall").val(val);
	$(".toollist_pic").append("<li><a onclick=\"del_album_img(\'" + imgurl +"\',this);\"><img src='" + imgurl + "'></a></li>");
	$('#imagemore').val("");
}
function del_album_img(imgurl,obj) {  
	var val = StringOperate.remove($("#imagemoreall").val(), imgurl); 
	$("#imagemoreall").val(val);
	$(obj).remove();//删除元素
}

</script>
<style>
/*多图上传样式*/
.toollist_pic{margin-left: 75px;clear: both;width: 100%;text-align: center;float: left;margin-right: 10px;}
.toollist_pic li{float: left;list-style:none;clear: initial;}
.toollist_pic li img{width: 70px;height: 70px;}
</style>
</head>
<body>
        <div class="formtitle"><span>编辑商家</span></div>
		<form  action="<?php echo U('seller/editseller',array('seller_id'=>$seller_id));?>" class="form-horizontal" method="post" onsubmit="return check();">
			    <ul class="forminfo">
					<li>
                        <label>商家位置</label>
                        <div id="container" style="width:500px; height:300px"></div>
                    </li>
					<li>
						<label>名称</label>
						<input style="width: 400px;" name="info[sellername]" type="text" class="dfinput" id="sellername" value="<?php echo ($seller["sellername"]); ?>"  maxlength="30" />
					</li> 
					<li>
						<label>联系人</label>
						<input name="info[sellerlinkman]"  type="text" class="dfinput" id="sellerlinkman" value="<?php echo ($seller["sellerlinkman"]); ?>" maxlength="20" />
					</li>    
					<li>
						<label>电话</label>
						<input name="info[sellerlinkphone]" type="text" class="dfinput" id="sellerlinkphone" value="<?php echo ($seller["sellerlinkphone"]); ?>"  maxlength="11"/>
					</li> 
                    <li>
						<label>账号</label>
						<input name="info[username]"  type="text" class="dfinput"  id="username" value="<?php echo ($seller["username"]); ?>"  maxlength="20" readonly />
					</li>
					<!--<li>
						<label>密码</label>
						<input name="info[password]"  type="text" class="dfinput"  id="password" value="<?php echo ($seller["password"]); ?>"  maxlength="20"   />
					</li>-->					
					<li  style="position: relative;">
					     <label>商家地址</label>
					     <input id="selleraddress" name="info[selleraddress]"  type="text" class="dfinput" value="<?php echo ($seller["selleraddress"]); ?>"   />
                         <input type='button' id='btn' value='搜索' class='btn' style='width:50px; background: #2e8ded'> 
                         <div id="result" style="width:345px; height:300px;position: absolute;top:32px;left: 86px;"></div>
                    </li> 
                    <li>
					     <label>商家坐标</label>
						 <input  name="info[seller_location]" id='seller_location'  type="text" class="dfinput" value="<?php echo ($seller["seller_location"]); ?>" readonly/>
					</li> 
					<li>
					<label>实景照片</label>
						<input style="width: 400px;" name="info[seller_images]" id="imagemoreall" type="text" class="dfinput" value="<?php echo ($seller["seller_images"]); ?>" readonly/>&nbsp;
						<input type="button" id="uploadbutton" value="上传" />
						<input name="forum_images" id="imagemore" type="hidden" class="dfinput" value="" readonly/>
						<ul class="toollist_pic"> </ul>
					</li>
					<li>
						<label>营业执照号码</label>
						<input name="info[sellerpaper]"  type="text" class="dfinput" id="sellerpaper" value="<?php echo ($seller["sellerpaper"]); ?>"  maxlength="20" />
					</li>
					<li>
						<label>营业执照图片</label>
					   <input style="width: 400px;" name="info[sellerpaper_image]" id="sellerpaper_image" type="text" class="dfinput" value="<?php echo ($seller["sellerpaper_image"]); ?>"  readonly/>&nbsp;
						<input type="button" id="uploadbutton1" value="上传" />
					</li>
					 <li>
						<label>服务说明</label>
						<textarea type="text"  name="info[seller_content]" id="seller_content" maxlength="500" style="width:500px;height:160px;"  ><?php echo ($seller["seller_content"]); ?></textarea>
					</li>
					<li> <input name="btn" type="submit" class="btn" value="确认保存" style="color:back;" /><a href="<?php echo U('seller/sellerlist');?>"><input class="btn" value="返回上一页" style="color:back;text-align:center;" /></a></li>
			    </ul>	
               
		</form>
	</body>
	<script>
function check(){
    var sellername = $('#sellername').val();
		if(sellername.length<=0){
			alert("名称不能为空！");
			$('#sellername').focus();
			return false;
		}
	var sellerlinkman = $('#sellerlinkman').val();
		if(sellerlinkman.length<=0){
			alert("联系人不能为空！");
			$('#sellerlinkman').focus();
			return false;
		}
	var sellerlinkphone = $('#sellerlinkphone').val();
	    if(sellerlinkphone.length<=0){
			alert("电话不能为空！");
			$('#sellerlinkphone').focus();
			return false;
		}
	if(!(/^0?(13[0-9]|15[012356789]|17[013678]|18[0-9]|14[57])[0-9]{8}$/.test(sellerlinkphone))){ 
		  alert("手机号码格式错误"); 
		  $('#sellerlinkphone').focus(); 
		  return false; 
		 } 
	var username = $('#username').val();
		if(username.length<=0){
			alert("账号不能为空！");
			$('#username').focus();
			return false;
		}
	var password = $('#password').val();
		if(password.length<=0){
			alert("密码不能为空！");
			$('#password').focus();
			return false;
		}	
	var selleraddress = $('#selleraddress').val();
		if(selleraddress.length<=0){
			alert("商家地址不能为空！");
			$('#selleraddress').focus();
			return false;
		}
	var seller_location = $('#seller_location').val();
		if(seller_location.length<=0){
			alert("商家坐标不能为空！");
			$('#seller_location').focus();
			return false;
		}
	
	var imagemoreall = $('#imagemoreall').val();
		if(imagemoreall.length<=0){
			alert("实景照片不能为空！");
			$('#imagemoreall').focus();
			return false;
		}
    var sellerpaper = $('#sellerpaper').val();
		if(sellerpaper.length<=0){
			alert("营业执照号码不能为空！");
			$('#sellerpaper').focus();
			return false;
		}
	var sellerpaper_image = $('#sellerpaper_image').val();
		if(sellerpaper_image.length<=0){
			alert("营业执照图片不能为空！");
			$('#sellerpaper_image').focus();
			return false;
		}
	var seller_content = $('#seller_content').val();
		if(seller_content.length<=0){
			alert("活动说明不能为空！");
			$('#seller_content').focus();
			return false;
		}
	
}
</script>
	<script>
	//实例化地图 控制地图显示
	var map = new AMap.Map("container", {
		resizeEnable: true,
		zoom: 11
	});
	//定位
	map.plugin('AMap.Geolocation', function () {
		geolocation = new AMap.Geolocation({
			enableHighAccuracy: true, //是否使用高精度定位，默认:true
			timeout: 3000, //超过10秒后停止定位，默认：无穷大
			buttonOffset: new AMap.Pixel(10, 20), //定位按钮与设置的停靠位置的偏移量，默认：Pixel(10, 20)
			zoomToAccuracy: false, //定位成功后调整地图视野范围使定位位置及精度范围视野内可见，默认：false
			buttonPosition: 'RB'
		});
		map.addControl(geolocation);
		//点击自动填写社区地址和社区经纬度
		geolocation.getCurrentPosition(function (status, result) {
			if (status == 'complete') {
				$("#selleraddress").val(result.formattedAddress)
				$("#seller_location").val(result.position.getLng() + ',' + result.position.getLat());
			} else {
				$("#selleraddress").val('<?php echo ($seller["selleraddress"]); ?>')
			}
		});
	});
	//经纬度编码地址
	AMap.plugin("AMap.Geocoder", function () {
		var geocoder = new AMap.Geocoder({
			city: '029' //城市默认：“全国”
		})
		var marker = new AMap.Marker({
			map: map,
			bubble: true
		})
		map.on('click', function (e) {
			$("#seller_location").val(e.lnglat.getLng() + ',' + e.lnglat.getLat());
			marker.setPosition(e.lnglat);
			geocoder.getAddress(e.lnglat, function (status, result) {
				if (status == 'complete') {
					$("#selleraddress").val(result.regeocode.formattedAddress)
				} else {
					$("#selleraddress").val('')
					alert('找不到地址，请手动填写');
				}
			})
		})
	})
	//搜索
	AMap.plugin(['AMap.Autocomplete', 'AMap.PlaceSearch'], function () {    //回调函数  
		//TODO: 使用autocomplete对象调用相关功能
		var autoOptions = {
			city: "", //城市，默认全国
			input: "selleraddress"//使用联想输入的input的id
		};
		autocomplete = new AMap.Autocomplete(autoOptions);
		//构造地点查询类
		var placeSearch = new AMap.PlaceSearch({
			pageSize: 5,
			pageIndex: 1,
			city: "029", //城市
			map: map,
			panel: "result"
		});

		AMap.event.addListener(autocomplete, "select", function (obj) {
			//TODO 针对选中的poi实现自己的功能
			placeSearch.search(obj.poi.name, function (status, result) {
			});
		});
		$("#btn").on('click', function () {
			$(".amap-sug-result").hide();
			placeSearch.search($("#selleraddress").val(), function (status, result) {
				$('#result').show();
				console.log(result);
			});
		})
		//隐藏
		$(document).on('click', function () {
			$('#result').hide();
			$('#result,.amap-sug-result,#container,#btn').on('click', function (e) {
				e.stopPropagation();
			})
		})
		$("#selleraddress").on('blur', function () {
			$('#result').show();
		})
	})

	</script>
	<style> /*去掉高德地图LOGO*/
	.amap-logo {
		right: 0 !important;
		left: auto !important;
		display: none;
	}

	.amap-copyright {
		right: 70px !important;
		left: auto !important;
	}  
	</style>

</html>