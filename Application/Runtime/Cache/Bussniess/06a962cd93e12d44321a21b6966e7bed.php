<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>商家登陆</title>
		<!--说明文字编码-->
		<meta http-equiv="Content-type" content="text/html" charset="utf-8">
		<!--针对 IE8 版本的一个特殊文件头标记，用于为 IE8 指定不同的页面渲染模式-->
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<!--设备物理宽度等于等于页面宽度,页面初始缩放1:1,禁止用户调整缩放-->
		<meta name="viewport" content="width=device-width, initial-scale=1.0,user-scalable=no" />
		<!--控制状态栏显示样式-->
		<meta name="apple-mobile-web-app-status-bar-style" content="black">
		<!--解决uc字体变大问题-->
		<meta name="wap-font-scale" content="no">
		<!--手机号码不被显示为拨号链接-->
		<meta content="telephone=no" name="format-detection" />
		<!--页面缓存时间的最大值是0秒，目的是不让页面缓存，每次访问必须到服务器读取-->
		<meta http-equiv="Pragma" content="no-cache">
		<meta http-equiv="Cache-Control" content="no-cache">
		<meta http-equiv="Expires" content="0">
		<link rel="stylesheet" type="text/css" href="/cleancar/Public/bussniess/css/public.css" />
		<link rel="stylesheet" href="/cleancar/Public/bussniess/css/load.css" />
	</head>
	<body>
		<div class="head">
			<!--<a href="javascript:history.go(-1);">
				<img src="/cleancar/Public/bussniess/images/back.png" />
			</a>-->
			<h1>商家登陆</h1>
		</div>
		<form class="m-t" role="form" action="<?php echo U('login/login');?>" method="post" onsubmit="return tijiao()">
		<div class="clear" style="height: 5rem;"></div>
		<div class="name">
			<p>用户名：</p>
			<input type="text" placeholder="请填写用户名" maxlength="30"  name="username" id="username" />
		</div>
		<div class="name">
			<p>密<span style="margin-left: 1.2rem;">码：</span></p>
			<input type="password" placeholder="请输入密码" maxlength="16" name="password"  id="password" />
		</div>
		<button class="btn"  type="submit" >登陆</button>
		</form>
		<script type="text/javascript" src="/cleancar/Public/bussniess/js/screenSize.js" ></script>
		<script type="text/javascript" src="/cleancar/Public/bussniess/js/jquery-3.1.1.min.js" ></script>
		<script>
			$(function(){
				$("body").show()
			})
		</script>
		<script>
		function tijiao(){
			var username = $('#username').val();
			if(username.length<=0){
				alert("用户名不能为空！");
				$('#username').focus();
				return false;
			}
			var password = $('#password').val();
			if(password.length<=0){
				alert("密码不能为空！");
				$('#password').focus();
				return false;
			}

		}
		</script>
	</body>
</html>