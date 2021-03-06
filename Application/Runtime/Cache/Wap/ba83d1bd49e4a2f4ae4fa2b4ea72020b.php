<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>个人资料</title>
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
        <script type="text/javascript" src="/cleancar/Public/imageUpload.js" ></script>
    </head>  
    <body style="display: none;">
        <div class="box">
            <header>
                <i onClick="javascript :history.back(-1);"></i>
                <p>个人资料</p>
            </header>
            <div class="huiyuandenglu c">
                <div class="touxiang c">
                    <form name="form" id="ajxform" action="<?php echo U('User/profile');?>" method="post"  />
                    <i class="fl">头像</i>
                    <em class="fr"><img src="<?php echo ($result[0]['avatar']); ?>" id="upload-img" style="width: 3.185rem; height: 3.185rem; border-radius:4rem; "    /></em>
                    <input id="imgpath_path" name="avatar" style="display: none;" />
                    <input class="input-file" id="imageUpload" type="file" name="fileInput" capture="camera" accept="image/*" />
                    </form>
                </div>
                <div class="gerenziliao c">
                    <i class="fl">手机号</i>
                    <em class="fr"><?php echo ($result[0]['phone']); ?></em>
                    <strong></strong>

                </div>
                <div class="gerenziliao c">
                    <i class="fl">车牌号</i>
                    <em class="fr"><?php echo ($result[0]['carcode']); ?></em>
                    <strong></strong>
                </div>
                <div class="gerenziliao c">
                    <a href="<?php echo U('change_password');?>">
                        <i class="fl">修改密码</i>
                        <strong></strong>
                    </a>
                </div>
                <button onclick="location.href = '<?php echo U('user/logout');?>'">退出登陆</button>				
            </div>			
        </div>
    </body>
    <script>
        $("body").show();
    </script>

    <script>
        //图片插件
        //图片上传
        $('#upload-img').imageUpload({
            imgTar: '#imageUpload',
            uploadField: 'imgpath_path',
            limitSize: 20, //兆 
            uploadUrl: "<?php echo U('upload/headimg');?>",
            uploadSuccess: function (res) { //return img url
                //alert(res);
                $("#imgpath_path").val(res);
                $("#upload-img").attr("src", res);
                $("#loading").fadeOut();//加载完毕 
                //$("#loading").fadeIn(); //加载
                $("#ajxform").submit();
                return res;

            },
            uploadError: function (res) { //something error
                console.log(res);
                // alert(res);
                return false;
            }
        });
    </script>

</html>