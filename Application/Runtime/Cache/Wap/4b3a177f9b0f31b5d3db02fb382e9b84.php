<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>活动详情</title>
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
    <body style="display: none;background-color: #fff;">
        <div class="box">
            <header>
                <i onClick="javascript :history.back(-1);"></i>
                <p>活动详情</p>
            </header>	
            <div class="huodongxiangqing">
                <?php if(is_array($activityDetails)): $i = 0; $__LIST__ = $activityDetails;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$activity): $mod = ($i % 2 );++$i;?><h4>
                        <img style="width: 100%;height: 100%" src="<?php echo ($activity["activity_image"]); ?>" />
                    </h4>
                    <div class="ct">
                        <?php echo ($activity["activity_content"]); ?>
                    </div>
                    <input type="hidden" id="activity_id" value="<?php echo ($activity_id); ?>"/>
                    <input type="hidden" id="user_id" value="<?php echo ($user_id); ?>"/>
                    <input type="hidden" id="isEngage" value="<?php echo ($isEngage); ?>"/><?php endforeach; endif; else: echo "" ;endif; ?>
            </div>
            <div class="footer">
                <input class="button link" value="立即报名"/>
            </div>
        </div>
    </body>
    <script>
        $("body").show();
        window.onload = function () {
            if($('#isEngage').val()==1)//报过名
            {
                $(".button").addClass("link");
                $(".button").val("您已参加该活动");
                $('.button').attr('disabled',"true");
            }else if($('#isEngage').val()==2){
                $(".button").removeClass("link");
                $('.button').removeAttr("disabled");
            }
        }
        //点击报名
        $(".button").click(function()
        {
          var user_id = $("#user_id").val();
          var activity_id = $("#activity_id").val();
            $.ajax({
                url: "<?php echo U('ajax/is_login');?>&user_id="+user_id+"&activity_id="+activity_id,
                type: "get",
                success: function (data) {
                    if(data == 0) {
                        location.href = "<?php echo U('login/login');?>";
                    }else if (data == 1) {
                        $(".button").addClass("link");
                        $(".button").val("您已参加该活动");
                        $('.button').attr('disabled',"true");
                    } else if(data == 2) {
                        $(".button").removeClass("link");
                        $('.button').removeAttr("disabled");
                    }
                }
            });
        });

    </script>
</html>