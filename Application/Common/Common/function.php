<?php

/**
 * moneyhash
 *
 * 字符串加密
 *
 */
function moneyhash($money) {
    return md5("dashang" . $money . "hengye");
}

/**
 * __mkdirs
 *
 * 循环建立目录的辅助函数
 *
 * @param dir    目录路径
 * @param mode    文件权限
 */
function __mkdirs($dir, $mode = 0777) {
    if (!is_dir($dir)) {
        __mkdirs(dirname($dir), $mode);
        @mkdir($dir, $mode);
        return true;
    }
    return true;
}

/*
 * 精确时间间隔函数
 * $time 发布时间 如 1356973323
 * $str 输出格式 如 Y-m-d H:i:s
 * 半年的秒数为15552000，1年为31104000，此处用半年的时间
 */

function from_time($time, $str) {
    isset($str) ? $str : $str = 'm-d';
    $way = time() - $time;
    $r = '';
    if ($way < 60) {
        $r = '刚刚';
    } elseif ($way >= 60 && $way < 3600) {
        $r = floor($way / 60) . '分钟前';
    } elseif ($way >= 3600 && $way < 86400) {
        $r = floor($way / 3600) . '小时前';
    } elseif ($way >= 86400 && $way < 2592000) {
        $r = floor($way / 86400) . '天前';
    } elseif ($way >= 2592000 && $way < 15552000) {
        $r = floor($way / 2592000) . '个月前';
    } else {
        $r = date("$str", $time);
    }
    return $r;
}

/*
 * 精确时间间隔函数(和上一个函数的区别在这个函数是将来的时间)
 * $time 发布时间 如 1356973323
 * $str 输出格式 如 Y-m-d H:i:s
 * 半年的秒数为15552000，1年为31104000，此处用半年的时间
 */

function future_time($time, $str) {
    isset($str) ? $str : $str = 'm-d';
    $way = time() - $time;
    $r = "";
    if ($way > 0) {
        $r = "正在";
    } else if ($way <= 0 && $way > -60) {
        $r = "即将";
    } else if ($way <= -60 && $way > -86400) {
        $r = "今天";
    } else if ($way <= -86400 && $way > -2592000) {
        if (floor($way / -86400) == 1) {
            $r = "明天";
        } else if (floor($way / -86400) == 2) {
            $r = "后天";
        }
    } else if ($way <= -2592000) {
        $y = date("Y", $time);
        $m = date("m", $time);
        $d = date("d", $time);
        $r = intval($y) . '年' . intval($m) . '月' . intval($d) . '日';
    }
    return $r;
}

//自定义输出
function dd($data) {
    header("content-type:text/html;Charset=utf-8");
    echo "<pre>";
    print_r($data);
    die();
}

//生成特定二维码，将图片2作为背景，图片1加层在图片2上
/*
  $image1 图片1
  $image2 图片2
  $from_w 载入图片的缩放宽,二维码正方形
  $to_x 要载入的区域x坐标
  $to_y 要载入的区域y坐标
  $out_image 输出图片名称
 */
//format_qrcode("qrcode_111.png",'qrcode_background.png',220,70,40);
function format_qrcode($image1, $image2, $from_w, $to_x, $to_y) {
    //文件保存目录路径
    $save_path = THINK_PATH . '../uploadfile/qrcode/';
    //文件保存目录URL
    $save_url = C("WEB_URL") . '/uploadfile/qrcode/';
    //将画布保存到指定的png文件
    $pathinfo = pathinfo($image1);
    //定宽输出文件名
    $out_image_from_w = str_replace("." . $pathinfo['extension'], "", $pathinfo['basename']) . "_" . $from_w . "." . $pathinfo['extension'];
    //合成图片文件名
    $out_image_show = str_replace("." . $pathinfo['extension'], "", $pathinfo['basename']) . "_show." . $pathinfo['extension'];

    //将人物和装备图片分别取到两个画布中
    if ($pathinfo['extension'] == "jpg") {
        $image_1 = imagecreatefromjpeg($save_path . $image1);
    } elseif ($pathinfo['extension'] == "png") {
        $image_1 = imagecreatefrompng($save_path . $image1);
    }
    $image_2 = imagecreatefrompng($save_path . $image2);
    //创建一个和图片2等宽高的真彩色画布
    $image_3 = imageCreatetruecolor(imagesx($image_2), imagesy($image_2));
    //为真彩色画布创建白色背景
    //$color = imagecolorallocate($image_3, 255, 255, 255);//背景为透明
    $color = imagecolorallocate($image_3, 255, 255, 0); //背景为白色
    imagefill($image_3, 0, 0, $color);
    imageColorTransparent($image_3, $color);
    //首先将$image_2画布采样copy到真彩色画布中，不会失真
    imagecopyresampled($image_3, $image_2, 0, 0, 0, 0, imagesx($image_2), imagesy($image_2), imagesx($image_2), imagesy($image_2));
    //如果$image_1图片尺寸大于指定宽高则对图片进行压缩

    if (imagesx($image_1) > $from_w) {
        //创建一个画布
        $image_1_1 = imageCreatetruecolor($from_w, $from_w);
        //图片进行压缩
        imagecopyresampled($image_1_1, $image_1, 0, 0, 0, 0, $from_w, $from_w, imagesx($image_1), imagesy($image_1));
        imagepng($image_1_1, $save_path . $out_image_from_w);
        //再将$image_1_1图片copy到已经具有$image_2的真彩色画布中，同样也不会失真
        imagecopymerge($image_3, $image_1_1, $to_x, $to_y, 0, 0, imagesx($image_1_1), imagesy($image_1_1), 100);
    } else {
        //再将$image_1图片copy到已经具有$image_2的真彩色画布中，同样也不会失真
        imagecopymerge($image_3, $image_1, $to_x, $to_y, 0, 0, imagesx($image_1), imagesy($image_1), 100);
    }

    //输出图片
    if ($pathinfo['extension'] == "jpg") {
        imagejpeg($image_3, $save_path . $out_image_show);
    } elseif ($pathinfo['extension'] == "png") {
        imagepng($image_3, $save_path . $out_image_show);
    }
    return $save_url . $out_image_show;
}

/**
 * 字符截取 支持UTF8/GBK
 * @param $string
 * @param $length
 * @param $dot
 */
function str_cut($string, $length, $dot = '...', $charset = "utf-8") {
    $strlen = strlen($string);
    if ($strlen <= $length)
        return $string;
    $string = str_replace(array(' ', '&nbsp;', '&amp;', '&quot;', '&#039;', '&ldquo;', '&rdquo;', '&mdash;', '&lt;', '&gt;', '&middot;', '&hellip;'), array('∵', ' ', '&', '"', "'", '“', '”', '—', '<', '>', '·', '…'), $string);
    $strcut = '';
    if (strtolower($charset) == 'utf-8') {
        $length = intval($length - strlen($dot) - $length / 3);
        $n = $tn = $noc = 0;
        while ($n < strlen($string)) {
            $t = ord($string[$n]);
            if ($t == 9 || $t == 10 || (32 <= $t && $t <= 126)) {
                $tn = 1;
                $n++;
                $noc++;
            } elseif (194 <= $t && $t <= 223) {
                $tn = 2;
                $n += 2;
                $noc += 2;
            } elseif (224 <= $t && $t <= 239) {
                $tn = 3;
                $n += 3;
                $noc += 2;
            } elseif (240 <= $t && $t <= 247) {
                $tn = 4;
                $n += 4;
                $noc += 2;
            } elseif (248 <= $t && $t <= 251) {
                $tn = 5;
                $n += 5;
                $noc += 2;
            } elseif ($t == 252 || $t == 253) {
                $tn = 6;
                $n += 6;
                $noc += 2;
            } else {
                $n++;
            }
            if ($noc >= $length) {
                break;
            }
        }
        if ($noc > $length) {
            $n -= $tn;
        }
        $strcut = substr($string, 0, $n);
        $strcut = str_replace(array('∵', '&', '"', "'", '“', '”', '—', '<', '>', '·', '…'), array(' ', '&amp;', '&quot;', '&#039;', '&ldquo;', '&rdquo;', '&mdash;', '&lt;', '&gt;', '&middot;', '&hellip;'), $strcut);
    } else {
        $dotlen = strlen($dot);
        $maxi = $length - $dotlen - 1;
        $current_str = '';
        $search_arr = array('&', ' ', '"', "'", '“', '”', '—', '<', '>', '·', '…', '∵');
        $replace_arr = array('&amp;', '&nbsp;', '&quot;', '&#039;', '&ldquo;', '&rdquo;', '&mdash;', '&lt;', '&gt;', '&middot;', '&hellip;', ' ');
        $search_flip = array_flip($search_arr);
        for ($i = 0; $i < $maxi; $i++) {
            $current_str = ord($string[$i]) > 127 ? $string[$i] . $string[++$i] : $string[$i];
            if (in_array($current_str, $search_arr)) {
                $key = $search_flip[$current_str];
                $current_str = str_replace($search_arr[$key], $replace_arr[$key], $current_str);
            }
            $strcut .= $current_str;
        }
    }
    return $strcut . $dot;
}

/**
 * 图片过滤替换
 */
function wap_img($url) {
    return '<img src="' . $url . '" style="width:100%;">';
}

/**
 * 内容中图片替换
 */
function content_strip($content) {
    $content = preg_replace('/<img[^>]*src=[\'"]?([^>\'"\s]*)[\'"]?[^>]*>/ie', "wap_img('$1')", $content);
    return $content;
}

/**
 * 判断email格式是否正确
 * @param $email
 */
function is_email($email) {
    return strlen($email) > 6 && preg_match("/^[\w\-\.]+@[\w\-\.]+(\.\w+)+$/", $email);
}

/**
 * 判断手机号码格式是否正确
 * @param $email
 */
function is_phone($phone) {
    return strlen($phone) == 11 && preg_match("/^1[0-9]{10}$/", $phone);
}

/**
 * 产生随机字符串
 *
 * @param    int        $length  输出长度 
 * @param    string     $chars   可选的 ，默认为 0123456789
 * @return   string     字符串
 */
function random($length, $chars = '0123456789') {
    $hash = '';
    $max = strlen($chars) - 1;
    for ($i = 0; $i < $length; $i++) {
        $hash .= $chars[mt_rand(0, $max)];
    }
    return $hash;
}

//书写运行中错误日志
function my_error_handler($errno, $errstr, $errfile, $errline) {
    if ($errno == 8)
        return '';
    $errfile = str_replace(THINK_PATH . "../Public/cache/", '', $errfile);
    error_log(date('m-d H:i:s', SYS_TIME) . ' | ' . $errno . ' | ' . str_pad($errstr, 30) . ' | ' . $errfile . ' | ' . $errline . "\r\n", 3, 'errorlog/error_' . date('YW', SYS_TIME) . '.php');
}

//书写日志到run.log
function write_log($message = '') {
    __mkdirs(THINK_PATH . '../Public/cache/runlog/');
    $statlogfile = THINK_PATH . '../Public/cache/runlog/' . date("YW", SYS_TIME) . '.log'; //不存在自动生成
    if ($fp = @fopen($statlogfile, 'a')) {
        @flock($fp, 2);
        fwrite($fp, $message . "[" . date("Y-m-d H:i:s", SYS_TIME) . "]\r\n");
        fclose($fp);
    }
}

//获取当前URL
function geturl() {
    return 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
}
