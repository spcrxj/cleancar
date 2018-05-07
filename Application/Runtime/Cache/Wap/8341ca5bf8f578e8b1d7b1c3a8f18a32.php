<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
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
        <script type="text/javascript" src="http://3gimg.qq.com/lightmap/components/geolocation/geolocation.min.js"></script>
        <script>
            alert(123);
            (function (doc, win) {
                var docEl = doc.documentElement,
                        resizeEvt = 'orientationchange' in window ? 'orientationchange' : 'resize',
                        recalc = function () {
                            var clientWidth = docEl.clientWidth;
                            /*自加*/
                            clientWidth = document.documentElement ? document.documentElement.clientWidth : document.body.clientWidth;
                            if (clientWidth > 720)
                                clientWidth = 720;
                            /*自加*/
                            if (!clientWidth)
                                return;
                            docEl.style.fontSize = 24 * (clientWidth / 720) + 'px';
                        };
                if (!doc.addEventListener)
                    return;
                win.addEventListener(resizeEvt, recalc, false);
                doc.addEventListener('DOMContentLoaded', recalc, false);
            })(document, window);
            function gotourl() {
                var fromcoord = $("#mylocation").val();
                if (fromcoord.length > 0) {
                    location.href = "http://apis.map.qq.com/uri/v1/routeplan?type=drive&from=起&fromcoord=" + fromcoord + "&to=止&tocoord=<?= $setting['location'] ?>&policy=1&referer=myapp";
                } else {
                    alert("获取地理位置失败，请刷新页面重试！");
                }
            }

            var mapapijson;
            var geolocation = new qq.maps.Geolocation("XNYBZ-XKBHS-OJYOK-6DMZO-GOJMZ-FAFL3", "myapp");
            var options = {timeout: 4000};
            function showPosition(position) {
                var json = eval('(' + JSON.stringify(position, null, 4) + ')');
                sheng = json.province;
                shi = json.city;
                district = json.district;//区
                lat = json.lat;
                lng = json.lng;
                $("#mylocation").val(lat + "," + lng);
                $("#daohang").show();
            }
            ;
            function showErr() {
                $("#mylocation").val("");
                $("#daohang").hide();
            }
            ;
            geolocation.getLocation(showPosition, showErr, options);
        </script>
    </head>

    <body>
        <div class="box">
            <div class="head_bg c">
                <div class="head c">
                    <div class="head_text"><h4>个人中心</h4></div>
                </div>
            </div>
            <div class="grzx_bg"> 
                <div class="grzx_bg_ct c">
                    <ul class="c">
                        <li id="daohang" style="display:none;">
                            <input type="hidden" id="mylocation"> 
                        </li>
                          
                    </ul>
                </div>
            </div>

        </div>
    </body>
</html>