<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>我的订单</title>
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
                <p>我的订单</p>
            </header>	
            <div class="wodedingdan xichejilu c">
                <ul  id="container" >
                	<?php if(is_array($result)): foreach($result as $key=>$vo): ?><li>
                            <p><?php echo ($vo['sellername']); ?></p>
                            <h4>时间：<?php echo (date("Y-m-d H:i",$vo['log_time'])); ?></h4>
                            <h5>项目：洗车</h5>
                            <h6 class="dianji" data-value="<?php echo ($vo['log_id']); ?>" >确定</h6>
                         </li><?php endforeach; endif; ?>
                </ul>
            	<button id="getmore">查看更多</button>
                <input type="hidden" id='page' value=1>	
            </div>
             	
        </div>
    </body>
        <script>
		$(".dianji").click(function(){
			var _this=$(this);
			 var orderid=$(this).attr('data-value');
			 $.ajax({
                url: "<?php echo U('User/confirm');?>",
                type: 'post',
            	data: {orderid:orderid},
				dataType:'json', 
                success: function (data) {
					if(data==1){
						_this.removeClass("dianji").addClass("weidianji").html("已确认");
					};
                }
            });	
		});
		
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
                url: "<?php echo U('User/order');?>&p=" + next,
                type: "get", 
                success: function (data) {
                    if (data.length == 0) {
                        $("#getmore").html("没有更多数据").attr("disabled", true);
                    } else {
					    var html = '';
                        for (var i = 0; i < data.length; i++) {
						    html += ' <li>';
                            html += ' <p>'+data[i].sellername+'</p>';
							html += ' <h4>时间：' + getLocalTime(data[i].log_time) + '</h4>';
							html += ' <h5>项目：洗车</h5>';                            
							html += ' <h6 class="dianji">确定<input type="hidden" value="'+data[i].log_id+'"/></h6>';
                            html += ' </li>';
                        }
                        $("#container").append(html);
                    }
                }
            });
        })
		
    </script>
</html>