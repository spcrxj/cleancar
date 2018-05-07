<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>商家详情</title>
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
                <p>商家详情</p>
            </header>
            <div class="shangjiaxiangqing_hd c">
                <dl>
                    <dt>
                        <img src="<?php echo ($sellerInfo['seller_images']); ?>" />
                    </dt>
                    <dd>
                        <h4><?php echo ($sellerInfo['sellername']); ?></h4>
                        <p>08:00-19:00</p>
                        <p>人次：256312</p>
                    </dd>
                </dl>
            </div>
            <div class="shangjiaxiangqing_dizhi c">
                <a href="#" onclick="gotourl('我的地址', '<?php echo ($user_location); ?>', '<?php echo ($sellerInfo["sellername"]); ?>', '<?php echo ($sellerInfo["seller_location"]); ?>')">
                    <p class="fl"><?php echo ($sellerInfo['selleraddress']); ?></p>
                    <i class="fr" ></i>
                </a>
            </div>
            <div class="fuwushuoming">
                <h4>服务说明</h4>
                <?php echo ($sellerInfo['seller_content']); ?>
            </div>
        </div>
    </body>
    <script>
        $("body").show();
        function gotourl(from, fromcoord, to, tocoord) {
            if (fromcoord.length > 0 && tocoord.length > 0) {
                location.href = "http://apis.map.qq.com/uri/v1/routeplan?type=drive&from=" + from + "&fromcoord=" + fromcoord + "&to=" + to + "&tocoord=" + tocoord + "&policy=1&referer=myapp";
            } else {
                alert("获取地理位置失败！");
                return false;
            }
        }
    </script>
</html>