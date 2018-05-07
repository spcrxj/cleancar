<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>缴费</title>
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
                <p>缴费</p>
            </header>
            <div class="huiyuandenglu c">
                <div class="jiaofei_ct c">
                    <input type="hidden" value="500"/>
                    <p>年度洗车会员<i>（不限次数）</i></p>
                    <h4>12个月会员，每月41.7元</h4>
                    <h5>￥<i>500</i></h5>
                </div>
                <div class="jiaofei_zhifu c">
                    <i class="fl"></i>
                    <p class="fl">微信支付</p>
                    <input type="radio" checked="checked" class="fr"/>
                </div>
                <button onclick="wxpay()">确   定</button>				
            </div>			
        </div>
    </body>
    <script>
        $("body").show();
    </script>
    <script>
        function wxpay(){
            var money=500;
            location.href="<?php echo U('user/weixinpayorder');?>&money="+money;
        }
    </script>
</html>