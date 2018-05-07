<?php if (!defined('THINK_PATH')) exit();?><script type="text/javascript" src="js/jquery-1.10.2.min.js" ></script><!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>洗车记录</title>
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
                <p>洗车记录</p>
            </header>	
            <div class="xichejilu c">
                <div class="xichejilu_hd c">
                    <h4 class="fl">日期</h4>
                    <h5 class="fl">项目</h5>
                    <h6 class="fl">商家</h6>
                </div>
                <div class="xichejilu_cts" id="container">
					<?php if(is_array($result)): foreach($result as $key=>$vo): ?><div class="xichejilu_ct">
                            <h4 class="fl"><?php echo (date("Y-m-d H:i",$vo['log_time'])); ?></h4>
                            <h5 class="fl">洗车</h5>
                            <h6 class="fl"><?php echo ($vo['sellername']); ?>
                            </h6>
                        </div><?php endforeach; endif; ?>
                </div>
                <button id="getmore">查看更多</button>
                <input type="hidden" id='page' value=1>
            </div>	
            <!--没有消息-->
            <div class="meiyouxiaoxi">
                <h4>
                    <img src="/cleancar/Public/wap/images/meiyouxiaoxi_03.png" /> 
                </h4>
                <p>你还没有任何消息</p>
            </div>
        </div>
    </body>

    <script>
		function getLocalTime(nS) {     
			//2017/7/19 上午10:05:08
		    var s=new Date(parseInt(nS) * 1000).toLocaleString().replace(/上午/g, "").replace(/\//g, "-");      
			s=s.substring(0,s.length-3);
			return s;
		}     
	
	
	    $("body").show();
		 $("#getmore").on("click", function () {
            var p = parseInt($("#page").val())
            var next = p + 1;
            $("#page").val(next);
            $.ajax({
                url: "<?php echo U('User/clean_record');?>&p=" + next,
                type: "get", 
                success: function (data) {
					
                    if (data.length == 0) {
                        $("#getmore").html("没有更多数据").attr("disabled", true);
                    } else {
					    var html = '';
                        for (var i = 0; i < data.length; i++) {
                        	
						    html += ' <div class="xichejilu_ct">';
                            html += ' <h4 class="fl">' + getLocalTime(data[i].log_time) + '</h4>';
                            html += ' <h5 class="fl">洗车</h5>';
                            html += ' <h6 class="fl">'+data[i].sellername+'</h6>';
                            html += ' </div>';
                        }
                        $("#container").append(html);
                    }
                }
            });
        })
		
    </script>
    
</html>