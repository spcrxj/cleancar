<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>会员登录</title>
        <meta http-equiv="Content-type" content="text/html; charset=utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta http-equiv="Cache-Control" content="no-transform" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
        <meta name="apple-mobile-web-app-status-bar-style" content="black">
        <meta name="renderer" content="webkit">
        <!--uc浏览器判断到页面上文字居多时，会自动放大字体优化移动用户体验。添加以下头部可以禁用掉该优化-->
        <meta name="wap-font-scale" content="no">
        <meta content="telephone=no" name="format-detection"/>
        <META HTTP-EQUIV="Pragma" CONTENT="no-cache">
        <link rel="stylesheet" href="/cleancar/Public/wap/css/html5.css" />
        <link rel="stylesheet" href="/cleancar/Public/wap/css/index.css" />
        <script type="text/javascript" src="/cleancar/Public/wap/js/jquery-1.10.2.min.js" ></script>
        <script type="text/javascript" src="/cleancar/Public/wap/js/screenSize.js" ></script>
    </head>  
    <body style="display: none;">
        <div class="box">
            <header>
                <i onClick="javascript :history.back(-1);"></i>
                <p>会员登录</p>
            </header>

            <form  method="post" class="form-horizontal" action="<?php echo U('login/login');?>" onsubmit="return check()">
                <div class="huiyuandenglu c">
                    <div class="huiyuandenglu_ct c">
                        <label class="fl">用户名：</label>
                        <input  name="username" id="username" type="text" placeholder="手机号/车牌号（车牌号请填写完整）" maxlength="11" class="fl"/>
                    </div>
                    <div class="huiyuandenglu_ct c">
                        <label class="fl">密   码：</label>
                        <input name="password" id="password" type="password" placeholder="请输入密码" maxlength="18" class="fl"/>
                    </div>
                    <a href="<?php echo U('login/forget_password');?>">忘记密码</a>
                    <button onclick="">登    陆</button>				
                </div>	
            </form>
        </div>
    </body>
    <script>
        $("body").show();
         //提交表单时 进行验证
            function check() {
                 /*正则手机号或者车牌号
                 手机号 1[1,3~5,7~9]1  
                 */
                 if(!$("#username").val().match(/^(1[1,3-5,7-9]\d{9}|[\u2E80-\u9FFF]\w{6})$/)){
                     alert("用户名为手机号或车牌！") 
                     return false;
                 }  
                 if(!$("#password").val().match(/^\w{6,12}$/)){
                     alert("密码长度为6~12！") 
                     return false;
                 } 
                 
            }
    </script>
</html>