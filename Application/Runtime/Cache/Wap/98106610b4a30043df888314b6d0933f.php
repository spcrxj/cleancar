<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>会员中心</title>
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
                <p>会员中心</p>
            </header>
            <div class="huiyuanzhongxin c">
            <!--
                <dl>
                    <dt>
                        <img src="/cleancar/Public/wap/images/touxiang_btn_03.png" />
                    </dt>
                    <dd>
                        <h4>陕A123456</h4>
                        <h5>到期时间：2018年12月8日</h5>
                        <h5 style="display: none;">未交费</h5><!--h5标签内容切换-->
                    <!--/dd>
                </dl-->
                
                 <dl>
                    <dt>
                        <img src="<?php echo ($result[0]['avatar']); ?>" style="border-radius:3rem;"  />
                    </dt>
                    <dd>
                        <h4><?php echo ($result[0]['carcode']); ?></h4>
                        <h5>到期时间：<?php echo (date("Y-m-d",$result[0]['cleantime'])); ?></h5>
                        <h5 style="display: none;">未交费</h5><!--h5标签内容切换-->
                    </dd>
                </dl>
                
                <a href="<?php echo U('user/charge');?>">缴费</a>
            </div>
            <div class="huiyuanzhongxin_ct c">
                <a href="<?php echo U('user/profile');?>">
                    <i class="fl">
                        <img src="/cleancar/Public/wap/images/gerenziliao_03.png" />
                    </i>
                    <p class="fl">个人资料</p>
                    <em class="fr"></em>
                </a>
            </div>
            <div class="huiyuanzhongxin_cts c">
                <ul>
                    <li class="c">
                        <a href="<?php echo U('user/order');?>">
                            <i class="fl">
                                <img src="/cleancar/Public/wap/images/dingdan.png"/>
                            </i>
                            <p class="fl">我的订单</p>
                            <em class="fr"></em>
                        </a>
                    </li>
                    <li class="c">
                        <a href="<?php echo U('user/charge_record');?>">
                            <i class="fl">
                                <img src="/cleancar/Public/wap/images/jiaofeijilu_07.png" />
                            </i>
                            <p class="fl">缴费记录</p>
                            <em class="fr"></em>
                        </a>
                    </li>
                    <li class="c">
                        <a href="<?php echo U('user/clean_record');?>">
                            <i class="fl">
                                <img src="/cleancar/Public/wap/images/xichejilu_10.png" />
                            </i>
                            <p class="fl">洗车记录</p>
                            <em class="fr"></em>
                        </a>
                    </li>
                    <li class="c">
                        <a href="<?php echo U('system/activity_list');?>">
                            <i class="fl">
                                <img src="/cleancar/Public/wap/images/youhuihuodong_13.png" />
                            </i>
                            <p class="fl">优惠活动</p>
                            <em class="fr"></em>
                        </a>
                    </li>
                    <li class="c">
                        <a href="<?php echo U('system/company_introduction');?>">
                            <i class="fl">
                                <img src="/cleancar/Public/wap/images/gongsijieshao_15.png" />
                            </i>
                            <p class="fl">公司介绍</p>
                            <em class="fr"></em>
                        </a>
                    </li>
                    <li class="c">
                        <a href="<?php echo U('system/message');?>">
                            <i class="fl">
                                <img src="/cleancar/Public/wap/images/xiaoxitongzhi_18.png" />
                            </i>
                            <p class="fl">消息通知</p>
                            <em class="fr"></em>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </body>
    <script>
        $("body").show();
    </script>
</html>