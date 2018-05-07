<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>会员注册</title>
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
                <p>会员注册</p>
            </header>

            <form  method="post" class="form-horizontal" action="<?php echo U('login/register');?>" onsubmit="return check()">
                <div class="huiyuandenglu">
                    <div class="huiyuandenglu_ct c">
                        <label class="fl">姓   名：</label>
                        <input name="realname" id="realname" type="text" placeholder="请输入姓名" maxlength="8" class="fl"/>
                    </div>
                    <div class="huiyuandenglu_ct c">
                        <label class="fl">电   话：</label>
                        <input name="phone" id="phone" type="tel" placeholder="请输入手机号" maxlength="11" class="fl"/>
                    </div>
                    <div class="huiyuandenglu_cts c" style="margin: 0.74rem auto 0;width: 25.556rem;">
                        <div class="huiyuandenglu_label" style="width: 13.521rem;border-radius: 5px;height: 2.963rem;background-color: #fff;float: left;">
                            <label class="fl" style="width: 5.04rem;height: 2.963rem;font-size: 0.8889rem;line-height: 2.963rem;color: #363636;text-align: center;display: block;">验证码：</label>
                            <input id="vcode" type="text" placeholder="请输入验证码" maxlength="4" class="fl" style="width: 8.481rem;height: 2.963rem;padding: 1.04rem 0rem;border: none;color: #c2c1c1;font-size: 0.8889rem;border-radius: 5px;"/>
                        </div>
                        <i class="fl" style="width: 1.5rem;height: 2.963rem;background-color: #f0f0f0;"></i>
                        <span id="get_code_button" onclick="seed()" class="fr" style="width: 10.52rem;height: 2.963rem;background-color: #21a5ff;text-align: center;font-size: 1.111rem;line-height: 2.963rem;color: #fff;border-radius: 5px;">发送验证码</span>
                    </div>
                    <div class="huiyuandenglu_ct c">
                        <label class="fl">密   码：</label>
                        <input name="password" id="password" type="password" placeholder="请输入密码" maxlength="16" class="fl"/>
                    </div>
                    <div class="huiyuandenglu_ct c">
                        <label class="fl">品   牌：</label>
                        <input name="brand" id="brand" type="text" placeholder="请输入品牌/车型" maxlength="16" class="fl"/>
                    </div>
                    <div class="huiyuandenglu_ct c">
                        <label class="fl">车   牌：</label>
                        <h4 class="fl c">
                            <i>省</i>
                            <em></em>
                        </h4>
                        <input type="hidden" name="per_carcode" id="pre_carcode" value="">
                        <input name="carcode" id="carcode" type="text" placeholder="请输入" maxlength="6" class="fr" style="width: 16.5rem;height: 2.963rem;padding: 1.04rem 0rem;border: none;color: #c2c1c1;font-size: 0.8889rem;"/>
                    </div>
                    <button onclick="">注    册</button>				
                </div>
            </form>
            <!--车牌弹出层-->
            <div class="chepaidiqu_bg"></div>
            <div class="chepaidiqu c">
                <ul>
                    <li>陕</li>
                    <li>豫</li>
                    <li>云</li>
                    <li>辽</li>
                    <li>黑</li>
                    <li>湘</li>
                    <li>皖</li>
                    <li>鲁</li>
                    <li>新</li>
                    <li>苏</li>
                    <li>浙</li>
                    <li>赣</li>
                    <li>鄂</li>
                    <li>桂</li>
                    <li>甘</li>
                    <li>晋</li>
                    <li>蒙</li>
                    <li>冀</li>
                    <li>吉</li>
                    <li>闽</li>
                    <li>贵</li>
                    <li>粤</li>
                    <li>川</li>
                    <li>青</li>
                    <li>藏</li>
                </ul>
            </div>
            <input type="hidden" id="vcode_flag" value="">
        </div>
        <script>
            //显示隐藏的页面体
            $("body").show();

            //弹出省层
            $(function () {
                $(".chepaidiqu ul li").click(function () {
                    var _text = $(this).text();
                    $(".huiyuandenglu_ct h4 i").text(_text);
                    $("#pre_carcode").val(_text);
                })
                $('.huiyuandenglu_ct h4').click(function () {
                    $('.chepaidiqu_bg').fadeTo(1000, 1);
                    $('.chepaidiqu').animate({
                        bottom: '0'
                    });
                })
                $('.chepaidiqu_bg').click(function () {
                    $('.chepaidiqu_bg').fadeOut(300);
                    $('.chepaidiqu').animate({
                        bottom: '-100rem'
                    });
                })
                $('.chepaidiqu ul li').click(function () {
                    $('.chepaidiqu_bg').fadeOut(300);
                    $('.chepaidiqu').animate({
                        bottom: '-100rem'
                    });
                })
            });
            //弹出省层--

//****************************************************************************************
////获取短信验证码
            var countdown = 60;
            var btnable = 1;
            function seed() {
                if (btnable == 0) {
                    return false;
                }
                var tel = document.getElementById('phone').value;
                var tel_z = /^1\d{10}$/;
                if (tel.length <= 0) {
                    alert("请输入手机号码");
                    return false;
                }
                if (!tel_z.test(tel)) {
                    alert("手机号码格式不正确！");
                    return false;

                }
                //检测当前账号是否存在？
                var str = $.ajax({async: false, cache: false, url: "<?php echo U('ajax/check_register_mobile_number');?>&mobile=" + tel + "  ", data: ""}).responseText;
                if (str == 1) {
                    alert("用户已注册！");
                    return false;
                }
                btnable = 0; //将按钮置为不可点击
                $('#get_code_button').attr('disabled', true);
                alert("短信发送成功！");
                fasongtimer = setInterval("settime()", 1000);
                $.ajax({
                    url: "<?php echo U('ajax/send_sms');?>",
                    type: "POST",
                    async: true,
                    data: {tel: tel},
                    cache: false,
                    success: function (data) {
                        // alert("发送成功！");
                        console.log(data);
                    }

                })
            }
            //时间倒计时60
            function settime() {
                if (countdown <= 0) {
                    document.getElementById('get_code_button').style.color = '#21a5ff';
                    btnable = 1;
                    $('#get_code_button').removeAttr("disabled");
                    $('#get_code_button').html('获取验证码');
                    clearInterval(fasongtimer);
                    countdown = 60; //重置时间
                    return false;
                }
                countdown = countdown - 1;
                document.getElementById('get_code_button').style.color = '#999999';
                document.getElementById('get_code_button').innerHTML = "等待" + countdown + "秒";
            }
//*************************************************************************************


            //提交表单时 进行验证
            function check() {
                if ($("#realname").val().length == 0) {
                    alert("姓名不能为空！")
                    return false;
                }
                if ($("#vcode_flag").val() != 1) {
                    alert("验证码不正确！")
                    return false;
                }

                if (!$("#password").val().match(/^\w{6,12}$/)) {
                    alert("密码长度为6~12！")
                    return false;
                }

                if ($("#brand").val().length == 0) {
                    alert("请输入品牌！")
                    return false;
                }
                if (!$("#carcode").val().match(/^\w{6}$/)) {
                    alert("车牌长度为6！")
                    return false;
                }
                if ($("#pre_carcode").val().length == 0) {
                    alert("请选择车牌省份！")
                    return false;
                }

            }

            //验证验证码是否正确
            $("#vcode").on("input", function () {
                $.get("<?php echo U('ajax/check_if_cvode_is_verified');?>", {vcode: $(this).val()}, function (c) {
                    $("#vcode_flag").val(c)
                })
            })

            //输入电话号时清空验证码
            $("#phone").on('input', function () {
                $("#vcode").val("");
                $("#vcode_flag").val("")
            })
        </script> 
    </body>
</html>