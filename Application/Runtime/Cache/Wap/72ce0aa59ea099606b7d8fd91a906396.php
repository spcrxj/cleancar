<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>金立方洗车</title>
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
        <script type="text/javascript" src="/cleancar/Public/wap/js/media-query.js" ></script>
        <script type="text/javascript" src="/cleancar/Public/wap/js/swiper-2.1.min.js" ></script>
        <script type="text/javascript" src="/cleancar/Public/wap/js/jq_scroll.js" ></script> 
    </head>  
    <script type="text/javascript">
        $(document).ready(function () {
            $("#scrollDiv").Scroll({
                line: 1,
                speed: 500,
                timer: 5000,
                up: "but_up",
                down: "but_down"
            });
        });
    </script>
    <body style="display: none;">
        <div id="cover" style="position: fixed;width: 100%;height: 100%;background: rgba(0,0,0,0.1);z-index: 9999;display: none"></div> 
        <div id="loading" style="width:85px;height:85px;position:fixed;left:50%;top:50%;margin-top:-43px;margin-left:-43px;display:none;z-index:99999;">
            <img src="/cleancar/Public/wap/images/loading_page.gif">
        </div>
        <div class="box">
            <header class="c">
                <p>金立方洗车</p>
                <a href="<?php echo U('system/message');?>">
                    <em class="fr"></em>
                    <?php if(($count != null) AND ($count != 0)): ?><font><?php echo ($count); ?></font>
                        <?php if($count > 9): ?><script>
                                $('font').css({"width": "1rem", "height": "1rem", "line-height": "1rem"});
                            </script><?php endif; endif; ?>
                </a>
            </header>
            <!-- 轮播图-->
            <div class="banner_box">
                <div class="swiper-container">
                    <div class="swiper-wrapper" id="swiper-wrapper">
                        <?php if(is_array($focuslist)): $i = 0; $__LIST__ = $focuslist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$focus): $mod = ($i % 2 );++$i;?><div class="swiper-slide">
                                <a href="<?php echo ($focus["focus_url"]); ?>"><img src="<?php echo ($focus["focus_image"]); ?>" alt=""></a>
                            </div><?php endforeach; endif; else: echo "" ;endif; ?>  
                    </div>
                    <div class="pagination"></div>
                </div>
            </div>
            <!--滚动公告-->
            <div class="in_xwzx_bg c">
                <span></span>
                <div class="scrollbox">
                    <div id="scrollDiv">
                        <ul>
                            <?php if(is_array($activitylist)): $i = 0; $__LIST__ = $activitylist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$activity): $mod = ($i % 2 );++$i;?><li>
                                    <a href="<?php echo U('system/activity_detail',array('activity_id'=>$activity['id']));?>"><?php echo ($activity["sellername"]); ?> <?php echo ($activity["activity_starttime"]); ?><i><?php echo ($activity["activity_title"]); ?></i>，小伙伴赶快来吧!</a> 
                                </li><?php endforeach; endif; else: echo "" ;endif; ?>
                            <!--<li>
            <a href="<?php echo U('system/activity_detail');?>">雁塔路洗车行今天<i>9.9元洗车</i>，小伙伴赶快来吧!</a>
        </li>-->
                        </ul>
                    </div>
                </div>
            </div>
            <div class="nav c">
                <ul>
                    <li>
                        <a href="<?php echo U('login/notice');?>">
                            <h4>
                                <img src="/cleancar/Public/wap/images/huiyuanbanli_13.png" />
                            </h4>
                            <h5>会员办理</h5>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo U('user/index');?>">
                            <h4>
                                <img src="/cleancar/Public/wap/images/huiyuanzhongxin_15.png" />
                            </h4>
                            <h5>会员中心</h5>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo U('system/company_introduction');?>">
                            <h4>
                                <img src="/cleancar/Public/wap/images/gongsijieshao_17.png" />
                            </h4>
                            <h5>公司介绍</h5>
                        </a>
                    </li>
                </ul>
            </div>
            <!--热门活动-->
            <div class="remenhuodong">
                <h4>
                    <img src="/cleancar/Public/wap/images/remenhuodong_23.png" />
                </h4>
                <ul>
                    <?php if(is_array($activityList)): $i = 0; $__LIST__ = $activityList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$activity): $mod = ($i % 2 );++$i;?><li>
                            <a href="<?php echo U('system/activity_detail',array('activity_id'=>$activity['id']));?>">
                                <img style="width: 100%; height: 100%;" src="<?php echo ($activity["activity_image"]); ?>" />
                            </a>
                        </li><?php endforeach; endif; else: echo "" ;endif; ?>
                </ul>
            </div>
            <!--商家推荐-->
            <div class="shangjiatuijian">
                <h4>
                    <img src="/cleancar/Public/wap/images/tuijianshangjia_31.png" />
                </h4>
                <div class="shangjiatuijian_hd c">
                    <ul>
                        <li class="link">综合排序</li>
                        <li>洗车人次</li>
                        <li>距离最近</li>
                    </ul>
                </div>
                <div class="shangjiatuijian_cts">
                    <div class="shangjiatuijian_ct div c">
                        <ul id="container0">
                            <?php if(is_array($sellerList)): $i = 0; $__LIST__ = $sellerList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$seller): $mod = ($i % 2 );++$i;?><li class="c">
                                    <dl>
                                        <dt>
                                            <a href="<?php echo U('system/bus_detail',array('seller_id'=>$seller['seller_id']));?>">
                                                <img src="<?php echo ($seller["seller_images"]); ?>" />
                                            </a>
                                        </dt>
                                        <dd>
                                            <div class="shangjia">
                                                <a href="<?php echo U('system/bus_detail',array('seller_id'=>$seller['seller_id']));?>">
                                                    <p><?php echo ($seller["sellername"]); ?></p>
                                                    <h5><?php echo ($seller["selleraddress"]); ?></h5>
                                                </a>
                                            </div>
                                            <div class="juli c">
                                                <i class="fl"></i>
                                                <em class="fl"><?php echo ($seller["distance"]); ?>KM</em>
                                                <strong class="fl">人次：<?php echo ($seller["clean_people"]); ?></strong>
                                            </div>
                                            <div class="fuwuneirongs c">
                                                <div class="fuwuneirong c fl">
                                                    <?php if($seller['remark']['0']):?><i class="fl"><?php echo ($seller['remark']['0']); ?></i><?php endif;?>
                                                    <?php if($seller['remark']['0']):?><i class="fl"><?php echo ($seller['remark']['1']); ?></i><?php endif;?>
                                                </div>
                                                <a class="fr c" onclick="gotourl('我的地址', '<?php echo ($user_location); ?>', '<?php echo ($seller["sellername"]); ?>', '<?php echo ($seller["seller_location"]); ?>')">
                                                    <i class="fl">
                                                        <img src="/cleancar/Public/wap/images/dingwei_07.png" />
                                                    </i>
                                                    <em class="fl" >导航</em>
                                                </a>
                                            </div>
                                        </dd>
                                    </dl>
                                </li><?php endforeach; endif; else: echo "" ;endif; ?>
                        </ul>  
                    </div>
                    <div class="shangjiatuijian_ct div1 c">
                        <ul id="container1">
                            <?php if(is_array($sellerTimesList)): $i = 0; $__LIST__ = $sellerTimesList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$seller): $mod = ($i % 2 );++$i;?><li class="c">
                                    <dl>
                                        <dt>
                                            <a href="<?php echo U('system/bus_detail',array('seller_id'=>$seller['seller_id']));?>">
                                                <img src="<?php echo ($seller["seller_images"]); ?>" />
                                            </a>
                                        </dt>
                                        <dd>
                                            <div class="shangjia">
                                                <a href="<?php echo U('system/bus_detail',array('seller_id'=>$seller['seller_id']));?>">
                                                    <p><?php echo ($seller["sellername"]); ?></p>
                                                    <h5><?php echo ($seller["selleraddress"]); ?></h5>
                                                </a>
                                            </div>
                                            <div class="juli c">
                                                <i class="fl"></i>
                                                <em class="fl"><?php echo ($seller["distance"]); ?>KM</em>
                                                <strong class="fl">人次：<?php echo ($seller["clean_people"]); ?></strong>
                                            </div>
                                            <div class="fuwuneirongs c">
                                                <div class="fuwuneirong c fl">
                                                    <?php if($seller['remark']['0']):?><i class="fl"><?php echo ($seller['remark']['0']); ?></i><?php endif;?>
                                                    <?php if($seller['remark']['0']):?><i class="fl"><?php echo ($seller['remark']['1']); ?></i><?php endif;?>
                                                </div>
                                                <a  class="fr c"  onclick="gotourl('我的地址', '<?php echo ($user_location); ?>', '<?php echo ($seller["sellername"]); ?>', '<?php echo ($seller["seller_location"]); ?>')">
                                                    <i class="fl">
                                                        <img src="/cleancar/Public/wap/images/dingwei_07.png" />
                                                    </i>
                                                    <em class="fl">导航</em>
                                                </a>
                                            </div>
                                        </dd>
                                    </dl>
                                </li><?php endforeach; endif; else: echo "" ;endif; ?>
                        </ul>
                    </div>
                    <div class="shangjiatuijian_ct div1 c">
                        <ul id="container2">
                            <?php if(is_array($sellerDistanceList)): $i = 0; $__LIST__ = $sellerDistanceList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$seller): $mod = ($i % 2 );++$i;?><li class="c">
                                    <dl>
                                        <dt>
                                            <a href="<?php echo U('system/bus_detail',array('seller_id'=>$seller['seller_id']));?>">
                                                <img src="<?php echo ($seller["seller_images"]); ?>" />
                                            </a>
                                        </dt>
                                        <dd>
                                            <div class="shangjia">
                                                <a href="<?php echo U('system/bus_detail',array('seller_id'=>$seller['seller_id']));?>">
                                                    <p><?php echo ($seller["sellername"]); ?></p>
                                                    <h5><?php echo ($seller["selleraddress"]); ?></h5>
                                                </a>
                                            </div>
                                            <div class="juli c">
                                                <i class="fl"></i>
                                                <em class="fl"><?php echo ($seller["distance"]); ?>KM</em>
                                                <strong class="fl">人次：<?php echo ($seller["clean_people"]); ?></strong>
                                            </div>
                                            <div class="fuwuneirongs c">
                                                <div class="fuwuneirong c fl">
                                                    <?php if($seller['remark']['0']):?><i class="fl"><?php echo ($seller['remark']['0']); ?></i><?php endif;?>
                                                    <?php if($seller['remark']['0']):?><i class="fl"><?php echo ($seller['remark']['1']); ?></i><?php endif;?>
                                                </div>
                                                <a  class="fr c"  onclick="gotourl('我的地址', '<?php echo ($user_location); ?>', '<?php echo ($seller["sellername"]); ?>', '<?php echo ($seller["seller_location"]); ?>')">
                                                    <i class="fl">
                                                        <img src="/cleancar/Public/wap/images/dingwei_07.png" />
                                                    </i>
                                                    <em class="fl">导航</em>
                                                </a>
                                            </div>
                                        </dd>
                                    </dl>
                                </li><?php endforeach; endif; else: echo "" ;endif; ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!--用来区分type类型综合排序、人数、距离-->
        <input type="hidden" value="0" id="order_type">
        <!--用来区分p的值--> 
        <input type="hidden" value="2" id="p0">
        <input type="hidden" value="2" id="p1">
        <input type="hidden" value="2" id="p2"> 
    </body> 
    <script>
        //显示主页
        $("body").show();
        //跳转导航
        function gotourl(from, fromcoord, to, tocoord) {
            if (fromcoord.length > 0 && tocoord.length > 0) {
                location.href = "http://apis.map.qq.com/uri/v1/routeplan?type=drive&from=" + from + "&fromcoord=" + fromcoord + "&to=" + to + "&tocoord=" + tocoord + "&policy=1&referer=myapp";
            } else {
                alert("获取地理位置失败！");
                return false;
            }
        }
        //切换效果
        $(function () {
            $('.shangjiatuijian_hd ul li').click(function () {
                var index = $('.shangjiatuijian_hd ul li').index(this);
                $('#order_type').val(index);
                $(this).addClass('link').siblings().removeClass('link')
                $('.shangjiatuijian_cts .shangjiatuijian_ct').eq(index).css('display', 'block').siblings().css('display', 'none')
            })
        })

        //滚动加载
        $(window).scroll(function () {
            var totalheight = 0;     //定义一个总的高度变量
            totalheight = parseFloat($(window).height()) + parseFloat($(window).scrollTop()); //浏览器的高度加上滚动条的高度 （页面总高度） 
            if ($(document).height() <= totalheight) {
                var ind = $('#order_type').val()
                var pid = "#p" + ind;
                var p = $(pid).val();
                getData(ind, p);
            }
        });

        function getData(ind, p) {
            $.ajax({
                url: "<?php echo U('ajax/index_get_more');?>&p=" + p + "&index=" + ind,
                type: "get",
                timeout: 3000,
                success: function (data) {
                    var pid = "#p" + ind;
                    var p = $(pid).val(parseInt($(pid).val()) + 1); //重置当前页数 
                    var container = "#container" + ind;
                    if (data.length == 0) {
                        $(container).append('没有任何商家！');
                    } else {
                        var data = data.sellerList;
                        var html = '';
                        for (var i = 0; i < data.length; i++) {
                            html += '<li class="c">';
                            html += '<dl>';
                            html += '<dt>';
                            html += '<a href="<?php echo U('system/bus_detail');?>&seller_id=' + data[i].seller_id + '">';
                            html += '<img src=' + data[i].seller_images + '>';
                            html += '</a>';
                            html += '</dt>';
                            html += '<dd>';
                            html += '<div class="shangjia">';
                            html += '<a href="<?php echo U('system/bus_detail');?>&seller_id=' + data[i].seller_id + '">';
                            html += '<p>' + data[i].sellername + '</p>';
                            html += '<h5>' + data[i].selleraddress + '</h5>';
                            html += '</a>';
                            html += '</div>';
                            html += '<div class="juli c">';
                            html += '<i class="fl"></i>';
                            html += '<em class="fl">' + data[i].distance + 'KM</em>';
                            html += '<strong class="fl">人次：' + data[i].clean_people + '</strong>';
                            html += '</div>';
                            html += '<div class="fuwuneirongs">';
                            html += '<div class="fuwuneirong c fl">';
                            if (data[i].remark[0])
                                html += '<i class="fl">' + data[i].remark[0] + '</i>';
                            if (data[i].remark[1])
                                html += '<i class="fl">' + data[i].remark[1] + '</i>';
                            html += '</div>';
                            html += '<a class="fr c"    onclick="gotourl(\'我的地址\', \'<?php echo ($user_location); ?>\', \'' + data[i].sellername + '\', \'' + data[i].seller_location + '\')"></i>';
                            html += '<i class="fl">';
                            html += '<img src="/cleancar/Public/wap/images/dingwei_07.png" />';
                            html += '</i>';
                            html += '<em class="fl">导航</em>';
                            html += '</a>';
                            html += '<div>';
                            html += '</dd>';
                            html += '</dl>';
                            html += '</li>';
                        }
                        $(container).append(html);
                    }
                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                    //通常情况下textStatus和errorThrown只有其中一个包含信息
                    alert("服务器超时");
                },
                beforeSend: function () {
                    $("#cover").show()
                    $("#loading").fadeIn(); //加载
                },
                complete: function () {
                    $("#cover").hide()
                    $("#loading").fadeOut();//加载完毕  
                }
            });
        }
    </script>
</html>